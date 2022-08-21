<?php

namespace App\Models;

use App\Models\Scopes\SchoolScope;
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

    protected static function booted()
    {
        static::addGlobalScope(new SchoolScope());
    }

    public function getCompletedAtAttribute($value)
    {
        return is_null($value) ? $value : \date('d-M-Y', \strtotime($value));
    }

    public function getDayAttribute()
    {
        return \substr($this->completed_at, 0, 2);
    }

    public function getMonthAttribute()
    {
        return \substr($this->completed_at, 3, 3);
    }

    public function getYearAttribute()
    {
        return \substr($this->completed_at, 7, 4);
    }

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
