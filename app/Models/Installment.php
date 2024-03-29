<?php

namespace App\Models;

use App\Models\Scopes\AcademicYearScope;
use App\Models\Scopes\SchoolScope;
use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{

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
    ];


    protected static function booted()
    {
        static::addGlobalScope(new AcademicYearScope);
        static::addGlobalScope(new SchoolScope);
    }

    public function getMonthNameAttribute(): string
    {
        list($month, $year) = \explode(" ", $this->month);
        return date('F', mktime(0, 0, 0, (int)$month, 1, (int)$year));
    }

    public function getMonthNameAndYearAttribute(): string
    {
        list($month, $year) = \explode(" ", $this->month);
        return date('F Y', mktime(0, 0, 0, (int)$month, 1, (int)$year));
    }

    public function getShortMonthNameAttribute(): string
    {
        list($month, $year) = \explode(" ", $this->month);
        return date('M', mktime(0, 0, 0, (int)$month, 1, $year));
    }


    public function getPaidAmountAttribute(): int
    {
        return $this->amount - $this->due_amount;
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param int
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnpaid($query, $admissionId)
    {
        return $query->where('admission_id', $admissionId)
            ->where('due_amount', '>', 0);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param int
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePaid($query, $admissionId)
    {
        return $query->where('admission_id', $admissionId)
            ->whereColumn('due_amount', '!=', 'amount');
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param int
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNil($query, $admissionId)
    {
        return $query->where('admission_id', $admissionId)
            ->where('due_amount', 0);
    }
}
