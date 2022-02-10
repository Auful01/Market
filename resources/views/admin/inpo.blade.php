@extends('layout.app')

@section('content')

<div class="container mt-5">
    <div class="row d-flex justify-content-between mb-3">
        <h3>Jenis Pasar</h3>
        <button class="btn btn-primary" id="tambah-pasar">+ Tambah Pasar</button>
    </div>
    <div class="row">
        <div class="col">
            <label for="">Pasar</label>
            <select name="pasar" id="pasar" class="form-control" required></select>
        </div>
        <div class="col">
            <label for="">Tanggal</label>
            <input type="date" class="form-control" id="tanggal" required>
        </div>
        <div class="col">
            <label for=""></label>
            <button class="btn btn-success form-control" id="laporan">Laporan</button>
        </div>
        <div class="col">
            <label for=""></label>
            <button class="btn btn-danger form-control">Cetak</button>
        </div>
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




$(document).ready( function () {

    $('#infoTable').DataTable();

    // if ($('input').attr('type','search')) {
    // $('input').attr('type','date')
// }
} );
function loadInfo() {
    $.ajax({
    type:"GET",
    url : "/load-info",
    success : function (data) {
        $('#body-info').empty()
    $.each(data, function (k ,v) {
        $('#infoTable').DataTable(
            "columns" : [
                {'data' : v.id_info}
                {'data' : v.nama_jenis_pasar}
                {'data' : v.nama_komoditas}
                {'data' : v.nama_kategori}
                {'data' : v.satuan}
                {'data' : v.sebelum}
                {'data' : v.harga}
                {'data' : v.selisih}
                {'data' : v.harga_normal}
                {'data' : $('<div class="row d-flex justify-content-start">').append($('<button class="btn btn-warning mr-2" id="edit-info" data-id="'+v.id_kategori+'" data-komoditas="'+v.id_kategori+'">').append($('<i class="far fa-trash-alt"></i>')), $('<button class="btn btn-danger" id="delete-kategori" data-komoditas="'+v.id_kategori+'">').append($('<i class="far fa-trash-alt"></i>')) ))}
            ]
        )

    })
    }
})

}

setTimeout(loadInfo, 2000);

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
    $('body').on('click', '#edit-info', function () {
        $('#modal-edit-info').modal('show')
    })

    $('body').on('click', '#update-pasar', function () {

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
          <h5 class="modal-title" id="exampleModalLabel">Tambah Informasi</h5>
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

  {{-- EDIT --}}
<div class="modal fade" id="modal-edit-info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Informasi</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form >
            <div class="form-group">
                <label for="">Pasar</label>
                <select name="pasar" id="pasar-edit" class="form-control"></select>
            </div>
            <div class="form-group">
                <label for="">Komoditas</label>
                <select name="komoditas" id="komoditas-edit" class="form-control"></select>
            </div>
            <div class="form-group">
                <label for="">Kategori</label>
                <select name="kategori" id="kategori-edit" class="form-control"></select>
            </div>
            <div class="form-group">
                <label for="">Harga Hari ini</label>
                <input type="text" id="harga-edit" name="harga" class="form-control">
                {{-- <select name="kategori" id="kategori"></select> --}}
            </div>


          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button id="update-pasar" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
  @endsection
