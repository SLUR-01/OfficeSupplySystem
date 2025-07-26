<?php

namespace App\Http\Controllers\Chairman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RequestSupply;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
  
   

public function dashboard()
    {  
        $user = auth()->user(); // Get the authenticated chairman

        // Fetch only requests from the chairman's department
        $requests = RequestSupply::where('department', $user->department)
                                ->whereNull('chairman_status') // Optional: Show only pending requests
                                ->get(); 
                                
        $requests = RequestSupply::orderBy('withdrawal_status', 'asc')->get(); 
        return view('chairman.dashboard', compact('requests'));
        
    }

public function approve($id)
    {
        try {
            $user = auth()->user();
            $request = RequestSupply::findOrFail($id);
    
            // Validate user role and department
            if ($user->role !== 'chairman' || $request->department !== $user->department) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to approve this request.'
                ], 403);
            }
    
            // Update the request status
            $request->chairman_status = 'Approved';
            $request->save();
    
            return response()->json([
                'success' => true,
                'message' => 'Request approved successfully.'
            ]);
    
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Request not found.'
            ], 404);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while approving the request: ' . $e->getMessage()
            ], 500);
        }
    }


}




// public function dashboard()
// {
//     $requests = RequestSupply::all(); 
//     return view('chairman.dashboard', compact('requests'));
    
// }

// public function approve($id)
// {

//     $request = RequestSupply::findOrFail($id);


//     if (auth()->user()->usertype === 'chairman') {
//         $request->status = 'Approved by Chairman';
//         $request->save();
//     }
 
    

//     return redirect()->route('chairman.dashboard', compact('request'));

// }
