<?php

namespace App\Models;

use App\Models\Scopes\AcademicYearScope;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'user_id', 'student_id', 'body'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function (Message $message) {
            $message->created_at = \working_year()[0];
        });
    }

    protected static function booted()
    {
        static::addGlobalScope(new AcademicYearScope());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
