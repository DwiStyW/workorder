<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable=[
        'no_tiket',
        'tanggal',
        'pelapor',
        'divisi',
        'mesin',
        'ruang',
        'keterangan',
        'photo',
        'status',
        'update_by',
        'kepala',
        'anggota',
        'kategori_wo',
        'durasi',
    ];
}