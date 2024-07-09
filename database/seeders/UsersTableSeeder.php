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
                'role_id' => $adminRole->id,
            ],
            [
                'name' => 'Jane Doe',
                'num_member' => 2,
                'username' => 'Janedoe@123',
                'password' => Hash::make('Password#321'),
                'role_id' => $memberRole->id,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
