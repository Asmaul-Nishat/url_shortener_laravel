<?php

namespace App\Models;

use App\Models\QrCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShortUrl extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'original_url',
        'short_code',
        'custom_alias',
        'click_count',
        'expires_at',
        'password',
        'scheduled_at',
        'status',
        'is_favorite',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'scheduled_at' => 'datetime',
        'click_count' => 'integer',
        'is_favorite' => 'boolean',
        'deleted_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function clicks(): HasMany
    {
        return $this->hasMany(UrlClick::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function qrCodes(): HasMany
    {
        return $this->hasMany(QrCode::class);
    }

    public function getShortUrlAttribute(): string
    {
        return url(
            $this->custom_alias ?: $this->short_code
        );
    }

    public function isExpired(): bool
    {
        return $this->expires_at !== null
            && $this->expires_at->isPast();
    }

    public function isScheduled(): bool
    {
        return $this->scheduled_at !== null
            && $this->scheduled_at->isFuture();
    }

    public function isPasswordProtected(): bool
    {
        return !empty($this->password);
    }
}