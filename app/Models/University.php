<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    protected $withCount = ['fields', 'users'];
    public function fields()
    {
        return $this->hasMany(Field::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
