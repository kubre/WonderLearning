<?php

namespace App\Models;

use App\Models\Scopes\AcademicYearScope;
use App\Models\Scopes\SchoolScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Screen\AsSource;

class Division extends Model
{
    use AsSource;

    protected $fillable = [
        'title',
        'program',
        'teacher_id',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function (Division $division) {
            $division->school_id = school()->id;
            $division->created_at = working_year()[0];
        });
    }

    protected static function booted()
    {
        static::addGlobalScope(new AcademicYearScope());
        static::addGlobalScope(new SchoolScope());
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id', 'id', 'users');
    }

    public function getTitleAndProgramAttribute()
    {
        return "{$this->attributes['title']} ({$this->attributes['program']})";
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function subjects()
    {
        $this->hasManyThrough(Syllabus::class, ProgramSubject::class, 'program', 'syllabus_id', 'program');
    }

    public function scopeOfTeacher($query, int $teacherId)
    {
        return $query->where('teacher_id', $teacherId);
    }
}
