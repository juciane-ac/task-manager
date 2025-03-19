<?php

namespace App\Models;

use App\Enums\TaskPriority;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Task extends Model
{
    protected $fillable = ['title', 'description', 'responsible', 'priority', 'deadline', 'project_id'];

    
    protected $casts = [
        'priority' => TaskPriority::class, 
    ];

    protected static function booted(): void
    {
        static::addGlobalScope('responsible', function (Builder $builder) {
            if (auth()->user()->hasRole('user')) {
                $builder->where('responsible', auth()->id());
            }
        });
    }

    public function getPriorityLabelAttribute(): string
    {
        return match($this->priority) {
            TaskPriority::low->value => 'Baixa',
            TaskPriority::medium->value => 'Média',
            TaskPriority::high->value => 'Alta',
        };
    }

    public function responsavel(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible', 'id');
    }


    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
