<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecruitmentProfile extends Model
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
        'website',
        'company_phone',
        'contact_person_name',
    ];

    /**
     * Get the user that owns the recruitment profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
