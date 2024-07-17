<?php
namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TransaksiExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    public function collection()
    {
        return $this->transactions->map(function ($transaction) {
            return [
                'ID' => $transaction->id,
                'Nama User' => $transaction->user->name, // Akses nama user melalui relasi
                'Nomor Anggota' => $transaction->user->num_member, // Akses nomor anggota melalui relasi
                'Transaction Type' => $transaction->transaction_type,
                'Description' => $transaction->description,
                'Date Transaction' => $transaction->date_transaction,
                'Nominal' => $transaction->nominal,
                'Created At' => $transaction->created_at,
                'Updated At' => $transaction->updated_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No Transaksi',
            'Nama User',
            'Nomor Anggota',
            'Tipe Transaksi',
            'Description',
            'Date Transaction',
            'Nominal',
            'Created At',
            'Updated At',
        ];
    }
}
