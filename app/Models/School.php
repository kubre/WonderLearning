<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;


class School extends Model
{
    use AsSource;
    use HasFactory;
    use Filterable;


    public const PROGRAMMES = [
        'Playgroup' => 'Playgroup',
        'Nursery' => 'Nursery',
        'Junior KG' => 'Junior KG',
        'Senior KG' => 'Senior KG',
    ];


    /** @var array */
    protected $fillable = [
        'name', 'logo', 'contact', 'code', 'academic_year', 'academic_year_start', 'academic_year_end', 'email', 'address', 'login_url', 'suspended_at',
    ];

    protected $casts = [
        'suspended_at' => 'datetime',
    ];


    public array $allowedFilters = [
        'name', 'code',
    ];


    public array $allowedSorts = [
        'name',
    ];


    // Attributes
    public function getStartMonthAttribute(): int
    {
        return (int) substr($this->academic_year, 3, 2);
    }


    public function getAcademicYearAttribute($value): string
    {
        if (is_null($value) || strlen($value) != 11) return '01-06|31-05';
        return $value;
    }


    public function getAcademicYearStartAttribute(): string
    {
        return explode('|', $this->academic_year)[0];
    }


    public function getAcademicYearEndAttribute(): string
    {
        return explode('|', $this->academic_year)[1];
    }


    public function setAcademicYearStartAttribute(string $value): void
    {
        $this->academic_year = substr_replace($this->academic_year, $value, 0, 5);
    }


    public function setAcademicYearEndAttribute(string $value): void
    {
        $this->academic_year = substr_replace($this->academic_year, $value, -5);
    }

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

    public function kitStock(): HasOne
    {
        return $this->hasOne(KitStock::class);
    }

    public function syllabi(): BelongsToMany
    {
        return $this->belongsToMany(Syllabus::class)
            ->withPivot('id', 'completed_at');
    }
}
