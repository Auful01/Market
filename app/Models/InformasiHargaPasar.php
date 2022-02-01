<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiHargaPasar extends Model
{
    use HasFactory;

    protected $table = 'informasi_harga_pasar';
    protected $primaryKey = 'id_informasi_harga_pasar';
    protected $fillable = [
        'komoditi',
        'rata_rata_kemarin',
        'pasar_baru',
        'rata_rata',
        'perubahan_harga',
        'harga_normal',
    ];
}
