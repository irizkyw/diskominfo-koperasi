<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nama_event', 'deskripsi_event', 'tanggal_event'
    ];

    public $casts = [
        'tanggal_event' => 'date'
    ];

}
