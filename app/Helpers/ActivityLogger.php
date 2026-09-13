<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    /**
     * Create an activity log.
     */
    public static function log(
        string $activity,
        string $type,
        ?string $description = null,
        string $status = 'Successful'
    ): void {
        ActivityLog::create([
            'user_id' => Auth::id(),

            'activity' => $activity,

            'type' => $type,

            'description' => $description,

            'ip_address' => request()->ip(),

            'status' => $status,

            'user_agent' => request()->userAgent(),

            'created_at' => now(),
        ]);
    }
}