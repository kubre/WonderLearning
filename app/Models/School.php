<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Orchid\Screen\AsSource;

/** @property Collection $students */
/** @property Collection $enquiries */
class School extends Model
{
    use AsSource, HasFactory;

    /** @var array */
    protected $fillable = [
        'name', 'logo', 'contact', 'email', 'address', 'login_url',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
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
