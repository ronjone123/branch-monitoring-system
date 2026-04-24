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

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $selectedBusinessUnitId = $request->input('business_unit_id');
        $selectedBranchId = $request->input('branch_id');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

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

        $applianceCashBaseQuery = function () use ($dateFrom, $dateTo) {
            return SalesTransaction::query()
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

        $motorcycleCashBaseQuery = function () use ($dateFrom, $dateTo) {
            return SalesTransaction::query()
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
        $combinedCashBaseQuery = function () use ($dateFrom, $dateTo) {
            return SalesTransaction::query()
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

        $applianceInstallmentBaseQuery = function () use ($dateFrom, $dateTo) {
            return SalesTransaction::query()
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

        $motorcycleInstallmentBaseQuery = function () use ($dateFrom, $dateTo) {
            return SalesTransaction::query()
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

        $combinedInstallmentBaseQuery = function () use ($dateFrom, $dateTo) {
            return SalesTransaction::query()
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

        $today = now()->toDateString();
        $currentMonthStart = now()->startOfMonth()->toDateString();

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
            ->map(function ($branch) use ($today, $currentMonthStart, $dateFrom, $dateTo) {
                $todayQuery = SalesTransaction::query()
                    ->where('branch_id', $branch->id)
                    ->whereDate('invoice_date', $today);

                $monthToDateQuery = SalesTransaction::query()
                    ->where('branch_id', $branch->id)
                    ->whereBetween('invoice_date', [$currentMonthStart, $today]);

                if ($dateFrom) {
                    $todayQuery->whereDate('invoice_date', '>=', $dateFrom);
                    $monthToDateQuery->whereDate('invoice_date', '>=', $dateFrom);
                }

                if ($dateTo) {
                    $todayQuery->whereDate('invoice_date', '<=', $dateTo);
                    $monthToDateQuery->whereDate('invoice_date', '<=', $dateTo);
                }

                return (object) [
                    'branch_id' => $branch->id,
                    'branch_code' => $branch->code,
                    'branch_name' => $branch->display_name,
                    'business_unit_name' => $branch->businessUnit->name ?? '-',
                    'today_transaction_count' => (clone $todayQuery)->count(),
                    'today_amount' => (clone $todayQuery)->sum('promissory_note_amount'),
                    'month_to_date_transaction_count' => (clone $monthToDateQuery)->count(),
                    'month_to_date_amount' => (clone $monthToDateQuery)->sum('promissory_note_amount'),
                ];
            })
            ->sortByDesc('month_to_date_amount')
            ->values();

        $applianceCashSummary = Branch::query()
            ->whereHas('businessUnit', function ($query) {
                $query->where('code', 'L4');
            })
            ->with('businessUnit')
            ->orderBy('display_name')
            ->get()
            ->map(function ($branch) use ($today, $currentMonthStart, $applianceCashBaseQuery) {
                $base = fn () => $applianceCashBaseQuery()->where('branch_id', $branch->id);

                $todayBrandNew = $base()
                    ->whereDate('invoice_date', $today)
                    ->where('unit_type', '!=', 'REPO');

                $todayRepo = $base()
                    ->whereDate('invoice_date', $today)
                    ->where('unit_type', 'REPO');

                $toDateBrandNew = $base()
                    ->whereBetween('invoice_date', [$currentMonthStart, $today])
                    ->where('unit_type', '!=', 'REPO');

                $toDateRepo = $base()
                    ->whereBetween('invoice_date', [$currentMonthStart, $today])
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

                    'total_units' => (clone $base())->whereBetween('invoice_date', [$currentMonthStart, $today])->count(),
                    'total_cod'   => (clone $base())->whereBetween('invoice_date', [$currentMonthStart, $today])->sum('cash_amount'),
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
            ->whereHas('businessUnit', function ($query) {
                $query->where('code', 'L4');
            })
            ->with('businessUnit')
            ->orderBy('display_name')
            ->get()
            ->map(function ($branch) use ($today, $currentMonthStart, $applianceInstallmentBaseQuery) {
                $base = fn () => $applianceInstallmentBaseQuery()->where('branch_id', $branch->id);

                $todayBrandNew = $base()
                    ->whereDate('invoice_date', $today)
                    ->where('unit_type', '!=', 'REPO');

                $todayRepo = $base()
                    ->whereDate('invoice_date', $today)
                    ->where('unit_type', 'REPO');

                $toDateBrandNew = $base()
                    ->whereBetween('invoice_date', [$currentMonthStart, $today])
                    ->where('unit_type', '!=', 'REPO');

                $toDateRepo = $base()
                    ->whereBetween('invoice_date', [$currentMonthStart, $today])
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

                    'total_units' => (clone $base())->whereBetween('invoice_date', [$currentMonthStart, $today])->count(),
                    'total_amount' => (clone $base())->whereBetween('invoice_date', [$currentMonthStart, $today])->sum('promissory_note_amount'),
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
            ->whereHas('businessUnit', function ($query) {
                $query->whereIn('code', ['L4', 'M8']);
            })
            ->with('businessUnit')
            ->orderBy('display_name')
            ->get()
            ->map(function ($branch) use ($today, $currentMonthStart, $motorcycleCashBaseQuery) {
                $base = fn () => $motorcycleCashBaseQuery()->where('branch_id', $branch->id);

                $todayBrandNew = $base()
                    ->whereDate('invoice_date', $today)
                    ->where('unit_type', '!=', 'REPO');

                $todayRepo = $base()
                    ->whereDate('invoice_date', $today)
                    ->where('unit_type', 'REPO');

                $toDateBrandNew = $base()
                    ->whereBetween('invoice_date', [$currentMonthStart, $today])
                    ->where('unit_type', '!=', 'REPO');

                $toDateRepo = $base()
                    ->whereBetween('invoice_date', [$currentMonthStart, $today])
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

                    'total_units' => (clone $base())->whereBetween('invoice_date', [$currentMonthStart, $today])->count(),
                    'total_cod'   => (clone $base())->whereBetween('invoice_date', [$currentMonthStart, $today])->sum('cash_amount'),
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
            ->whereHas('businessUnit', function ($query) {
                $query->whereIn('code', ['L4', 'M8']);
            })
            ->with('businessUnit')
            ->orderBy('display_name')
            ->get()
            ->map(function ($branch) use ($today, $currentMonthStart, $motorcycleInstallmentBaseQuery) {
                $base = fn () => $motorcycleInstallmentBaseQuery()->where('branch_id', $branch->id);

                $todayBrandNew = $base()
                    ->whereDate('invoice_date', $today)
                    ->where('unit_type', '!=', 'REPO');

                $todayRepo = $base()
                    ->whereDate('invoice_date', $today)
                    ->where('unit_type', 'REPO');

                $toDateBrandNew = $base()
                    ->whereBetween('invoice_date', [$currentMonthStart, $today])
                    ->where('unit_type', '!=', 'REPO');

                $toDateRepo = $base()
                    ->whereBetween('invoice_date', [$currentMonthStart, $today])
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

                    'total_units' => (clone $base())->whereBetween('invoice_date', [$currentMonthStart, $today])->count(),
                    'total_amount' => (clone $base())->whereBetween('invoice_date', [$currentMonthStart, $today])->sum('promissory_note_amount'),
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
            ->whereHas('businessUnit', function ($query) {
                $query->whereIn('code', ['L4', 'M8']);
            })
            ->with('businessUnit')
            ->orderBy('display_name')
            ->get()
            ->map(function ($branch) use ($today, $currentMonthStart, $combinedCashBaseQuery) {
                $base = fn () => $combinedCashBaseQuery()->where('branch_id', $branch->id);

                $todayBrandNew = $base()
                    ->whereDate('invoice_date', $today)
                    ->where('unit_type', '!=', 'REPO');

                $todayRepo = $base()
                    ->whereDate('invoice_date', $today)
                    ->where('unit_type', 'REPO');

                $toDateBrandNew = $base()
                    ->whereBetween('invoice_date', [$currentMonthStart, $today])
                    ->where('unit_type', '!=', 'REPO');

                $toDateRepo = $base()
                    ->whereBetween('invoice_date', [$currentMonthStart, $today])
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

                    'total_units' => (clone $base())->whereBetween('invoice_date', [$currentMonthStart, $today])->count(),
                    'total_cod'   => (clone $base())->whereBetween('invoice_date', [$currentMonthStart, $today])->sum('cash_amount'),
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
            ->whereHas('businessUnit', function ($query) {
                $query->whereIn('code', ['L4', 'M8']);
            })
            ->with('businessUnit')
            ->orderBy('display_name')
            ->get()
            ->map(function ($branch) use ($today, $currentMonthStart, $combinedInstallmentBaseQuery) {
                $base = fn () => $combinedInstallmentBaseQuery()->where('branch_id', $branch->id);

                $todayBrandNew = $base()
                    ->whereDate('invoice_date', $today)
                    ->where('unit_type', '!=', 'REPO');

                $todayRepo = $base()
                    ->whereDate('invoice_date', $today)
                    ->where('unit_type', 'REPO');

                $toDateBrandNew = $base()
                    ->whereBetween('invoice_date', [$currentMonthStart, $today])
                    ->where('unit_type', '!=', 'REPO');

                $toDateRepo = $base()
                    ->whereBetween('invoice_date', [$currentMonthStart, $today])
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

                    'total_units' => (clone $base())->whereBetween('invoice_date', [$currentMonthStart, $today])->count(),
                    'total_amount' => (clone $base())->whereBetween('invoice_date', [$currentMonthStart, $today])->sum('promissory_note_amount'),
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
                DB::raw('COALESCE(SUM(promissory_note_amount), 0) as total_amount')
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
        $branchChartAmounts = $branchTotals->map(fn ($item) => (float) $item->total_amount)->values();

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
        ));
    }
}