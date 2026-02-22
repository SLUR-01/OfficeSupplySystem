<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // Correct import for the base controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\RequestSupply;
use App\Models\RequestItem;

class RequestSupplyController extends Controller
{

    public function approve($id)
    {
        // Load request with its items
        $request = RequestSupply::with('items')->findOrFail($id);

        // Only admin can approve
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized.'], 403);
        }

        $request->admin_status = 'Approved';
        $request->withdrawal_status = 'Pending'; // pending until user prints receipt
        $request->save();

        // Deduct stock for each item
        foreach ($request->items as $item) {
            if (!$item->stock_id) {
                return response()->json(['error' => "Item ID missing for {$item->item_name}"], 400);
            }

            $stock = Stock::find($item->stock_id);

            if (!$stock) {
                return response()->json(['error' => "Stock not found for item: {$item->item_name}"], 400);
            }

            if ($stock->remaining_stocks < $item->quantity) {
                return response()->json([
                    'error' => "Insufficient stock for item: {$item->item_name}."
                ], 400);
            }
        }

        return response()->json(['message' => 'Request Approved Successfully!']);
    }


    // ->with('success', 'Request approved successfully!')
}
