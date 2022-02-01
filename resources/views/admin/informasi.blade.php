@extends('layout.app')

@section('content')
<div class="container mt-5">
    <div class="row d-flex justify-content-between mb-3">
        <h3>Jenis Pasar</h3>
        <button class="btn btn-primary" id="tambah-pasar">+ Tambah Pasar</button>
    </div>

    <table id="infoTable" class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Pasar</th>
                <th>Komoditi</th>
                <th>Kategori</th>
                <th>Satuan</th>
                <th>Harga Kemarin</th>
                <th>Harga Sekarang</th>
                <th>Perubahan Harga</th>
                <th>Harga normal</th>
                <th>action</th>
            </tr>
        </thead>
        <tbody id="body-info">
            {{-- @php
                $i = 1;
            @endphp
            @foreach ($pasar as $p)
            <tr>
                <td>{{$i}}</td>
                <td>{{$pasar->jenis_pasar}}</td>
            </tr>
            @endforeach

            @php
                $i++;
            @endphp --}}
        </tbody>
    </table>


</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
<script>
setTimeout(loadInfo, 2000);



$(document).ready( function () {

    // $('#infoTable').DataTable();

    // if ($('input').attr('type','search')) {
    // $('input').attr('type','date')
// }
} );
function loadInfo() {
    $.ajax({
    type:"GET",
    url : "/load-info",
    success : function (data) {
        // $('#infoTable').empty()
        $('#infoTable').DataTable({
            "data" : data,
            "columns" : [
    // $.each(data, function (k ,v) {
                {'data' : 'id_info'},
                {'data' : 'nama_jenis_pasar'},
                {'data' : 'nama_komoditas'},
                {'data' : 'nama_kategori'},
                {'data' : 'satuan'},
                {'data' : 'sebelum'},
                {'data' : 'harga'},
                {'data' : 'selisih'},
                {'data' : 'harga_normal'},
                { 'data' : 'id_kategori',
                    'render' : function (data, type, row) {
                    return '<div class="row d-flex justify-content-start"><button class="btn btn-warning mr-2" id="edit-kategori" data-id='+data+' data-komoditas='+data+'><i class="far fa-trash-alt"></i><button class="btn btn-danger" id="delete-kategori" data-komoditas='+data+'><i class="far fa-trash-alt"></i>'}
                }
    // })
            ]
    }
        )
        // var tr = $('<tr>').append(
        //     $('<td>').text(v.id_info),
        //     $('<td>').text(v.nama_jenis_pasar),
        //     $('<td>').text(v.nama_komoditas),
        //     $('<td>').text(v.nama_kategori),
        //     $('<td>').text(v.satuan),
        //     $('<td>').text(v.sebelum),
        //     $('<td>').text(v.harga),
        //     $('<td>').text(v.selisih),
        //     $('<td>').text(v.harga_normal),
        //     $('<td>').append($('<div class="row d-flex justify-content-start">').append($('<button class="btn btn-warning mr-2" id="edit-kategori" data-id="'+v.id_kategori+'" data-komoditas="'+v.id_kategori+'">').append($('<i class="far fa-trash-alt"></i>')), $('<button class="btn btn-danger" id="delete-kategori" data-komoditas="'+v.id_kategori+'">').append($('<i class="far fa-trash-alt"></i>')) ))
        // ).appendTo('#infoTable')
    }
})
}

    $('#tambah-pasar').on('click', function () {
        $('#modal-tambah-pasar').modal('show')
        $.ajax({
            url : '/load-komoditas',
            type : 'GET',
            success : function (data) {
                $('#komoditas').append('<option > Choose One</option>')
                $.each(data, function (k, v) {
                    $('#komoditas').append('<option value='+v.id_komoditas+'>'+v.nama_komoditas+'</option>')
                    })
            }
        });
        $.ajax({
            url : '/load-pasar',
            type : 'GET',
            success : function (data) {
                $('#pasar').append('<option > Choose One</option>')
                $.each(data, function (k, v) {
                    $('#pasar').append('<option value='+v.id_jenis_pasar+'>'+v.nama_jenis_pasar+'</option>')
                    })
            }
        })
    })

    $('body').on('change', '#komoditas', function () {
        $('#kategori').empty()
        var komoditas = $(this).find(':selected').val()
        console.log(komoditas);
        $.ajax({
            url : '/kategori-detail',
            type : 'GET',
            data : {
                'komoditas' : komoditas
            },
            success : function (data){
                $('#kategori').append('<option > Choose One</option>')
                $.each(data, function (k, v) {
                    $('#kategori').append('<option value='+v.id_kategori+'>'+v.nama_kategori+'</option>')
                    })
            }
        })
    })


    $('body').on('click', '#save-pasar', function () {
        var pasar = $('#pasar').find(':selected').val()
        // var komoditas = $('#komoditas').find(':selected').val()
        var kategori = $('#kategori').find(':selected').val()
        var harga = $('#harga').val()
        $.ajax({
            url : '/info',
            type : 'POST',
            data : {
                '_token' : '{{ csrf_token() }}',
                'pasar' : pasar,
                'kategori' : kategori,
                'harga' : harga
            },
            success : function (data) {
                $('#modal-tambah-pasar').modal('hide')
                    window.location.reload()
                    Swal.fire({
                    title: 'Sukses!',
                    text: 'Komoditas baru telah ditambahkan',
                    icon: 'success',
                    timer : 2000,
                    showConfirmButton: false,
                    confirmButtonText : false,
                    timerProgressBar : true
                })
            }
        })
    })
</script>
@endsection

@section('modal')
<div class="modal fade" id="modal-tambah-pasar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form >
            <div class="form-group">
                <label for="">Pasar</label>
                <select name="pasar" id="pasar" class="form-control"></select>
            </div>
            <div class="form-group">
                <label for="">Komoditas</label>
                <select name="komoditas" id="komoditas" class="form-control"></select>
            </div>
            <div class="form-group">
                <label for="">Kategori</label>
                <select name="kategori" id="kategori" class="form-control"></select>
            </div>
            <div class="form-group">
                <label for="">Harga Hari ini</label>
                <input type="text" id="harga" name="harga" class="form-control">
                {{-- <select name="kategori" id="kategori"></select> --}}
            </div>


          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button id="save-pasar" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
@endsection
