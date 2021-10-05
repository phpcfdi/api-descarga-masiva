<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Package extends Model
{
    use HasFactory;

    /** @var array<string> */
    protected $fillable = ['petition_id', 'sat_package', 'status', 'path'];

    public function petition(): BelongsTo
    {
        return $this->belongsTo(Petition::class);
    }
}
