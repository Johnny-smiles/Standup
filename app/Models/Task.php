<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'workday_id',
        'user_id',
        'status',
        'time',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function workday(): BelongsTo
    {
        return $this->belongsTo(Workday::class);
    }

    public function getStatusTextAttribute($value): string
    {
        return ucfirst(str_replace('_', ' ', $value));
    }
}
