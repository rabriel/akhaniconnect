<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserActivity extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'activity_type',
        'method',
        'route_name',
        'path',
        'ip_address',
        'country_code',
        'country_name',
        'browser',
        'platform',
        'device_type',
        'response_status',
        'user_agent',
        'metadata',
        'occurred_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'metadata' => 'array',
        'occurred_at' => 'datetime',
        'response_status' => 'integer',
    ];

    /**
     * Get the user that owns the activity record.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
