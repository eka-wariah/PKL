<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $student1 = User::create([
            'name'     => 'Student 1',
            'email'    => 'student1@gmail.com',
            'password' => bcrypt('password'),
        ]);
        $student1->assignRole('student');

        $student2 = User::create([
            'name'     => 'Student 2',
            'email'    => 'student2@gmail.com',
            'password' => bcrypt('password'),
        ]);
        $student2->assignRole('student');

        $student3 = User::create([
            'name'     => 'Student 3',
            'email'    => 'student3@gmail.com',
            'password' => bcrypt('password'),
        ]);
        $student3->assignRole('student');

        $student4 = User::create([
            'name'     => 'Student 4',
            'email'    => 'student4@gmail.com',
            'password' => bcrypt('password'),
        ]);
        $student4->assignRole('student');
    }
}
