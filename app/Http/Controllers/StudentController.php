<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    /**
     * Display all vendors with menus.
     */
    public function index(): View
    {
        $vendors = Vendor::with(['menuItems' => function ($query) {
            $query->orderBy('category')->orderBy('name');
        }])->get();

        return view('students.index', compact('vendors'));
    }

    /**
     * Display a specific vendor's menu.
     */
    public function showVendor(Vendor $vendor): View
    {
        $vendor->load(['menuItems' => function ($query) {
            $query->orderBy('category')->orderBy('name');
        }]);

        return view('students.vendor', compact('vendor'));
    }

    /**
     * Search for menu items.
     */
    public function search(Request $request): View
    {
        $query = MenuItem::with('vendor');

        // Search by item name or description
        if ($request->filled('q')) {
            $searchTerm = $request->input('q');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by vendor
        if ($request->filled('vendor_id')) {
            $query->where('vendor_id', $request->input('vendor_id'));
        }

        // Filter by availability
        if ($request->filled('availability')) {
            $isAvailable = $request->input('availability') === 'available';
            $query->where('is_available', $isAvailable);
        }

        $menuItems = $query->get();
        $vendors = Vendor::all();

        return view('students.search', compact('menuItems', 'vendors'));
    }

    /**
     * Display the student's orders.
     */
    public function myOrders(): View
    {
        $orders = auth()->user()->orders()
            ->with(['vendor', 'orderItems.menuItem'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('students.my-orders', compact('orders'));
    }
}
