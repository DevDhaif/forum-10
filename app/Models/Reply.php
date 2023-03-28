<?php

namespace App\Models;

use App\Favoritable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;
    use Favoritable;
    protected $guarded = [];

    protected $with = ['owner', 'favorites'];
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function channel(){
        return $this->belongsTo(Channel::class);
    }
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }
    


    
}
