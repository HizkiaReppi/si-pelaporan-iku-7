<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function laporanIku(): HasMany
    {
        return $this->hasMany(IKU7::class);
    }

    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Check if user is online.
     */
    public function isOnline(): Bool
    {
        return $this->last_activity >= now()->subMinutes();
    }

    /**
     * Get user last activity.
     */
    public function lastActivityAgo(): String
    {
        return $this->last_activity !== null ? Carbon::parse($this->last_activity)->diffForHumans() : 'Tidak Pernah Login';
    }
}
