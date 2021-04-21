<?php

namespace App\Models;

use App\Models\Scopes\AcademicYearScope;
use App\Models\Scopes\SchoolScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KitStock extends Model
{
    protected $fillable = [
        'playgroup_total',
        'playgroup_assigned',
        'nursery_total',
        'nursery_assigned',
        'junior_kg_total',
        'junior_kg_assigned',
        'senior_kg_total',
        'senior_kg_assigned',
        'created_at',
        'school_id',
    ];

    protected $casts = [
        'playgroup_total' => 'integer',
        'playgroup_assigned' => 'integer',
        'nursery_total' => 'integer',
        'nursery_assigned' => 'integer',
        'junior_kg_total' => 'integer',
        'junior_kg_assigned' => 'integer',
        'senior_kg_total' => 'integer',
        'senior_kg_assigned' => 'integer',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function (KitStock $kit) {
            $kit->created_at = working_year()[0];
            $kit->school_id = school()->id;
        });
    }

    public static function booted()
    {
        static::addGlobalScope(new AcademicYearScope);
        static::addGlobalScope(new SchoolScope);
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}
