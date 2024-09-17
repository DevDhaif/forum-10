<?php

namespace App\Models;

use App\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;
    use RecordsActivity;
    protected $guarded = [];

    protected static function booted()
    {
        static::deleted(function ($vote) {
            $vote->activity()->delete();
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function voted()
    {
        return $this->morphTo();
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }
}
