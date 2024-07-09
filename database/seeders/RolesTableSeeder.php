<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['name' => 'Administrator', 'desc' => 'Administrator'],
            ['name' => 'Member', 'desc' => 'Member'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
