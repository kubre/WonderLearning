<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Screen\AsSource;

class School extends Model
{
    use AsSource, Attachable;

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'logo', 'contact', 'email', 'address', 'login_url', 'owner_id', 
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id', 'users');
    }
}
