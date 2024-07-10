<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi'; // Specify the correct table name

    protected $fillable = ['user_id', 'transaction_type', 'description', 'date_transaction', 'nominal'];
}
