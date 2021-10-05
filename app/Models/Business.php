<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Business extends Model
{
    use HasFactory;

    /** @var array<string> */
    protected $fillable = [
        'rfc',
        'legal_name',
        'common_name',
        'certificate',
        'private_key',
        'passphrase',
        'valid_until',
    ];

    /** @var array<string> */
    protected $hidden = ['passphrase'];

    /** @var array<string, string> */
    protected $casts = [
        'valid_until' => 'datetime',
    ];

    public function petitions(): HasMany
    {
        return $this->hasMany(Petition::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
