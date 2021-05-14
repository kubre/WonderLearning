<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Screen\AsSource;

class DivisionAttendance extends Model
{
    use AsSource;

    public $fillable = [
        'division_id',
        'date_at',
    ];

    public $casts = [
        'date_at' => 'date',
    ];

    public $timestamps = false;

    public function getDateAtAttribute($value)
    {
        return (new Carbon($value))->format('d-M-Y');
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    public function absents(): HasMany
    {
        return $this->hasMany(Absent::class, 'division_attendance_id');
    }
}
