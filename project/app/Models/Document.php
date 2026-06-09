<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Document extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'application_id',
        'category',
        'type',
        'display_name',
        'original_name',
        'path',
        'mime_type',
        'size',
        'status',
        'uploaded_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'uploaded_at' => 'datetime',
        'size' => 'integer',
    ];

    /**
     * Get the user that owns the document.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the application that owns the document.
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    /**
     * Get the preferred download filename for the document.
     */
    public function getDownloadNameAttribute(): string
    {
        $originalName = (string) $this->original_name;
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $baseName = trim((string) ($this->display_name ?: pathinfo($originalName, PATHINFO_FILENAME)));

        if ($baseName === '') {
            return $originalName;
        }

        return $extension !== ''
            ? Str::finish($baseName, '.' . $extension)
            : $baseName;
    }
}
