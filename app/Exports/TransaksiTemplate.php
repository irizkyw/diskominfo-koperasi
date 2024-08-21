<?php
namespace App\Exports;

use App\Models\User;
use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TransaksiTemplate implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $tahun;

    public function __construct($tahun)
    {
        $this->tahun = $tahun;
    }

    public function collection()
    {
        // Fetch all users
        $users = User::where('role_id', 2)->get();

        return $users->map(function ($user) {
            $previousYear = $this->tahun - 1;
            $totalSimpananWajib = Transaksi::where('user_id', $user->id)
                ->whereYear('date_transaction', $previousYear)
                ->sum('nominal');
                
            return [
                'No Anggota' => $user->num_member,
                'Nama User' => $user->name,
                'Simpanan Pokok' => $user->golongan->simp_pokok,
                'Simpanan Sukarela' => $user->golongan->simp_sukarela,
                'Simpanan Wajib sampai Desember ' . ($this->tahun - 1) => $totalSimpananWajib,
                'Jan' => null,
                'Feb' => null,
                'Mar' => null,
                'Apr' => null,
                'May' => null,
                'Jun' => null,
                'Jul' => null,
                'Aug' => null,
                'Sep' => null,
                'Oct' => null,
                'Nov' => null,
                'Dec' => null,
                'Simpanan Wajib Januari sampai Desember ' . $this->tahun => null,
                'Simpanan Wajib sampai Desember ' . $this->tahun => null,
                'Setelah dikurangi 20%' => null,
                'Jumlah Simpanan ' . $this->tahun => null,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No Anggota',
            'Nama User',
            'Simpanan Pokok',
            'Simpanan Sukarela',
            'Simpanan Wajib sampai Desember ' . ($this->tahun - 1),
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec',
            'Simpanan Wajib Januari sampai Desember ' . $this->tahun,
            'Simpanan Wajib sampai Desember ' . $this->tahun,
            'Setelah dikurangi 20%',
            'Jumlah Simpanan ' . $this->tahun
        ];
    }
}
