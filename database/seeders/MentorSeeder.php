<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Mentor;


class MentorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mentor1 = User::create([
            'name'     => 'Mentor 1',
            'email'    => 'mentor1@gmail.com',
            'password' => bcrypt('password'),
        ]);
      

        $mentor1->assignRole('mentor');

        $mentor2 = User::create([
            'name'     => 'Mentor 2',
            'email'    => 'mentor2@gmail.com',
            'password' => bcrypt('password'),
        ]);
        $mentor2->assignRole('mentor');

        $mentor3 = User::create([
            'name'     => 'Mentor 3',
            'email'    => 'mentor3@gmail.com',
            'password' => bcrypt('password'),
        ]);
        $mentor3->assignRole('mentor');

        $mentor4 = User::create([
            'name'     => 'Mentor 4',
            'email'    => 'mentor4@gmail.com',
            'password' => bcrypt('password'),
        ]);
        $mentor4->assignRole('mentor');
    }
}
