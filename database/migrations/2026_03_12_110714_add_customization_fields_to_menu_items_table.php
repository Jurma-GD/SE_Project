<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->string('image_url')->nullable()->after('category');
            $table->string('custom_category')->nullable()->after('category');
            $table->json('tags')->nullable()->after('custom_category');
            $table->integer('preparation_time')->nullable()->after('tags')->comment('in minutes');
            $table->boolean('is_spicy')->default(false)->after('preparation_time');
            $table->boolean('is_vegetarian')->default(false)->after('is_spicy');
            $table->boolean('is_featured')->default(false)->after('is_vegetarian');
            $table->integer('stock_quantity')->nullable()->after('is_featured');
            $table->json('customization_options')->nullable()->after('stock_quantity');
            $table->text('allergen_info')->nullable()->after('customization_options');
            $table->integer('calories')->nullable()->after('allergen_info');
            $table->integer('display_order')->default(0)->after('calories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropColumn([
                'image_url',
                'custom_category',
                'tags',
                'preparation_time',
                'is_spicy',
                'is_vegetarian',
                'is_featured',
                'stock_quantity',
                'customization_options',
                'allergen_info',
                'calories',
                'display_order',
            ]);
        });
    }
};
