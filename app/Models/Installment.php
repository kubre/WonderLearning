<?php

namespace App\Models;

use App\Models\Scopes\AcademicYearScope;
use App\Models\Scopes\SchoolScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    use HasFactory;

    protected $fillable = [
        'month',
        'amount',
        'due_amount',
        'admission_id',
        'school_id',
        'created_at',
    ];

    protected $casts = [
        'amount' => 'integer',
        'due_amount' => 'integer',
        'month' => 'integer',
    ];


    protected static function booted()
    {
        static::addGlobalScope(new AcademicYearScope);
        static::addGlobalScope(new SchoolScope);
    }

    public function getMonthNameAttribute(): string
    {
        return date('F', mktime(0, 0, 0, $this->month));
    }

    public function getShortMonthNameAttribute(): string
    {
        return date('M', mktime(0, 0, 0, $this->month));
    }
}
