<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';
    protected $primaryKey = 'id_laporan';
    protected $fillable = [
        'id_jenis_pasar',
        'tanggal',
        'id_informasi_harga_pasar',
    ];

    /**
     * Get the pasar t owns the Laporan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pasar()
    {
        return $this->belongsTo(JenisPasar::class, 'id_jenis_pasar');
    }

    public function informasi()
    {
        return $this->belongsTo(InformasiHargaPasar::class, 'id_informasi_harga_pasar');
    }
}
