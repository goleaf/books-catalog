<?php

namespace Database\Seeders\demo;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;


class UserSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@bookcatalog.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // Create regular users
        $faker = Faker::create();
        $users = [];
        for ($i = 0; $i < 5; $i++) {
            $users[] = [
                'name' => $faker->name,
                'email' => $faker->unique()->userName . '@bookcatalog.com',
            ];
        }

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make('password'),
                'is_admin' => false,
            ]);
        }
    }
}
