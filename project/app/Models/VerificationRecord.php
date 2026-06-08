<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class VerificationRecord extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'module',
        'provider',
        'status',
        'provider_reference',
        'summary',
        'last_error',
        'last_verified_at',
        'verifiable_type',
        'verifiable_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'summary' => 'array',
        'last_verified_at' => 'datetime',
    ];

    /**
     * Get the user that owns the verification record.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the attempts for this verification record.
     */
    public function attempts(): HasMany
    {
        return $this->hasMany(VerificationAttempt::class);
    }

    /**
     * Get the subject this verification record belongs to.
     */
    public function verifiable(): MorphTo
    {
        return $this->morphTo();
    }
}
