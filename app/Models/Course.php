<?php

namespace App\Models;

use Database\Factories\CourseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Course extends Model
{
    /** @use HasFactory<CourseFactory> */
    use HasFactory;

    protected $guarded = [];


    public function enrollments(): hasMany
    {
        return $this->hasMany(Enrollment::class);
    }
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'enrollments');
    }
    public function assignments(): hasMany
    {
        return $this->hasMany(Assignment::class);
    }
    public function quizzes(): hasMany
    {
        return $this->hasMany(Quiz::class);
    }
    public function forumPosts(): hasMany
    {
        return $this->hasMany(Post::class);
    }
    public function attendance(): hasMany
    {
        return $this->hasMany(Attendance::class);
    }
    public function grades(): HasManyThrough
    {
        return $this->hasManyThrough(Grade::class, Submission::class);
    }
    public function slides(): HasMany
    {
        return $this->hasMany(Slide::class);
    }

    public function quickLinks(): HasMany
    {
        return $this->hasMany(QuickLink::class);
    }

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];
}
