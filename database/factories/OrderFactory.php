<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->student(),
            'vendor_id' => Vendor::factory(),
            'order_number' => $this->generateUniqueOrderNumber(),
            'status' => fake()->randomElement([
                Order::STATUS_PENDING,
                Order::STATUS_READY,
                Order::STATUS_COMPLETED,
            ]),
            'total_amount' => fake()->randomFloat(2, 50, 500),
            'notes' => fake()->optional(0.3)->sentence(10),
        ];
    }

    /**
     * Generate a unique order number.
     */
    protected function generateUniqueOrderNumber(): string
    {
        return 'ORD-' . strtoupper(fake()->unique()->bothify('??##??##'));
    }

    /**
     * Indicate that the order is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => Order::STATUS_PENDING,
        ]);
    }

    /**
     * Indicate that the order is ready.
     */
    public function ready(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => Order::STATUS_READY,
        ]);
    }

    /**
     * Indicate that the order is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => Order::STATUS_COMPLETED,
        ]);
    }

    /**
     * Indicate that the order is cancelled.
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => Order::STATUS_CANCELLED,
        ]);
    }
}
