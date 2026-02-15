<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Models\RequestSupply;
use App\Models\RequestItem;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->month ?? now()->format('Y-m');

        $startDate = \Carbon\Carbon::parse($month . '-01')->startOfMonth();
        $endDate   = \Carbon\Carbon::parse($month . '-01')->endOfMonth();

        // Summary Cards
        $totalStocks = \App\Models\Stock::count();

        $lowStocks = \App\Models\Stock::whereColumn('remaining_stocks', '<=', 'reorderpoint')
            ->count();

        $pendingRequests = \App\Models\RequestSupply::where('admin_status', 'Pending')->count();

        $completedRequests = \App\Models\RequestSupply::where('withdrawal_status', 'Completed')->count();

        $withdrawalHistory = \App\Models\RequestSupply::with(['items'])
            ->where('withdrawal_status', 'Completed')
            ->latest('completed_at')
            ->paginate(4);

        // Monthly Report (Join with Stocks)
        $monthlyReport = \App\Models\RequestItem::select(
            'stocks.id as stock_id',
            'stocks.item_name',
            'stocks.variant_value',
            'stocks.current_stock',
            'stocks.remaining_stocks',
            \DB::raw('COALESCE(SUM(request_items.quantity),0) as total_withdrawn')
        )
            ->rightJoin('stocks', 'request_items.stock_id', '=', 'stocks.id')
            ->leftJoin('request_supplies', function ($join) use ($startDate, $endDate) {
                $join->on('request_items.request_supply_id', '=', 'request_supplies.id')
                    ->whereBetween('request_supplies.completed_at', [$startDate, $endDate])
                    ->where('request_supplies.withdrawal_status', 'Completed');
            })
            ->groupBy(
                'stocks.id',
                'stocks.item_name',
                'stocks.variant_value',
                'stocks.current_stock',
                'stocks.remaining_stocks'
            )
            ->get();

        return view('admin.dashboard', compact(
            'totalStocks',
            'lowStocks',
            'pendingRequests',
            'completedRequests',
            'monthlyReport',
            'withdrawalHistory',
            'month'
        ));
    }
}
