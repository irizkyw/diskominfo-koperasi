<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use App\Models\Transaksi;
use App\Models\Tabungan;
use App\Models\Golongan;
use App\Models\Role;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'num_member',
        'username',
        'password',
        'role_id', 'status_active'
    ];

    protected $dates = ['deleted_at'];

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

    public static function restoreUser($num_member)
    {
        $user = static::withTrashed()->where('num_member', $num_member)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $user->restore();

        return response()->json(['message' => 'User restored successfully.']);
    }

    public function isAdmin()
    {
        $adminRoleId = Role::where('name', 'Administrator')->value('id');
        return $this->role_id === $adminRoleId;
    }


}
