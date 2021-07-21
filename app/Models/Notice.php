<?php

namespace App\Models;

use App\Models\Scopes\AcademicYearScope;
use App\Models\Scopes\SchoolScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Notice extends Model
{
    use AsSource;
    use Filterable;
    use Attachable;

    protected $fillable = ['title', 'body', 'user_id', 'division_id'];

    protected $casts = [
        'date_at' => 'datetime:d-M-Y',
    ];

    protected $allowedFilters = [
        'title', 'user_id',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function (Notice $notice) {
            $notice->user_id = auth()->id();
            $notice->school_id = auth()->user()->school_id;
            $notice->date_at = now();
            $notice->created_at = \working_year()[0];
        });
    }

    protected static function booted()
    {
        static::addGlobalScope(new AcademicYearScope());
        static::addGlobalScope(new SchoolScope());
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
