<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImportBatchRequest;
use App\Models\ImportBatch;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Services\Import\ImportBatchProcessor;
use App\Models\ImportBatchSheet;
use App\Services\Import\ImportBatchPreviewService;
use Illuminate\Http\Request;
use App\Services\Import\TransactionSheetParser;



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

        $filename = now()->format('Ymd_His') . '_' . Str::random(8) . '_' . preg_replace('/[^A-Za-z0-9._-]/', '_', $file->getClientOriginalName());

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

        return view('import-batches.show', ['importBatch' => $import_batch]);
    }

    public function previewSheet(
    \App\Models\ImportBatch $import_batch,
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
    \App\Models\ImportBatch $import_batch,
    ImportBatchSheet $sheet,
    TransactionSheetParser $parser
    ): RedirectResponse {
        abort_unless($sheet->import_batch_id === $import_batch->id, 404);

        $parser->parse($import_batch, $sheet);

        return redirect()
            ->route('import-batches.show', $import_batch)
            ->with('success', 'Sheet parsed successfully.');
    }
    public function parseAllSheets(
    \App\Models\ImportBatch $import_batch,
    TransactionSheetParser $parser
    ): RedirectResponse {
        $transactionSheets = $import_batch->sheets()
            ->where('sheet_type', 'transaction')
            ->get();

        $parsedSheets = 0;
        $totalImportedRows = 0;

        foreach ($transactionSheets as $sheet) {
            // Optional: skip already imported sheets
            // Remove this if you want re-parse every time
            if ($sheet->status === 'imported' && $sheet->imported_rows > 0) {
                continue;
            }

            $imported = $parser->parse($import_batch, $sheet);
            $totalImportedRows += $imported;
            $parsedSheets++;
        }

        return redirect()
            ->route('import-batches.show', $import_batch)
            ->with('success', "Parsed {$parsedSheets} transaction sheet(s), imported {$totalImportedRows} row(s).");
    }

    public function resetSheet(
    \App\Models\ImportBatchSheet $import_batch_sheet
    ): RedirectResponse {
        \App\Models\SalesTransaction::where(
            'import_batch_sheet_id',
            $import_batch_sheet->id
        )->delete();

        $import_batch_sheet->update([
            'valid_rows' => 0,
            'invalid_rows' => 0,
            'imported_rows' => 0,
            'skipped_rows' => 0,
            'status' => 'pending',
        ]);

        $batch = $import_batch_sheet->importBatch;

        $batch->update([
            'valid_rows' => $batch->sheets()->sum('valid_rows'),
            'invalid_rows' => $batch->sheets()->sum('invalid_rows'),
            'imported_rows' => $batch->sheets()->sum('imported_rows'),
            'skipped_rows' => $batch->sheets()->sum('skipped_rows'),
        ]);

        return redirect()
            ->route('import-batches.show', $batch)
            ->with('success', "Reset parsed data for sheet {$import_batch_sheet->sheet_name}.");
    }
}