<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Transaksi;
use App\Models\Golongan;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'Administrator', 'desc' => 'Administrator'],
            ['name' => 'Member', 'desc' => 'Member'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

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

        $transactions = [
            [
                'id' => 1,
                'user_id' => 2,
                'transaction_type' => 'SIMPANAN-BULANAN',
                'description' => 'Januari',
                'date_transaction' => '2024-01-17',
                'nominal' => 100000,
                'created_at' => '2024-07-31 23:31:03',
                'updated_at' => '2024-07-23 23:31:03',
            ],
            [
                'id' => 2,
                'user_id' => 2,
                'transaction_type' => 'SIMPANAN-BULANAN',
                'description' => 'Februari',
                'date_transaction' => '2024-02-15',
                'nominal' => 100000,
            ],
            [
                'id' => 3,
                'user_id' => 2,
                'transaction_type' => 'SIMPANAN-BULANAN',
                'description' => 'Maret',
                'date_transaction' => '2024-03-14',
                'nominal' => 100000,
            ],
            [
                'id' => 4,
                'user_id' => 2,
                'transaction_type' => 'SIMPANAN-BULANAN',
                'description' => 'April',
                'date_transaction' => '2024-04-18',
                'nominal' => 100000,
            ],
            [
                'id' => 5,
                'user_id' => 2,
                'transaction_type' => 'SIMPANAN-BULANAN',
                'description' => 'Mei',
                'date_transaction' => '2024-05-15',
                'nominal' => 100000,
            ],
            [
                'id' => 6,
                'user_id' => 2,
                'transaction_type' => 'SIMPANAN-BULANAN',
                'description' => 'Juni',
                'date_transaction' => '2024-06-04',
                'nominal' => 100000,
            ],
            [
                'id' => 7,
                'user_id' => 2,
                'transaction_type' => 'SIMPANAN-BULANAN',
                'description' => 'Juli',
                'date_transaction' => '2024-07-10',
                'nominal' => 100000,
            ],
            [
                'id' => 8,
                'user_id' => 2,
                'transaction_type' => 'SIMPANAN-BULANAN',
                'description' => 'Agustus',
                'date_transaction' => '2024-08-07',
                'nominal' => 100000,
            ],
            [
                'id' => 9,
                'user_id' => 2,
                'transaction_type' => 'SIMPANAN-BULANAN',
                'description' => 'September',
                'date_transaction' => '2024-09-11',
                'nominal' => 100000,
            ],
            [
                'id' => 10,
                'user_id' => 2,
                'transaction_type' => 'SIMPANAN-BULANAN',
                'description' => 'Oktober',
                'date_transaction' => '2024-10-09',
                'nominal' => 100000,
            ],
            [
                'id' => 11,
                'user_id' => 2,
                'transaction_type' => 'SIMPANAN-BULANAN',
                'description' => 'November',
                'date_transaction' => '2024-11-08',
                'nominal' => 100000,
            ],
            [
                'id' => 12,
                'user_id' => 2,
                'transaction_type' => 'SIMPANAN-BULANAN',
                'description' => 'Desember',
                'date_transaction' => '2024-12-10',
                'nominal' => 100000,
            ],
        ];


        foreach ($transactions as $transaction) {
            Transaksi::create($transaction);
        }

        $golongans = [
            [
                'nama_golongan' => 'PNS',
                'desc' => 'PNS',
                'simp_pokok' => 150000,
            ],
            [
                'nama_golongan' => 'Non-PNS',
                'desc' => 'Non-PNS',
                'simp_pokok' => 100000,
            ],
            [
                'nama_golongan' => 'Pensiunan',
                'desc' => 'Pensiunan',
                'simp_pokok' => 50000,
            ],
        ];

        foreach ($golongans as $golongan) {
            Golongan::create($golongan);
        }
    }
}
