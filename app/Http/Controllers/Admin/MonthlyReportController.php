<?php
namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Stock;
use App\Models\RequestSupply;
use App\Models\ReturnRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;  // Make sure to import the Request class
use Illuminate\Support\Facades\DB;
class MonthlyReportController extends Controller
{
    public function monthlyReports(Request $request)
    {
        
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);
    
        // // Fetch the data for the selected month and year
        // $totalRequesters = $this->getTotalRequesters($year, $month);
        // $totalUsers = $this->getTotalUsers($year, $month);
    
        // // Total completed withdrawals
        // $totalCompletedItems = RequestSupply::where('withdrawal_status', 'completed')
        //                                    ->whereYear('created_at', $year)
        //                                    ->whereMonth('created_at', $month)
        //                                    ->sum('quantity');
    
        // // Total return requests (all statuses)
        // $totalReturns = ReturnRequest::whereYear('created_at', $year)
        //                             ->whereMonth('created_at', $month)
        //                             ->count();
    
        // // Total completed replacements
        // $totalReplacementCompleted = ReturnRequest::where('replacement_status', 'completed')
        //                                         ->whereYear('created_at', $year)
        //                                         ->whereMonth('created_at', $month)
        //                                         ->count();

         // Count of unique requesters (users who submitted requests)
    $totalRequesters = RequestSupply::join('users', 'request_supplies.user_id', '=', 'users.id')
    ->whereYear('request_supplies.created_at', $year)
    ->whereMonth('request_supplies.created_at', $month)
    ->where('users.role', 'user')
    ->distinct('request_supplies.user_id')
    ->count('request_supplies.user_id');

    // Total number of requests made in the month
    $totalRequests = RequestSupply::whereYear('created_at', $year)
    ->whereMonth('created_at', $month)
    ->count();

// Total quantity withdrawn (only completed withdrawals)
$totalWithdrawnQuantity = RequestSupply::where('withdrawal_status', 'completed')
        ->whereYear('created_at', $year)
        ->whereMonth('created_at', $month)
        ->sum('quantity');

// Total quantity returned (sum of the 'quantity' field in return requests)
$totalReturnQuantity = ReturnRequest::whereYear('created_at', $year)
    ->whereMonth('created_at', $month)
    ->sum('quantity'); // summing the 'quantity' of returned items

// Use the correct variable name here
$netWithdrawnQuantity = $totalWithdrawnQuantity - $totalReturnQuantity;


    // Total quantity replaced (only completed replacements)
    $totalReplacementQuantity = ReturnRequest::where('replacement_status', 'completed')
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->sum('quantity'); // assuming
    
        // Fetch all stock records
        $stocks = Stock::orderBy('item_name')->get();
        $itemNames = $stocks->pluck('item_name');
        $quantities = $stocks->pluck('stock_quantity');
    
        $reports = Stock::get();
        $requestHistory = RequestSupply::where('withdrawal_status', 'completed')->get();
    
