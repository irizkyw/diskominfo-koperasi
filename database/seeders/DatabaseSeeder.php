<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Golongan;
use App\Models\Tabungan;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Define roles
        $roles = [
            ["name" => "Administrator", "desc" => "Administrator"],
            ["name" => "Member", "desc" => "Member"],
        ];

        // Create roles
        foreach ($roles as $role) {
            Role::firstOrCreate($role);
        }

        // Get the Administrator role
        $adminRole = Role::where("name", "Administrator")->first();

        // Define golongans
        $golongans = [
            [
                "nama_golongan" => "Golongan 1",
                "desc" => "Golongan 1",
                "simp_pokok" => 150000,
            ],
            [
                "nama_golongan" => "Golongan 2",
                "desc" => "Golongan 2",
                "simp_pokok" => 100000,
            ],
            [
                "nama_golongan" => "Golongan 3",
                "desc" => "Golongan 3",
                "simp_pokok" => 75000,
            ],
            [
                "nama_golongan" => "Non-PNS",
                "desc" => "Golongan 4",
                "simp_pokok" => 500000,
            ],
        ];

        // Create golongans
        foreach ($golongans as $golongan) {
            Golongan::firstOrCreate($golongan);
        }

        // Define admin user
        $adminUser = [
            [
                "name" => "Admin Kodija",
                "num_member" => 0,
                "username" => "Admin@666",
                "password" => Hash::make("Admin#123"),
                "status_active" => true,
                "role_id" => $adminRole->id,
                "golongan_id" => 1,
            ],
        ];

        // Create admin user
        foreach ($adminUser as $userData) {
            $user = User::firstOrCreate(
                ["username" => $userData["username"]],
                $userData
            );

            // Create tabungan for the admin user
            Tabungan::firstOrCreate(
                ["user_id" => $user->id],
                [
                    "simp_pokok" => 150000,
                    "simp_sukarela" => 0,
                    "simp_wajib" => 0,
                    "tabungan_tahun" => 0,
                ]
            );
        }
    }
}
