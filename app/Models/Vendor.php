<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'vendor_name',
        'location',
        'contact_info',
        'description',
    ];

    /**
     * Get the user that owns the vendor profile.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the menu items for the vendor.
     */
    public function menuItems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(MenuItem::class);
    }

    /**
     * Get the orders for the vendor.
     */
    public function orders(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the operating hours for the vendor, ordered by day of week.
     */
    public function operatingHours(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(VendorOperatingHours::class)->orderBy('day_of_week');
    }

    /**
     * Determine whether the vendor is currently open.
     */
    public function isOpenNow(): bool
    {
        $dayOfWeek = (int) now()->format('w');
        $currentTime = now()->format('H:i:s');

        $record = $this->operatingHours
            ->firstWhere('day_of_week', $dayOfWeek);

        if (! $record || $record->is_closed) {
            return false;
        }

        return $currentTime >= $record->open_time
            && $currentTime <= $record->close_time;
    }
}
