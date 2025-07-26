<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle a new user registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate user input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:user,chairman,dean,admin'],
            'department' => [
                'nullable',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->role !== 'admin' && empty($value)) {
                        $fail('The department field is required for non-admin roles.');
                    }
                }
            ],
        ]);

        // Set department as null for admin
        $department = $request->role === 'admin' ? null : $request->department;

        // Create the new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'department' => $department,
        ]);

        // Fire registered event and log the user in
        event(new Registered($user));
        Auth::login($user);

        // Redirect based on user role
        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'chairman' => redirect()->route('chairman.dashboard'),
            'dean' => redirect()->route('dean.dashboard'),
            'user' => redirect()->route('user.dashboard'),
            default => redirect()->route('user.dashboard'), // fallback
        };
    }
}
