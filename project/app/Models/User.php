<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'first_name',
        'surname',
        'email',
        'phone',
        'password',
        'status',
        'last_login_at',
        'email_verified_at',
        'phone_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the user's role.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the user's shared profile.
     */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * Get the user's candidate profile.
     */
    public function candidateProfile(): HasOne
    {
        return $this->hasOne(CandidateProfile::class);
    }

    /**
     * Get the user's recruitment profile.
     */
    public function recruitmentProfile(): HasOne
    {
        return $this->hasOne(RecruitmentProfile::class);
    }

    /**
     * Get the user's procurement profile.
     */
    public function procurementProfile(): HasOne
    {
        return $this->hasOne(ProcurementProfile::class);
    }

    /**
     * Get the user's client profile.
     */
    public function clientProfile(): HasOne
    {
        return $this->hasOne(ClientProfile::class);
    }

    /**
     * Get the documents uploaded by the user.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Get the verification records for the user.
     */
    public function verificationRecords(): HasMany
    {
        return $this->hasMany(VerificationRecord::class);
    }

    /**
     * Get the tracked activity records for the user.
     */
    public function activities(): HasMany
    {
        return $this->hasMany(UserActivity::class);
    }

    /**
     * Get the user's POPIA acknowledgement history.
     */
    public function privacyAcknowledgements(): HasMany
    {
        return $this->hasMany(PrivacyAcknowledgement::class);
    }

    /**
     * Get the jobs posted by the recruiter.
     */
    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }

    /**
     * Get the applications submitted by the candidate.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'candidate_user_id');
    }

    /**
     * Get the user's full name.
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn (): string => trim("{$this->first_name} {$this->surname}")
        );
    }

    /**
     * Determine whether the user has the given role slug.
     */
    public function hasRole(string $roleSlug): bool
    {
        return $this->role?->slug === $roleSlug;
    }

    /**
     * Determine whether the user is a superadmin.
     */
    public function isSuperadmin(): bool
    {
        return $this->hasRole('superadmin');
    }

    /**
     * Determine whether the user has the given permission slug.
     */
    public function hasPermissionTo(string $permissionSlug): bool
    {
        if ($this->isSuperadmin()) {
            return true;
        }

        $this->loadMissing('role.permissions');

        return $this->role !== null
            && $this->role->permissions->contains('slug', $permissionSlug);
    }

    /**
     * Determine whether the user has a verified SA identity record.
     */
    public function hasVerifiedIdentity(): bool
    {
        $this->loadMissing('verificationRecords');

        return $this->verificationRecords
            ->where('module', 'sa_identity')
            ->where('status', 'verified')
            ->isNotEmpty();
    }
}
