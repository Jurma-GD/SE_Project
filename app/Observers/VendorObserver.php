<?php

namespace App\Observers;

use App\Models\Vendor;
use App\Models\VendorOperatingHours;

class VendorObserver
{
    /**
     * Handle the Vendor "created" event.
     *
     * Seeds seven VendorOperatingHours rows (one per day, all closed by default)
     * for the newly created vendor.
     */
    public function created(Vendor $vendor): void
    {
        $rows = [];

        for ($day = 0; $day <= 6; $day++) {
            $rows[] = [
                'vendor_id' => $vendor->id,
                'day_of_week' => $day,
                'open_time' => null,
                'close_time' => null,
                'is_closed' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        VendorOperatingHours::insert($rows);
    }
}
