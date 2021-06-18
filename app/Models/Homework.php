<?php

namespace App\Models;

use App\Models\Scopes\AcademicYearScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Homework extends Model
{
    use AsSource;
    use Filterable;
    use Attachable;

    protected $fillable = [
        'title', 'body', 'date_at', 'division_id',
    ];

    protected $casts = [
        'date_at' => 'datetime:d-M-Y',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function (Homework $homework) {
            $homework->created_at = \working_year()[0];
        });
    }

    protected static function booted()
    {
        static::addGlobalScope(new AcademicYearScope());
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }
}
