<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\RequestSupply;
class StockController extends Controller
{
   
    public function stocks()
        {
            $stocks = Stock::get();

 

            return view('admin.stocks', compact('stocks'));

        }

 
    public function withdrawStock(Request $request)
        {
            $request->validate([
                'item_id' => 'required|exists:stocks,id',
                'quantity' => 'required|integer|min:1',
                'withdrawal_status' => 'required|in:Pending,Processing,Ready to Pick Up,Completed',// Assuming these are possible statuses
            ]);

            $stock = Stock::findOrFail($request->item_id);

            // Check if there's enough stock available only when status is "ready to pick up"
            if ($request->withdrawal_status === 'Ready to Pick Up') {
                if ($stock->stock_quantity < $request->quantity) {
                    return back()->with('error', 'Insufficient stock available.');
                }

                // Deduct stock only when status is "ready to pick up"
                $stock->stock_quantity -= $request->quantity;
                $stock->save();
            }

            return back()->with('success', 'Withdrawal request processed successfully.');
        }

    public function updateStock(Request $request)
        {
            $request->validate([
                'item_id' => 'required|exists:stocks,id',
                'stock_quantity' => 'required|integer|min:1' // Changed min to 1 since we're adding
            ]);

            try {
                $stock = Stock::findOrFail($request->item_id);
                
                // Add the new quantity to the existing stock
                $stock->stock_quantity += $request->stock_quantity;
                $stock->save();

                return response()->json([
                    'success' => true,
                    'item_id' => $stock->id,
                    'stock_quantity' => $stock->stock_quantity,
                    'message' => 'Stock updated successfully! Added '.$request->stock_quantity.' items. New total: '.$stock->stock_quantity
                ]);

            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error updating stock: ' . $e->getMessage()
                ], 500);
            }
        }
        public function addNewItem(Request $request)
        {
            try {
                $validated = $request->validate([
                    'item_name' => 'required|string|max:255',
                    'variant_type' => 'required|string|in:color,type,size',
                    'variant_value' => 'required|string|max:255',
                    'quantity' => 'required|integer|min:0',
                ]);
        
                // Check if item with same name and variant already exists
                $existingItem = Stock::where('item_name', $validated['item_name'])
                                    ->where('variant_value', $validated['variant_value'])
                                    ->first();
        
                if ($existingItem) {
                    return response()->json([
                        'success' => false,
                        'message' => 'An item with this name and variant already exists.'
                    ], 422);
                }
        
                $stock = Stock::create([
                    'item_name' => $validated['item_name'],
                    'variant_type' => $validated['variant_type'],
                    'variant_value' => $validated['variant_value'],
                    'stock_quantity' => $validated['quantity'],
                ]);
        
                return response()->json([
                    'success' => true,
                    'message' => 'Item added successfully!',
                    'data' => $stock
                ]);
        
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error adding item: ' . $e->getMessage()
                ], 500);
            }
        }
        

        
}
