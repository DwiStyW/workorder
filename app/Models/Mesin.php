<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesin extends Model
{
    use HasFactory;
    protected $fillable=[
        'no_mesin',
        'nama_mesin',
        'id_kategori',
        'level',
        'update_by',
    ];
}