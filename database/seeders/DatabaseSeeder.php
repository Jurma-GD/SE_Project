<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test student users
        $student1 = User::factory()->student()->create([
            'name' => 'Juan Dela Cruz',
            'email' => 'student@test.com',
        ]);

        $student2 = User::factory()->student()->create([
            'name' => 'Maria Santos',
            'email' => 'maria@test.com',
        ]);

        // ========== KWAGO VENDOR ==========
        $kwagoUser = User::factory()->create([
            'name' => 'Kwago Manager',
            'email' => 'vendor@test.com',
            'role' => 'vendor',
        ]);

        $kwago = Vendor::create([
            'user_id' => $kwagoUser->id,
            'vendor_name' => 'Kwago',
            'location' => 'Main Building, Ground Floor - Near Library',
            'contact_info' => '0917-123-4567',
            'description' => 'Your favorite Filipino comfort food! Serving rice meals, snacks, and refreshments. Open 7 AM - 7 PM.',
        ]);

        // Kwago Rice Meals
        $kwagoItems = [
            ['name' => 'Adobong Manok', 'description' => 'Classic Filipino chicken adobo with rice', 'price' => 65.00, 'category' => 'Rice Meals', 'available' => true],
            ['name' => 'Pork Sisig', 'description' => 'Sizzling pork sisig with egg and rice', 'price' => 75.00, 'category' => 'Rice Meals', 'available' => true],
            ['name' => 'Beef Tapa', 'description' => 'Marinated beef tapa with garlic rice and egg', 'price' => 80.00, 'category' => 'Rice Meals', 'available' => true],
            ['name' => 'Fried Chicken', 'description' => 'Crispy fried chicken with rice', 'price' => 70.00, 'category' => 'Rice Meals', 'available' => true],
            ['name' => 'Pork Tocino', 'description' => 'Sweet pork tocino with garlic rice', 'price' => 65.00, 'category' => 'Rice Meals', 'available' => true],
            ['name' => 'Longganisa', 'description' => 'Filipino sausage with rice and egg', 'price' => 60.00, 'category' => 'Rice Meals', 'available' => true],
            ['name' => 'Bangus Belly', 'description' => 'Grilled milkfish belly with rice', 'price' => 85.00, 'category' => 'Rice Meals', 'available' => false],
            
            // Kwago Snacks
            ['name' => 'Lumpia Shanghai', 'description' => 'Crispy spring rolls (5 pcs)', 'price' => 35.00, 'category' => 'Snacks', 'available' => true],
            ['name' => 'Palabok', 'description' => 'Filipino rice noodles with sauce and toppings', 'price' => 45.00, 'category' => 'Snacks', 'available' => true],
            ['name' => 'Pancit Canton', 'description' => 'Stir-fried noodles with vegetables', 'price' => 40.00, 'category' => 'Snacks', 'available' => true],
            ['name' => 'Siomai', 'description' => 'Steamed pork dumplings (4 pcs)', 'price' => 25.00, 'category' => 'Snacks', 'available' => true],
            ['name' => 'Turon', 'description' => 'Fried banana spring rolls (2 pcs)', 'price' => 20.00, 'category' => 'Snacks', 'available' => true],
            
            // Kwago Beverages
            ['name' => 'Iced Coffee', 'description' => 'Cold brewed coffee with milk', 'price' => 35.00, 'category' => 'Beverages', 'available' => true],
            ['name' => 'Calamansi Juice', 'description' => 'Fresh Filipino lime juice', 'price' => 25.00, 'category' => 'Beverages', 'available' => true],
            ['name' => 'Mango Shake', 'description' => 'Fresh mango smoothie', 'price' => 45.00, 'category' => 'Beverages', 'available' => true],
            ['name' => 'Bottled Water', 'description' => 'Purified drinking water', 'price' => 15.00, 'category' => 'Beverages', 'available' => true],
            ['name' => 'Sago\'t Gulaman', 'description' => 'Sweet tapioca and jelly drink', 'price' => 20.00, 'category' => 'Beverages', 'available' => true],
        ];

        foreach ($kwagoItems as $item) {
            MenuItem::create([
                'vendor_id' => $kwago->id,
                'name' => $item['name'],
                'description' => $item['description'],
                'price' => $item['price'],
                'is_available' => $item['available'],
                'category' => $item['category'],
            ]);
        }

        // ========== CANTEEN VENDOR ==========
        $canteenUser = User::factory()->create([
            'name' => 'Canteen Manager',
            'email' => 'canteen@test.com',
            'role' => 'vendor',
        ]);

        $canteen = Vendor::create([
            'user_id' => $canteenUser->id,
            'vendor_name' => 'Canteen',
            'location' => 'Student Center, 2nd Floor',
            'contact_info' => '0918-765-4321',
            'description' => 'Main campus canteen serving a variety of meals, snacks, and drinks. Breakfast, lunch, and merienda available. Open 6 AM - 8 PM.',
        ]);

        // Canteen Menu Items
        $canteenItems = [
            // Breakfast
            ['name' => 'Tapsilog', 'description' => 'Beef tapa, sinangag (fried rice), and itlog (egg)', 'price' => 75.00, 'category' => 'Breakfast', 'available' => true],
            ['name' => 'Tocilog', 'description' => 'Pork tocino, fried rice, and egg', 'price' => 70.00, 'category' => 'Breakfast', 'available' => true],
            ['name' => 'Longsilog', 'description' => 'Longganisa, fried rice, and egg', 'price' => 65.00, 'category' => 'Breakfast', 'available' => true],
            ['name' => 'Cornsilog', 'description' => 'Corned beef, fried rice, and egg', 'price' => 60.00, 'category' => 'Breakfast', 'available' => true],
            ['name' => 'Hotsilog', 'description' => 'Hotdog, fried rice, and egg', 'price' => 50.00, 'category' => 'Breakfast', 'available' => true],
            
            // Main Dishes
            ['name' => 'Chicken Curry', 'description' => 'Tender chicken in curry sauce with rice', 'price' => 70.00, 'category' => 'Main Dishes', 'available' => true],
            ['name' => 'Pork Menudo', 'description' => 'Pork and liver stew with vegetables', 'price' => 65.00, 'category' => 'Main Dishes', 'available' => true],
            ['name' => 'Beef Caldereta', 'description' => 'Beef stew in tomato sauce with rice', 'price' => 85.00, 'category' => 'Main Dishes', 'available' => true],
            ['name' => 'Chicken Inasal', 'description' => 'Grilled marinated chicken with rice', 'price' => 75.00, 'category' => 'Main Dishes', 'available' => true],
            ['name' => 'Pork Binagoongan', 'description' => 'Pork in shrimp paste sauce with rice', 'price' => 70.00, 'category' => 'Main Dishes', 'available' => false],
            ['name' => 'Lechon Kawali', 'description' => 'Crispy deep-fried pork belly with rice', 'price' => 80.00, 'category' => 'Main Dishes', 'available' => true],
            
            // Noodles & Pasta
            ['name' => 'Spaghetti', 'description' => 'Filipino-style sweet spaghetti', 'price' => 50.00, 'category' => 'Noodles & Pasta', 'available' => true],
            ['name' => 'Carbonara', 'description' => 'Creamy pasta with bacon', 'price' => 60.00, 'category' => 'Noodles & Pasta', 'available' => true],
            ['name' => 'Pancit Bihon', 'description' => 'Stir-fried rice noodles', 'price' => 45.00, 'category' => 'Noodles & Pasta', 'available' => true],
            ['name' => 'Lomi', 'description' => 'Thick egg noodle soup', 'price' => 55.00, 'category' => 'Noodles & Pasta', 'available' => true],
            
            // Snacks
            ['name' => 'Burger Steak', 'description' => 'Beef patty with mushroom gravy and rice', 'price' => 55.00, 'category' => 'Snacks', 'available' => true],
            ['name' => 'Chicken Sandwich', 'description' => 'Fried chicken fillet sandwich', 'price' => 45.00, 'category' => 'Snacks', 'available' => true],
            ['name' => 'Club Sandwich', 'description' => 'Triple-decker sandwich with fries', 'price' => 65.00, 'category' => 'Snacks', 'available' => true],
            ['name' => 'French Fries', 'description' => 'Crispy potato fries', 'price' => 35.00, 'category' => 'Snacks', 'available' => true],
            ['name' => 'Cheese Sticks', 'description' => 'Fried cheese rolls (5 pcs)', 'price' => 30.00, 'category' => 'Snacks', 'available' => true],
            
            // Beverages
            ['name' => 'Iced Tea', 'description' => 'Refreshing lemon iced tea', 'price' => 25.00, 'category' => 'Beverages', 'available' => true],
            ['name' => 'Hot Coffee', 'description' => 'Freshly brewed coffee', 'price' => 20.00, 'category' => 'Beverages', 'available' => true],
            ['name' => 'Buko Juice', 'description' => 'Fresh coconut juice', 'price' => 30.00, 'category' => 'Beverages', 'available' => true],
            ['name' => 'Soft Drinks', 'description' => 'Assorted sodas', 'price' => 25.00, 'category' => 'Beverages', 'available' => true],
            ['name' => 'Fruit Shake', 'description' => 'Banana, mango, or melon shake', 'price' => 40.00, 'category' => 'Beverages', 'available' => true],
            
            // Desserts
            ['name' => 'Halo-Halo', 'description' => 'Filipino mixed dessert with ice', 'price' => 50.00, 'category' => 'Desserts', 'available' => true],
            ['name' => 'Leche Flan', 'description' => 'Creamy caramel custard', 'price' => 35.00, 'category' => 'Desserts', 'available' => true],
            ['name' => 'Buko Pandan', 'description' => 'Coconut and pandan jelly dessert', 'price' => 30.00, 'category' => 'Desserts', 'available' => false],
        ];

        foreach ($canteenItems as $item) {
            MenuItem::create([
                'vendor_id' => $canteen->id,
                'name' => $item['name'],
                'description' => $item['description'],
                'price' => $item['price'],
                'is_available' => $item['available'],
                'category' => $item['category'],
            ]);
        }
    }
}

