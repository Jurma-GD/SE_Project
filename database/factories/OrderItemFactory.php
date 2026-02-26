<?php

namespace Database\Factories;

use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $menuItem = MenuItem::factory()->create();

        return [
            'order_id' => Order::factory(),
            'menu_item_id' => $menuItem->id,
            'quantity' => fake()->numberBetween(1, 5),
            'price_at_order' => $menuItem->price,
            'item_name' => $menuItem->name,
        ];
    }
}
