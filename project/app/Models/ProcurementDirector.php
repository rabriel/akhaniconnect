<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ProcurementDirector extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'procurement_profile_id',
        'full_name',
        'initials',
        'birth_date',
        'gender',
        'title',
        'marital_status',
        'privacy_status',
        'cellular_number',
        'home_telephone',
        'work_telephone',
        'email_address',
        'residential_address',
        'postal_address',
        'employer',
        'number_of_enquiries',
        'id_number',
        'position',
        'status',
        'provider_reference',
        'director_status',
        'verification_summary',
        'director_data',
        'verified_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_date' => 'date',
        'number_of_enquiries' => 'integer',
        'verification_summary' => 'array',
        'director_data' => 'array',
        'verified_at' => 'datetime',
    ];

    /**
     * Get the procurement profile that owns the director.
     */
    public function procurementProfile(): BelongsTo
    {
        return $this->belongsTo(ProcurementProfile::class);
    }

    /**
     * Get verification records linked to this director.
     */
    public function verificationRecords(): MorphMany
    {
        return $this->morphMany(VerificationRecord::class, 'verifiable');
    }
}
