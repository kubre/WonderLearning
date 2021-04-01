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
        'name',
        'program',
        'fees_installments',
        'batch',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new AcademicYearScope);
        static::addGlobalScope(new SchoolScope);
    }

    public function getFeesTotalColumnAttribute(): string
    {
        return Str::of($this->program)->lower()->snake() . '_total';
    }

    public function getInvoiceNoAttribute(): string
    {
        return 'A' . Str::of($this->program)->limit(1, '')->upper()
            . '/' . Str::of($this->school_id)->limit(4, '')->padLeft(4, '0')
            . '/' . Str::of($this->student_id)->limit(4, '')->padLeft(4, '0');
    }


    public function getTotalFeesAttribute()
    {
        return $this->school->fees->{$this->fees_total_column} - $this->discount;
    }


    public function getPaidFeesAttribute()
    {
        // TODO: Make sure to only add the fees
        return $this->receipts()->sum('amount');
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
}