<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PasarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return $pasar;
        return view('admin.pasar');
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
        $pasar = DB::table('jenis_pasar')->insert(['nama_jenis_pasar' => '' . $request->jenis_pasar . '', 'created_at' => date('Y/m/d')]);
        return $pasar;
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

    public function loadPasar()
    {
        $pasar = DB::table('jenis_pasar')->select('*')->get();
        return $pasar;
    }

    public function updatePasar(Request $request)
    {
        $pasar = DB::select('UPDATE jenis_pasar SET nama_jenis_pasar = "' . $request->jenis_pasar . '" WHERE id_jenis_pasar=' . $request->id . '');
        return $pasar;
    }

    public function deletePasar(Request $request)
    {
        DB::select('DELETE FROM info_harga WHERE id_jenis_pasar =' . $request->id .  '');
        return DB::select('DELETE FROM jenis_pasar WHERE id_jenis_pasar = ' . $request->id . '');
    }
}
