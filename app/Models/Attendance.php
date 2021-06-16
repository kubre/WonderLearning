<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{

    public $fillable = [
        'admission_id',
        'division_attendance_id',
        'is_present',
    ];

    public function getStatusAttribute()
    {
        return $this->attributes['is_present'] ? "P" : "A";
    }

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }

    public function divisionAttendance()
    {
        return $this->belongsTo(DivisionAttendance::class);
    }

    public $timestamps = false;

    public $incrementing = false;
}
