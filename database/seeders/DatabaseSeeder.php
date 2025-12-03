<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password'=> bcrypt('12345678'),
            'role'=>'admin'
        ]);
        User::create([
            'name' => 'Staff',
            'email' => 'staff@gmail.com',
            'password'=> bcrypt('12345678'),
            'role'=>'staff'
        ]);
        User::create([
            'name' => 'Fadhilah',
            'email' => 'fadhilah@gmail.com',
            'password'=> bcrypt('12345678'),
            'role'=>'pengunjung'
        ]);
    }
}
