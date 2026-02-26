<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vendor>
 */
class VendorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->vendor(),
            'vendor_name' => fake()->company(),
            'location' => fake()->randomElement([
                'Building A - Ground Floor',
                'Building B - 2nd Floor',
                'Main Cafeteria',
                'Student Center',
                'Library Lobby',
                'Gymnasium Entrance',
                'Science Building - 1st Floor',
                'Arts Building - Ground Floor',
            ]),
            'contact_info' => fake()->phoneNumber(),
            'description' => fake()->optional()->sentence(10),
        ];
    }
}
