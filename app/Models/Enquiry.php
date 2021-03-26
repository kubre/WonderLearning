<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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
    use HasFactory, AsSource, Filterable;

    /** @var array */
    protected $fillable = [
        'name', 'gender', 'dob_at', 'enquirer_name', 'enquirer_email', 'enquirer_contact', 'locality', 'reference', 'follow_up_at', 'student_id', 'school_id', ];

    /** @var array */
    protected $dates = ['dob_at', 'follow_up_at', ];

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
