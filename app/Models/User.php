<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /** @var array<string> */
    protected $fillable = ['id', 'name', 'email', 'password', 'is_admin'];

    /** @var array<string> */
    protected $hidden = ['password', 'remember_token'];

    /** @var array<string, string> */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
    ];

    /**
     * returns allowed sorts fields the "-" is use by frontend to allow desc ordering
     *
     * @return array<string>
     */
    public static function allowedSorts(): array
    {
        return [
            'name', '-name', 'email', '-email',
        ];
    }

    public function businesses(): BelongsToMany
    {
        return $this->belongsToMany(Business::class);
    }
}
