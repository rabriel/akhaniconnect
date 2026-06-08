<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ProcurementProfile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'company_name',
        'registration_number',
        'vat_number',
        'company_phone',
        'enterprise_status',
        'enterprise_type',
        'enterprise_address',
        'enterprise_data',
        'enterprise_synced_at',
        'verification_progress',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'enterprise_data' => 'array',
        'enterprise_synced_at' => 'datetime',
        'verification_progress' => 'integer',
    ];

    /**
     * Get the user that owns the procurement profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the directors associated with the procurement profile.
     */
    public function directors(): HasMany
    {
        return $this->hasMany(ProcurementDirector::class);
    }

    /**
     * Get verification records linked to this procurement profile.
     */
    public function verificationRecords(): MorphMany
    {
        return $this->morphMany(VerificationRecord::class, 'verifiable');
    }
}
