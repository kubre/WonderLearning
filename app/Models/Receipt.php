<?php

namespace App\Models;

use App\Models\Scopes\AcademicYearScope;
use App\Models\Scopes\SchoolScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Receipt extends Model
{
    use AsSource, Filterable, SoftDeletes;

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
        'paid_at',
        'receipt_at',
    ];

    protected $casts = [
        'amount' => 'integer',
        'receipt_at' => 'date:Y-m-d',
        'paid_at' => 'date:Y-m-d',
    ];

    public const MODE_ONLINE_PAYMENTS = 'o';

    public const MODE_BANK = 'b';

    public const MODE_CASH = 'c';

    public const PAYMENT_MODES = [
        self::MODE_CASH => 'Cash',
        self::MODE_ONLINE_PAYMENTS => 'Online Payment',
        self::MODE_BANK => 'Cheque',
    ];

    public const SCHOOL_FEES = 'School Fees';

    protected static function booted()
    {
        static::addGlobalScope(new AcademicYearScope);
        static::addGlobalScope(new SchoolScope);
    }

    public function getReceiptNoAttribute($value)
    {
        return str_pad($value, 6, '0', STR_PAD_LEFT);
    }

    public function getModeAttribute(): string
    {
        return static::PAYMENT_MODES[$this->payment_mode];
    }

    public function admission(): BelongsTo
    {
        return $this->belongsTo(Admission::class)
            ->withoutGlobalScopes();
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function approval()
    {
        return $this->morphOne(Approval::class, 'approval');
    }

    public function runWhenApproved()
    {
        $this->delete();
    }
}
