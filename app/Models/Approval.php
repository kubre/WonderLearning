<?php

namespace App\Models;

use App\Models\Scopes\AcademicYearScope;
use App\Models\Scopes\SchoolScope;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    protected $fillable = [
        'school_id',
        'approval_type',
        'approval_id',
        'method',
        'data',
        'created_at',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new AcademicYearScope());
        static::addGlobalScope(new SchoolScope());
    }

    public function approval()
    {
        return $this->morphTo();
    }
}
