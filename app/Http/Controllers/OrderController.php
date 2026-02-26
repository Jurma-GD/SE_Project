<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Store a newly created order.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'items' => 'required|array|min:1',
            'items.*.menu_item_id' => 'required|exists:menu_items,id',
            'items.*.quantity' => 'required|integer|min:1|max:99',
            'notes' => 'nullable|string|max:500',
        ]);

        // Validate item availability before order creation
        $menuItemIds = collect($validated['items'])->pluck('menu_item_id');
        $menuItems = MenuItem::whereIn('id', $menuItemIds)->get();

        foreach ($validated['items'] as $item) {
            $menuItem = $menuItems->firstWhere('id', $item['menu_item_id']);
            
            if (!$menuItem) {
                return back()->withErrors(['items' => 'One or more menu items do not exist.']);
            }

            if (!$menuItem->is_available) {
                return back()->withErrors(['items' => "Item '{$menuItem->name}' is currently unavailable."]);
            }

            // Verify item belongs to the selected vendor
            if ($menuItem->vendor_id != $validated['vendor_id']) {
                return back()->withErrors(['items' => "Item '{$menuItem->name}' does not belong to the selected vendor."]);
            }
        }

        // Create order and order items in transaction
        try {
            $order = DB::transaction(function () use ($validated, $menuItems, $request) {
                // Generate unique order number
                $orderNumber = $this->generateUniqueOrderNumber();

                // Calculate total amount
                $totalAmount = 0;
                foreach ($validated['items'] as $item) {
                    $menuItem = $menuItems->firstWhere('id', $item['menu_item_id']);
                    $totalAmount += $menuItem->price * $item['quantity'];
                }

                // Create order
                $order = Order::create([
                    'user_id' => $request->user()->id,
                    'vendor_id' => $validated['vendor_id'],
                    'order_number' => $orderNumber,
                    'status' => Order::STATUS_PENDING,
                    'total_amount' => $totalAmount,
                    'notes' => $validated['notes'] ?? null,
                ]);

                // Create order items
                foreach ($validated['items'] as $item) {
                    $menuItem = $menuItems->firstWhere('id', $item['menu_item_id']);
                    
                    OrderItem::create([
                        'order_id' => $order->id,
                        'menu_item_id' => $menuItem->id,
                        'quantity' => $item['quantity'],
                        'price_at_order' => $menuItem->price,
                        'item_name' => $menuItem->name,
                    ]);
                }

                return $order;
            });

            // Return order confirmation
            return redirect()->route('orders.show', $order)
                ->with('success', "Order placed successfully! Your order number is {$order->order_number}.");
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to place order. Please try again.']);
        }
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        // Ensure the user can only view their own orders
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this order.');
        }

        // Load relationships
        $order->load(['orderItems.menuItem', 'vendor']);

        return view('orders.show', compact('order'));
    }
    /**
     * Display vendor's order queue.
     */
    public function vendorOrders(Request $request)
    {
        $vendor = $request->user()->vendor;

        if (!$vendor) {
            abort(403, 'Unauthorized access. Vendor profile not found.');
        }

        // Get status filter from request
        $status = $request->query('status');

        // Build query
        $query = Order::where('vendor_id', $vendor->id)
            ->with(['user', 'orderItems.menuItem'])
            ->orderBy('created_at', 'desc');

        // Apply status filter if provided
        if ($status && in_array($status, [Order::STATUS_PENDING, Order::STATUS_READY, Order::STATUS_COMPLETED, Order::STATUS_CANCELLED])) {
            $query->where('status', $status);
        }

        $orders = $query->paginate(20);

        return view('vendor.orders.index', compact('orders', 'status'));
    }

    /**
     * Update order status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $vendor = $request->user()->vendor;

        if (!$vendor || $order->vendor_id !== $vendor->id) {
            abort(403, 'Unauthorized access to this order.');
        }

        $validated = $request->validate([
            'status' => 'required|in:' . implode(',', [
                Order::STATUS_PENDING,
                Order::STATUS_READY,
                Order::STATUS_COMPLETED,
                Order::STATUS_CANCELLED
            ]),
        ]);

        $order->update(['status' => $validated['status']]);

        return back()->with('success', 'Order status updated successfully.');
    }

    /**
     * Mark order as ready for pickup.
     */
    public function markReady(Request $request, Order $order)
    {
        $vendor = $request->user()->vendor;

        if (!$vendor || $order->vendor_id !== $vendor->id) {
            abort(403, 'Unauthorized access to this order.');
        }

        $order->update(['status' => Order::STATUS_READY]);

        return back()->with('success', "Order {$order->order_number} marked as ready for pickup.");
    }

    /**
     * Mark order as completed.
     */
    public function markCompleted(Request $request, Order $order)
    {
        $vendor = $request->user()->vendor;

        if (!$vendor || $order->vendor_id !== $vendor->id) {
            abort(403, 'Unauthorized access to this order.');
        }

        $order->update(['status' => Order::STATUS_COMPLETED]);

        return back()->with('success', "Order {$order->order_number} marked as completed.");
    }

    /**
     * Generate a unique order number.
     */
    private function generateUniqueOrderNumber(): string
    {
        do {
            $orderNumber = 'ORD-' . strtoupper(substr(uniqid(), -8));
        } while (Order::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }
}

