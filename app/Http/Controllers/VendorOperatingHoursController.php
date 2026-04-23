<?php

namespace App\Http\Controllers;

use App\Models\VendorOperatingHours;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VendorOperatingHoursController extends Controller
{
    /**
     * Update the operating hours for the authenticated vendor.
     */
    public function update(Request $request): RedirectResponse
    {
        $vendor = auth()->user()->vendor;

        if (! $vendor) {
            abort(404, 'Vendor profile not found');
        }

        // Normalise is_closed: checkboxes only submit when checked, so inject 0 for missing days.
        $hours = $request->input('hours', []);
        foreach (range(0, 6) as $day) {
            if (! isset($hours[$day]['is_closed'])) {
                $hours[$day]['is_closed'] = '0';
            }
        }
        $request->merge(['hours' => $hours]);

        $validated = $request->validate([
            'hours'                  => ['required', 'array'],
            'hours.*.is_closed'      => ['required', 'boolean'],
            'hours.*.open_time'      => [
                'nullable',
                'date_format:H:i',
                'required_if:hours.*.is_closed,0',
            ],
            'hours.*.close_time'     => [
                'nullable',
                'date_format:H:i',
                'required_if:hours.*.is_closed,0',
            ],
        ]);

        // Custom after-validation: close_time must be strictly after open_time when open
        $errors = [];

        foreach ($validated['hours'] as $day => $entry) {
            $isClosed = filter_var($entry['is_closed'], FILTER_VALIDATE_BOOLEAN);

            if (! $isClosed) {
                $openTime  = $entry['open_time']  ?? null;
                $closeTime = $entry['close_time'] ?? null;

                if ($openTime && $closeTime && $closeTime <= $openTime) {
                    $errors["hours.{$day}.close_time"] = [
                        "The close time for day {$day} must be after the open time.",
                    ];
                }
            }
        }

        if (! empty($errors)) {
            return redirect()->back()
                ->withErrors($errors)
                ->withInput();
        }

        foreach (range(0, 6) as $day) {
            $entry    = $validated['hours'][$day] ?? [];
            $isClosed = isset($entry['is_closed'])
                ? filter_var($entry['is_closed'], FILTER_VALIDATE_BOOLEAN)
                : true;

            VendorOperatingHours::updateOrCreate(
                [
                    'vendor_id'   => $vendor->id,
                    'day_of_week' => $day,
                ],
                [
                    'is_closed'  => $isClosed,
                    'open_time'  => $isClosed ? null : ($entry['open_time']  ?? null),
                    'close_time' => $isClosed ? null : ($entry['close_time'] ?? null),
                ]
            );
        }

        return redirect()->route('vendor.profile')
            ->with('success', 'Operating hours updated successfully');
    }
}
