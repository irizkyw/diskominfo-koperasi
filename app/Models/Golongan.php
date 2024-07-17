<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tabungan;

class Golongan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_golongan', 'desc', 'simp_pokok'
    ];

    public function tabungan()
    {
        return $this->hasMany(Tabungan::class, 'golongan_id');
    }
}
