<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the Admin's profile form.
     */
    public function editProfile(Request $request): View
    {
        $user = $request->user();
        $role = $user->role; // Assuming 'role' is stored in the users table
        
    
        $views = [
            'admin' => 'admin.profile.edit',
            'user' => 'user.profile.edit',
            'chairman' => 'chairman.profile.edit',
            'dean' => 'dean.profile.edit',
        ];
    
        // Check if the role has a matching view
        if (array_key_exists($role, $views)) {
            return view($views[$role], [$role => $user]);
        }
    
        // Default fallback (optional)
        abort(403, 'Unauthorized');
    }
    
  
    public function updateProfile(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $role = $user->role; // Assuming 'role' is stored in the users table
    
        $user->fill($request->validated());
    
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
    
        $user->save();
    
        // Define redirection routes based on user roles
        $routes = [
            'admin' => 'admin.profile.edit',
            'user' => 'user.profile.edit',
            'chairman' => 'chairman.profile.edit',
            'dean' => 'dean.profile.edit',
        ];
    
        // Redirect based on role, or fallback if role is unknown
        return isset($routes[$role])
            ? Redirect::route($routes[$role])->with('status', 'profile-updated')
            : abort(403, 'Unauthorized');
    }
    


    public function destroyProfile(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);
    
        $user = $request->user();
    
        Auth::logout();
    
        $user->delete();
    
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return Redirect::to('/');
    }
}    