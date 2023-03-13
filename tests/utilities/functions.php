<?php

use App\Models\Channel;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

function create($class, $attributes = [])
{
    return $class::factory()->create($attributes);
}

function make($class, $attributes = [])
{
    return $class::factory()->make($attributes);
}
