<?php

namespace App\Models;

use App\Enums\TaskPriority;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = ['title', 'description', 'responsible', 'priority', 'deadline', 'project_id'];

    
    protected $casts = [
        'priority' => TaskPriority::class, 
    ];

    public function getPriorityLabelAttribute(): string
    {
        return match($this->priority) {
            TaskPriority::low => 'Baixa',
            TaskPriority::medium => 'Média',
            TaskPriority::high => 'Alta',
        };
    }

    public function responsible(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible');
    }


    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
