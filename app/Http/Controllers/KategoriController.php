<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
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
        $kategori = DB::table('kategori')->insert(['id_komoditas' => $request->id_komoditas, 'nama_kategori' => $request->nama_kategori, 'satuan' => $request->satuan, 'harga_normal' => $request->harga_normal]);
        return $kategori;
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

    public function loadKategori()
    {
        $kategori = DB::table('kategori')->join('komoditas', 'komoditas.id_komoditas', '=', 'kategori.id_komoditas')->select('komoditas.nama_komoditas', 'kategori.id_komoditas', 'kategori.id_kategori', 'kategori.nama_kategori', 'kategori.satuan', 'kategori.harga_normal')->get();
        return $kategori;
    }

    public function findKategori(Request $request)
    {
        $kategori = DB::table('kategori')->join('komoditas', 'komoditas.id_komoditas', '=', 'kategori.id_komoditas')->select('komoditas.nama_komoditas', 'kategori.id_komoditas', 'kategori.id_kategori', 'kategori.nama_kategori', 'kategori.satuan', 'kategori.harga_normal')->where('kategori.id_komoditas', '=', $request->komoditas)->orWhere('komoditas.nama_komoditas', '=', $request->komoditas)->get();
        return $kategori;
    }

    public function updateKategori(Request $request)
    {
        $kategori = Kategori::find($request->id_kategori);
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->harga_normal = $request->harga_normal;
        $kategori->satuan = $request->satuan;
        $kategori->id_komoditas = $request->id_komoditas;
        $kategori->save();
        return $kategori;
    }

    public function deleteKategori(Request $request)
    {
        return Kategori::find($request->kategori)->delete();
    }
}
