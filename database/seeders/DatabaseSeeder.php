<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Reply;
use App\Models\Thread;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();



        \App\Models\User::factory()->create([
            'name' => 'Dhaifallah',
            'email' => 'devdhaif@gmail.com',
        ]);
        Reply::factory(50)->create();

    }
}
