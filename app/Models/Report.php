<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'short_url_id',
        'name',
        'type',
        'date_range',
        'start_date',
        'end_date',
        'format',
        'file_path',
        'total_clicks',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'total_clicks' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function shortUrl(): BelongsTo
    {
        return $this->belongsTo(ShortUrl::class);
    }
}