<?php

namespace Database\Factories;

use App\Models\MenuItem;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MenuItem>
 */
class MenuItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['Main Course', 'Side Dish', 'Beverage', 'Dessert', 'Snack', 'Breakfast'];
        $foodItems = [
            'Chicken Adobo',
            'Pork Sinigang',
            'Beef Tapa',
            'Pancit Canton',
            'Lumpia Shanghai',
            'Fried Rice',
            'Grilled Chicken',
            'Fish Fillet',
            'Vegetable Salad',
            'Banana Cue',
            'Turon',
            'Halo-Halo',
            'Buko Juice',
            'Iced Coffee',
            'Mango Shake',
        ];

        return [
            'vendor_id' => Vendor::factory(),
            'name' => fake()->randomElement($foodItems),
            'description' => fake()->optional(0.7)->sentence(8),
            'price' => fake()->randomFloat(2, 15, 250),
            'is_available' => fake()->boolean(80),
            'category' => fake()->randomElement($categories),
        ];
    }

    /**
     * Indicate that the menu item is available.
     */
    public function available(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_available' => true,
        ]);
    }

    /**
     * Indicate that the menu item is unavailable.
     */
    public function unavailable(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_available' => false,
        ]);
    }
}
