<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Stock;
use Illuminate\Http\Request;
use App\Models\RequestSupply;
use App\Models\ReturnRequest;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    public function withdrawal()
    {
        $requests = RequestSupply::whereIn('withdrawal_status', ['Processing', 'Ready to Pick Up'])
        ->orderBy('date_needed', 'asc')
        ->get();
    
   
        return view('admin.withdrawal', compact('requests'));
    }

    public function updateWithdrawal(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'withdrawal_status' => 'required|in:Pending,Processing,Ready to Pick Up,Completed',
                'withdrawn_by' => 'required_if:withdrawal_status,Completed|string|max:255',
                'completed_at' => 'required_if:withdrawal_status,Completed|date',
              
            ]);
    
            $supplyRequest = RequestSupply::findOrFail($id);
    
            // Handle stock deduction when changing to "Ready to Pick Up"
            if ($request->withdrawal_status === 'Completed' && $supplyRequest->withdrawal_status !== 'Completed') {
                $stock = Stock::where('item_name', $supplyRequest->item_name)
                              ->where('variant_value', $supplyRequest->variant_value) // Add variant condition
                              ->first();
    
                if (!$stock) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Item with specified variant not found in stock inventory.'
                    ], 400);
                }
    
                if ($stock->stock_quantity < $supplyRequest->quantity) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Insufficient stock available for this variant. Only ' . $stock->stock_quantity . ' remaining.'
                    ], 400);
                }
    
                // Deduct the stock
                $stock->stock_quantity -= $supplyRequest->quantity;
                $stock->save();
            }
    
            // Handle completion status
            if ($request->withdrawal_status === 'Completed') {
                $supplyRequest->completed_at = $request->completed_at ?? now();
                $supplyRequest->withdrawn_by = $request->withdrawn_by;
            }
    
            $supplyRequest->withdrawal_status = $request->withdrawal_status;
            $supplyRequest->save();
    
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Withdrawal status updated successfully!',
                    'status' => $supplyRequest->withdrawal_status,
                    'status_class' => $this->getStatusClass($supplyRequest->withdrawal_status)
                ]);
            }
    
            return redirect()->back()->with('success', 'Withdrawal status updated successfully!');
    
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error updating status: ' . $e->getMessage()
                ], 500);
            }
    
            return back()->with('error', 'Error updating status: ' . $e->getMessage());
        }
    }
    public function withdrawnBy(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'withdrawn_by' => 'required|string|max:255'
            ]);
    
            $supplyRequest = RequestSupply::findOrFail($id);
            $supplyRequest->update(['withdrawn_by' => $validated['withdrawn_by']]);
    
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Item has been successfully marked as withdrawn!'
                ]);
            }
    
            return back()->with('success', 'Item has been successfully marked as withdrawn!');
    
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error marking as withdrawn: ' . $e->getMessage()
                ], 500);
            }
    
            return back()->with('error', 'Error marking as withdrawn: ' . $e->getMessage());
        }
    }
    
    // Helper function to get status class for styling
    private function getStatusClass($status)
    {
        switch ($status) {
            case 'Processing':
                return 'bg-yellow-100 text-yellow-800';
            case 'Ready to Pick Up':
                return 'bg-blue-100 text-blue-800 animate-beat';
            case 'Completed':
                return 'bg-green-100 text-green-800';
            default:
                return 'bg-gray-100 text-gray-800';
        }
    }

    public function return()
    {
        // Fetch all return records and load the user relationship
        $approvedReturns = ReturnRequest::where('return_status', 'approved')->get();

        $pendingReturns = ReturnRequest::where('return_status', 'pending')->get();

        
        $requests = RequestSupply::all();
        return view('admin.return.return', compact('approvedReturns','pendingReturns' , 'requests'));
    }

    public function updateReturn(Request $request)
    {
        try {
            $return = ReturnRequest::findOrFail($request->return_id);
            
            $return->quantity_received = $request->quantity_received;
            $return->replacement_status = 'completed';
            $return->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Return updated successfully!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating return: ' . $e->getMessage()
            ], 500);
        }
    }

    public function completedReturn(Request $request)
    {
        $request->validate([
            'return_id' => 'required|exists:returns,id',
            'quantity_received' => 'required|integer|min:0',
        ]);
    
        try {
            $return = ReturnRequest::findOrFail($request->return_id);
    
            if ($request->quantity_received > $return->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Quantity received cannot exceed original returned quantity (' . $return->quantity . ')'
                ], 422);
            }
    
            // Update return status and details
            $return->update([
                'quantity_received' => $request->quantity_received,
                'received_at' => now(),
                'received_by' => auth()->id(),
                'replacement_status' => 'completed'
            ]);
    
            // Fetch updated return
            $return->refresh();
    
            // Deduct from stock if replacement is completed
            if ($return->replacement_status === 'completed') {
                $stock = Stock::where('item_name', $return->item_name)
                
                    ->where('variant_value', $return->variant_value)
                    ->first();
    
                if ($stock) {
                    $stock->stock_quantity -= $return->quantity_received;
                    $stock->save();
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Stock not found for the returned item.'
                    ], 404);
                }
            }
    
            return response()->json([
                'success' => true,
                'message' => 'Item received and stock updated successfully.',
                'data' => [
                    'return_id' => $return->id,
                    'quantity_received' => $return->quantity_received,
                    'replacement_status' => $return->replacement_status
                ]
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error processing return: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function approve($id)
{
    try {
        $return = ReturnRequest::findOrFail($id);
        
        // Get the associated stock including variant
        $stock = Stock::where('item_name', $return->item_name)
                    ->where('variant_value', $return->variant_value)
                    ->first();
        
        if (!$stock) {
            return response()->json([
                'success' => false,
                'message' => 'Associated item not found',
            ], 400);
        }

        $currentStock = $stock->stock_quantity; // Make sure this matches your DB column name
        $returnQuantity = $return->quantity;
        
        // Check if approving would result in negative stock
        if ($returnQuantity > $currentStock) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot approve this return. The quantity returned ('.$returnQuantity.') exceeds current stock ('.$currentStock.').',
            ], 400);
        }
        
        // Update status to approved
        $return->update([
            'return_status' => 'approved',
            'processed_at' => now(),
        ]);
        
 
        
        return response()->json([
            'success' => true,
            'message' => 'Return request approved successfully.',
            'data' => [
                'return_id' => $return->id,
                'new_status' => $return->return_status,
            ]
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error approving return request: ' . $e->getMessage()
        ], 500);
    }
}
    public function reject($id)
    {
        try {
            $return = ReturnRequest::findOrFail($id);
            
            // Update status to rejected
            $return->update([
                'return_status' => 'rejected',
            ]);
            
            // Add any additional logic here (e.g., send notification)
            // Example: Send rejection notification
            // Notification::send($return->user, new ReturnRejected($return));
            
            return response()->json([
                'success' => true,
                'message' => 'Return request rejected successfully.',
                'data' => [
                    'request_id' => $return->id,
                    'new_status' => $return->return_status,
            
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error rejecting return request: ' . $e->getMessage()
            ], 500);
        }
    }
    protected function updateInventory(ReturnRequest $return)
    {
        $item = Stock::where('item_name', $return->item_name)->first();
        
        if ($item) {
            $newQuantity = $item->quantity + $return->quantity;
            $item->update(['quantity' => $newQuantity]);
        }
    }


    }



// public function withdrawal()
// {
//     return view('admin.withdrawal');
// }

// public function return()
// {
//     return view('admin.return');
// }