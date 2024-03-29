<?php

namespace App\Models;

use App\Models\Scopes\AcademicYearScope;
use App\Models\Scopes\SchoolScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
use Illuminate\Support\Str;

class Admission extends Model
{
    use AsSource;
    use Filterable;
    use HasFactory;
    use SoftDeletes;

    protected ?int $c_invoice_fees = null;

    /** @var array */
    protected $fillable = [
        'admission_at',
        'program',
        'discount',
        'batch',
        'is_transportation_required',
        'student_id',
        'school_id',
        'division_id',
        'created_at',
    ];

    /** @var array */
    protected $casts = [
        'is_transportation_required' => 'boolean',
        'discount' => 'integer',
        'admission_at' => 'datetime',
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

    protected static function boot()
    {
        parent::boot();
        static::creating(function (Admission $admission) {
            $admission->school_id = auth()->user()->school_id;
            $admission->created_at = $admission->created_at ?? \working_year()[0];
        });
    }

    protected static function booted()
    {
        static::addGlobalScope(new AcademicYearScope());
        static::addGlobalScope(new SchoolScope());
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
        return $this->invoice_fees - ($this->discount ?: 0);
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

    public function getSearchTitleAttribute()
    {
        return $this->student->search_title;
    }

    public function getInvoiceFeesAttribute()
    {
        if (is_null($this->c_invoice_fees)) {
            $this->c_invoice_fees = optional($this->hasOne(Fees::class, 'school_id', 'school_id')
                ->withoutGlobalScopes()
                ->whereBetween('created_at', get_academic_year($this->created_at))
                ->first())
                ->{$this->fees_total_column};
        }
        return $this->c_invoice_fees;
    }

    // Relations

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    public function receipts(): HasMany
    {
        return $this->hasMany(Receipt::class);
    }

    public function installments(): HasMany
    {
        return $this->hasMany(Installment::class);
    }

    public function unpaid_installments(): HasMany
    {
        return $this->hasMany(Installment::class)->where('due_amount', '>', 0);
    }

    public function school_fees_receipts(): HasMany
    {
        return $this->hasMany(Receipt::class)
            ->where('receipts.for', Receipt::SCHOOL_FEES);
    }

    public function general_receipts(): HasMany
    {
        return $this->hasMany(Receipt::class)
            ->where('receipts.for', '!=', Receipt::SCHOOL_FEES);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(PerformanceReport::class);
    }
}
