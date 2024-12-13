<?php
namespace App\Exports;
use App\Models\Tabungan;
use App\Models\Transaksi;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TransaksiExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $users;
    protected $tahun;

    public function __construct($users, $tahun)
    {
        $this->users = $users instanceof \Illuminate\Database\Eloquent\Builder
            ? $users
            : Transaksi::query()->with('user')->get()->groupBy('user_id');
        $this->tahun = $tahun;
    }

    public function collection()
    {
        return $this->users->map(function ($transactions) {
            $user = $transactions->first()->user;
            $tabungan = Tabungan::where('user_id', $user->id)->first();

            // Initialize monthly totals
            $monthlyTotals = array_fill(1, 12, '-');

            // Aggregate totals for the specified year
            foreach ($transactions as $transaction) {
                $date = Carbon::parse($transaction->date_transaction);
                if ($date->year == $this->tahun) {
                    $month = $date->format('n');

                    if ($monthlyTotals[$month] === '-') {
                        $monthlyTotals[$month] = 0;
                    }
                    $monthlyTotals[$month] += $transaction->nominal;
                }
            }

            // Replace zero values with '-'
            foreach ($monthlyTotals as $key => $value) {
                $monthlyTotals[$key] = $value === 0 ? '-' : $value;
            }

            // Calculate total savings for the year
            $simpananWajibTahunIni = 0;
            for ($i = 1; $i <= 12; $i++) {
                if ($monthlyTotals[$i] === '-') {
                    $monthlyTotals[$i] = 0;
                }
                $simpananWajibTahunIni += $monthlyTotals[$i];
            }

            $formatTabungan = function ($value) {
                return $value === null ? '-' : ($value === 0 ? '0' : $value);
            };

            $previousYear = $this->tahun - 1;
            $totalSimpananWajib = Tabungan::where('user_id', $user->id)
                ->where('tabungan_tahun', $previousYear)
                ->sum('simp_wajib');
                
            $simpananPokok = $user->savings->first()->simp_pokok;
            $simpananSukarela = $user->savings->first()->simp_sukarela;

            return [
                'No Anggota' => $user->num_member,
                'Nama User' => $user->name,
                'Simpanan Pokok' => $simpananPokok,
                'Simpanan Sukarela' => $simpananSukarela,
                'Simpanan Wajib sampai Desember '.($this->tahun-1) => $totalSimpananWajib,
                'Jan' => $monthlyTotals[1],
                'Feb' => $monthlyTotals[2],
                'Mar' => $monthlyTotals[3],
                'Apr' => $monthlyTotals[4],
                'May' => $monthlyTotals[5],
                'Jun' => $monthlyTotals[6],
                'Jul' => $monthlyTotals[7],
                'Aug' => $monthlyTotals[8],
                'Sep' => $monthlyTotals[9],
                'Oct' => $monthlyTotals[10],
                'Nov' => $monthlyTotals[11],
                'Dec' => $monthlyTotals[12],
                'Simpanan Wajib Januari sampai Desember '.$this->tahun => $simpananWajibTahunIni,
                'Simpanan Wajib sampai Desember '.$this->tahun => $totalSimpananWajib + $simpananWajibTahunIni,
                'Setelah dikuranngi 20%' => ($totalSimpananWajib + $simpananWajibTahunIni) * 0.8,
                'Jumlah Simpanan '.$this->tahun => $simpananPokok + $simpananSukarela + ($totalSimpananWajib + $simpananWajibTahunIni) * 0.8
            ];
        });
    }

    public function headings(): array
    {
        // Get the first item from the collection and extract keys from it
        $firstRow = $this->collection()->first();
        
        // If the first row is null, return empty array or default headings
        if (!$firstRow) {
            return [
                'No Anggota',
                'Nama User',
                'Simpanan Pokok',
                'Simpanan Sukarela',
                'Simpanan Wajib Tahun Lalu',
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
                'Simpanan Wajib Januari sampai Desember Tahun Ini',
                'Simpanan Wajib sampai Desember Tahun Ini',
                'Setelah dikuranngi 20%',
                'Jumlah Simpanan Tahun Ini'
            ];
        }
        return array_keys($firstRow);
    }

}
