<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PetitionLog extends Model
{
    use HasFactory;

    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'petition_logs';

    /** @var array<string> */
    protected $fillable = [
        'petition_id',
        'occurred_at',
        'message',
        'request',
        'response',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'occurred_at' => 'datetime',
    ];

    public function petition(): BelongsTo
    {
        return $this->belongsTo(Petition::class);
    }
}
