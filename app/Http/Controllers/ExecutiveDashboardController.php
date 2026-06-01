<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\BusinessUnit;
use App\Models\ImportConflict;
use App\Models\ImportError;
use App\Models\SalesTransaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ExecutiveDashboardController extends Controller
{
    public function index(Request $request): View
    {
        $dateFilters = $this->resolveDateFilters($request);
        $filters = [
            'date_preset' => $dateFilters['date_preset'],
            'date_from' => $dateFilters['date_from'],
            'date_to' => $dateFilters['date_to'],
            'business_unit_id' => $request->input('business_unit_id'),
            'branch_id' => $request->input('branch_id'),
            'product_group' => $request->input('product_group'),
            'transaction_type' => $request->input('transaction_type'),
        ];

        $branchIds = $this->filteredBranchIds($filters);
        $transactions = $this->filteredTransactions($filters, $branchIds);
        $salesAmountExpression = $this->salesAmountExpression();

        $totalSales = (clone $transactions)->sum(DB::raw($salesAmountExpression));
        $unitsSold = (clone $transactions)->count();
        $cashSales = (clone $transactions)->sum('cash_amount');
        $installmentSales = (clone $transactions)->sum('promissory_note_amount');

        $pendingConflictCount = $this->filteredConflicts($filters, $branchIds)
            ->where('status', 'pending')
            ->count();

        $dataQualityIssueCount = $this->filteredImportErrors($filters)->count();
        $pendingDataIssues = $pendingConflictCount + $dataQualityIssueCount;

        $branchLeaderboard = $this->branchLeaderboard($filters, $branchIds, $salesAmountExpression);

        $pnTargetUpdates = $this->buildPnTargetUpdates($filters, $branchIds);
        $targetAchievement = $this->targetAchievement($pnTargetUpdates);

        $cashVsInstallment = [
            'cash' => (object) [
                'label' => 'Cash Sales',
                'amount' => $cashSales,
                'units' => $this->cashTransactions(clone $transactions)->count(),
            ],
            'installment' => (object) [
                'label' => 'Installment / PN',
                'amount' => $installmentSales,
                'units' => $this->installmentTransactions(clone $transactions)->count(),
            ],
        ];

        $brandNewVsRepo = $this->brandNewVsRepo(clone $transactions, $salesAmountExpression);
        $unitTypeMixInsights = $this->unitTypeMixInsights(clone $transactions, $salesAmountExpression);
        $productGroupBreakdown = $this->productGroupBreakdown(clone $transactions, $salesAmountExpression);

        $topSellingBrand = $this->topSellingBrand(clone $transactions, $salesAmountExpression);
        $hotProduct = $this->hotProduct(clone $transactions, $salesAmountExpression);
        $highestTermShare = $this->highestTermShare(clone $transactions, $salesAmountExpression);
        $productIntelligence = $this->productIntelligence(clone $transactions, $salesAmountExpression);
        $executiveChartData = $this->executiveChartData($filters, $branchIds, $salesAmountExpression);
        $cashInstallmentReports = $this->buildCashInstallmentReports($filters, $branchIds);
        $customerIntelligenceKpis = $this->buildCustomerIntelligenceKpis($filters, $branchIds, $salesAmountExpression);

        $businessUnits = BusinessUnit::orderBy('name')->get();
        $branches = Branch::when($filters['business_unit_id'], function ($query) use ($filters) {
                $query->where('business_unit_id', $filters['business_unit_id']);
            })
            ->orderBy('display_name')
            ->get();

        return view('executive-dashboard', compact(
            'filters',
            'businessUnits',
            'branches',
            'totalSales',
            'unitsSold',
            'cashSales',
            'installmentSales',
            'pendingDataIssues',
            'branchLeaderboard',
            'pnTargetUpdates',
            'targetAchievement',
            'cashVsInstallment',
            'brandNewVsRepo',
            'unitTypeMixInsights',
            'productGroupBreakdown',
            'topSellingBrand',
            'hotProduct',
            'highestTermShare',
            'productIntelligence',
            'executiveChartData',
            'cashInstallmentReports',
            'customerIntelligenceKpis'
        ));
    }

    private function resolveDateFilters(Request $request): array
    {
        $today = Carbon::now(config('app.timezone'))->startOfDay();
        $preset = $request->input('date_preset');

        if (! $preset) {
            $preset = ($request->filled('date_from') || $request->filled('date_to'))
                ? 'custom'
                : 'this_month';
        }

        if (! in_array($preset, ['today', 'this_month', 'last_month', 'year_to_date', 'all_time', 'custom'], true)) {
            $preset = 'this_month';
        }

        $dateFrom = null;
        $dateTo = null;

        switch ($preset) {
            case 'today':
                $dateFrom = $today->copy();
                $dateTo = $today->copy();
                break;

            case 'last_month':
                $lastMonth = $today->copy()->subMonthNoOverflow();
                $dateFrom = $lastMonth->copy()->startOfMonth();
                $dateTo = $lastMonth->copy()->endOfMonth()->startOfDay();
                break;

            case 'year_to_date':
                $dateFrom = $today->copy()->startOfYear();
                $dateTo = $today->copy();
                break;

            case 'all_time':
                break;

            case 'custom':
                $dateFrom = $request->filled('date_from')
                    ? Carbon::parse($request->input('date_from'), config('app.timezone'))->startOfDay()
                    : null;
                $dateTo = $request->filled('date_to')
                    ? Carbon::parse($request->input('date_to'), config('app.timezone'))->startOfDay()
                    : null;
                break;

            case 'this_month':
            default:
                $dateFrom = $today->copy()->startOfMonth();
                $dateTo = $today->copy();
                $preset = 'this_month';
                break;
        }

        if ($dateFrom && $dateTo && $dateTo->lt($dateFrom)) {
            [$dateFrom, $dateTo] = [$dateTo, $dateFrom];
        }

        return [
            'date_preset' => $preset,
            'date_from' => $dateFrom?->toDateString(),
            'date_to' => $dateTo?->toDateString(),
        ];
    }

    private function filteredBranchIds(array $filters): Collection
    {
        return Branch::query()
            ->when($filters['business_unit_id'], function ($query) use ($filters) {
                $query->where('business_unit_id', $filters['business_unit_id']);
            })
            ->when($filters['branch_id'], function ($query) use ($filters) {
                $query->where('id', $filters['branch_id']);
            })
            ->pluck('id');
    }

    private function filteredTransactions(array $filters, Collection $branchIds): Builder
    {
        $query = SalesTransaction::query();

        if ($branchIds->isNotEmpty()) {
            $query->whereIn('branch_id', $branchIds);
        } else {
            $query->whereRaw('1 = 0');
        }

        return $query
            ->when($filters['date_from'], function ($query) use ($filters) {
                $query->whereDate('invoice_date', '>=', $filters['date_from']);
            })
            ->when($filters['date_to'], function ($query) use ($filters) {
                $query->whereDate('invoice_date', '<=', $filters['date_to']);
            })
            ->when($filters['product_group'], function ($query) use ($filters) {
                $this->applyProductGroupFilter($query, $filters['product_group']);
            })
            ->when($filters['transaction_type'], function ($query) use ($filters) {
                $this->applyTransactionTypeFilter($query, $filters['transaction_type']);
            });
    }

    private function filteredConflicts(array $filters, Collection $branchIds): Builder
    {
        $query = ImportConflict::query();

        if ($branchIds->isNotEmpty()) {
            $query->whereIn('branch_id', $branchIds);
        } else {
            $query->whereRaw('1 = 0');
        }

        return $query
            ->when($filters['date_from'], function ($query) use ($filters) {
                $query->whereDate('created_at', '>=', $filters['date_from']);
            })
            ->when($filters['date_to'], function ($query) use ($filters) {
                $query->whereDate('created_at', '<=', $filters['date_to']);
            });
    }

    private function filteredImportErrors(array $filters): Builder
    {
        return ImportError::query()
            ->when($filters['date_from'], function ($query) use ($filters) {
                $query->whereDate('created_at', '>=', $filters['date_from']);
            })
            ->when($filters['date_to'], function ($query) use ($filters) {
                $query->whereDate('created_at', '<=', $filters['date_to']);
            });
    }

    private function branchLeaderboard(array $filters, Collection $branchIds, string $salesAmountExpression): Collection
    {
        $salesByBranch = $this->filteredTransactions($filters, $branchIds)
            ->selectRaw('branch_id')
            ->selectRaw('COUNT(*) as units_sold')
            ->selectRaw("SUM($salesAmountExpression) as total_sales")
            ->selectRaw('SUM(COALESCE(cash_amount, 0)) as cash_sales')
            ->selectRaw('SUM(COALESCE(promissory_note_amount, 0)) as installment_sales')
            ->groupBy('branch_id')
            ->get()
            ->keyBy('branch_id');

        return Branch::whereIn('id', $branchIds)
            ->orderBy('display_name')
            ->get()
            ->map(function (Branch $branch) use ($filters, $salesByBranch) {
                $sales = $salesByBranch->get($branch->id);
                $topBrand = $this->branchTopBrand($filters, $branch->id);
                $hotProduct = $this->branchHotProduct($filters, $branch->id);
                $topTerm = $this->branchTopTerm($filters, $branch->id);

                return (object) [
                    'branch_id' => $branch->id,
                    'branch_name' => $branch->display_name,
                    'branch_code' => $branch->code,
                    'total_sales' => (float) ($sales->total_sales ?? 0),
                    'units_sold' => (int) ($sales->units_sold ?? 0),
                    'cash_sales' => (float) ($sales->cash_sales ?? 0),
                    'installment_sales' => (float) ($sales->installment_sales ?? 0),
                    'top_brand' => $topBrand->brand_name ?? null,
                    'top_brand_units' => (int) ($topBrand->units_sold ?? 0),
                    'hot_product' => $hotProduct->product_name ?? null,
                    'hot_product_units' => (int) ($hotProduct->units_sold ?? 0),
                    'top_term' => $topTerm->terms ?? null,
                    'top_term_units' => (int) ($topTerm->units_sold ?? 0),
                    'top_term_share' => $topTerm->share ?? null,
                ];
            })
            ->sortBy([
                ['total_sales', 'desc'],
                ['branch_name', 'asc'],
            ])
            ->values();
    }

    private function branchTopBrand(array $filters, int $branchId): ?object
    {
        return $this->filteredTransactions($filters, collect([$branchId]))
            ->selectRaw("COALESCE(NULLIF(brand_name_raw, ''), 'Unclassified Brand') as brand_name")
            ->selectRaw('COUNT(*) as units_sold')
            ->groupBy('brand_name')
            ->orderByDesc('units_sold')
            ->orderBy('brand_name')
            ->first();
    }

    private function branchHotProduct(array $filters, int $branchId): ?object
    {
        return $this->filteredTransactions($filters, collect([$branchId]))
            ->selectRaw("
                COALESCE(
                    NULLIF(model, ''),
                    NULLIF(product_description, ''),
                    NULLIF(product, ''),
                    'Unknown Product'
                ) as product_name
            ")
            ->selectRaw('COUNT(*) as units_sold')
            ->groupBy('product_name')
            ->orderByDesc('units_sold')
            ->orderBy('product_name')
            ->first();
    }

    private function branchTopTerm(array $filters, int $branchId): ?object
    {
        $transactions = $this->installmentTransactions(
            $this->filteredTransactions($filters, collect([$branchId]))
        )
            ->whereNotNull('terms')
            ->where('terms', '!=', '');

        $totalTermRows = (clone $transactions)->count();

        $topTerm = $transactions
            ->selectRaw('terms')
            ->selectRaw('COUNT(*) as units_sold')
            ->groupBy('terms')
            ->orderByDesc('units_sold')
            ->orderBy('terms')
            ->first();

        if ($topTerm) {
            $topTerm->share = $totalTermRows > 0
                ? round(($topTerm->units_sold / $totalTermRows) * 100, 1)
                : 0;
        }

        return $topTerm;
    }

    private function buildPnTargetUpdates(array $filters, Collection $branchIds): array
    {
        $applianceTargets = [
            'L4 Gensan' => 200000,
            'L4 Glan' => 200000,
            'L4 Marbel' => 250000,
            'L4 Tacurong' => 200000,
            'L4 Isulan' => 200000,
            'L4 Kulaman' => 150000,
        ];

        $motorcycleTargets = [
            'M8 Digos' => 1412500,
            'M8 Gensan' => 1912500,
            'L4 Gensan' => 1012500,
            'L4 Glan' => 1012500,
            'L4 Marbel' => 1162500,
            'L4 Tacurong' => 1212500,
            'L4 Isulan' => 1212500,
            'L4 Kulaman' => 862500,
        ];

        $combinedTargets = $motorcycleTargets;

        foreach ($applianceTargets as $branchLabel => $target) {
            $combinedTargets[$branchLabel] = ($combinedTargets[$branchLabel] ?? 0) + $target;
        }

        $dateFrom = $filters['date_from']
            ? \Carbon\Carbon::parse($filters['date_from'])->startOfDay()
            : now()->startOfMonth()->startOfDay();
        $dateTo = $filters['date_to']
            ? \Carbon\Carbon::parse($filters['date_to'])->startOfDay()
            : now()->startOfDay();

        if ($dateTo->lt($dateFrom)) {
            [$dateFrom, $dateTo] = [$dateTo, $dateFrom];
        }

        $targetMonthStart = $dateFrom->copy()->startOfMonth();
        $targetMonthEnd = $dateFrom->copy()->endOfMonth()->startOfDay();
        $currentProjectionDate = collect([
            now()->startOfDay(),
            $dateTo->copy(),
            $targetMonthEnd->copy(),
        ])->min();

        $totalWorkingDays = max($this->countWorkingDays($targetMonthStart, $targetMonthEnd), 1);
        $elapsedWorkingDays = $currentProjectionDate->lt($targetMonthStart)
            ? 0
            : $this->countWorkingDays($targetMonthStart, $currentProjectionDate);
        $progressPercentage = min($elapsedWorkingDays / $totalWorkingDays, 1);

        $applianceRows = $this->buildTargetRows(
            $filters,
            $branchIds,
            $applianceTargets,
            ['APPLIANCE', 'APPLIANCES'],
            $totalWorkingDays,
            $progressPercentage
        );
        $motorcycleRows = $this->buildTargetRows(
            $filters,
            $branchIds,
            $motorcycleTargets,
            ['MOTORCYCLE'],
            $totalWorkingDays,
            $progressPercentage
        );
        $combinedRows = $this->buildTargetRows(
            $filters,
            $branchIds,
            $combinedTargets,
            ['MOTORCYCLE', 'APPLIANCE', 'APPLIANCES'],
            $totalWorkingDays,
            $progressPercentage
        );

        return [
            'appliance' => [
                'title' => 'PN Sales Target Update - Appliance',
                'rows' => $applianceRows,
                'totals' => $this->targetTotals($applianceRows, $totalWorkingDays),
            ],
            'motorcycle' => [
                'title' => 'PN Sales Target Update - Motorcycle',
                'rows' => $motorcycleRows,
                'totals' => $this->targetTotals($motorcycleRows, $totalWorkingDays),
            ],
            'combined' => [
                'title' => 'Combined PN Sales Target Update - Motorcycle & Appliances',
                'rows' => $combinedRows,
                'totals' => $this->targetTotals($combinedRows, $totalWorkingDays),
            ],
        ];
    }

    private function countWorkingDays(\Carbon\Carbon $dateFrom, \Carbon\Carbon $dateTo): int
    {
        $days = 0;
        $cursor = $dateFrom->copy();

        while ($cursor->lte($dateTo)) {
            if (! $cursor->isSunday()) {
                $days++;
            }

            $cursor->addDay();
        }

        return $days;
    }

    private function buildTargetRows(
        array $filters,
        Collection $branchIds,
        array $targets,
        array $productGroups,
        int $totalWorkingDays,
        float $progressPercentage
    ): Collection {
        $branches = Branch::whereIn('id', $branchIds)->get();

        return collect($targets)
            ->map(function ($workingPlan, $branchLabel) use ($filters, $branchIds, $branches, $productGroups, $totalWorkingDays, $progressPercentage) {
                $branch = $this->resolveTargetBranch($branches, $branchLabel);

                if ($filters['branch_id'] && (! $branch || (string) $branch->id !== (string) $filters['branch_id'])) {
                    return null;
                }

                if ($filters['business_unit_id'] && $branch && ! $branchIds->contains($branch->id)) {
                    return null;
                }

                $actualPnSales = $branch
                    ? $this->actualPnSalesAmount($filters, $branch->id, $productGroups)
                    : 0;
                $projectedAmount = $workingPlan * $progressPercentage;
                $projectedPercentage = $progressPercentage * 100;
                $salesTargetPerDay = $workingPlan / max($totalWorkingDays, 1);
                $actualPercentage = $workingPlan > 0 ? ($actualPnSales / $workingPlan) * 100 : 0;
                $varianceAmount = $actualPnSales - $projectedAmount;
                $variancePercentage = $workingPlan > 0 ? ($varianceAmount / $workingPlan) * 100 : 0;

                return (object) [
                    'branch' => $branchLabel,
                    'working_plan' => (float) $workingPlan,
                    'projected_amount' => (float) $projectedAmount,
                    'projected_percentage' => (float) $projectedPercentage,
                    'sales_target_per_day' => (float) $salesTargetPerDay,
                    'actual_amount' => (float) $actualPnSales,
                    'actual_percentage' => (float) $actualPercentage,
                    'variance_amount' => (float) $varianceAmount,
                    'variance_percentage' => (float) $variancePercentage,
                ];
            })
            ->filter()
            ->values();
    }

    private function resolveTargetBranch(Collection $branches, string $branchLabel): ?Branch
    {
        $target = $this->normalizeTargetLabel($branchLabel);

        return $branches->first(function (Branch $branch) use ($target) {
            $labels = [
                $branch->display_name,
                $branch->name ?? null,
                $branch->code,
                trim(($branch->code ?? '') . ' ' . ($branch->display_name ?? '')),
                trim(($branch->code ?? '') . ' ' . ($branch->name ?? '')),
            ];

            foreach ($labels as $label) {
                if ($label && $this->normalizeTargetLabel($label) === $target) {
                    return true;
                }
            }

            return false;
        });
    }

    private function normalizeTargetLabel(?string $label): string
    {
        $normalized = strtolower(preg_replace('/[^a-z0-9]+/i', '', (string) $label));

        return str_replace(
            ['lucky4', 'motor8', 'gensan'],
            ['l4', 'm8', 'gsc'],
            $normalized
        );
    }

    private function actualPnSalesAmount(array $filters, int $branchId, array $productGroups): float
    {
        return (float) SalesTransaction::query()
            ->where('branch_id', $branchId)
            ->when($filters['date_from'], function ($query) use ($filters) {
                $query->whereDate('invoice_date', '>=', $filters['date_from']);
            })
            ->when($filters['date_to'], function ($query) use ($filters) {
                $query->whereDate('invoice_date', '<=', $filters['date_to']);
            })
            ->whereIn(DB::raw('UPPER(TRIM(product_line_name))'), $productGroups)
            ->sum(DB::raw('COALESCE(promissory_note_amount, 0)'));
    }

    private function targetTotals(Collection $rows, int $totalWorkingDays): object
    {
        $workingPlan = (float) $rows->sum('working_plan');
        $projectedAmount = (float) $rows->sum('projected_amount');
        $actualAmount = (float) $rows->sum('actual_amount');
        $varianceAmount = $actualAmount - $projectedAmount;

        return (object) [
            'branch' => 'TOTAL',
            'working_plan' => $workingPlan,
            'projected_amount' => $projectedAmount,
            'projected_percentage' => $workingPlan > 0 ? ($projectedAmount / $workingPlan) * 100 : 0,
            'sales_target_per_day' => $workingPlan / max($totalWorkingDays, 1),
            'actual_amount' => $actualAmount,
            'actual_percentage' => $workingPlan > 0 ? ($actualAmount / $workingPlan) * 100 : 0,
            'variance_amount' => $varianceAmount,
            'variance_percentage' => $workingPlan > 0 ? ($varianceAmount / $workingPlan) * 100 : 0,
        ];
    }

    private function targetAchievement(array $pnTargetUpdates): object
    {
        $combinedTotal = $pnTargetUpdates['combined']['totals'] ?? null;
        $targetTotal = (float) ($combinedTotal->working_plan ?? 0);
        $actualTotal = (float) ($combinedTotal->actual_amount ?? 0);
        $achievementPercentage = $targetTotal > 0
            ? ($actualTotal / $targetTotal) * 100
            : 0;
        $status = $achievementPercentage >= 100 ? 'hit' : 'behind';

        return (object) [
            'target_total' => $targetTotal,
            'actual_total' => $actualTotal,
            'achievement_percentage' => $achievementPercentage,
            'status' => $status,
            'status_label' => $status === 'hit' ? 'Target Hit' : 'Below Target',
        ];
    }

    private function buildCashInstallmentReports(array $filters, Collection $branchIds): array
    {
        $reportDay = $filters['date_to'] ?: Carbon::now(config('app.timezone'))->toDateString();
        $reportPeriodStart = $filters['date_from']
            ?: Carbon::parse($reportDay, config('app.timezone'))->startOfMonth()->toDateString();

        return [
            'cash' => [
                'title' => 'Cash Reports',
                'subtitle' => 'Cash sales by major product group for the selected filters.',
                'reports' => [
                    'appliance' => $this->cashInstallmentReportSummary($filters, $branchIds, 'cash', 'appliance', $reportDay, $reportPeriodStart),
                    'motorcycle' => $this->cashInstallmentReportSummary($filters, $branchIds, 'cash', 'motorcycle', $reportDay, $reportPeriodStart),
                    'combined' => $this->cashInstallmentReportSummary($filters, $branchIds, 'cash', 'combined', $reportDay, $reportPeriodStart),
                ],
            ],
            'installment' => [
                'title' => 'Installment / PN Reports',
                'subtitle' => 'Promissory note sales by major product group for the selected filters.',
                'reports' => [
                    'appliance' => $this->cashInstallmentReportSummary($filters, $branchIds, 'installment', 'appliance', $reportDay, $reportPeriodStart),
                    'motorcycle' => $this->cashInstallmentReportSummary($filters, $branchIds, 'installment', 'motorcycle', $reportDay, $reportPeriodStart),
                    'combined' => $this->cashInstallmentReportSummary($filters, $branchIds, 'installment', 'combined', $reportDay, $reportPeriodStart),
                ],
            ],
        ];
    }

    private function cashInstallmentReportSummary(
        array $filters,
        Collection $branchIds,
        string $saleType,
        string $reportGroup,
        string $reportDay,
        string $reportPeriodStart
    ): object {
        $amountColumn = $saleType === 'cash' ? 'cash_amount' : 'promissory_note_amount';
        $base = $this->cashInstallmentReportBaseQuery($filters, $branchIds, $saleType, $reportGroup);

        $todayBrandNew = $this->cashInstallmentSegment(clone $base, $reportDay, $reportDay, false, $amountColumn);
        $todayRepo = $this->cashInstallmentSegment(clone $base, $reportDay, $reportDay, true, $amountColumn);
        $toDateBrandNew = $this->cashInstallmentSegment(clone $base, $reportPeriodStart, $reportDay, false, $amountColumn);
        $toDateRepo = $this->cashInstallmentSegment(clone $base, $reportPeriodStart, $reportDay, true, $amountColumn);
        $total = $this->cashInstallmentSegment(clone $base, $reportPeriodStart, $reportDay, null, $amountColumn);

        return (object) [
            'label' => match ($reportGroup) {
                'appliance' => 'Appliance',
                'motorcycle' => 'Motorcycle',
                default => 'Combined',
            },
            'today_brand_new_units' => $todayBrandNew->units,
            'today_brand_new_amount' => $todayBrandNew->amount,
            'today_repo_units' => $todayRepo->units,
            'today_repo_amount' => $todayRepo->amount,
            'todate_brand_new_units' => $toDateBrandNew->units,
            'todate_brand_new_amount' => $toDateBrandNew->amount,
            'todate_repo_units' => $toDateRepo->units,
            'todate_repo_amount' => $toDateRepo->amount,
            'total_units' => $total->units,
            'total_amount' => $total->amount,
        ];
    }

    private function cashInstallmentReportBaseQuery(
        array $filters,
        Collection $branchIds,
        string $saleType,
        string $reportGroup
    ): Builder {
        $amountColumn = $saleType === 'cash' ? 'cash_amount' : 'promissory_note_amount';

        $query = SalesTransaction::query()
            ->whereIn('branch_id', $branchIds)
            ->whereNotNull('product_line_name')
            ->whereNotNull($amountColumn)
            ->where($amountColumn, '>', 0)
            ->when($filters['date_from'], function ($query) use ($filters) {
                $query->whereDate('invoice_date', '>=', $filters['date_from']);
            })
            ->when($filters['date_to'], function ($query) use ($filters) {
                $query->whereDate('invoice_date', '<=', $filters['date_to']);
            });

        if ($saleType === 'installment') {
            $query->where('transaction_type', 'INSTALLMENT SALES');
        }

        if ($reportGroup === 'appliance') {
            $query->whereHas('branch.businessUnit', fn ($query) => $query->where('code', 'L4'))
                ->where('product_line_name', '!=', 'MOTORCYCLE');
        }

        if ($reportGroup === 'motorcycle') {
            $query->whereHas('branch.businessUnit', fn ($query) => $query->whereIn('code', ['L4', 'M8']))
                ->where('product_line_name', 'MOTORCYCLE');
        }

        if ($reportGroup === 'combined') {
            $query->whereHas('branch.businessUnit', fn ($query) => $query->whereIn('code', ['L4', 'M8']))
                ->whereIn('product_line_name', ['MOTORCYCLE', 'APPLIANCES', 'BED OR FOAM']);
        }

        if ($filters['product_group']) {
            $this->applyProductGroupFilter($query, $filters['product_group']);
        }

        return $query;
    }

    private function cashInstallmentSegment(
        Builder $query,
        string $dateFrom,
        string $dateTo,
        ?bool $repoOnly,
        string $amountColumn
    ): object {
        $query->whereBetween('invoice_date', [$dateFrom, $dateTo]);

        if ($repoOnly === true) {
            $query->where('unit_type', 'REPO');
        }

        if ($repoOnly === false) {
            $query->where('unit_type', '!=', 'REPO');
        }

        return (object) [
            'units' => (clone $query)->count(),
            'amount' => (float) (clone $query)->sum($amountColumn),
        ];
    }

    private function buildCustomerIntelligenceKpis(array $filters, Collection $branchIds, string $salesAmountExpression): array
    {
        $customerNameExpression = 'UPPER(TRIM(customer_name))';
        $contactExpression = "UPPER(TRIM(COALESCE(contact_number, '')))";

        $onlyFinancialSales = function ($query) {
            $query->where(function ($amountQuery) {
                $amountQuery->where('cash_amount', '>', 0)
                    ->orWhere('promissory_note_amount', '>', 0)
                    ->orWhere('gross_sales_amount', '>', 0)
                    ->orWhere('amount', '>', 0);
            });
        };

        $customerQuery = $this->filteredTransactions($filters, $branchIds);

        $topRepeatCustomers = (clone $customerQuery)
            ->where($onlyFinancialSales)
            ->selectRaw('MAX(id) as latest_sales_transaction_id')
            ->selectRaw('MAX(customer_name) as customer_name')
            ->selectRaw('MAX(contact_number) as contact_number')
            ->selectRaw('COUNT(*) as transaction_count')
            ->selectRaw("COUNT(DISTINCT NULLIF(account_number, '')) as account_count")
            ->selectRaw('SUM(COALESCE(promissory_note_amount, 0)) as total_pn_amount')
            ->selectRaw("SUM($salesAmountExpression) as total_sales_amount")
            ->selectRaw('MIN(invoice_date) as first_purchase_date')
            ->selectRaw('MAX(invoice_date) as latest_purchase_date')
            ->whereNotNull('customer_name')
            ->where('customer_name', '!=', '')
            ->groupByRaw($customerNameExpression)
            ->groupByRaw($contactExpression)
            ->havingRaw("COUNT(DISTINCT NULLIF(account_number, '')) > 1 OR COUNT(*) > 1")
            ->orderByDesc('account_count')
            ->orderByDesc('transaction_count')
            ->orderByDesc('total_sales_amount')
            ->limit(10)
            ->get();

        $topPnCustomers = (clone $customerQuery)
            ->where($onlyFinancialSales)
            ->selectRaw('MAX(id) as sales_transaction_id')
            ->selectRaw('MAX(customer_name) as customer_name')
            ->selectRaw('MAX(account_number) as account_number')
            ->selectRaw('MAX(receipt_number) as receipt_number')
            ->selectRaw('MAX(product_line_name) as product_line_name')
            ->selectRaw('MAX(brand_name_raw) as brand_name')
            ->selectRaw('MAX(model) as model')
            ->selectRaw('SUM(COALESCE(promissory_note_amount, 0)) as total_pn_amount')
            ->selectRaw('MAX(invoice_date) as latest_purchase_date')
            ->whereNotNull('customer_name')
            ->where('customer_name', '!=', '')
            ->whereNotNull('promissory_note_amount')
            ->where('promissory_note_amount', '>', 0)
            ->groupByRaw('UPPER(TRIM(account_number))')
            ->orderByDesc('total_pn_amount')
            ->limit(10)
            ->get();

        $topRepeatCustomer = $topRepeatCustomers->first();
        $topPnCustomer = $topPnCustomers->first();

        return [
            'top_repeat_buyer' => [
                'customer_name' => $topRepeatCustomer->customer_name ?? null,
                'count' => (int) ($topRepeatCustomer->transaction_count ?? 0),
                'account_count' => (int) ($topRepeatCustomer->account_count ?? 0),
                'amount' => (float) ($topRepeatCustomer->total_sales_amount ?? 0),
            ],
            'highest_pn_customer' => [
                'customer_name' => $topPnCustomer->customer_name ?? null,
                'pn_amount' => (float) ($topPnCustomer->total_pn_amount ?? 0),
                'account_number' => $topPnCustomer->account_number ?? null,
                'receipt_number' => $topPnCustomer->receipt_number ?? null,
            ],
            'repeat_count' => $topRepeatCustomers->count(),
        ];
    }

    private function brandNewVsRepo(Builder $query, string $salesAmountExpression): Collection
    {
        return $query
            ->selectRaw("
                CASE
                    WHEN UPPER(TRIM(COALESCE(unit_type, ''))) IN ('REPO', 'REPOSSESSED', 'REPOSSESSION') THEN 'Repo'
                    ELSE 'Brand New'
                END as unit_group
            ")
            ->selectRaw('COUNT(*) as units_sold')
            ->selectRaw("SUM($salesAmountExpression) as total_sales")
            ->groupBy('unit_group')
            ->orderByDesc('units_sold')
            ->get();
    }

    private function unitTypeMixInsights(Builder $query, string $salesAmountExpression): array
    {
        return [
            'brand_new' => [
                'top_brand' => $this->unitTypeTopBrand(clone $query, $salesAmountExpression, false),
                'top_product' => $this->unitTypeTopProduct(clone $query, $salesAmountExpression, false),
            ],
            'repo' => [
                'top_brand' => $this->unitTypeTopBrand(clone $query, $salesAmountExpression, true),
                'top_product' => $this->unitTypeTopProduct(clone $query, $salesAmountExpression, true),
            ],
        ];
    }

    private function unitTypeTopBrand(Builder $query, string $salesAmountExpression, bool $repoOnly): ?string
    {
        $brandExpression = 'TRIM(sales_transactions.brand_name_raw)';
        $baseQuery = $this->applyUnitTypeScope($query, $repoOnly)
            ->selectRaw("$brandExpression as label")
            ->selectRaw("$salesAmountExpression as sale_amount")
            ->whereNotNull('sales_transactions.brand_name_raw')
            ->whereRaw("$brandExpression != ''");

        $brand = DB::query()
            ->fromSub($baseQuery->toBase(), 'unit_type_brands')
            ->select('label')
            ->selectRaw('COUNT(*) as units_sold')
            ->selectRaw('SUM(sale_amount) as total_sales')
            ->groupBy('label')
            ->orderByDesc('units_sold')
            ->orderByDesc('total_sales')
            ->first();

        return $brand->label ?? null;
    }

    private function unitTypeTopProduct(Builder $query, string $salesAmountExpression, bool $repoOnly): ?string
    {
        $productExpression = "
            COALESCE(
                NULLIF(TRIM(sales_transactions.model), ''),
                NULLIF(TRIM(sales_transactions.product), ''),
                NULLIF(TRIM(sales_transactions.product_description), '')
            )
        ";
        $baseQuery = $this->applyUnitTypeScope($query, $repoOnly)
            ->selectRaw("$productExpression as label")
            ->selectRaw("$salesAmountExpression as sale_amount")
            ->whereRaw("$productExpression IS NOT NULL");

        $product = DB::query()
            ->fromSub($baseQuery->toBase(), 'unit_type_products')
            ->select('label')
            ->selectRaw('COUNT(*) as units_sold')
            ->selectRaw('SUM(sale_amount) as total_sales')
            ->groupBy('label')
            ->orderByDesc('units_sold')
            ->orderByDesc('total_sales')
            ->first();

        return $product->label ?? null;
    }

    private function applyUnitTypeScope(Builder $query, bool $repoOnly): Builder
    {
        if ($repoOnly) {
            return $query->whereIn(DB::raw("UPPER(TRIM(COALESCE(unit_type, '')))"), ['REPO', 'REPOSSESSED', 'REPOSSESSION']);
        }

        return $query->whereNotIn(DB::raw("UPPER(TRIM(COALESCE(unit_type, '')))"), ['REPO', 'REPOSSESSED', 'REPOSSESSION']);
    }

    private function productGroupBreakdown(Builder $query, string $salesAmountExpression): Collection
    {
        $rawProductGroupExpression = 'UPPER(TRIM(sales_transactions.product_line_name))';
        $productGroupKeyExpression = $this->productGroupKeyExpression();
        $productGroupLabelExpression = $this->productGroupLabelExpression();

        $baseQuery = (clone $query)
            ->whereNotNull('sales_transactions.product_line_name')
            ->whereRaw("TRIM(sales_transactions.product_line_name) != ''")
            ->whereRaw("$rawProductGroupExpression != ?", ['UNCLASSIFIED'])
            ->selectRaw("$productGroupKeyExpression as product_group_key")
            ->selectRaw("$productGroupLabelExpression as product_group")
            ->selectRaw("$salesAmountExpression as sale_amount");

        return DB::query()
            ->fromSub($baseQuery->toBase(), 'product_groups')
            ->select(['product_group_key', 'product_group'])
            ->selectRaw('COUNT(*) as units_sold')
            ->selectRaw('SUM(sale_amount) as total_sales')
            ->groupBy('product_group_key')
            ->groupBy('product_group')
            ->orderByDesc('total_sales')
            ->limit(10)
            ->get()
            ->map(function ($group) use ($query, $salesAmountExpression) {
                $group->top_brand = $this->productGroupTopBrand(
                    clone $query,
                    $salesAmountExpression,
                    $group->product_group_key
                );
                $group->top_product = $this->productGroupTopProduct(
                    clone $query,
                    $salesAmountExpression,
                    $group->product_group_key
                );

                return $group;
            });
    }

    private function productGroupTopBrand(Builder $query, string $salesAmountExpression, string $productGroupKey): ?string
    {
        $brandExpression = 'TRIM(sales_transactions.brand_name_raw)';
        $baseQuery = $this->applyProductGroupKeyScope($query, $productGroupKey)
            ->selectRaw("$brandExpression as label")
            ->selectRaw("$salesAmountExpression as sale_amount")
            ->whereNotNull('sales_transactions.brand_name_raw')
            ->whereRaw("$brandExpression != ''");

        $brand = DB::query()
            ->fromSub($baseQuery->toBase(), 'product_group_brands')
            ->select('label')
            ->selectRaw('COUNT(*) as units_sold')
            ->selectRaw('SUM(sale_amount) as total_sales')
            ->groupBy('label')
            ->orderByDesc('units_sold')
            ->orderByDesc('total_sales')
            ->first();

        return $brand->label ?? null;
    }

    private function productGroupTopProduct(Builder $query, string $salesAmountExpression, string $productGroupKey): ?string
    {
        $productExpression = "
            COALESCE(
                NULLIF(TRIM(sales_transactions.model), ''),
                NULLIF(TRIM(sales_transactions.product), ''),
                NULLIF(TRIM(sales_transactions.product_description), ''),
                NULLIF(TRIM(sales_transactions.parts_number), '')
            )
        ";
        $baseQuery = $this->applyProductGroupKeyScope($query, $productGroupKey)
            ->selectRaw("$productExpression as label")
            ->selectRaw("$salesAmountExpression as sale_amount")
            ->whereRaw("$productExpression IS NOT NULL");

        $product = DB::query()
            ->fromSub($baseQuery->toBase(), 'product_group_products')
            ->select('label')
            ->selectRaw('COUNT(*) as units_sold')
            ->selectRaw('SUM(sale_amount) as total_sales')
            ->groupBy('label')
            ->orderByDesc('units_sold')
            ->orderByDesc('total_sales')
            ->first();

        return $product->label ?? null;
    }

    private function applyProductGroupKeyScope(Builder $query, string $productGroupKey): Builder
    {
        return $query->whereRaw($this->productGroupKeyExpression() . ' = ?', [$productGroupKey]);
    }

    private function productGroupKeyExpression(): string
    {
        return "
            CASE
                WHEN UPPER(TRIM(sales_transactions.product_line_name)) = 'MOTORCYCLE' THEN 'motorcycle'
                WHEN UPPER(TRIM(sales_transactions.product_line_name)) IN ('APPLIANCE', 'APPLIANCES') THEN 'appliance'
                WHEN UPPER(TRIM(sales_transactions.product_line_name)) = 'FURNITURE' THEN 'furniture'
                WHEN UPPER(TRIM(sales_transactions.product_line_name)) IN ('BED OR FOAM', 'BED FOAM', 'FOAM') THEN 'bed_foam'
                WHEN UPPER(TRIM(sales_transactions.product_line_name)) IN ('SPARE PARTS', 'SPARE PART', 'PARTS') THEN 'spare_parts'
                ELSE LOWER(REPLACE(UPPER(TRIM(sales_transactions.product_line_name)), ' ', '_'))
            END
        ";
    }

    private function productGroupLabelExpression(): string
    {
        return "
            CASE
                WHEN UPPER(TRIM(sales_transactions.product_line_name)) = 'MOTORCYCLE' THEN 'Motorcycle'
                WHEN UPPER(TRIM(sales_transactions.product_line_name)) IN ('APPLIANCE', 'APPLIANCES') THEN 'Appliance'
                WHEN UPPER(TRIM(sales_transactions.product_line_name)) = 'FURNITURE' THEN 'Furniture'
                WHEN UPPER(TRIM(sales_transactions.product_line_name)) IN ('BED OR FOAM', 'BED FOAM', 'FOAM') THEN 'Bed/Foam'
                WHEN UPPER(TRIM(sales_transactions.product_line_name)) IN ('SPARE PARTS', 'SPARE PART', 'PARTS') THEN 'Spare Parts'
                ELSE UPPER(TRIM(sales_transactions.product_line_name))
            END
        ";
    }

    private function topSellingBrand(Builder $query, string $salesAmountExpression): ?object
    {
        $brandExpression = "COALESCE(NULLIF(sales_transactions.brand_name_raw, ''), 'Unclassified Brand')";

        $baseQuery = $query
            ->selectRaw("$brandExpression as brand_name")
            ->selectRaw("$salesAmountExpression as sale_amount");

        return DB::query()
            ->fromSub($baseQuery->toBase(), 'brands')
            ->select('brand_name')
            ->selectRaw('COUNT(*) as units_sold')
            ->selectRaw('SUM(sale_amount) as total_sales')
            ->groupBy('brand_name')
            ->orderByDesc('units_sold')
            ->orderByDesc('total_sales')
            ->first();
    }

    private function productIntelligence(Builder $query, string $salesAmountExpression): array
    {
        return [
            'top_brands' => $this->topSellingBrands(clone $query, $salesAmountExpression),
            'hot_products' => $this->hotProducts(clone $query, $salesAmountExpression),
            'top_terms' => $this->topTerms(clone $query, $salesAmountExpression),
        ];
    }

    private function executiveChartData(array $filters, Collection $branchIds, string $salesAmountExpression): array
    {
        $branchTotals = $this->filteredTransactions($filters, $branchIds)
            ->select('branch_id')
            ->selectRaw('COUNT(*) as transaction_count')
            ->selectRaw("SUM($salesAmountExpression) as total_amount")
            ->with('branch')
            ->groupBy('branch_id')
            ->orderByDesc('transaction_count')
            ->limit(10)
            ->get();

        $businessUnitTotals = BusinessUnit::with('branches')
            ->orderBy('name')
            ->get()
            ->map(function (BusinessUnit $businessUnit) use ($filters, $branchIds, $salesAmountExpression) {
                $unitBranchIds = $businessUnit->branches
                    ->pluck('id')
                    ->filter(fn ($branchId) => $branchIds->contains($branchId))
                    ->values();

                if ($unitBranchIds->isEmpty()) {
                    return null;
                }

                $transactions = $this->filteredTransactions($filters, $unitBranchIds);

                return (object) [
                    'name' => $businessUnit->name,
                    'transaction_count' => (clone $transactions)->count(),
                    'total_amount' => (float) (clone $transactions)->sum(DB::raw($salesAmountExpression)),
                ];
            })
            ->filter(fn ($unit) => $unit && ($unit->transaction_count > 0 || $unit->total_amount > 0))
            ->values();

        $trendFilters = array_merge($filters, [
            'date_from' => null,
            'date_to' => null,
        ]);

        $transactionsByMonth = $this->filteredTransactions($trendFilters, $branchIds)
            ->selectRaw("DATE_FORMAT(invoice_date, '%Y-%m') as month")
            ->selectRaw('COUNT(*) as transaction_count')
            ->selectRaw("SUM($salesAmountExpression) as total_amount")
            ->whereNotNull('invoice_date')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return [
            'branch_labels' => $branchTotals->map(fn ($item) => $item->branch->display_name ?? 'Unknown')->values(),
            'branch_counts' => $branchTotals->map(fn ($item) => (int) $item->transaction_count)->values(),
            'branch_amounts' => $branchTotals->map(fn ($item) => (float) $item->total_amount)->values(),
            'business_unit_labels' => $businessUnitTotals->map(fn ($item) => $item->name)->values(),
            'business_unit_counts' => $businessUnitTotals->map(fn ($item) => (int) $item->transaction_count)->values(),
            'business_unit_amounts' => $businessUnitTotals->map(fn ($item) => (float) $item->total_amount)->values(),
            'monthly_labels' => $transactionsByMonth->map(fn ($item) => $item->month)->values(),
            'monthly_counts' => $transactionsByMonth->map(fn ($item) => (int) $item->transaction_count)->values(),
            'monthly_amounts' => $transactionsByMonth->map(fn ($item) => (float) $item->total_amount)->values(),
        ];
    }

    private function topSellingBrands(Builder $query, string $salesAmountExpression): Collection
    {
        $brandExpression = "TRIM(sales_transactions.brand_name_raw)";

        $baseQuery = $query
            ->selectRaw("$brandExpression as label")
            ->selectRaw("$salesAmountExpression as sale_amount")
            ->whereNotNull('sales_transactions.brand_name_raw')
            ->whereRaw("$brandExpression != ''");

        return DB::query()
            ->fromSub($baseQuery->toBase(), 'brands')
            ->select('label')
            ->selectRaw('COUNT(*) as units_sold')
            ->selectRaw('SUM(sale_amount) as total_sales')
            ->groupBy('label')
            ->orderByDesc('units_sold')
            ->orderByDesc('total_sales')
            ->limit(3)
            ->get();
    }

    private function hotProduct(Builder $query, string $salesAmountExpression): ?object
    {
        $productNameExpression = "
            COALESCE(
                NULLIF(sales_transactions.model, ''),
                NULLIF(sales_transactions.product_description, ''),
                NULLIF(sales_transactions.product, ''),
                'Unknown Product'
            )
        ";

        $baseQuery = $query
            ->selectRaw("$productNameExpression as product_name")
            ->selectRaw("$salesAmountExpression as sale_amount");

        return DB::query()
            ->fromSub($baseQuery->toBase(), 'products')
            ->select('product_name')
            ->selectRaw('COUNT(*) as units_sold')
            ->selectRaw('SUM(sale_amount) as total_sales')
            ->groupBy('product_name')
            ->orderByDesc('units_sold')
            ->orderByDesc('total_sales')
            ->first();
    }

    private function hotProducts(Builder $query, string $salesAmountExpression): Collection
    {
        $productNameExpression = "
            COALESCE(
                NULLIF(TRIM(sales_transactions.model), ''),
                NULLIF(TRIM(sales_transactions.product_description), ''),
                NULLIF(TRIM(sales_transactions.product), '')
            )
        ";

        $baseQuery = $query
            ->selectRaw("$productNameExpression as label")
            ->selectRaw("$salesAmountExpression as sale_amount")
            ->whereRaw("$productNameExpression IS NOT NULL");

        return DB::query()
            ->fromSub($baseQuery->toBase(), 'products')
            ->select('label')
            ->selectRaw('COUNT(*) as units_sold')
            ->selectRaw('SUM(sale_amount) as total_sales')
            ->groupBy('label')
            ->orderByDesc('units_sold')
            ->orderByDesc('total_sales')
            ->limit(3)
            ->get();
    }

    private function highestTermShare(Builder $query, string $salesAmountExpression): ?object
    {
        $termsExpression = 'sales_transactions.terms';

        $totalTermTransactions = (clone $query)
            ->whereNotNull($termsExpression)
            ->where($termsExpression, '!=', '')
            ->count();

        $baseQuery = $query
            ->selectRaw("$termsExpression as terms")
            ->selectRaw("$salesAmountExpression as sale_amount")
            ->whereNotNull($termsExpression)
            ->where($termsExpression, '!=', '');

        $term = DB::query()
            ->fromSub($baseQuery->toBase(), 'terms')
            ->select('terms')
            ->selectRaw('COUNT(*) as units_sold')
            ->selectRaw('SUM(sale_amount) as total_sales')
            ->groupBy('terms')
            ->orderByDesc('units_sold')
            ->first();

        if ($term) {
            $term->share = $totalTermTransactions > 0
                ? round(($term->units_sold / $totalTermTransactions) * 100, 2)
                : 0;
        }

        return $term;
    }

    private function topTerms(Builder $query, string $salesAmountExpression): Collection
    {
        $termsExpression = 'TRIM(sales_transactions.terms)';

        $termQuery = (clone $query)
            ->whereNotNull('sales_transactions.terms')
            ->whereRaw("$termsExpression != ''")
            ->whereRaw("$termsExpression != '0'");

        $totalTermTransactions = (clone $termQuery)->count();

        $baseQuery = $termQuery
            ->selectRaw("$termsExpression as label")
            ->selectRaw("$salesAmountExpression as sale_amount");

        return DB::query()
            ->fromSub($baseQuery->toBase(), 'terms')
            ->select('label')
            ->selectRaw('COUNT(*) as units_sold')
            ->selectRaw('SUM(sale_amount) as total_sales')
            ->groupBy('label')
            ->orderByDesc('units_sold')
            ->limit(3)
            ->get()
            ->map(function ($term) use ($totalTermTransactions) {
                $term->share_percentage = $totalTermTransactions > 0
                    ? round(((int) $term->units_sold / $totalTermTransactions) * 100, 1)
                    : 0;

                return $term;
            });
    }

    private function cashTransactions(Builder $query): Builder
    {
        return $query->where(function ($query) {
            $query->whereIn(DB::raw('UPPER(TRIM(transaction_type))'), ['CASH', 'CASH SALES'])
                ->orWhere('cash_amount', '>', 0);
        });
    }

    private function installmentTransactions(Builder $query): Builder
    {
        return $query->where(function ($query) {
            $query->whereIn(DB::raw('UPPER(TRIM(transaction_type))'), ['INSTALLMENT', 'INSTALLMENT SALES'])
                ->orWhere('promissory_note_amount', '>', 0);
        });
    }

    private function applyProductGroupFilter(Builder $query, string $productGroup): void
    {
        $normalizedProductLine = DB::raw('UPPER(TRIM(product_line_name))');

        if ($productGroup === 'motorcycle') {
            $query->whereRaw('UPPER(TRIM(product_line_name)) = ?', ['MOTORCYCLE']);
        }

        if ($productGroup === 'appliance') {
            $query->whereIn($normalizedProductLine, ['APPLIANCE', 'APPLIANCES']);
        }

        if ($productGroup === 'furniture') {
            $query->whereIn($normalizedProductLine, ['FURNITURE']);
        }

        if ($productGroup === 'bed_foam') {
            $query->whereIn($normalizedProductLine, ['BED OR FOAM', 'BED FOAM', 'FOAM']);
        }

        if ($productGroup === 'spare_parts') {
            $query->whereIn($normalizedProductLine, ['SPARE PARTS', 'SPARE PART', 'PARTS']);
        }

        if ($productGroup === 'non_motorcycle') {
            $query->whereIn($normalizedProductLine, [
                'APPLIANCE',
                'APPLIANCES',
                'FURNITURE',
                'BED OR FOAM',
                'BED FOAM',
                'FOAM',
            ]);
        }
    }

    private function applyTransactionTypeFilter(Builder $query, string $transactionType): void
    {
        $normalizedTransactionType = DB::raw('UPPER(TRIM(transaction_type))');

        if ($transactionType === 'cash_sales') {
            $query->whereIn($normalizedTransactionType, ['CASH', 'CASH SALES']);
        }

        if ($transactionType === 'installment_sales') {
            $query->whereIn($normalizedTransactionType, ['INSTALLMENT', 'INSTALLMENT SALES']);
        }
    }

    private function salesAmountExpression(): string
    {
        return "
            COALESCE(
                NULLIF(sales_transactions.promissory_note_amount, 0),
                NULLIF(sales_transactions.cash_amount, 0),
                NULLIF(sales_transactions.gross_sales_amount, 0),
                NULLIF(sales_transactions.amount, 0),
                0
            )
        ";
    }
}
