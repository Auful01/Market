<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPasar extends Model
{
    use HasFactory;

    protected $table = 'jenis_pasar';
    protected $primaryKey = 'id_jenis_pasar';
    protected $fillable = [
        'nama_jenis_pasar',
    ];
}
