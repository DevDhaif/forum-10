<?php

use App\Models\Channel;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

function create($class, $attributes = [] , $times =null)
{
    return $class::factory($times)->create($attributes);
}

function make($class, $attributes = [] , $times =null)
{
    return $class::factory($times)->make($attributes);
}
