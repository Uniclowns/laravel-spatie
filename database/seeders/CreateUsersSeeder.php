<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class CreateUsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@email.com',
                'password' => bcrypt('123456'),
                'type' => 1,
            ],
            [
                'name' => 'Manager',
                'email' => 'manager@email.com',
                'password' => bcrypt('123456'),
                'type' => 2,
            ],
            [
                'name' => 'User',
                'email' => 'user@email.com',
                'password' => bcrypt('123456'),
            ],
        ];

        foreach ($users as $user)
        {
            User::create($user);
        }
    }
}
