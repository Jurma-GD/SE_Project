<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuItemController extends Controller
{
    /**
     * Display a listing of the vendor's menu items.
     */
    public function index(): View
    {
        $vendor = auth()->user()->vendor;
        
        if (!$vendor) {
            abort(404, 'Vendor profile not found');
        }

        $menuItems = $vendor->menuItems()->latest()->paginate(12);

        return view('vendor.menu-items.index', compact('menuItems'));
    }

    /**
     * Show the form for creating a new menu item.
     */
    public function create(): View
    {
        return view('vendor.menu-items.create');
    }

    /**
     * Store a newly created menu item in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $vendor = auth()->user()->vendor;
        
        if (!$vendor) {
            abort(404, 'Vendor profile not found');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0|max:99999.99',
            'is_available' => 'boolean',
            'category' => 'nullable|string|max:100',
        ]);

        $validated['vendor_id'] = $vendor->id;
        $validated['is_available'] = $request->has('is_available');

        MenuItem::create($validated);

        return redirect()->route('vendor.menu-items.index')
            ->with('success', 'Menu item created successfully');
    }

    /**
     * Show the form for editing the specified menu item.
     */
    public function edit(MenuItem $menuItem): View
    {
        $vendor = auth()->user()->vendor;
        
        if (!$vendor || $menuItem->vendor_id !== $vendor->id) {
            abort(403, 'Unauthorized access');
        }

        return view('vendor.menu-items.edit', compact('menuItem'));
    }

    /**
     * Update the specified menu item in storage.
     */
    public function update(Request $request, MenuItem $menuItem): RedirectResponse
    {
        $vendor = auth()->user()->vendor;
        
        if (!$vendor || $menuItem->vendor_id !== $vendor->id) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0|max:99999.99',
            'is_available' => 'boolean',
            'category' => 'nullable|string|max:100',
        ]);

        $validated['is_available'] = $request->has('is_available');

        $menuItem->update($validated);

        return redirect()->route('vendor.menu-items.index')
            ->with('success', 'Menu item updated successfully');
    }

    /**
     * Remove the specified menu item from storage.
     */
    public function destroy(MenuItem $menuItem): RedirectResponse
    {
        $vendor = auth()->user()->vendor;
        
        if (!$vendor || $menuItem->vendor_id !== $vendor->id) {
            abort(403, 'Unauthorized access');
        }

        $menuItem->delete();

        return redirect()->route('vendor.menu-items.index')
            ->with('success', 'Menu item deleted successfully');
    }

    /**
     * Toggle the availability status of a menu item (AJAX).
     */
    public function toggleAvailability(MenuItem $menuItem): JsonResponse
    {
        $vendor = auth()->user()->vendor;
        
        if (!$vendor || $menuItem->vendor_id !== $vendor->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $menuItem->is_available = !$menuItem->is_available;
        $menuItem->save();

        return response()->json([
            'success' => true,
            'is_available' => $menuItem->is_available,
            'message' => 'Availability updated successfully',
        ]);
    }
}
