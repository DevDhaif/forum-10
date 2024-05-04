<?php

namespace App\Filters;

use App\Models\User;
use Illuminate\Http\Request;

class QuestionFilters extends Filters
{
    protected $filters = ['by', 'popular'];
    protected function by($username)
    {
        $user =  User::where('name', $username)->firstOrFail();
        return $this->builder->where('user_id', $user->id);
    }
    protected function popular()
    {
        $this->builder->getQuery()->orders  = [];
        return $this->builder->orderBy('answers_count', 'desc');
    }
}
