<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Profile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'date_of_birth',
        'gender',
        'id_number',
        'passport_number',
        'phone_secondary',
        'avatar_path',
        'address_line_1',
        'address_line_2',
        'suburb',
        'city',
        'province',
        'postal_code',
        'country',
        'identity_verified',
        'identity_verified_at',
        'profile_completed',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_of_birth' => 'date',
        'identity_verified' => 'boolean',
        'identity_verified_at' => 'datetime',
        'profile_completed' => 'boolean',
    ];

    /**
     * Get the resolved avatar URL.
     */
    public function getAvatarUrlAttribute(): ?string
    {
        if (! $this->avatar_path) {
            return null;
        }

        return route('profile.avatar.show', $this);
    }

    /**
     * Get the user that owns the profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
