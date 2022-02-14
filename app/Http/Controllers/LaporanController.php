<?php

namespace App\Http\Controllers;

use App\Exports\LaporanExport;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function loadLaporan(Request $request)
    {
        $coba = DB::select("SELECT IF(info_harga.created_at IS NOT NULL, info_harga.harga ,'false') AS harga FROM info_harga WHERE DATE(info_harga.created_at) = DATE_SUB('" . $request->tanggal . "', INTERVAL 1 DAY)");
        $hasil =  isset($coba[0]) ?  $coba[0]->harga : 0;
        $info = DB::table('info_harga')->join('jenis_pasar', 'info_harga.id_jenis_pasar', '=', 'jenis_pasar.id_jenis_pasar')->join('kategori', 'info_harga.id_kategori', '=', 'kategori.id_kategori')->join('komoditas', 'kategori.id_komoditas', '=', 'komoditas.id_komoditas')->select('info_harga.id_info', 'info_harga.harga', 'jenis_pasar.nama_jenis_pasar', 'kategori.gambar', 'kategori.nama_kategori', 'kategori.satuan', 'kategori.harga_normal', 'komoditas.nama_komoditas', DB::raw('info_harga.harga - ' .  $hasil . ' AS selisih'),  DB::raw('' . $hasil . ' AS sebelum'))->where('jenis_pasar.id_jenis_pasar', '=', $request->pasar)->where(DB::raw('DATE(info_harga.created_at)'), '=', $request->tanggal)->get();
        return $info;
    }

    public function LoadDashboard(Request $request)
    {
        // $coba = DB::select("SELECT IF(info_harga.created_at IS NOT NULL, info_harga.harga ,'false') AS harga FROM info_harga WHERE DATE(info_harga.created_at) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)");
        // $hasil =  isset($coba[0]) ?  $coba[0]->harga : 0;
        // $coba = DB::select("SELECT IF(info_harga.created_at IS NOT NULL, info_harga.harga ,'false') AS harga FROM info_harga WHERE DATE(info_harga.created_at) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)");
        // return $hasil;
        $data = [];
        $pasar = DB::select('SELECT id_jenis_pasar, nama_jenis_pasar FROM jenis_pasar');
        // return $pasar;
        foreach ($pasar as $key => $p) {
            $coba = DB::select("SELECT IF(info_harga.created_at IS NOT NULL, info_harga.harga ,'false') AS harga FROM info_harga WHERE DATE(info_harga.created_at) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)");
            $hasil =  isset($coba[0]) ?  $coba[0]->harga : 0;

            // $selisih = DB::table('info_harga')->select('harga')->where('created_at', ' = ', DB::raw(' DATE_SUB(2022-01-25, INTERVAL 1 DAY)'))->get();
            $info = DB::select('select `info_harga`.`id_info`, `info_harga`.`harga`, jenis_pasar.id_jenis_pasar , `jenis_pasar`.`nama_jenis_pasar`, `kategori`.`nama_kategori`, `kategori`.`gambar`,  `kategori`.`satuan`, `kategori`.`harga_normal`, `komoditas`.`nama_komoditas`, `info_harga`.`created_at`, info_harga.harga - ' . $hasil . ' AS selisih, ' . $hasil . ' AS sebelum from `info_harga` inner join `jenis_pasar` on `info_harga`.`id_jenis_pasar` = `jenis_pasar`.`id_jenis_pasar` inner join `kategori` on `info_harga`.`id_kategori` = `kategori`.`id_kategori` inner join `komoditas` on `kategori`.`id_komoditas` = `komoditas`.`id_komoditas` where `jenis_pasar`.`id_jenis_pasar` = ' . $p->id_jenis_pasar . ' AND info_harga.created_at = CURRENT_DATE()');
            // $info = DB::table('info_harga')->join('jenis_pasar', 'info_harga.id_jenis_pasar', '=', 'jenis_pasar.id_jenis_pasar')->join('kategori', 'info_harga.id_kategori', '=', 'kategori.id_kategori')->join('komoditas', 'kategori.id_komoditas', '=', 'komoditas.id_komoditas')->select('info_harga.id_info', 'info_harga.harga', 'jenis_pasar.nama_jenis_pasar', 'kategori.nama_kategori', 'kategori.satuan', 'kategori.harga_normal', 'komoditas.nama_komoditas', 'info_harga.created_at', DB::raw('ABS(info_harga.harga - ' .  $hasil . ') AS selisih'),  DB::raw('' . $hasil . ' AS sebelum'))->where('jenis_pasar.id_jenis_pasar', '=', $p->id_jenis_pasar, 'AND',  DB::raw('info_harga.created_at = CURRENT_DATE()'))->get();

            array_push($data, [
                'pasar' => $p,
                'info' => $info
            ]);
        }

        return $data;
    }

    public function export(Request $request)
    {
        return Excel::download(new LaporanExport($request->pasar, $request->tanggal), 'laporan.xlsx');
    }
}
