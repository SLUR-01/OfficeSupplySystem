<?php

namespace App\Http\Controllers\Dean;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RequestSupply;

class DashboardController extends Controller
{
    //
public function dashboard()
    { 
        
            $requests = RequestSupply::orderBy('withdrawal_status', 'asc')->get(); // Fetches 10 items per page
            return view('dean.dashboard', compact('requests'));
            
        
    }
    public function approve($id)
    {
        try {
            $user = auth()->user();
            $request = RequestSupply::findOrFail($id);
    
            // Validate user role and department
            if ($user->role !== 'dean' || $request->department !== $user->department) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to approve this request.'
                ], 403);
            }
    
            // Update the request status
            $request->dean_status = 'Approved';
            $request->save();
    
            return response()->json([
                'success' => true,
                'message' => 'Request approved successfully.'
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while approving the request: ' . $e->getMessage()
            ], 500);
        }
    }
        
    
}
