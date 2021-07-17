<?php

namespace App\Models;

use App\Models\Scopes\AcademicYearScope;
use App\Models\Scopes\SchoolScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Gallery extends Model
{
    use AsSource;
    use Filterable;
    use Attachable;

    protected $fillable = ['title', 'date_at', 'division_id'];

    protected $casts = [
        'date_at' => 'datetime:d-M-Y',
    ];

    protected $allowedFilters = [
        'title', 'date_at',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function (Gallery $gallery) {
            $gallery->school_id = auth()->user()->school_id;
            $gallery->created_at = \working_year()[0];
        });
    }

    protected static function booted()
    {
        static::addGlobalScope(new AcademicYearScope());
        static::addGlobalScope(new SchoolScope());
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }
}
