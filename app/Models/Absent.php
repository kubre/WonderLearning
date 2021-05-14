<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absent extends Model
{

    public $fillable = [
        'absent_id',
        'division_attendance_id',
    ];

    public $timestamps = false;

    public $incrementing = false;
}
