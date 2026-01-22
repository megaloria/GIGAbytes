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
        'role',
        'xp_points',
        'level',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Role check methods
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isTeacher(): bool
    {
        return $this->role === 'teacher';
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    // Relationships
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'teacher_id');
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class, 'student_id');
    }

    public function badges(): BelongsToMany
    {
        return $this->belongsToMany(Badge::class, 'user_badges')
            ->withPivot('earned_at');
    }

    // XP and Level methods
    public function addXp(int $amount): void
    {
        $this->xp_points += $amount;
        $this->level = $this->calculateLevel();
        $this->save();
    }

    public function calculateLevel(): int
    {
        return floor($this->xp_points / 100) + 1;
    }

    public function xpToNextLevel(): int
    {
        return ($this->level * 100) - $this->xp_points;
    }

    public function xpProgress(): int
    {
        $currentLevelXp = ($this->level - 1) * 100;
        $nextLevelXp = $this->level * 100;
        $progress = $this->xp_points - $currentLevelXp;
        return min(100, ($progress / 100) * 100);
    }
}
