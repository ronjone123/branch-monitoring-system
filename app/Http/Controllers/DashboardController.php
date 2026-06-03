<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\BusinessUnit;
use App\Models\ImportBatch;
use App\Models\SalesTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $selectedBusinessUnitId = $request->input('business_unit_id');
        $selectedBranchId = $request->input('branch_id');
        $datePreset = $request->input('date_preset');
        $hasExplicitDatePreset = $request->has('date_preset');
        $hasManualDateFilters = $request->filled('date_from') || $request->filled('date_to');
        $today = Carbon::today(config('app.timezone'));

        if (! $hasExplicitDatePreset && ! $hasManualDateFilters) {
            $datePreset = 'this_month';
        } elseif (! $hasExplicitDatePreset && $hasManualDateFilters) {
            $datePreset = 'custom';
        }

        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        switch ($datePreset) {
            case 'today':
                $dateFrom = $today->toDateString();
                $dateTo = $today->toDateString();
                break;
            case 'this_month':
                $dateFrom = $today->copy()->startOfMonth()->toDateString();
                $dateTo = $today->toDateString();
                break;
            case 'last_month':
                $lastMonth = $today->copy()->subMonthNoOverflow();
                $dateFrom = $lastMonth->copy()->startOfMonth()->toDateString();
                $dateTo = $lastMonth->copy()->endOfMonth()->toDateString();
                break;
            case 'year_to_date':
                $dateFrom = $today->copy()->startOfYear()->toDateString();
                $dateTo = $today->toDateString();
                break;
            case 'all_time':
                $dateFrom = null;
                $dateTo = null;
                break;
            case 'custom':
                break;
            default:
                $datePreset = 'this_month';
                $dateFrom = $today->copy()->startOfMonth()->toDateString();
                $dateTo = $today->toDateString();
                break;
        }

        $datePresetLabel = match ($datePreset) {
            'today' => 'Today',
            'this_month' => 'This Month',
            'last_month' => 'Last Month',
            'year_to_date' => 'Year to Date',
            'all_time' => 'All Time',
            'custom' => 'Custom Range',
            default => 'This Month',
        };

        $branchesQuery = Branch::query();

        if ($selectedBusinessUnitId) {
            $branchesQuery->where('business_unit_id', $selectedBusinessUnitId);
        }

        if ($selectedBranchId) {
            $branchesQuery->where('id', $selectedBranchId);
        }

        $filteredBranchIds = $branchesQuery->pluck('id');

        $applyTransactionFilters = function ($query) use ($filteredBranchIds, $dateFrom, $dateTo) {
            if ($filteredBranchIds->isNotEmpty()) {
                $query->whereIn('branch_id', $filteredBranchIds);
            } else {
                $query->whereRaw('1 = 0');
            }

            if ($dateFrom) {
                $query->whereDate('invoice_date', '>=', $dateFrom);
            }

            if ($dateTo) {
                $query->whereDate('invoice_date', '<=', $dateTo);
            }

            return $query;
        };

        $applianceCashBaseQuery = function () use ($dateFrom, $dateTo, $filteredBranchIds) {
            return SalesTransaction::query()
                ->whereIn('branch_id', $filteredBranchIds)
                ->whereHas('branch.businessUnit', function ($query) {
                    $query->where('code', 'L4');
                })
                ->whereNotNull('product_line_name')
                ->where('product_line_name', '!=', 'MOTORCYCLE')
                ->whereNotNull('cash_amount')
                ->where('cash_amount', '>', 0)
                ->when($dateFrom, function ($query) use ($dateFrom) {
                    $query->whereDate('invoice_date', '>=', $dateFrom);
                })
                ->when($dateTo, function ($query) use ($dateTo) {
                    $query->whereDate('invoice_date', '<=', $dateTo);
                });
        };

        $motorcycleCashBaseQuery = function () use ($dateFrom, $dateTo, $filteredBranchIds) {
            return SalesTransaction::query()
                ->whereIn('branch_id', $filteredBranchIds)
                ->whereHas('branch.businessUnit', function ($query) {
                    $query->whereIn('code', ['L4', 'M8']);
                })
                ->where('product_line_name', 'MOTORCYCLE')
                ->whereNotNull('cash_amount')
                ->where('cash_amount', '>', 0)
                ->when($dateFrom, function ($query) use ($dateFrom) {
                    $query->whereDate('invoice_date', '>=', $dateFrom);
                })
                ->when($dateTo, function ($query) use ($dateTo) {
                    $query->whereDate('invoice_date', '<=', $dateTo);
                });
        };
        $combinedCashBaseQuery = function () use ($dateFrom, $dateTo, $filteredBranchIds) {
            return SalesTransaction::query()
                ->whereIn('branch_id', $filteredBranchIds)
                ->whereHas('branch.businessUnit', function ($query) {
                    $query->whereIn('code', ['L4', 'M8']);
                })
                ->whereNotNull('product_line_name')
                ->whereIn('product_line_name', ['MOTORCYCLE', 'APPLIANCES', 'BED OR FOAM'])
                ->whereNotNull('cash_amount')
                ->where('cash_amount', '>', 0)
                ->when($dateFrom, function ($query) use ($dateFrom) {
                    $query->whereDate('invoice_date', '>=', $dateFrom);
                })
                ->when($dateTo, function ($query) use ($dateTo) {
                    $query->whereDate('invoice_date', '<=', $dateTo);
                });
        };

        $applianceInstallmentBaseQuery = function () use ($dateFrom, $dateTo, $filteredBranchIds) {
            return SalesTransaction::query()
                ->whereIn('branch_id', $filteredBranchIds)
                ->whereHas('branch.businessUnit', function ($query) {
                    $query->where('code', 'L4');
                })
                ->where('transaction_type', 'INSTALLMENT SALES')
                ->whereNotNull('product_line_name')
                ->where('product_line_name', '!=', 'MOTORCYCLE')
                ->whereNotNull('promissory_note_amount')
                ->where('promissory_note_amount', '>', 0)
                ->when($dateFrom, function ($query) use ($dateFrom) {
                    $query->whereDate('invoice_date', '>=', $dateFrom);
                })
                ->when($dateTo, function ($query) use ($dateTo) {
                    $query->whereDate('invoice_date', '<=', $dateTo);
                });
        };

        $motorcycleInstallmentBaseQuery = function () use ($dateFrom, $dateTo, $filteredBranchIds) {
            return SalesTransaction::query()
                ->whereIn('branch_id', $filteredBranchIds)
                ->whereHas('branch.businessUnit', function ($query) {
                    $query->whereIn('code', ['L4', 'M8']);
                })
                ->where('transaction_type', 'INSTALLMENT SALES')
                ->where('product_line_name', 'MOTORCYCLE')
                ->whereNotNull('promissory_note_amount')
                ->where('promissory_note_amount', '>', 0)
                ->when($dateFrom, function ($query) use ($dateFrom) {
                    $query->whereDate('invoice_date', '>=', $dateFrom);
                })
                ->when($dateTo, function ($query) use ($dateTo) {
                    $query->whereDate('invoice_date', '<=', $dateTo);
                });
        };

        $combinedInstallmentBaseQuery = function () use ($dateFrom, $dateTo, $filteredBranchIds) {
            return SalesTransaction::query()
                ->whereIn('branch_id', $filteredBranchIds)
                ->whereHas('branch.businessUnit', function ($query) {
                    $query->whereIn('code', ['L4', 'M8']);
                })
                ->where('transaction_type', 'INSTALLMENT SALES')
                ->whereNotNull('product_line_name')
                ->whereIn('product_line_name', ['MOTORCYCLE', 'APPLIANCES', 'BED OR FOAM'])
                ->whereNotNull('promissory_note_amount')
                ->where('promissory_note_amount', '>', 0)
                ->when($dateFrom, function ($query) use ($dateFrom) {
                    $query->whereDate('invoice_date', '>=', $dateFrom);
                })
                ->when($dateTo, function ($query) use ($dateTo) {
                    $query->whereDate('invoice_date', '<=', $dateTo);
                });
        };


        $totalBranches = $branchesQuery->count();

        $activeBranches = Branch::whereIn('id', $filteredBranchIds)
            ->where('status', 'active')
            ->count();

        $totalImportBatches = ImportBatch::count();
        $totalUsers = User::count();

        $transactionsBaseQuery = $applyTransactionFilters(SalesTransaction::query());

        $salesAmountExpression = "
            COALESCE(
                NULLIF(promissory_note_amount, 0),
                NULLIF(cash_amount, 0),
                NULLIF(gross_sales_amount, 0),
                NULLIF(amount, 0),
                0
            )
        ";

        $onlyFinancialSales = function ($query) {
            $query->where(function ($amountQuery) {
                $amountQuery->where('cash_amount', '>', 0)
                    ->orWhere('promissory_note_amount', '>', 0)
                    ->orWhere('gross_sales_amount', '>', 0)
                    ->orWhere('amount', '>', 0);
            });
        };


        $customerNameExpression = "UPPER(TRIM(customer_name))";
        $contactExpression = "UPPER(TRIM(COALESCE(contact_number, '')))";

        $topRepeatCustomers = (clone $transactionsBaseQuery)
            ->where($onlyFinancialSales)
            ->selectRaw("MAX(id) as latest_sales_transaction_id")
            ->selectRaw("MAX(customer_name) as customer_name")
            ->selectRaw("MAX(contact_number) as contact_number")
            ->selectRaw("COUNT(*) as transaction_count")
            ->selectRaw("COUNT(DISTINCT NULLIF(account_number, '')) as account_count")
            ->selectRaw("SUM(COALESCE(promissory_note_amount, 0)) as total_pn_amount")
            ->selectRaw("SUM($salesAmountExpression) as total_sales_amount")
            ->selectRaw("MIN(invoice_date) as first_purchase_date")
            ->selectRaw("MAX(invoice_date) as latest_purchase_date")
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

        $topPnCustomers = (clone $transactionsBaseQuery)
            ->where($onlyFinancialSales)
            ->selectRaw("MAX(id) as sales_transaction_id")
            ->selectRaw("MAX(customer_name) as customer_name")
            ->selectRaw("MAX(account_number) as account_number")
            ->selectRaw("MAX(receipt_number) as receipt_number")
            ->selectRaw("MAX(product_line_name) as product_line_name")
            ->selectRaw("MAX(brand_name_raw) as brand_name")
            ->selectRaw("MAX(model) as model")
            ->selectRaw("SUM(COALESCE(promissory_note_amount, 0)) as total_pn_amount")
            ->selectRaw("MAX(invoice_date) as latest_purchase_date")
            ->whereNotNull('customer_name')
            ->where('customer_name', '!=', '')
            ->whereNotNull('promissory_note_amount')
            ->where('promissory_note_amount', '>', 0)
            ->groupByRaw("UPPER(TRIM(account_number))")
            ->orderByDesc('total_pn_amount')
            ->limit(10)
            ->get();

        $latestRepeatCustomers = (clone $transactionsBaseQuery)
            ->where($onlyFinancialSales)
            ->selectRaw("MAX(id) as latest_sales_transaction_id")
            ->selectRaw("MAX(customer_name) as customer_name")
            ->selectRaw("MAX(contact_number) as contact_number")
            ->selectRaw("COUNT(*) as transaction_count")
            ->selectRaw("COUNT(DISTINCT NULLIF(account_number, '')) as account_count")
            ->selectRaw("MAX(invoice_date) as latest_purchase_date")
            ->whereNotNull('customer_name')
            ->where('customer_name', '!=', '')
            ->groupByRaw($customerNameExpression)
            ->groupByRaw($contactExpression)
            ->havingRaw("COUNT(DISTINCT NULLIF(account_number, '')) > 1 OR COUNT(*) > 1")
            ->orderByDesc('latest_purchase_date')
            ->limit(10)
            ->get();

        $topRepeatCustomerInsight = $topRepeatCustomers->first();
        $topPnCustomerInsight = $topPnCustomers->first();

        $topBrands = (clone $transactionsBaseQuery)
            ->select(
                'brand_name_raw as brand_name',
                DB::raw('COUNT(*) as transaction_count'),
                DB::raw("SUM($salesAmountExpression) as total_amount")
            )
            ->whereNotNull('brand_name_raw')
            ->where('brand_name_raw', '!=', '')
            ->groupBy('brand_name_raw')
            ->orderByDesc('transaction_count')
            ->limit(10)
            ->get();

        $validProductLines = [
            'MOTORCYCLE',
            'APPLIANCE',
            'APPLIANCES',
            'FURNITURE',
            'BED OR FOAM',
            'BED FOAM',
            'FOAM',
        ];

        $topProductLines = (clone $transactionsBaseQuery)
            ->selectRaw('UPPER(TRIM(product_line_name)) as product_line')
            ->selectRaw('COUNT(*) as transaction_count')
            ->selectRaw("SUM($salesAmountExpression) as total_amount")
            ->whereNotNull('product_line_name')
            ->where('product_line_name', '!=', '')
            ->whereIn(DB::raw('UPPER(TRIM(product_line_name))'), $validProductLines)
            ->groupBy(DB::raw('UPPER(TRIM(product_line_name))'))
            ->orderByDesc('transaction_count')
            ->limit(10)
            ->get();

        $productNameExpression = "
            COALESCE(
                NULLIF(model, ''),
                NULLIF(product_description, ''),
                NULLIF(product, ''),
                'Unknown Product'
            )
        ";

        $hotProducts = (clone $transactionsBaseQuery)
            ->selectRaw("$productNameExpression as product_name")
            ->selectRaw('COUNT(*) as transaction_count')
            ->selectRaw("SUM($salesAmountExpression) as total_amount")
            ->groupBy('product_name')
            ->orderByDesc('transaction_count')
            ->limit(10)
            ->get();

        $totalTermTransactions = (clone $transactionsBaseQuery)
            ->whereNotNull('terms')
            ->where('terms', '!=', '')
            ->count();

        $topTerms = (clone $transactionsBaseQuery)
            ->select(
                'terms',
                DB::raw('COUNT(*) as transaction_count'),
                DB::raw("SUM($salesAmountExpression) as total_amount")
            )
            ->whereNotNull('terms')
            ->where('terms', '!=', '')
            ->groupBy('terms')
            ->orderByDesc('transaction_count')
            ->limit(10)
            ->get()
            ->map(function ($term) use ($totalTermTransactions) {
                $term->percentage = $totalTermTransactions > 0
                    ? round(($term->transaction_count / $totalTermTransactions) * 100, 2)
                    : 0;

                return $term;
            });

        $topBrandInsight = $topBrands->first();
        $hotProductInsight = $hotProducts->first();
        $highestTermInsight = $topTerms->sortByDesc('percentage')->first();

        $filteredTransactionCount = (clone $transactionsBaseQuery)->count();

        $filteredTotalAmount = (clone $transactionsBaseQuery)
            ->sum('promissory_note_amount');

        $filteredCashAmount = (clone $transactionsBaseQuery)
            ->sum('cash_amount');

        $filteredSalesAmount = (float) ((clone $transactionsBaseQuery)
            ->selectRaw("SUM($salesAmountExpression) as total_amount")
            ->value('total_amount') ?? 0);

        $salesMixDetailReport = $this->buildSalesMixDetailReport($transactionsBaseQuery, $salesAmountExpression);

        $latestAvailableTransactionDate = (clone $transactionsBaseQuery)
            ->whereNotNull('invoice_date')
            ->max('invoice_date');

        $filteredBranchCount = (clone $transactionsBaseQuery)
            ->whereNotNull('branch_id')
            ->distinct('branch_id')
            ->count('branch_id');

        $topFilteredBranchResult = (clone $transactionsBaseQuery)
            ->select(
                'sales_transactions.branch_id',
                DB::raw('COUNT(sales_transactions.id) as transaction_count'),
                DB::raw('SUM(COALESCE(sales_transactions.promissory_note_amount, 0)) as filtered_total_amount')
            )
            ->whereNotNull('sales_transactions.branch_id')
            ->groupBy('sales_transactions.branch_id')
            ->orderByDesc('filtered_total_amount')
            ->first();

        $topFilteredBranch = null;

        if ($topFilteredBranchResult) {
            $branch = \App\Models\Branch::find($topFilteredBranchResult->branch_id);

            $topFilteredBranch = (object) [
                'branch_id' => $topFilteredBranchResult->branch_id,
                'branch_name' => $branch?->display_name ?? 'Branch #' . $topFilteredBranchResult->branch_id,
                'branch_code' => $branch?->code ?? '-',
                'transaction_count' => $topFilteredBranchResult->transaction_count,
                'filtered_total_amount' => $topFilteredBranchResult->filtered_total_amount,
            ];
        }


        $topFilteredBusinessUnitResult = (clone $transactionsBaseQuery)
            ->join('branches', 'sales_transactions.branch_id', '=', 'branches.id')
            ->select(
                'branches.business_unit_id',
                DB::raw('COUNT(sales_transactions.id) as transaction_count'),
                DB::raw('SUM(COALESCE(sales_transactions.promissory_note_amount, 0)) as filtered_total_amount')
            )
            ->whereNotNull('branches.business_unit_id')
            ->groupBy('branches.business_unit_id')
            ->orderByDesc('filtered_total_amount')
            ->first();

        $topFilteredBusinessUnit = null;

        if ($topFilteredBusinessUnitResult) {
            $businessUnit = \App\Models\BusinessUnit::find($topFilteredBusinessUnitResult->business_unit_id);

            $topFilteredBusinessUnit = (object) [
                'business_unit_id' => $topFilteredBusinessUnitResult->business_unit_id,
                'name' => $businessUnit?->name ?? 'Business Unit #' . $topFilteredBusinessUnitResult->business_unit_id,
                'code' => $businessUnit?->code ?? '-',
                'transaction_count' => $topFilteredBusinessUnitResult->transaction_count,
                'filtered_total_amount' => $topFilteredBusinessUnitResult->filtered_total_amount,
            ];
        }

        $activeFilteredBranches = $filteredBranchCount;

        $comparisonEnabled = false;

        $previousPeriodStart = null;
        $previousPeriodEnd = null;

        $previousPeriodTransactionCount = 0;
        $previousPeriodAmount = 0;
        $previousPeriodCashAmount = 0;
        $previousPeriodBranchCount = 0;

        $transactionChangePercent = null;
        $amountChangePercent = null;
        $cashAmountChangePercent = null;
        $branchCountChangePercent = null;

        $calculatePercentChange = function ($current, $previous): ?float {
            if ((float) $previous === 0.0) {
                return null;
            }

            return (((float) $current - (float) $previous) / abs((float) $previous)) * 100;
        };

        if ($dateFrom && $dateTo) {
            $currentPeriodStart = Carbon::parse($dateFrom)->startOfDay();
            $currentPeriodEnd = Carbon::parse($dateTo)->endOfDay();

            if ($currentPeriodStart->lte($currentPeriodEnd)) {
                $comparisonEnabled = true;

                $periodDays = $currentPeriodStart->diffInDays($currentPeriodEnd) + 1;

                $previousPeriodEnd = $currentPeriodStart->copy()->subDay();
                $previousPeriodStart = $previousPeriodEnd->copy()->subDays($periodDays - 1);

                $previousPeriodQuery = SalesTransaction::query();

                if ($filteredBranchIds->isNotEmpty()) {
                    $previousPeriodQuery->whereIn('branch_id', $filteredBranchIds);
                } else {
                    $previousPeriodQuery->whereRaw('1 = 0');
                }

                $previousPeriodQuery
                    ->whereDate('invoice_date', '>=', $previousPeriodStart->toDateString())
                    ->whereDate('invoice_date', '<=', $previousPeriodEnd->toDateString());

                $previousPeriodTransactionCount = (clone $previousPeriodQuery)->count();

                $previousPeriodAmount = (clone $previousPeriodQuery)
                    ->sum('promissory_note_amount');

                $previousPeriodCashAmount = (clone $previousPeriodQuery)
                    ->sum('cash_amount');

                $previousPeriodBranchCount = (clone $previousPeriodQuery)
                    ->whereNotNull('branch_id')
                    ->distinct('branch_id')
                    ->count('branch_id');

                $transactionChangePercent = $calculatePercentChange(
                    $filteredTransactionCount,
                    $previousPeriodTransactionCount
                );

                $amountChangePercent = $calculatePercentChange(
                    $filteredTotalAmount,
                    $previousPeriodAmount
                );

                $cashAmountChangePercent = $calculatePercentChange(
                    $filteredCashAmount,
                    $previousPeriodCashAmount
                );

                $branchCountChangePercent = $calculatePercentChange(
                    $filteredBranchCount,
                    $previousPeriodBranchCount
                );
            }
        }

        $today = now()->toDateString();
        $currentMonthStart = now()->startOfMonth()->toDateString();

        $reportDay = $dateTo ?: $today;

        $reportPeriodStart = $dateFrom
            ?: ($dateTo
                ? \Carbon\Carbon::parse($dateTo)->startOfMonth()->toDateString()
                : $currentMonthStart);

        $todayTransactionsQuery = $applyTransactionFilters(SalesTransaction::query())
            ->whereDate('invoice_date', $today);

        $monthToDateTransactionsQuery = $applyTransactionFilters(SalesTransaction::query())
            ->whereBetween('invoice_date', [$currentMonthStart, $today]);

        $branchPerformanceSummary = Branch::query()
            ->when($selectedBusinessUnitId, function ($query) use ($selectedBusinessUnitId) {
                $query->where('business_unit_id', $selectedBusinessUnitId);
            })
            ->when($selectedBranchId, function ($query) use ($selectedBranchId) {
                $query->where('id', $selectedBranchId);
            })
            ->with(['businessUnit', 'location'])
            ->get()
            ->map(function ($branch) use ($dateFrom, $dateTo, $onlyFinancialSales, $salesAmountExpression) {
                $branchSalesQuery = SalesTransaction::query()
                    ->where('branch_id', $branch->id)
                    ->where($onlyFinancialSales);

                if ($dateFrom) {
                    $branchSalesQuery->whereDate('invoice_date', '>=', $dateFrom);
                }

                if ($dateTo) {
                    $branchSalesQuery->whereDate('invoice_date', '<=', $dateTo);
                }

                return (object) [
                    'branch_id' => $branch->id,
                    'branch_code' => $branch->code,
                    'branch_name' => $branch->display_name,
                    'business_unit_name' => $branch->businessUnit->name ?? '-',
                    'transaction_count' => (clone $branchSalesQuery)->count(),
                    'cash_total' => (clone $branchSalesQuery)->sum('cash_amount'),
                    'pn_total' => (clone $branchSalesQuery)->sum('promissory_note_amount'),
                    'total_amount' => (float) ((clone $branchSalesQuery)
                        ->selectRaw("SUM($salesAmountExpression) as total_amount")
                        ->value('total_amount') ?? 0),
                ];
            })
            ->sortByDesc('total_amount')
            ->filter(fn ($branch) => $branch->transaction_count > 0)
            ->values();

        $applianceCashSummary = Branch::query()
            ->whereIn('id', $filteredBranchIds)
            ->whereHas('businessUnit', function ($query) {
                $query->where('code', 'L4');
            })
            ->with('businessUnit')
            ->orderBy('display_name')
            ->get()
            ->map(function ($branch) use ($reportDay, $reportPeriodStart, $applianceCashBaseQuery) {
                $base = fn () => $applianceCashBaseQuery()->where('branch_id', $branch->id);

                $todayBrandNew = $base()
                    ->whereDate('invoice_date', $reportDay)
                    ->where('unit_type', '!=', 'REPO');

                $todayRepo = $base()
                    ->whereDate('invoice_date', $reportDay)
                    ->where('unit_type', 'REPO');

                $toDateBrandNew = $base()
                    ->whereBetween('invoice_date', [$reportPeriodStart, $reportDay])
                    ->where('unit_type', '!=', 'REPO');

                $toDateRepo = $base()
                    ->whereBetween('invoice_date', [$reportPeriodStart, $reportDay])
                    ->where('unit_type', 'REPO');

                return (object) [
                    'branch_name' => $branch->display_name,
                    'branch_code' => $branch->code,

                    'today_brand_new_units' => (clone $todayBrandNew)->count(),
                    'today_brand_new_cod'   => (clone $todayBrandNew)->sum('cash_amount'),

                    'today_repo_units' => (clone $todayRepo)->count(),
                    'today_repo_cod'   => (clone $todayRepo)->sum('cash_amount'),

                    'todate_brand_new_units' => (clone $toDateBrandNew)->count(),
                    'todate_brand_new_cod'   => (clone $toDateBrandNew)->sum('cash_amount'),

                    'todate_repo_units' => (clone $toDateRepo)->count(),
                    'todate_repo_cod'   => (clone $toDateRepo)->sum('cash_amount'),

                    'total_units' => (clone $base())->whereBetween('invoice_date', [$reportPeriodStart, $reportDay])->count(),
                    'total_cod'   => (clone $base())->whereBetween('invoice_date', [$reportPeriodStart, $reportDay])->sum('cash_amount'),
                ];
            })
            ->values();

        $applianceCashTotals = (object) [
            'today_brand_new_units' => $applianceCashSummary->sum('today_brand_new_units'),
            'today_brand_new_cod'   => $applianceCashSummary->sum('today_brand_new_cod'),
            'today_repo_units'      => $applianceCashSummary->sum('today_repo_units'),
            'today_repo_cod'        => $applianceCashSummary->sum('today_repo_cod'),
            'todate_brand_new_units'=> $applianceCashSummary->sum('todate_brand_new_units'),
            'todate_brand_new_cod'  => $applianceCashSummary->sum('todate_brand_new_cod'),
            'todate_repo_units'     => $applianceCashSummary->sum('todate_repo_units'),
            'todate_repo_cod'       => $applianceCashSummary->sum('todate_repo_cod'),
            'total_units'           => $applianceCashSummary->sum('total_units'),
            'total_cod'             => $applianceCashSummary->sum('total_cod'),
        ];

        $applianceInstallmentSummary = Branch::query()
            ->whereIn('id', $filteredBranchIds)
            ->whereHas('businessUnit', function ($query) {
                $query->where('code', 'L4');
            })
            ->with('businessUnit')
            ->orderBy('display_name')
            ->get()
            ->map(function ($branch) use ($reportDay, $reportPeriodStart, $applianceInstallmentBaseQuery) {
                $base = fn () => $applianceInstallmentBaseQuery()->where('branch_id', $branch->id);

                $todayBrandNew = $base()
                    ->whereDate('invoice_date', $reportDay)
                    ->where('unit_type', '!=', 'REPO');

                $todayRepo = $base()
                    ->whereDate('invoice_date', $reportDay)
                    ->where('unit_type', 'REPO');

                $toDateBrandNew = $base()
                    ->whereBetween('invoice_date', [$reportPeriodStart, $reportDay])
                    ->where('unit_type', '!=', 'REPO');

                $toDateRepo = $base()
                    ->whereBetween('invoice_date', [$reportPeriodStart, $reportDay])
                    ->where('unit_type', 'REPO');

                return (object) [
                    'branch_name' => $branch->display_name,
                    'branch_code' => $branch->code,

                    'today_brand_new_units' => (clone $todayBrandNew)->count(),
                    'today_brand_new_amount' => (clone $todayBrandNew)->sum('promissory_note_amount'),

                    'today_repo_units' => (clone $todayRepo)->count(),
                    'today_repo_amount' => (clone $todayRepo)->sum('promissory_note_amount'),

                    'todate_brand_new_units' => (clone $toDateBrandNew)->count(),
                    'todate_brand_new_amount' => (clone $toDateBrandNew)->sum('promissory_note_amount'),

                    'todate_repo_units' => (clone $toDateRepo)->count(),
                    'todate_repo_amount' => (clone $toDateRepo)->sum('promissory_note_amount'),

                    'total_units' => (clone $base())->whereBetween('invoice_date', [$reportPeriodStart, $reportDay])->count(),
                    'total_amount' => (clone $base())->whereBetween('invoice_date', [$reportPeriodStart, $reportDay])->sum('promissory_note_amount'),
                ];
            })
            ->values();

        $applianceInstallmentTotals = (object) [
            'today_brand_new_units' => $applianceInstallmentSummary->sum('today_brand_new_units'),
            'today_brand_new_amount' => $applianceInstallmentSummary->sum('today_brand_new_amount'),
            'today_repo_units' => $applianceInstallmentSummary->sum('today_repo_units'),
            'today_repo_amount' => $applianceInstallmentSummary->sum('today_repo_amount'),
            'todate_brand_new_units' => $applianceInstallmentSummary->sum('todate_brand_new_units'),
            'todate_brand_new_amount' => $applianceInstallmentSummary->sum('todate_brand_new_amount'),
            'todate_repo_units' => $applianceInstallmentSummary->sum('todate_repo_units'),
            'todate_repo_amount' => $applianceInstallmentSummary->sum('todate_repo_amount'),
            'total_units' => $applianceInstallmentSummary->sum('total_units'),
            'total_amount' => $applianceInstallmentSummary->sum('total_amount'),
        ];

        $motorcycleCashSummary = Branch::query()
            ->whereIn('id', $filteredBranchIds)
            ->whereHas('businessUnit', function ($query) {
                $query->whereIn('code', ['L4', 'M8']);
            })
            ->with('businessUnit')
            ->orderBy('display_name')
            ->get()
            ->map(function ($branch) use ($reportDay, $reportPeriodStart, $motorcycleCashBaseQuery) {
                $base = fn () => $motorcycleCashBaseQuery()->where('branch_id', $branch->id);

                $todayBrandNew = $base()
                    ->whereDate('invoice_date', $reportDay)
                    ->where('unit_type', '!=', 'REPO');

                $todayRepo = $base()
                    ->whereDate('invoice_date', $reportDay)
                    ->where('unit_type', 'REPO');

                $toDateBrandNew = $base()
                    ->whereBetween('invoice_date', [$reportPeriodStart, $reportDay])
                    ->where('unit_type', '!=', 'REPO');

                $toDateRepo = $base()
                    ->whereBetween('invoice_date', [$reportPeriodStart, $reportDay])
                    ->where('unit_type', 'REPO');

                return (object) [
                    'branch_name' => $branch->display_name,
                    'branch_code' => $branch->code,

                    'today_brand_new_units' => (clone $todayBrandNew)->count(),
                    'today_brand_new_cod'   => (clone $todayBrandNew)->sum('cash_amount'),

                    'today_repo_units' => (clone $todayRepo)->count(),
                    'today_repo_cod'   => (clone $todayRepo)->sum('cash_amount'),

                    'todate_brand_new_units' => (clone $toDateBrandNew)->count(),
                    'todate_brand_new_cod'   => (clone $toDateBrandNew)->sum('cash_amount'),

                    'todate_repo_units' => (clone $toDateRepo)->count(),
                    'todate_repo_cod'   => (clone $toDateRepo)->sum('cash_amount'),

                    'total_units' => (clone $base())->whereBetween('invoice_date', [$reportPeriodStart, $reportDay])->count(),
                    'total_cod'   => (clone $base())->whereBetween('invoice_date', [$reportPeriodStart, $reportDay])->sum('cash_amount'),
                ];
            })
            ->values();

        $motorcycleCashTotals = (object) [
            'today_brand_new_units' => $motorcycleCashSummary->sum('today_brand_new_units'),
            'today_brand_new_cod'   => $motorcycleCashSummary->sum('today_brand_new_cod'),
            'today_repo_units'      => $motorcycleCashSummary->sum('today_repo_units'),
            'today_repo_cod'        => $motorcycleCashSummary->sum('today_repo_cod'),
            'todate_brand_new_units'=> $motorcycleCashSummary->sum('todate_brand_new_units'),
            'todate_brand_new_cod'  => $motorcycleCashSummary->sum('todate_brand_new_cod'),
            'todate_repo_units'     => $motorcycleCashSummary->sum('todate_repo_units'),
            'todate_repo_cod'       => $motorcycleCashSummary->sum('todate_repo_cod'),
            'total_units'           => $motorcycleCashSummary->sum('total_units'),
            'total_cod'             => $motorcycleCashSummary->sum('total_cod'),
        ];

        $motorcycleInstallmentSummary = Branch::query()
            ->whereIn('id', $filteredBranchIds)
            ->whereHas('businessUnit', function ($query) {
                $query->whereIn('code', ['L4', 'M8']);
            })
            ->with('businessUnit')
            ->orderBy('display_name')
            ->get()
            ->map(function ($branch) use ($reportDay, $reportPeriodStart, $motorcycleInstallmentBaseQuery) {
                $base = fn () => $motorcycleInstallmentBaseQuery()->where('branch_id', $branch->id);

                $todayBrandNew = $base()
                    ->whereDate('invoice_date', $reportDay)
                    ->where('unit_type', '!=', 'REPO');

                $todayRepo = $base()
                    ->whereDate('invoice_date', $reportDay)
                    ->where('unit_type', 'REPO');

                $toDateBrandNew = $base()
                    ->whereBetween('invoice_date', [$reportPeriodStart, $reportDay])
                    ->where('unit_type', '!=', 'REPO');

                $toDateRepo = $base()
                    ->whereBetween('invoice_date', [$reportPeriodStart, $reportDay])
                    ->where('unit_type', 'REPO');

                return (object) [
                    'branch_name' => $branch->display_name,
                    'branch_code' => $branch->code,

                    'today_brand_new_units' => (clone $todayBrandNew)->count(),
                    'today_brand_new_amount' => (clone $todayBrandNew)->sum('promissory_note_amount'),

                    'today_repo_units' => (clone $todayRepo)->count(),
                    'today_repo_amount' => (clone $todayRepo)->sum('promissory_note_amount'),

                    'todate_brand_new_units' => (clone $toDateBrandNew)->count(),
                    'todate_brand_new_amount' => (clone $toDateBrandNew)->sum('promissory_note_amount'),

                    'todate_repo_units' => (clone $toDateRepo)->count(),
                    'todate_repo_amount' => (clone $toDateRepo)->sum('promissory_note_amount'),

                    'total_units' => (clone $base())->whereBetween('invoice_date', [$reportPeriodStart, $reportDay])->count(),
                    'total_amount' => (clone $base())->whereBetween('invoice_date', [$reportPeriodStart, $reportDay])->sum('promissory_note_amount'),
                ];
            })
            ->values();

        $motorcycleInstallmentTotals = (object) [
            'today_brand_new_units' => $motorcycleInstallmentSummary->sum('today_brand_new_units'),
            'today_brand_new_amount' => $motorcycleInstallmentSummary->sum('today_brand_new_amount'),
            'today_repo_units' => $motorcycleInstallmentSummary->sum('today_repo_units'),
            'today_repo_amount' => $motorcycleInstallmentSummary->sum('today_repo_amount'),
            'todate_brand_new_units' => $motorcycleInstallmentSummary->sum('todate_brand_new_units'),
            'todate_brand_new_amount' => $motorcycleInstallmentSummary->sum('todate_brand_new_amount'),
            'todate_repo_units' => $motorcycleInstallmentSummary->sum('todate_repo_units'),
            'todate_repo_amount' => $motorcycleInstallmentSummary->sum('todate_repo_amount'),
            'total_units' => $motorcycleInstallmentSummary->sum('total_units'),
            'total_amount' => $motorcycleInstallmentSummary->sum('total_amount'),
        ];

        $combinedCashSummary = Branch::query()
            ->whereIn('id', $filteredBranchIds)
            ->whereHas('businessUnit', function ($query) {
                $query->whereIn('code', ['L4', 'M8']);
            })
            ->with('businessUnit')
            ->orderBy('display_name')
            ->get()
            ->map(function ($branch) use ($reportDay, $reportPeriodStart, $combinedCashBaseQuery) {
                $base = fn () => $combinedCashBaseQuery()->where('branch_id', $branch->id);

                $todayBrandNew = $base()
                    ->whereDate('invoice_date', $reportDay)
                    ->where('unit_type', '!=', 'REPO');

                $todayRepo = $base()
                    ->whereDate('invoice_date', $reportDay)
                    ->where('unit_type', 'REPO');

                $toDateBrandNew = $base()
                    ->whereBetween('invoice_date', [$reportPeriodStart, $reportDay])
                    ->where('unit_type', '!=', 'REPO');

                $toDateRepo = $base()
                    ->whereBetween('invoice_date', [$reportPeriodStart, $reportDay])
                    ->where('unit_type', 'REPO');

                return (object) [
                    'branch_name' => $branch->display_name,
                    'branch_code' => $branch->code,
                    'business_unit_name' => $branch->businessUnit->name ?? '-',

                    'today_brand_new_units' => (clone $todayBrandNew)->count(),
                    'today_brand_new_cod'   => (clone $todayBrandNew)->sum('cash_amount'),

                    'today_repo_units' => (clone $todayRepo)->count(),
                    'today_repo_cod'   => (clone $todayRepo)->sum('cash_amount'),

                    'todate_brand_new_units' => (clone $toDateBrandNew)->count(),
                    'todate_brand_new_cod'   => (clone $toDateBrandNew)->sum('cash_amount'),

                    'todate_repo_units' => (clone $toDateRepo)->count(),
                    'todate_repo_cod'   => (clone $toDateRepo)->sum('cash_amount'),

                    'total_units' => (clone $base())->whereBetween('invoice_date', [$reportPeriodStart, $reportDay])->count(),
                    'total_cod'   => (clone $base())->whereBetween('invoice_date', [$reportPeriodStart, $reportDay])->sum('cash_amount'),
                ];
            })
            ->values();

            $combinedCashTotals = (object) [
            'today_brand_new_units' => $combinedCashSummary->sum('today_brand_new_units'),
            'today_brand_new_cod'   => $combinedCashSummary->sum('today_brand_new_cod'),

            'today_repo_units' => $combinedCashSummary->sum('today_repo_units'),
            'today_repo_cod'   => $combinedCashSummary->sum('today_repo_cod'),

            'todate_brand_new_units' => $combinedCashSummary->sum('todate_brand_new_units'),
            'todate_brand_new_cod'   => $combinedCashSummary->sum('todate_brand_new_cod'),

            'todate_repo_units' => $combinedCashSummary->sum('todate_repo_units'),
            'todate_repo_cod'   => $combinedCashSummary->sum('todate_repo_cod'),

            'total_units' => $combinedCashSummary->sum('total_units'),
            'total_cod'   => $combinedCashSummary->sum('total_cod'),
        ];

        $combinedInstallmentSummary = Branch::query()
            ->whereIn('id', $filteredBranchIds)
            ->whereHas('businessUnit', function ($query) {
                $query->whereIn('code', ['L4', 'M8']);
            })
            ->with('businessUnit')
            ->orderBy('display_name')
            ->get()
            ->map(function ($branch) use ($reportDay, $reportPeriodStart, $combinedInstallmentBaseQuery) {
                $base = fn () => $combinedInstallmentBaseQuery()->where('branch_id', $branch->id);

                $todayBrandNew = $base()
                    ->whereDate('invoice_date', $reportDay)
                    ->where('unit_type', '!=', 'REPO');

                $todayRepo = $base()
                    ->whereDate('invoice_date', $reportDay)
                    ->where('unit_type', 'REPO');

                $toDateBrandNew = $base()
                    ->whereBetween('invoice_date', [$reportPeriodStart, $reportDay])
                    ->where('unit_type', '!=', 'REPO');

                $toDateRepo = $base()
                    ->whereBetween('invoice_date', [$reportPeriodStart, $reportDay])
                    ->where('unit_type', 'REPO');

                return (object) [
                    'branch_name' => $branch->display_name,
                    'branch_code' => $branch->code,

                    'today_brand_new_units' => (clone $todayBrandNew)->count(),
                    'today_brand_new_amount' => (clone $todayBrandNew)->sum('promissory_note_amount'),

                    'today_repo_units' => (clone $todayRepo)->count(),
                    'today_repo_amount' => (clone $todayRepo)->sum('promissory_note_amount'),

                    'todate_brand_new_units' => (clone $toDateBrandNew)->count(),
                    'todate_brand_new_amount' => (clone $toDateBrandNew)->sum('promissory_note_amount'),

                    'todate_repo_units' => (clone $toDateRepo)->count(),
                    'todate_repo_amount' => (clone $toDateRepo)->sum('promissory_note_amount'),

                    'total_units' => (clone $base())->whereBetween('invoice_date', [$reportPeriodStart, $reportDay])->count(),
                    'total_amount' => (clone $base())->whereBetween('invoice_date', [$reportPeriodStart, $reportDay])->sum('promissory_note_amount'),
                ];
            })
            ->values();

        $combinedInstallmentTotals = (object) [
            'today_brand_new_units' => $combinedInstallmentSummary->sum('today_brand_new_units'),
            'today_brand_new_amount' => $combinedInstallmentSummary->sum('today_brand_new_amount'),
            'today_repo_units' => $combinedInstallmentSummary->sum('today_repo_units'),
            'today_repo_amount' => $combinedInstallmentSummary->sum('today_repo_amount'),
            'todate_brand_new_units' => $combinedInstallmentSummary->sum('todate_brand_new_units'),
            'todate_brand_new_amount' => $combinedInstallmentSummary->sum('todate_brand_new_amount'),
            'todate_repo_units' => $combinedInstallmentSummary->sum('todate_repo_units'),
            'todate_repo_amount' => $combinedInstallmentSummary->sum('todate_repo_amount'),
            'total_units' => $combinedInstallmentSummary->sum('total_units'),
            'total_amount' => $combinedInstallmentSummary->sum('total_amount'),
        ];

        $todayTransactionCount = (clone $todayTransactionsQuery)->count();
        $todayAmount = (clone $todayTransactionsQuery)->sum('promissory_note_amount');

        $monthToDateTransactionCount = (clone $monthToDateTransactionsQuery)->count();
        $monthToDateAmount = (clone $monthToDateTransactionsQuery)->sum('promissory_note_amount');

        $totalSalesTransactions = (clone $transactionsBaseQuery)->count();
        $totalImportedAmount = (clone $transactionsBaseQuery)->sum('promissory_note_amount');

        $latestImportBatches = ImportBatch::with('user')
            ->latest()
            ->take(5)
            ->get();

        $latestTransactions = $applyTransactionFilters(
            SalesTransaction::with(['branch', 'importBatch'])
        )
            ->whereNotNull('invoice_date')
            ->orderByDesc('invoice_date')
            ->orderByDesc('id')
            ->take(10)
            ->get();

        $branchTotals = $applyTransactionFilters(
            SalesTransaction::select(
                'branch_id',
                DB::raw('COUNT(*) as transaction_count'),
                DB::raw('COALESCE(SUM(cash_amount), 0) as cash_sales'),
                DB::raw('COALESCE(SUM(promissory_note_amount), 0) as pn_sales'),
                DB::raw("SUM($salesAmountExpression) as total_sales")
            )->with('branch')
        )
            ->groupBy('branch_id')
            ->orderByDesc('transaction_count')
            ->take(10)
            ->get();

        $businessUnitTotals = BusinessUnit::withCount('branches')
            ->with('branches')
            ->get()
            ->map(function ($businessUnit) use ($selectedBusinessUnitId, $selectedBranchId, $dateFrom, $dateTo) {
                $branchIds = $businessUnit->branches->pluck('id');

                if ($selectedBusinessUnitId && (int) $businessUnit->id !== (int) $selectedBusinessUnitId) {
                    $branchIds = collect();
                }

                if ($selectedBranchId) {
                    $branchIds = $branchIds->filter(fn ($id) => (int) $id === (int) $selectedBranchId);
                }

                $transactionCount = $branchIds->isNotEmpty()
                    ? SalesTransaction::when($dateFrom, fn ($query) => $query->whereDate('invoice_date', '>=', $dateFrom))
                        ->when($dateTo, fn ($query) => $query->whereDate('invoice_date', '<=', $dateTo))
                        ->whereIn('branch_id', $branchIds)
                        ->count()
                    : 0;

                $totalAmount = $branchIds->isNotEmpty()
                    ? SalesTransaction::when($dateFrom, fn ($query) => $query->whereDate('invoice_date', '>=', $dateFrom))
                        ->when($dateTo, fn ($query) => $query->whereDate('invoice_date', '<=', $dateTo))
                        ->whereIn('branch_id', $branchIds)
                        ->sum('promissory_note_amount')
                    : 0;

                return (object) [
                    'name' => $businessUnit->name,
                    'code' => $businessUnit->code,
                    'branch_count' => $branchIds->count(),
                    'transaction_count' => $transactionCount,
                    'total_amount' => $totalAmount,
                ];
            })
            ->filter(function ($unit) {
                return $unit->branch_count > 0 || $unit->transaction_count > 0 || $unit->total_amount > 0;
            })
            ->values();

        $topBranchThisMonth = $branchPerformanceSummary->first();
        $topBusinessUnitThisMonth = $businessUnitTotals->sortByDesc('total_amount')->first();
        $topFiveBranchesThisMonth = $branchPerformanceSummary->take(5)->values();

        $branchChartLabels = $branchTotals->map(fn ($item) => $item->branch->display_name ?? 'Unknown')->values();
        $branchChartCounts = $branchTotals->map(fn ($item) => (int) $item->transaction_count)->values();
        $branchChartAmounts = $branchTotals->map(fn ($item) => (float) $item->total_sales)->values();

        $businessUnitChartLabels = $businessUnitTotals->map(fn ($item) => $item->name)->values();
        $businessUnitChartCounts = $businessUnitTotals->map(fn ($item) => (int) $item->transaction_count)->values();
        $businessUnitChartAmounts = $businessUnitTotals->map(fn ($item) => (float) $item->total_amount)->values();

        $transactionsByMonth = $applyTransactionFilters(
            SalesTransaction::select(
                DB::raw("DATE_FORMAT(invoice_date, '%Y-%m') as month"),
                DB::raw('COUNT(*) as transaction_count'),
                DB::raw('COALESCE(SUM(promissory_note_amount), 0) as total_amount')
            )
        )
            ->whereNotNull('invoice_date')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $transactionsByMonthLabels = $transactionsByMonth->map(fn ($item) => $item->month)->values();
        $transactionsByMonthCounts = $transactionsByMonth->map(fn ($item) => (int) $item->transaction_count)->values();
        $transactionsByMonthAmounts = $transactionsByMonth->map(fn ($item) => (float) $item->total_amount)->values();

        $businessUnits = BusinessUnit::orderBy('name')->get();

        $branches = Branch::when($selectedBusinessUnitId, function ($query) use ($selectedBusinessUnitId) {
            $query->where('business_unit_id', $selectedBusinessUnitId);
        })
            ->orderBy('display_name')
            ->get();


        return view('dashboard', compact(
            'totalBranches',
            'activeBranches',
            'totalImportBatches',
            'totalSalesTransactions',
            'totalUsers',
            'totalImportedAmount',
            'filteredTransactionCount',
            'filteredTotalAmount',
            'filteredCashAmount',
            'filteredSalesAmount',
            'salesMixDetailReport',
            'latestAvailableTransactionDate',
            'filteredBranchCount',
            'latestImportBatches',
            'latestTransactions',
            'branchTotals',
            'businessUnitTotals',
            'branchChartLabels',
            'branchChartCounts',
            'branchChartAmounts',
            'businessUnitChartLabels',
            'businessUnitChartCounts',
            'businessUnitChartAmounts',
            'transactionsByMonthLabels',
            'transactionsByMonthCounts',
            'transactionsByMonthAmounts',
            'businessUnits',
            'branches',
            'selectedBusinessUnitId',
            'selectedBranchId',
            'datePreset',
            'datePresetLabel',
            'dateFrom',
            'dateTo',
            'todayTransactionCount',
            'todayAmount',
            'monthToDateTransactionCount',
            'monthToDateAmount',
            'branchPerformanceSummary',
            'topBranchThisMonth',
            'topBusinessUnitThisMonth',
            'topFiveBranchesThisMonth',
            'applianceCashSummary',
            'applianceCashTotals',
            'motorcycleCashSummary',
            'motorcycleCashTotals',
            'combinedCashSummary',
            'combinedCashTotals',
            'applianceInstallmentSummary',
            'applianceInstallmentTotals',
            'motorcycleInstallmentSummary',
            'motorcycleInstallmentTotals',
            'combinedInstallmentSummary',
            'combinedInstallmentTotals',
            'comparisonEnabled',
            'previousPeriodStart',
            'previousPeriodEnd',
            'previousPeriodTransactionCount',
            'previousPeriodAmount',
            'previousPeriodCashAmount',
            'previousPeriodBranchCount',
            'transactionChangePercent',
            'amountChangePercent',
            'cashAmountChangePercent',
            'branchCountChangePercent',
            'topFilteredBranch',
            'topFilteredBusinessUnit',
            'activeFilteredBranches',
            'topBrands',
            'topProductLines',
            'hotProducts',
            'topTerms',
            'topBrandInsight',
            'hotProductInsight',
            'highestTermInsight',
            'topRepeatCustomers',
            'topPnCustomers',
            'latestRepeatCustomers',
            'topRepeatCustomerInsight',
            'topPnCustomerInsight',
        ));
    }

    private function buildSalesMixDetailReport($transactionsBaseQuery, string $salesAmountExpression): array
    {
        $cashQuery = (clone $transactionsBaseQuery)->where('cash_amount', '>', 0);
        $pnQuery = (clone $transactionsBaseQuery)->where('promissory_note_amount', '>', 0);
        $paymentTotal = (float) (clone $cashQuery)->sum('cash_amount')
            + (float) (clone $pnQuery)->sum('promissory_note_amount');

        $paymentMix = [
            $this->buildSalesMixRow(
                'Cash Sales',
                $cashQuery,
                $paymentTotal,
                'cash_amount',
                true
            ),
            $this->buildSalesMixRow(
                'PN / Installment Sales',
                $pnQuery,
                $paymentTotal,
                'promissory_note_amount',
                true
            ),
        ];

        $brandNewQuery = (clone $transactionsBaseQuery)->where('unit_type', '!=', 'REPO');
        $repoQuery = (clone $transactionsBaseQuery)->where('unit_type', 'REPO');
        $unitStatusTotal = $this->sumSalesMixAmount($brandNewQuery, $salesAmountExpression)
            + $this->sumSalesMixAmount($repoQuery, $salesAmountExpression);

        $unitStatusMix = [
            $this->buildSalesMixRow(
                'Brand New',
                $brandNewQuery,
                $unitStatusTotal,
                null,
                false,
                true,
                true,
                $salesAmountExpression
            ),
            $this->buildSalesMixRow(
                'Repo',
                $repoQuery,
                $unitStatusTotal,
                null,
                false,
                true,
                true,
                $salesAmountExpression
            ),
        ];

        $productGroupDefinitions = [
            [
                'label' => 'Motorcycle',
                'filter' => fn ($query) => $query->whereRaw("UPPER(TRIM(COALESCE(product_line_name, ''))) = ?", ['MOTORCYCLE']),
            ],
            [
                'label' => 'Appliance / Appliances',
                'filter' => fn ($query) => $query->whereIn(DB::raw("UPPER(TRIM(COALESCE(product_line_name, '')))"), ['APPLIANCE', 'APPLIANCES']),
            ],
            [
                'label' => 'Furniture',
                'filter' => fn ($query) => $query->whereRaw("UPPER(TRIM(COALESCE(product_line_name, ''))) = ?", ['FURNITURE']),
            ],
            [
                'label' => 'Bed/Foam',
                'filter' => fn ($query) => $query->whereIn(DB::raw("UPPER(TRIM(COALESCE(product_line_name, '')))"), ['BED OR FOAM', 'BED FOAM', 'FOAM']),
            ],
            [
                'label' => 'Spare Parts',
                'filter' => fn ($query) => $query->whereIn(DB::raw("UPPER(TRIM(COALESCE(product_line_name, '')))"), ['SPARE PARTS', 'SPARE PART', 'PARTS']),
            ],
            [
                'label' => 'Needs Classification',
                'filter' => function ($query) {
                    $validProductLines = [
                        'MOTORCYCLE',
                        'APPLIANCE',
                        'APPLIANCES',
                        'FURNITURE',
                        'BED OR FOAM',
                        'BED FOAM',
                        'FOAM',
                        'SPARE PARTS',
                        'SPARE PART',
                        'PARTS',
                    ];

                    $query->where(function ($classificationQuery) use ($validProductLines) {
                        $classificationQuery
                            ->whereNull('product_line_name')
                            ->orWhereRaw("TRIM(COALESCE(product_line_name, '')) = ''")
                            ->orWhereNotIn(DB::raw("UPPER(TRIM(COALESCE(product_line_name, '')))"), $validProductLines);
                    });
                },
            ],
        ];

        $productGroupQueries = collect($productGroupDefinitions)
            ->map(function ($definition) use ($transactionsBaseQuery) {
                $query = clone $transactionsBaseQuery;
                $definition['filter']($query);

                return [
                    'label' => $definition['label'],
                    'query' => $query,
                ];
            });

        $productGroupTotal = $productGroupQueries
            ->sum(fn ($group) => $this->sumSalesMixAmount($group['query'], $salesAmountExpression));

        $productGroupMix = $productGroupQueries
            ->map(function ($group) use ($productGroupTotal, $salesAmountExpression) {
                return $this->buildSalesMixRow(
                    $group['label'],
                    $group['query'],
                    $productGroupTotal,
                    null,
                    false,
                    true,
                    true,
                    $salesAmountExpression
                );
            })
            ->filter(fn ($row) => $row['transactions'] > 0 || $row['amount'] > 0)
            ->values()
            ->all();

        return [
            'payment_mix' => $paymentMix,
            'unit_status_mix' => $unitStatusMix,
            'product_group_mix' => $productGroupMix,
        ];
    }

    private function buildSalesMixRow(
        string $label,
        $query,
        float $shareTotal,
        ?string $amountColumn = null,
        bool $includeTopBranch = false,
        bool $includeTopBrand = false,
        bool $includeTopProduct = false,
        ?string $salesAmountExpression = null
    ): array {
        $amount = $amountColumn
            ? (float) (clone $query)->sum($amountColumn)
            : $this->sumSalesMixAmount($query, $salesAmountExpression);

        return [
            'label' => $label,
            'transactions' => (int) (clone $query)->count(),
            'amount' => $amount,
            'share' => $shareTotal > 0 ? ($amount / $shareTotal) * 100 : 0,
            'top_branch' => $includeTopBranch ? $this->topSalesMixBranch($query, $amountColumn, $salesAmountExpression) : null,
            'top_brand' => $includeTopBrand ? $this->topSalesMixValue($query, 'brand', $salesAmountExpression) : null,
            'top_product' => $includeTopProduct ? $this->topSalesMixValue($query, 'product', $salesAmountExpression) : null,
        ];
    }

    private function sumSalesMixAmount($query, ?string $salesAmountExpression): float
    {
        if (! $salesAmountExpression) {
            return 0;
        }

        return (float) ((clone $query)
            ->selectRaw("SUM($salesAmountExpression) as total_amount")
            ->value('total_amount') ?? 0);
    }

    private function topSalesMixBranch($query, ?string $amountColumn, ?string $salesAmountExpression): ?string
    {
        $amountSelect = $amountColumn
            ? "SUM(COALESCE($amountColumn, 0))"
            : "SUM($salesAmountExpression)";

        $topBranch = (clone $query)
            ->select('branch_id')
            ->selectRaw('COUNT(*) as transaction_count')
            ->selectRaw("$amountSelect as total_amount")
            ->whereNotNull('branch_id')
            ->groupBy('branch_id')
            ->orderByDesc('transaction_count')
            ->orderByDesc('total_amount')
            ->first();

        if (! $topBranch) {
            return null;
        }

        $branch = Branch::find($topBranch->branch_id);

        return $branch?->display_name ?? $branch?->code ?? 'Branch #' . $topBranch->branch_id;
    }

    private function topSalesMixValue($query, string $type, string $salesAmountExpression): ?string
    {
        $labelExpression = $type === 'brand'
            ? "UPPER(TRIM(brand_name_raw))"
            : "UPPER(TRIM(COALESCE(NULLIF(model, ''), NULLIF(product, ''), NULLIF(product_description, ''), NULLIF(parts_number, ''))))";

        $labelRows = (clone $query)
            ->selectRaw("$labelExpression as label")
            ->selectRaw("$salesAmountExpression as row_amount")
            ->whereRaw("$labelExpression IS NOT NULL")
            ->whereRaw("$labelExpression != ''");

        $topValue = DB::query()
            ->fromSub($labelRows, 'sales_mix_labels')
            ->select('label')
            ->selectRaw('COUNT(*) as transaction_count')
            ->selectRaw('SUM(row_amount) as total_amount')
            ->groupBy('label')
            ->orderByDesc('transaction_count')
            ->orderByDesc('total_amount')
            ->first();

        return $topValue?->label;
    }
}
