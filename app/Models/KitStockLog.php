<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class KitStockLog extends Model
{
    use AsSource;

    public $incrementing = false;

    public $timestamps = false;

    public $fillable = [
        'kit_stock_id', 'program', 'quantity', 'added_at',
    ];

    public $casts = [
        'quantity' => 'integer',
        'added_at' => 'date',
    ];

    public function getAddedAtAttribute($value)
    {
        return Carbon::createFromTimeString($value)->format('d-M-Y h:i A');
    }
}
