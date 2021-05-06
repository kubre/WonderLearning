<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SchoolSyllabus extends Pivot
{

    public $table = 'school_syllabus';

    public $timestamps = false;

    /** @var bool */
    public $incrementing = true;

    public $fillable = [
        'school_id',
        'syllabus_id',
        'completed_at',
    ];

    public function approval(): MorphOne
    {
        return $this->morphOne(Approval::class, 'approval');
    }

    public function syllabus(): BelongsTo
    {
        return $this->belongsTo(Syllabus::class);
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}