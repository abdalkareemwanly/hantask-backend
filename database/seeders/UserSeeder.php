<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'seller',
                'email' => 'seller@gmail.com',
                'username' => 'seller',
                'password' => Hash::make('123456'),
                'user_status' => 1,
                'user_type' => 0
            ],
            [
                'name' => 'seller1',
                'email' => 'seller1@gmail.com',
                'username' => 'seller1',
                'password' => Hash::make('123456'),
                'user_status' => 1,
                'user_type' => 0
            ],
            [
                'name' => 'seller2',
                'email' => 'seller2@gmail.com',
                'username' => 'seller2',
                'password' => Hash::make('123456'),
                'user_type' => 0,
                'user_status' => 1,
            ],
            [
                'name' => 'buyer',
                'email' => 'buyer@gmail.com',
                'username' => 'buyer',
                'password' => Hash::make('123456'),
                'user_status' => 1,
                'user_type' => 1
            ],
            [
                'name' => 'buyer1',
                'email' => 'buyer1@gmail.com',
                'username' => 'buyer1',
                'password' => Hash::make('123456'),
                'user_status' => 1,
                'user_type' => 1
            ],
            [
                'name' => 'buyer2',
                'email' => 'buyer2@gmail.com',
                'username' => 'buyer2',
                'password' => Hash::make('123456'),
                'user_status' => 1,
                'user_type' => 1
            ]
        ];
        foreach($users as $user) {
            User::create($user);
        }
    }
}
