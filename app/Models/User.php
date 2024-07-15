<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Transaksi;
use App\Models\Tabungan;
use App\Models\Golongan;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'num_member',
        'username',
        'password',
        'role_id', 'status_active'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function savings()
    {
        return $this->hasMany(Tabungan::class, 'user_id');
    }
}
