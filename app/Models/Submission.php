<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'student_id',
        'content',
        'video_link',
        'score',
        'feedback',
        'status',
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isGraded(): bool
    {
        return $this->status === 'graded';
    }

    public function calculateXp(): int
    {
        if (!$this->isGraded() || $this->score === null) {
            return 0;
        }
        return (int) round($this->task->points * ($this->score / 100));
    }
}
