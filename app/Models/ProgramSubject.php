<?php

namespace App\Models;

use App\Models\Scopes\AcademicYearScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Screen\AsSource;

class ProgramSubject extends Model
{
    use AsSource;

    protected $table = 'program_subjects';

    protected $primaryKey = 'syllabus_id';

    public $incrementing = false;

    protected $fillable = [
        'program', 'syllabus_id',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function (ProgramSubject $association) {
            $association->created_at = working_year()[0];
        });
    }

    protected static function booted()
    {
        static::addGlobalScope(new AcademicYearScope());
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Syllabus::class, 'syllabus_id');
    }
}
