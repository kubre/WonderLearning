<?php

namespace App\Models;

use App\Models\Scopes\AcademicYearScope;
use App\Models\Scopes\AdmissionYearScope;
use App\Models\Scopes\SchoolScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Receipt extends Model
{
    use AsSource, Filterable;

    protected $fillable = [
        'receipt_no',
        'receipt_at',
        'amount',
        'for',
        'payment_mode',
        'bank_name',
        'bank_branch',
        'transaction_no',
        'paid_at',
        'school_id',
        'admission_id',
        'created_at',
    ];


    public $allowedFilters = [
        'receipt_id',
    ];

    protected $casts = [
        'amount' => 'integer',
        'receipt_at' => 'date:Y-m-d',
        'paid_at' => 'date:Y-m-d',
    ];

    public const PAYMENT_MODES = [
        'c' => 'Cash',
        'o' => 'Online Payment',
        'b' => 'Cheque',
    ];

    public const SCHOOL_FEES = 'School Fees';

    protected static function booted()
    {
        static::addGlobalScope(new AcademicYearScope);
        static::addGlobalScope(new SchoolScope);
    }


    public function getModeAttribute()
    {
        return static::PAYMENT_MODES[$this->payment_mode];
    }

    public function admission(): BelongsTo
    {
        return $this->belongsTo(Admission::class);
    }


    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}
