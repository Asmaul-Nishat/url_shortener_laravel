<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'language',
        'timezone',
        'date_format',
        'default_expiration',
        'allow_custom_aliases',
        'duplicate_detection',
        'link_expiration_alerts',
        'report_notifications',
        'security_alerts',
    ];

    protected $casts = [
        'allow_custom_aliases' => 'boolean',
        'duplicate_detection' => 'boolean',
        'link_expiration_alerts' => 'boolean',
        'report_notifications' => 'boolean',
        'security_alerts' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}