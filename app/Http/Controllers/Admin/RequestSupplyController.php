<?php


namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; // Correct import for the base controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\RequestSupply;

class RequestSupplyController extends Controller
{

    public function approve($id)
    {
        $request = RequestSupply::findOrFail($id);
    
        if (auth()->user()->role === 'admin') {
            $request->admin_status = 'Approved';
    
            if ($request->chairman_status === 'Approved' && $request->dean_status === 'Approved') {
                $request->withdrawal_status = 'Processing';
            }
    
            $request->save();
        }
    
        $stock = Stock::where('item_name', $request->item_name)->first();
    
        if (!$stock || $stock->stock_quantity < $request->quantity) {
            return response()->json(['error' => 'Insufficient stock to fulfill this request.'], 400);
        }
    
      
        $stock->save();
    
        return response()->json(['message' => 'Request Approved Successfully!']);
    }
    
    
    // ->with('success', 'Request approved successfully!')
}

