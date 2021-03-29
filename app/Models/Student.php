<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/** @property School $school */
/** @property Enquiry $enquiry */
class Student extends Model
{
    use AsSource, Filterable;

    /** @var array */
    protected $fillable = [
        'name', 'photo', 'dob_at', 'gender', 'father_name', 'father_contact', 'father_occupation', 'father_email', 'father_organization_name', 'mother_name', 'mother_contact', 'mother_occupation', 'mother_email', 'mother_organization_name', 'previous_school', 'siblings', 'address', 'city', 'state', 'postal_code', 'nationality', 'school_id',
    ];

    /** @var array */
    protected $casts = [
        'siblings' => 'array',
        'dob_at' => 'date'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function enquiry()
    {
        return $this->hasOne(Enquiry::class);
    }
}
