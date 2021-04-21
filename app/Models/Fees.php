<?php

namespace App\Models;

use App\Models\Scopes\AcademicYearScope;
use App\Models\Scopes\SchoolScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

/** @property School $school */
/** @property Carbon $created_at */
/** @property Carbon $updated_at */
class Fees extends Model
{
    use AsSource, HasFactory;

    /** @var array */
    protected $fillable = [
        'title',
        'playgroup',
        'playgroup_total',
        'nursery',
        'nursery_total',
        'junior_kg',
        'junior_kg_total',
        'senior_kg',
        'senior_kg_total',
        'school_id',
        'created_at'
    ];

    /** @var array */
    protected $casts = [
        'playgroup' => 'array',
        'nursery' => 'array',
        'junior_kg' => 'array',
        'senior_kg' => 'array',
        'playgroup_total' => 'integer',
        'nursery_total' => 'integer',
        'junior_kg_total' => 'integer',
        'senior_kg_total' => 'integer',
    ];

    protected static function boot()
    {
        $working_year = working_year();
        parent::boot();
        static::creating(function (Fees $fees) use ($working_year) {
            $fees->title = get_academic_year_formatted($working_year);
            $fees->created_at = $working_year[0];
            $fees->school_id = auth()->user()->school_id;
        });
    }

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
}
