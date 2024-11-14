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
        $user = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123456'),
                'no_hp' => '081234567890',
                'role' => 'Admin',
            ],
            [
                'name' => 'Maulana',
                'email' => 'maulana@gmail.com',
                'password' => Hash::make('123456'),
                'no_hp' => '08123456789',
                'role' => 'User',
            ],
            [
                'name' => 'Haekal',
                'email' => 'haekal@gmail.com',
                'password' => Hash::make('123456'),
                'no_hp' => '08123456788',
                'role' => 'User',
            ],
            [
                'name' => 'Noval',
                'email' => 'noval@gmail.com',
                'password' => Hash::make('123456'),
                'no_hp' => '08123456787',
                'role' => 'User',
            ],
        ];

        foreach ($user as $u) {
            User::create($u);
        }
    }
}
