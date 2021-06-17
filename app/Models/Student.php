<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/** @property School $school */
/** @property Enquiry $enquiry */
class Student extends Model
{
    use AsSource, Filterable, HasFactory;


    protected $fillable = [
        'name', 'photo', 'dob_at', 'gender', 'code', 'father_name', 'father_contact', 'father_occupation', 'father_email', 'father_organization_name', 'mother_name', 'mother_contact', 'mother_occupation', 'mother_email', 'mother_organization_name', 'previous_school', 'siblings', 'address', 'city', 'state', 'postal_code', 'nationality', 'school_id', 'created_at', 'father_logged_at', 'mother_logged_at',
    ];


    protected $casts = [
        'siblings' => 'array',
        'dob_at' => 'date'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function (Student $student) {
            $student->school_id = school()->id;
        });
    }

    public function getPrnAttribute()
    {
        $date = clone $this->created_at;
        return strtoupper($this->school->code) . '/' . str_pad($this->code, 4, '0', STR_PAD_LEFT) . '/' . $this->created_at->format('y') . $date->addYear()->format('y');
    }


    public function getSearchTitleAttribute(): string
    {
        return $this->attributes['name'] . ' (' . $this->prn . ')';
    }

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
    public function admission()
    {
        return $this->hasOne(Admission::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function enquiry()
    {
        return $this->hasOne(Enquiry::class);
    }

    public function receipts(): HasMany
    {
        return $this->hasMany(Receipt::class);
    }
}
