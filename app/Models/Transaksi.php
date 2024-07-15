<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = ['user_id', 'transaction_type', 'description', 'date_transaction', 'nominal'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
