<?php

namespace App\Models;

use App\Models\Scopes\AcademicYearScope;
use App\Models\Scopes\SchoolScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'approval_type',
        'approval_id',
        'method',
        'created_at',
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
