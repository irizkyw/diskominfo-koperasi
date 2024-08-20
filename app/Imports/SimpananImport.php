<?php
namespace App\Imports;

use App\Models\Tabungan;
use App\Models\User;
use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class SimpananImport implements ToModel, WithHeadingRow
{
    private $year;
    private $months;

    public function __construct($year)
    {
        $this->year = $year;
        $this->months = ['jan', 'feb', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'sept', 'okt', 'nov', 'des'];
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $user = User::where('num_member', $row['no_angg'])->first();

        if (!$user) {
            $username = $this->generateUniqueUsername($row['nama'], $row['no_angg']);
            $user = User::create([
                'name' => $row['nama'],
                'num_member' => $row['no_angg'],
                'username' => $username,
                'password' => Hash::make($username),
                'role_id' => 2,
                'status_active' => true,
            ]);
        }

        $tabungan = Tabungan::create([
            'user_id' => $user->id,
            'simp_pokok' => $row['simpanan_pokok'],
            'simp_sukarela' => $row['simpanan_sukarela'],
            'simp_wajib' => $row['simpanan_wajib_s_d_desember_' . ($this->year - 1)],
            'golongan_id' => 1,
        ]);

        foreach ($this->months as $month) {
            $columnName = $month . '_rp';
            if (!empty($row[$columnName])) {
                Transaksi::create([
                    'user_id' => $user->id,
                    'transaction_type' => 'Simpanan Wajib',
                    'desc' => "Import data for $month.",
                    'nominal' => $row[$columnName],
                    'date_transaction' => Carbon::parse("$month 1, $this->year")->format('Y-m-d'),
                ]);
            }
        }

        $totalColumn = 'simpanan_wajib_s_d_desember_' . $this->year;
        if (!empty($row[$totalColumn])) {
            Transaksi::create([
                'user_id' => $user->id,
                'transaction_type' => 'Simpanan Wajib',
                'desc' => "Import data for Simpanan Wajib s/d Desember $this->year.",
                'nominal' => $row[$totalColumn],
                'date_transaction' => Carbon::now()->format('Y-m-d'),
            ]);
        }

        return $tabungan;
    }

    private function generateUniqueUsername($name, $num_member)
    {
        do {
            $words = explode(' ', $name);
            $firstName = strtolower($words[0]);
            $username = $firstName . str_pad($num_member, 3, '0', STR_PAD_LEFT);
            $userExists = User::where('username', $username)->exists();
        } while ($userExists);

        return $username;
    }
}

