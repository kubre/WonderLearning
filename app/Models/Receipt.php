<?php

namespace App\Models;

use App\Models\Scopes\AcademicYearScope;
use App\Models\Scopes\AdmissionYearScope;
use App\Models\Scopes\SchoolScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Screen\AsSource;

class Receipt extends Model
{
    use AsSource;

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
        return $this->belongsTo(Student::class);
    }


    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}
