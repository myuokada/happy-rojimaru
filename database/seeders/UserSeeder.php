<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'          => 'Carebears1',
            'email'         => 'Carebears1@gmail.com',
            'password'      => Hash::make('Carebears1'),
            'role_id'       => 1
        ]);
        User::create([
            'name'          => 'Carebears2',
            'email'         => 'Carebears2@gmail.com',
            'password'      => Hash::make('Carebears2'),
            'role_id'       => 2
        ]);
        User::create([
            'name'          => 'Carebears3',
            'email'         => 'Carebears3@gmail.com',
            'password'      => Hash::make('Carebears3'),
            'role_id'       => 2
        ]);
        User::create([
            'name'          => 'Carebears4',
            'email'         => 'Carebears4@gmail.com',
            'password'      => Hash::make('Carebears4'),
            'role_id'       => 2
        ]);
        User::create([
            'name'          => 'Carebears5',
            'email'         => 'Carebears5@gmail.com',
            'password'      => Hash::make('Carebears5'),
            'role_id'       => 2
        ]);
    }
}
