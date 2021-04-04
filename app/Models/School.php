<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Orchid\Platform\Models\Role;
use Orchid\Screen\AsSource;

/** @property Collection $students */
/** @property Collection $enquiries */
class School extends Model
{
    use AsSource, HasFactory;

    /** @var array */
    protected $fillable = [
        'name', 'logo', 'contact', 'email', 'address', 'login_url', 'center_head_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }


    public function center_head(): BelongsTo
    {
        return $this->belongsTo(User::class, 'center_head_id', 'id', 'users');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function enquiries()
    {
        return $this->hasMany(Enquiry::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function receipts(): HasMany
    {
        return $this->hasMany(Receipt::class);
    }

    public function fees(): HasOne
    {
        return $this->hasOne(Fees::class);
    }
}
