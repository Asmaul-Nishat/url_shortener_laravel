<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'default_link_status',
        'default_expiration_days',
        'allow_guest_short_urls',
        'allow_guest_qr_codes',
        'enable_analytics',
        'enable_reports',
        'enable_activity_logs',
    ];

    protected $casts = [
        'default_expiration_days' => 'integer',
        'allow_guest_short_urls' => 'boolean',
        'allow_guest_qr_codes' => 'boolean',
        'enable_analytics' => 'boolean',
        'enable_reports' => 'boolean',
        'enable_activity_logs' => 'boolean',
    ];

    /**
     * Get the current system settings.
     *
     * Creates the default settings row if it does not exist.
     */
    public static function current(): self
    {
        return static::firstOrCreate(
            ['id' => 1],
            [
                'default_link_status' => 'active',
                'default_expiration_days' => 0,
                'allow_guest_short_urls' => true,
                'allow_guest_qr_codes' => true,
                'enable_analytics' => true,
                'enable_reports' => true,
                'enable_activity_logs' => true,
            ]
        );
    }
}