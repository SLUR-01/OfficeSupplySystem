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
        $request = RequestSupply::with('items')->findOrFail($id);

        // Only admin can approve
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized.'], 403);
        }

        // Just update statuses
        $request->admin_status = 'Approved';
        $request->withdrawal_status = 'Pending';
        $request->save();

        return response()->json([
            'message' => 'Request Approved Successfully!'
        ]);
    }


    // ->with('success', 'Request approved successfully!')
}
