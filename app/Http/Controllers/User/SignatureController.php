<?php

namespace App\Http\Controllers\User;
use App\Models\RequestSupply;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SignatureController extends Controller
{
    
    public function saveSignature(Request $request)
    {
        $request->validate([
            'signature' => 'required|string',
        ]);
    
        $user = Auth::user();
        $signatureData = $request->input('signature');
    
        // Define the directory and ensure it exists
        $directory = public_path('signatures');
        if (!\File::exists($directory)) {
            \File::makeDirectory($directory, 0755, true); // Create the directory if not exists
        }
    
        // Convert Base64 to an image and save it
        $image = str_replace('data:image/png;base64,', '', $signatureData);
        $image = str_replace(' ', '+', $image);
        $imageName = 'signatures/' . $user->id . '_signature.png';
        
        \File::put(public_path($imageName), base64_decode($image));
    
        // Save the file path in the database
        $user->signature = $imageName;
        $user->save();
    
        return redirect()->back()->with('status', 'Your signature has been saved successfully.');
    }
    
}
