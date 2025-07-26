<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeedbackController extends Controller


{   
    public function feedback()
    {
        return view('user.feedback');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'type' => 'required|string',
            'comments' => 'required|string',
            'contact_me' => 'sometimes|boolean',
            'email' => 'nullable|email|required_if:contact_me,true'
        ]);
    
        try {
            \App\Models\Feedback::create($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Thank you for your feedback! Your input helps us improve our service.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error submitting feedback: ' . $e->getMessage()
            ], 500);
        }
    }
}
