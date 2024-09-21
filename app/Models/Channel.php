<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;

    public function getRouteKeyName()
    {
        return 'slug';
    }

    function threads()
    {
        return $this->hasMany(Thread::class);
    }
    function questions()
    {
        return $this->hasMany(Question::class);
    }
}
