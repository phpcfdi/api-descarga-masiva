<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Petition extends Model
{
    use HasFactory;

    /** @var array<string> */
    protected $fillable = [
        'business_id',
        'download_service',
        'download_type',
        'download_nature',
        'period_since',
        'period_until',
        'status',
        'sat_request',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'period_since' => 'datetime',
        'period_until' => 'datetime',
    ];

    public function packages(): HasMany
    {
        return $this->hasMany(Package::class);
    }

    public function petitionLogs(): HasMany
    {
        return $this->hasMany(PetitionLog::class);
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }
}
