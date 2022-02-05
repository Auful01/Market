<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.informasi');
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
        $info = DB::table('info_harga')->insert(['id_jenis_pasar' => $request->pasar, 'id_kategori' => $request->kategori, 'harga' => $request->harga, 'created_at' => date('Y/m/d')]);
        return $info;
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

    public function loadInfo()
    {
        // $selisih = DB::table('')
        // $info = DB::table('info_harga')->join('info_harga', 'p', 'p.id_info', '=', 'info_harga.id_info')->join('jenis_pasar', 'info_harga.id_jenis_pasar', '=', 'jenis_pasar.id_jenis_pasar')->join('kategori', 'info_harga.id_kategori', '=', 'kategori.id_kategori')->join('komoditas', 'kategori.id_komoditas', '=', 'komoditas.id_komoditas')->select('info_harga.id_info', DB::raw('subdate(info_harga.created_at,1) AS sebelum'), 'info_harga.harga', 'jenis_pasar.nama_jenis_pasar', 'kategori.nama_kategori', 'kategori.satuan', 'kategori.harga_normal', 'komoditas.nama_komoditas', DB::raw('info_harga.harga - p.harga AS selisih'))->where('p.id_info = info_harga.id_info - 1')->get();
        // $coba = DB::select("SELECT IF(DATE_SUB(DATE(info_harga.created_at), INTERVAL 1 DAY) IS NOT NULL, info_harga.harga ,'false') AS harga, DATE(info_harga.created_at) AS tanggal FROM info_harga ");
        // foreach ($coba as $k => $v) {
        //     $hasil[] =  isset($coba[$k]) ?  $coba[$k]->harga : 0;
        // }
        // $selisih = DB::table('info_harga')->select('harga')->where('created_at', ' = ', DB::raw(' DATE_SUB(2022-01-25, INTERVAL 1 DAY)'))->get();
        // $info = DB::table('info_harga')->join('jenis_pasar', 'info_harga.id_jenis_pasar', '=', 'jenis_pasar.id_jenis_pasar')->join('kategori', 'info_harga.id_kategori', '=', 'kategori.id_kategori')->join('komoditas', 'kategori.id_komoditas', '=', 'komoditas.id_komoditas')->select('info_harga.id_info', 'info_harga.harga', 'jenis_pasar.nama_jenis_pasar', 'kategori.nama_kategori', 'kategori.satuan', 'kategori.harga_normal', 'komoditas.nama_komoditas', DB::raw('ABS(info_harga.harga - (DATE_SUB(DATE(info_harga.created_at), INTERVAL 1 DAY) IS NOT NULL, info_harga.harga ,0)) AS selisih'),  DB::raw('(DATE_SUB(DATE(info_harga.created_at), INTERVAL 1 DAY) IS NOT NULL, info_harga.harga ,0) AS sebelum'))->get();
        $info = DB::select('select info_harga.id_info, IF(p.harga IS NULL, 0, p.harga) AS sebelum, info_harga.id_kategori, info_harga.harga, DATE(info_harga.created_at) AS tanggal ,jenis_pasar.nama_jenis_pasar, kategori.nama_kategori, kategori.satuan, kategori.harga_normal, komoditas.nama_komoditas, ABS(info_harga.harga - IF(p.harga IS NULL,0,p.harga)) AS selisih from info_harga inner join jenis_pasar on info_harga.id_jenis_pasar = jenis_pasar.id_jenis_pasar inner join kategori on info_harga.id_kategori = kategori.id_kategori inner join komoditas on kategori.id_komoditas = komoditas.id_komoditas LEFT JOIN info_harga as p on p.created_at = subdate(info_harga.created_at,1) ORDER BY tanggal');
        return $info;
        // return $info;
    }

    // public function updateInfo(Request $request)
    // {
    //     $info = DB::select('UPDATE info_harga SET id_jenis_pasar=' . $request->pasar . ' id_kategori=' . $request->kategori . ' harga=' . $request->harga . ' WHERE info_harga.id_info=' . $request->info .  '');
    //     return $info;
    // }

    public function deleteInfo(Request $request)
    {
        return DB::select('DELETE FROM info_harga WHERE info_harga.id_info =' . $request->id . '');
    }
}
