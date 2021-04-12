<?php

namespace App\Models;

use App\Models\Scopes\AcademicYearScope;
use App\Models\Scopes\SchoolScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
use Illuminate\Support\Str;

/** @property School $school */
/** @property Student $student */
/** @property Carbon $created_at */
/** @property Carbon $updated_at */
/** @property Carbon $admission_at */
class Admission extends Model
{
    use AsSource, Filterable, HasFactory;

    /** @var array */
    protected $fillable = [
        'admission_at',
        'program',
        'fees_installments',
        'discount',
        'batch',
        'is_transportation_required',
        'student_id',
        'school_id',
        'created_at',
    ];

    /** @var array */
    protected $casts = [
        'is_transportation_required' => 'boolean',
        'fees_installments' => 'integer',
        'discount' => 'integer',
        'admission_at' => 'date:Y-m-d',
    ];

    protected $allowedFilters = [
        'admission_at',
        'parent_name',
        'parent_contact',
        'program',
        'fees_installments',
        'batch',
    ];

    protected $allowedSorts = [
        'admission_at',
        'student_id',
        'parent_name',
        'parent_contact',
        'program',
        'fees_installments',
        'batch',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new AcademicYearScope);
        static::addGlobalScope(new SchoolScope);
    }

    public function getFeesColumnAttribute(): string
    {
        return Str::of($this->program)->lower()->snake();
    }

    public function getFeesTotalColumnAttribute(): string
    {
        return $this->fees_column . '_total';
    }

    public function getInvoiceNoAttribute(): string
    {
        return 'A' . Str::of($this->program)->limit(1, '')->upper()
            . '/' . Str::of($this->school_id)->limit(4, '')->padLeft(4, '0')
            . '/' . Str::of($this->student_id)->limit(4, '')->padLeft(4, '0');
    }

    public function getPrnAttribute()
    {
        return $this->student->prn;
    }

    public function getTotalFeesAttribute()
    {
        return $this->school->fees->{$this->fees_total_column} - $this->discount;
    }


    public function getPaidFeesAttribute()
    {
        return $this->receipts
            ->where('for', 'School Fees')
            ->sum('amount');
    }

    public function getBalanceAmountAttribute()
    {
        return $this->total_fees - $this->paid_fees;
    }


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

    public function receipts(): HasMany
    {
        return $this->hasMany(Receipt::class);
    }

    public function school_fees_receipts(): HasMany
    {
        return $this->hasMany(Receipt::class)->where('receipts.for', Receipt::SCHOOL_FEES);
    }
}
