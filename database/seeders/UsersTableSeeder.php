<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Role;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $adminRole = Role::where('name', 'Administrator')->first();
        $memberRole = Role::where('name', 'Member')->first();

        $users = [
            [
                'name' => 'John Doe',
                'num_member' => 1,
                'username' => 'Johndoe@123',
                'password' => Hash::make('Password#321'),
                'status_active' => false,
                'role_id' => $adminRole->id,
            ],
            [
                'name' => 'Jane Doe',
                'num_member' => 2,
                'username' => 'Janedoe@123',
                'password' => Hash::make('Password#321'),
                'status_active' => true,
                'role_id' => $memberRole->id,
            ],
            [
                'name' => 'Admin Kodija',
                'num_member' => 0,
                'username' => 'Admin@666',
                'password' => Hash::make('Admin#123'),
                'status_active' => true,
                'role_id' => $adminRole->id,
            ],
        ];

        foreach ($users as $userData) {
            $user = User::where('username', $userData['username'])->first();

            if (!$user) {
                User::create($userData);
            }
        }
    }
}