        // Inventory Summary (Withdrawn / Returned per item this month)
        $inventorySummary = DB::table('stocks as s')
->leftJoin(DB::raw("(
    SELECT item_name, variant_value, SUM(quantity) as monthly_withdrawn
    FROM request_supplies
    WHERE withdrawal_status = 'completed'
    AND YEAR(created_at) = $year
    AND MONTH(created_at) = $month
    GROUP BY item_name, variant_value
) as rs"), function ($join) {
    $join->on('s.item_name', '=', 'rs.item_name')
         ->on(DB::raw('IFNULL(s.variant_value, "")'), '=', DB::raw('IFNULL(rs.variant_value, "")'));
})
->leftJoin(DB::raw("(
    SELECT item_name, variant_value, SUM(quantity) as monthly_returned
    FROM returns
    WHERE replacement_status = 'completed'
    AND YEAR(created_at) = $year
    AND MONTH(created_at) = $month
    GROUP BY item_name, variant_value
) as rr"), function ($join) {
    $join->on('s.item_name', '=', 'rr.item_name')
         ->on(DB::raw('IFNULL(s.variant_value, "")'), '=', DB::raw('IFNULL(rr.variant_value, "")'));
})
->leftJoin(DB::raw("(
    SELECT item_name, variant_value, SUM(quantity) as monthly_replaced
    FROM returns
    WHERE YEAR(created_at) = $year
    AND MONTH(created_at) = $month
    GROUP BY item_name, variant_value
) as rp"), function ($join) {
    $join->on('s.item_name', '=', 'rp.item_name')
         ->on(DB::raw('IFNULL(s.variant_value, "")'), '=', DB::raw('IFNULL(rp.variant_value, "")'));
})
->select(
    's.item_name',
    's.variant_value',
    's.stock_quantity as current_stock',
    DB::raw('GREATEST(COALESCE(rs.monthly_withdrawn, 0) - COALESCE(rr.monthly_returned, 0), 0) as monthly_withdrawn'),
    DB::raw('COALESCE(rr.monthly_returned, 0) as monthly_returned'),
    DB::raw('COALESCE(rp.monthly_replaced, 0) as monthly_replaced')
)
->orderBy('s.item_name')
->get();

    
        return view('admin.monthly-reports', compact(
            'itemNames',
            'quantities',
            'totalRequesters',
            'totalRequests',
            'totalWithdrawnQuantity',
            'totalReturnQuantity',
            'totalReplacementQuantity',
            'reports',
            'requestHistory',
            'inventorySummary',
            'netWithdrawnQuantity'
        ));
    }
    
    public function getMonthlyCompletedWithdrawals(Request $request)
    {
        $query = RequestSupply::whereNotNull('completed_at')
            ->selectRaw('MONTH(completed_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month');
    
        // Filter by year (required)
        $year = $request->input('year', date('Y'));
        $query->whereYear('completed_at', $year);
    
        // Optional month filter
        if ($request->has('month')) {
            $query->whereMonth('completed_at', $request->month);
        }
    
        $results = $query->get();
    
        // Ensure all 12 months are represented
        $allMonths = collect(range(1, 12))->map(function ($month) use ($results) {
            $record = $results->firstWhere('month', $month);
            return [
                'month' => $month,
                'month_name' => date('F', mktime(0, 0, 0, $month, 1)),
                'count' => $record ? $record->count : 0
            ];
        });
    
        return response()->json($allMonths);
    }

    public function getMonthlyReturns(Request $request)
{
    $query = ReturnRequest::whereNotNull('return_date')
        ->selectRaw('MONTH(return_date) as month, COUNT(*) as count')
        ->groupBy('month')
        ->orderBy('month');

    // Required year filter
    $year = $request->input('year', date('Y'));
    $query->whereYear('return_date', $year);

    // Optional month filter
    if ($request->has('month')) {
        $query->whereMonth('return_date', $request->month);
    }

    $results = $query->get();

    // Normalize data for all 12 months
    $allMonths = collect(range(1, 12))->map(function ($month) use ($results) {
        $record = $results->firstWhere('month', $month);
        return [
            'month' => $month,
            'month_name' => date('F', mktime(0, 0, 0, $month, 1)),
            'count' => $record ? $record->count : 0
        ];
    });

    return response()->json($allMonths);
}
    // Helper methods to fetch data for the report
    private function getTotalRequesters($year, $month)
    {
        return RequestSupply::whereYear('datetime', $year)
                            ->whereMonth('datetime', $month)
                            ->distinct('user_id') // Get unique users
                            ->count();
    }
    
    private function getTotalUsers($year, $month)
    {
        return RequestSupply::whereYear('datetime', $year)
                            ->whereMonth('datetime', $month)
                            ->count();
    }
    
    private function getTotalItems($year, $month)
    {
        return RequestSupply::whereYear('datetime', $year)
                            ->whereMonth('datetime', $month)
                            ->sum('quantity');
    }   
    
    private function getTotalApproved($year, $month)
    {
        return RequestSupply::whereYear('datetime', $year)
                            ->whereMonth('datetime', $month)
                            // ->where('status', 'Approved')
                            ->count();
    }
    
}
