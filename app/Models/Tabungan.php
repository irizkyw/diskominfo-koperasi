<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Golongan;

class Tabungan extends Model
{
    use HasFactory;

    protected $table = 'tabungan';
    protected $fillable = ['user_id','simp_pokok','simp_sukarela','simp_wajib','tabungan_tahun'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
