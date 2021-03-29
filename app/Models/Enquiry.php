<?php

namespace App\Models;

use App\Models\Scopes\AcademicYearScope;
use App\Models\Scopes\SchoolScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/** @property School $school */
/** @property Student $student */
/** @property Carbon $created_at */
/** @property Carbon $updated_at */
/** @property Carbon $dob_at */
/** @property Carbon $follow_up_at */
class Enquiry extends Model
{
    use AsSource, Filterable;

    /** @var array */
    protected $fillable = [
        'name', 'gender', 'dob_at', 'program', 'enquirer_name', 'enquirer_email', 'enquirer_contact', 'locality', 'reference', 'follow_up_at', 'student_id', 'school_id',
    ];

    /** @var array */
    protected $dates = ['dob_at', 'follow_up_at',];

    /** @var array */
    protected $allowedFilters = [
        'created_at',
        'name',
        'follow_up_at',
    ];


    protected static function booted()
    {
        static::addGlobalScope(new AcademicYearScope);
        static::addGlobalScope(new SchoolScope);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
