<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'active',
        'is_admin',
        'slack_id',
        'avatar',
        'slack_username',
        'github_username',
        'github_token',
        'github_token_added_at',
        'github_token_changed_at',
        'github_token_deleted_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class);
    }

    public function workdays(): HasMany
    {
        return $this->hasMany(Workday::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
