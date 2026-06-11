<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImportBatchRequest;
use App\Models\ImportBatch;
use App\Models\ImportBatchSheet;
use App\Models\ImportConflict;
use App\Models\SalesTransaction;
use App\Services\Import\ImportBatchPreviewService;
use App\Services\Import\ImportBatchProcessor;
use App\Services\Import\TransactionSheetParser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Jobs\ParseImportBatchSheets;
use Illuminate\Support\Facades\DB;

class ImportBatchController extends Controller
{
    public function index(): View
    {
        $importBatches = ImportBatch::with('user')
            ->latest()
            ->paginate(10);

        return view('import-batches.index', compact('importBatches'));
    }

    public function create(): View
    {
        return view('import-batches.create');
    }

    public function store(StoreImportBatchRequest $request): RedirectResponse
    {
        $file = $request->file('import_file');

        $filename = now()->format('Ymd_His')
            . '_'
            . Str::random(8)
            . '_'
            . preg_replace('/[^A-Za-z0-9._-]/', '_', $file->getClientOriginalName());

        $storedPath = $file->storeAs('imports', $filename, 'local');

        $batch = ImportBatch::create([
            'uploaded_by' => Auth::id(),
            'original_filename' => $file->getClientOriginalName(),
            'stored_filename' => $storedPath,
            'source_type' => $request->input('source_type', 'manual_upload'),
            'status' => 'uploaded',
            'notes' => $request->input('notes'),
        ]);

        app(ImportBatchProcessor::class)->handle($batch);

        return redirect()
            ->route('import-batches.show', $batch)
            ->with('success', 'Import batch uploaded successfully.');
    }

    public function show(ImportBatch $import_batch): View
    {
        $import_batch->load(['user', 'sheets.branch', 'errors']);

        $importedTransactions = $import_batch->transactions()
            ->with('branch')
            ->latest('invoice_date')
            ->latest('id')
            ->limit(10)
            ->get();

        return view('import-batches.show', [
            'importBatch' => $import_batch,
            'importedTransactions' => $importedTransactions,
        ]);
    }

    public function previewSheet(
        ImportBatch $import_batch,
        ImportBatchSheet $sheet,
        ImportBatchPreviewService $previewService
    ): View {
        abort_unless($sheet->import_batch_id === $import_batch->id, 404);

        $preview = $previewService->previewTransactionSheet($import_batch, $sheet);

        return view('import-batches.preview-sheet', [
            'importBatch' => $import_batch,
            'sheet' => $sheet,
            'preview' => $preview,
        ]);
    }

    

    public function parseSheet(
    ImportBatch $import_batch,
    ImportBatchSheet $sheet,
    TransactionSheetParser $parser
    ): RedirectResponse {
        set_time_limit(300);
        ini_set('max_execution_time', '300');
        ini_set('memory_limit', '512M');

        abort_unless($sheet->import_batch_id === $import_batch->id, 404);

        if (! in_array($sheet->status, ['pending', 'failed'], true)) {
            return redirect()
                ->route('import-batches.show', $import_batch)
                ->with('success', "Sheet {$sheet->sheet_name} is already {$sheet->status}. Reset it first if you want to parse it again.");
        }

        $parser->parse($import_batch, $sheet);

        return redirect()
            ->route('import-batches.show', $import_batch)
            ->with('success', 'Sheet parsed successfully.');
    }

    public function parseAllSheets(ImportBatch $import_batch): RedirectResponse
    {
        if (in_array($import_batch->status, ['queued', 'processing'], true)) {
            return redirect()
                ->route('import-batches.show', $import_batch)
                ->with('success', 'This batch is already queued or being processed.');
        }

        $hasParseableSheets = $import_batch->sheets()
            ->where('sheet_type', 'transaction')
            ->whereIn('status', ['pending', 'failed'])
            ->exists();

        if (! $hasParseableSheets) {
            return redirect()
                ->route('import-batches.show', $import_batch)
                ->with('success', 'No pending or failed transaction sheets are available to parse.');
        }

        $import_batch->update([
            'status' => 'queued',
        ]);

        ParseImportBatchSheets::dispatch($import_batch->id);

        return redirect()
            ->route('import-batches.show', $import_batch)
            ->with('success', 'Parse all has started in the background. This page will refresh while processing.');
    }

    public function resetSheet(ImportBatchSheet $import_batch_sheet): RedirectResponse
    {
        $batch = DB::transaction(function () use ($import_batch_sheet) {
            SalesTransaction::where('import_batch_sheet_id', $import_batch_sheet->id)->delete();

            ImportConflict::where('import_batch_sheet_id', $import_batch_sheet->id)->delete();

            $import_batch_sheet->update([
                'valid_rows' => 0,
                'invalid_rows' => 0,
                'duplicate_rows' => 0,
                'conflict_rows' => 0,
                'imported_rows' => 0,
                'skipped_rows' => 0,
                'status' => 'pending',
                'notes' => null,
            ]);

            $batch = $import_batch_sheet->importBatch;

            $batch->update([
                'valid_rows' => $batch->sheets()->sum('valid_rows'),
                'invalid_rows' => $batch->sheets()->sum('invalid_rows'),
                'duplicate_rows' => $batch->sheets()->sum('duplicate_rows'),
                'conflict_rows' => $batch->sheets()->sum('conflict_rows'),
                'imported_rows' => $batch->sheets()->sum('imported_rows'),
                'skipped_rows' => $batch->sheets()->sum('skipped_rows'),
                'status' => 'uploaded',
            ]);

            return $batch;
        });

        return redirect()
            ->route('import-batches.show', $batch)
            ->with('success', "Reset parsed data for sheet {$import_batch_sheet->sheet_name}.");
    }
}
