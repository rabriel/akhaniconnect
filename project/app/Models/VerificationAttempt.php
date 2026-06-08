<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VerificationAttempt extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'verification_record_id',
        'status',
        'provider_reference',
        'request_payload',
        'raw_response',
        'processed_response',
        'error_message',
        'attempted_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'request_payload' => 'array',
        'processed_response' => 'array',
        'attempted_at' => 'datetime',
    ];

    /**
     * Get the verification record that owns the attempt.
     */
    public function verificationRecord(): BelongsTo
    {
        return $this->belongsTo(VerificationRecord::class);
    }
}
