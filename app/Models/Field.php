<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'university_id'];

    public function university()
    {
        return $this->belongsTo(University::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
