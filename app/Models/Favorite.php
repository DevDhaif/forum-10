<?php

namespace App\Models;

use App\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;
    use RecordsActivity;
    protected $guarded = [];

    public function favorited(){
        return $this->morphTo();
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }
}
