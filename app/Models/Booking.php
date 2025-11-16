<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nomer_hp', 
        'tanggal_booking',
        'jam_mulai',
        'jam_akhir'
    ];
}