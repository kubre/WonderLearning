<?php

namespace App\Models;

use App\Models\Traits\HasAcademicYear;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

/** @property School $school */
/** @property Carbon $created_at */
/** @property Carbon $updated_at */
class Fees extends Model
{
    use HasFactory, AsSource, HasAcademicYear;

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public static function getFeesCard(Carbon $date = null): ?Fees
    {
        return self::whereBetween('created_at', self::getAcademicYear($date))->first();
    }
}
