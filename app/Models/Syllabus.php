<?php

namespace App\Models;

use App\Models\Scopes\AcademicYearScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Kalnoy\Nestedset\NodeTrait;
use Orchid\Screen\AsSource;

class Syllabus extends Model
{
    use NodeTrait;
    use AsSource;

    public const TYPES = [
        'subject',
        'book',
        'chapter',
        'topic',
        'subtopic',
    ];

    public const SUB_TYPES = [
        'subject' => 'book',
        'book' => 'chapter',
        'chapter' => 'topic',
        'topic' => 'subtopic',
    ];

    public const SUBJECT = 'subject';
    public const BOOK = 'book';
    public const CHAPTER = 'chapter';
    public const TOPIC = 'topic';
    public const SUBTOPIC = 'subtopic';

    protected $fillable = [
        'name', 'type',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function (Syllabus $syllabus) {
            $syllabus->created_at = working_year()[0];
        });
    }

    protected static function booted()
    {
        static::addGlobalScope(new AcademicYearScope());
    }

    public function scopeSubjectsForTeacher(Builder $builder, int $teacherId)
    {
        $builder->withoutGlobalScopes()
            ->select('syllabi.*')
            ->rightJoin('program_subjects', 'syllabi.id', '=', 'program_subjects.syllabus_id')
            ->rightJoin('divisions', function ($join) {
                $join->on('program_subjects.program', '=', 'divisions.program');
            })
            ->where('divisions.teacher_id', $teacherId)
            ->whereBetween('syllabi.created_at', working_year());
    }

    public function scopeUnassignedSubjects(Builder $query): Builder
    {
        return $query->doesntHave('programme')->where('type', self::SUBJECT);
    }

    public function programme(): HasOne
    {
        return $this->hasOne(ProgramSubject::class, 'syllabus_id');
    }

    public function schools(): BelongsToMany
    {
        return $this->belongsToMany(School::class)
            ->withPivot('id', 'completed_at');
    }

    // public function children(): HasMany
    // {
    //     return $this->hasMany(Syllabus::class, 'syllabus_id', 'id');
    // }
}
