<?php

namespace App\Imports;

use App\Models\Tabungan;
use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Carbon\Carbon;

class TransaksiImport implements ToModel, WithHeadingRow
{
    use Importable;

    public function model(array $row)
    {
        // Assuming 'No Anggota' is the unique identifier for users
        $user = User::where('num_member', $row['No Anggota'])->first();
        
        if ($user) {
            // Create or update Tabungan data
            $tabungan = Tabungan::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'simp_pokok' => $row['Simpanan Pokok'],
                    'simp_sukarela' => $row['Simpanan Sukarela'],
                    'simp_wajib' => $row['Simpanan Wajib s/d Desember '.($row['Tahun'] - 1)]
                ]
            );

            // Import transactions
            foreach (['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $index => $month) {
                if ($row[$month] !== '-') {
                    Transaksi::updateOrCreate(
                        [
                            'user_id' => $user->id,
                            'date_transaction' => Carbon::create($row['Tahun'], $index + 1, 1)->format('Y-m-d')
                        ],
                        [
                            'nominal' => $row[$month]
                        ]
                    );
                }
            }
        }
    }
}
