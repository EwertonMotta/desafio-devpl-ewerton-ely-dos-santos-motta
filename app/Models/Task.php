<?php

namespace App\Models;

use App\Policies\TaskPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[UsePolicy(TaskPolicy::class)]
class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'deadline',
        'completed',
        'completed_at',
    ];

    protected $casts = [
        'deadline' => 'datetime',
        'completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    #[Scope]
    protected function pending(Builder $query): void
    {
        $query->where('completed', false);
    }

    #[Scope]
    protected function completed(Builder $query): void
    {
        $query->where('completed', true);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
