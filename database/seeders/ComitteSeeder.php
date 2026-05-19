<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class ComitteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $comitte1 = User::create([
    'name'     => 'Panitia 1',
    'email'    => 'panitia1@gmail.com',
    'password' => bcrypt('password'),
]);
$comitte1->assignRole('comitte');

$comitte2 = User::create([
    'name'     => 'Panitia 2',
    'email'    => 'panitia2@gmail.com',
    'password' => bcrypt('password'),
]);
$comitte2->assignRole('comitte');

$comitte3 = User::create([
    'name'     => 'Panitia 3',
    'email'    => 'panitia3@gmail.com',
    'password' => bcrypt('password'),
]);
$comitte3->assignRole('comitte');

$comitte4 = User::create([
    'name'     => 'Panitia 4',
    'email'    => 'panitia4@gmail.com',
    'password' => bcrypt('password'),
]);
$comitte4->assignRole('comitte');
    }
}
