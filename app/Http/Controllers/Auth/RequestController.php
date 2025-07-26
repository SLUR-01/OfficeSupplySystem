<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller; // Correctly import the base controller
use Illuminate\Support\Facades\Auth; // Correct import for the Auth facade
use App\Models\Request  ;  // Change the model name here

use Illuminate\Http\Request as HttpRequest; // Alias the Request class from Http

class RequestController extends Controller
{   

    public function request(){
        $requests = Request::all();
        return view('navigation.request' , compact('requests'));
      
    }

    public function store(HttpRequest $request)
    {
        $request->validate([
            'requester_name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'date' => 'required|date',
            'item_name' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);
      
        
        // Use the model to create a new request entry in the database
        Request::create($request->all());
               


        return redirect()->route('navigation.request')->with('success', 'Request submitted successfully.');
        
    }
    
}

