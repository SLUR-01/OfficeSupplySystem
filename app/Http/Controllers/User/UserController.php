<?php

namespace App\Http\Controllers\User;
use App\Models\RequestSupply;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Http\Controllers\Controller; // Correct import for the base controller
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
    
    {
       
      
        // public function history(Request $request)

        // {   
        //     $userId = Auth::id();
        //     // $sortDirection = $request->get('sort_direction', 'desc'); // Default to descending order
        
        //     $requests = RequestSupply::where('user_id', $user_id)
        //                 ->where('status', 'Completed') // Only show completed withdrawals
        //                 ->orderBy('withdrawed_at', $sortDirection) // Sort by withdrawal date
        //                 ->get();
        
        //     return view('user.history', compact('requests'));

        // }
        
 
    public function dashboard()
    {   
        $requests = RequestSupply::where('user_id', auth()->id())->get(); 

        $stocks = Stock::orderBy('item_name')
        ->get();
    

        $itemNames = $stocks->pluck('item_name'); 
        $quantities = $stocks->pluck('stock_quantity');
        
        return view('user.dashboard', 
            compact('requests',
                    'itemNames',
                    'quantities',
                    'stocks',
                    
        )); 
        
    }

//     public function getStatus($id)
// {
//     // Retrieve the request from the database
//     $request = RequestSupply::findOrFail($id);

//     // Check if all statuses are approved
//     $isApproved = (
//         strpos($request->chairman_status, 'Approved') !== false &&
//         strpos($request->dean_status, 'Approved') !== false &&
//         strpos($request->admin_status, 'Approved') !== false
//     );

//     // Return the view with the statuses and approval state
//     return view('user.dashboard', [
//         'chairman_status' => $request->chairman_status,
//         'dean_status' => $request->dean_status,
//         'admin_status' => $request->admin_status,
//         'is_approved' => $isApproved,
//         'requests' => RequestSupply::where('user_id', auth()->id())->get(), // Fetch new requests
//     ]);
// }


 
    
    
        
    }
