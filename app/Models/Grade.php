<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
{
    /** @use HasFactory<\Database\Factories\GradeFactory> */
    use HasFactory;

    protected $guarded = [];

    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class);
    }
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

}
