<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:vendor,student'],
            // Vendor-specific fields (only required if role is vendor)
            'vendor_name' => ['required_if:role,vendor', 'string', 'max:255'],
            'location' => ['required_if:role,vendor', 'string', 'max:255'],
            'contact_info' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        // If registering as vendor, create vendor profile
        if ($validated['role'] === 'vendor') {
            Vendor::create([
                'user_id' => $user->id,
                'vendor_name' => $validated['vendor_name'],
                'location' => $validated['location'],
                'contact_info' => $validated['contact_info'] ?? null,
                'description' => $validated['description'] ?? null,
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        // Redirect based on role
        if ($user->isVendor()) {
            return redirect()->route('vendor.dashboard');
        }

        return redirect('/');
    }
}
