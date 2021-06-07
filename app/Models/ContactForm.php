<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactForm extends Model
{
    public $fillable = [
        'name',
        'email',
        'contact',
        'subject',
        'message',
    ];
}
