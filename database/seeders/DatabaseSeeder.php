<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;


use App\Models\Field;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\University;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        // \App\Models\User::factory()->create([
        //     'name' => 'Dhaifallah',
        //     'email' => 'devdhaif@gmail.com',
        // ]);

        // Reply::factory(50)->create();

        $universities = ['Al neelain University', 'Sudan University of Science and Technology', 'University of Khartoum', 'Omdurman Islamic University', 'University of Medical Sciences and Technology', 'University of Bahri', 'University of Gezira', 'University of Kordofan', 'University of Juba'];
        foreach ($universities as $university) {
            University::insert(['name' => $university]);
        }

        $fields = ['Software Engineering', 'Computer Science', 'Information Technology', 'Computer Engineering', 'Information Systems', 'Data Science', 'Artificial Intelligence', 'Cyber Security', 'Network Engineering', 'Web Development'];
        foreach ($fields as $field) {
            Field::insert(['name' => $field]);
        }

        $allUniversities = University::all();
        $allFields = Field::all();

        User::whereNull('university_id')->orWhereNull('field_id')->each(function ($user) use ($allUniversities, $allFields) {
            $user->update([
                'university_id' => $allUniversities->random()->id,
                'field_id' => $allFields->random()->id,
            ]);
        });

    }
}
