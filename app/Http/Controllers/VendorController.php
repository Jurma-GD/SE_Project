<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VendorController extends Controller
{
    /**
     * Display the vendor dashboard.
     */
    public function dashboard(): View
    {
        $vendor = auth()->user()->vendor;
        
        if (!$vendor) {
            abort(404, 'Vendor profile not found');
        }

        $totalItems = $vendor->menuItems()->count();
        $pendingOrders = $vendor->orders()->where('status', 'pending')->count();

        return view('vendor.dashboard', compact('vendor', 'totalItems', 'pendingOrders'));
    }

    /**
     * Display the vendor profile page.
     */
    public function profile(): View
    {
        $vendor = auth()->user()->vendor;
        
        if (!$vendor) {
            abort(404, 'Vendor profile not found');
        }

        return view('vendor.profile', compact('vendor'));
    }

    /**
     * Update the vendor profile.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $vendor = auth()->user()->vendor;
        
        if (!$vendor) {
            abort(404, 'Vendor profile not found');
        }

        $validated = $request->validate([
            'vendor_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'contact_info' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $vendor->update($validated);

        return redirect()->route('vendor.profile')
            ->with('success', 'Profile updated successfully');
    }
}
