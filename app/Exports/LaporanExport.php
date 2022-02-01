<?php

namespace App\Exports;

use App\Models\Laporan;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanExport implements FromCollection, WithHeadings
{

    protected $pasar, $tanggal;
    function __construct($pasar, $tanggal)
    {
        $this->pasar = $pasar;
        $this->tanggal  = $tanggal;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $coba = DB::select("SELECT IF(info_harga.created_at IS NOT NULL, info_harga.harga ,'false') AS harga FROM info_harga WHERE DATE(info_harga.created_at) = DATE_SUB('" . $this->tanggal . "', INTERVAL 1 DAY)");
        $hasil =  isset($coba[0]) ?  $coba[0]->harga : 0;
        $info = DB::table('info_harga')->join('jenis_pasar', 'info_harga.id_jenis_pasar', '=', 'jenis_pasar.id_jenis_pasar')->join('kategori', 'info_harga.id_kategori', '=', 'kategori.id_kategori')->join('komoditas', 'kategori.id_komoditas', '=', 'komoditas.id_komoditas')->select('info_harga.id_info', 'info_harga.harga', 'jenis_pasar.nama_jenis_pasar', 'kategori.nama_kategori', 'kategori.satuan', 'kategori.harga_normal', 'komoditas.nama_komoditas', DB::raw('ABS(info_harga.harga - ' .  $hasil . ') AS selisih'),  DB::raw('' . $hasil . ' AS sebelum'))->where('jenis_pasar.id_jenis_pasar', '=', $this->pasar)->where(DB::raw('DATE(info_harga.created_at)'), '=', $this->tanggal)->get();
        return  $info;
        // return Laporan::all();
    }

    public function headings(): array
    {
        return ['NO', 'Komoditi', 'Kategori', 'Stn', 'Harga Kemarin', 'Harga Hari ini', 'Rata-rata', 'Perubahan Harga', 'Harga Normal'];
    }
}
