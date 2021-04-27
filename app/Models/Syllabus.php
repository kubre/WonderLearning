<?php

namespace App\Models;

use App\Models\Scopes\AcademicYearScope;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Syllabus extends Model
{
    use NodeTrait;

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


    // public function children(): HasMany
    // {
    //     return $this->hasMany(Syllabus::class, 'syllabus_id', 'id');
    // }
}
