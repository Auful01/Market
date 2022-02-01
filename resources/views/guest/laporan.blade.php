@extends('layout.app')

@section('content')

<div class="container">
    <h3>Laporan</h3>

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
            <a class="btn btn-danger form-control"  id="cetak" target="_blank">Cetak</a>
        </div>
    </div>

    <div class="judul alert alert-info mt-5 p-3">
        <div class="row d-flex justify-content-center">
            <div class="col-md-8">

                <h5 class="text-center ">
                    DATA INFORMASI HARGA KEBUTUHAN POKOK PANGAN
                </h5>
            </div>

        </div>
        <p id="tgl"> </p>
    </div>

    <div class="isi mt-5">

        <table class="table" id="isiTable" >
            <thead>
                <tr>
                    <th>No</th>
                    <th>Komoditi</th>
                    <th>Kategori</th>
                    <th>Stn</th>
                    <th>Harga Kemarin</th>
                    <th>Harga Hari ini</th>
                    <th>Rata rata</th>
                    <th>Perubahan Harga</th>
                    <th>Harga Normal</th>
                </tr>
            </thead>
            <tbody id="body-laporan">
                <tr>
                    <td colspan="9" class="text-center">Data Kosong</td>
                </tr>
            </tbody>
        </table>
    </div>

    <canvas id="myChart" width="400" height="400"></canvas>

</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>


    <script>
        $(document).ready( function () {
    $('#laporanTable').DataTable();
} );

// function name(params) {

// }
    $('#pasar').empty()
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

        $('#cetak').on('click', function () {
            var pasar = $('#pasar').val()
            var tanggal = $('#tanggal').val()

            $.ajax({
                url : "{{URL::to('/export')}}",
                type : 'GET',
                // dataType : 'json',
                data : {
                    'pasar' : pasar,
                    'tanggal': tanggal,
                },
                success : function (data,status, xhr) {
                    console.log(status);
                    window.location.href = '/export?pasar='+pasar+'&tanggal='+tanggal+''
                }
            })
        })

$('#laporan').on('click', function () {
    $('#body-laporan').empty()
    console.log('test');
    var pasar = $('#pasar').val()
    var tanggal = $('#tanggal').val()
    console.log(pasar, tanggal);
    if(pasar == null || pasar == 0 || pasar == 'Choose One' || tanggal == null){
        Swal.fire({
                    title: 'Gagal!',
                    text: 'Anda Harus memilih pasar dan tanggal',
                    icon: 'error',
                    timer : 2000,
                    confirmButtonText : false,
                    showConfirmButton : false,
                    timerProgressBar : true
                })
    }else{

                $('#tgl').empty()
                $('#tgl').append('Per Tanggal:' + tanggal)
        $.ajax({
            url : '/load-laporan',
            type : 'GET',
            data : {
                'pasar' : pasar,
                'tanggal' : tanggal
            },
            success : function (data) {
                console.log(data.length);
            $('#body-laporan').empty()
            if (data.length == 0) {

                $('<tr>').append($('<td colspan=9 class="text-center border"> ').text('Data tidak ditemukan')).appendTo('#isiTable')
            }
                $.each(data , function (k, v) {
                    a = 1;
                    var tr = $('<tr>').append(
                $('<td>').text(a),
                $('<td>').text(v.nama_komoditas),
                $('<td>').text(v.nama_kategori),
                $('<td>').text(v.satuan),
                $('<td>').text(v.sebelum),
                $('<td>').text(v.harga),
                $('<td>').text((v.harga + v.sebelum )/2),
                $('<td>').text(v.selisih),
                $('<td>').text(v.harga_normal)).appendTo('#isiTable')
                a++;
                })
            },
            error : function (data) {
                $('<tr>').append($('<td colspan=9 class="text-center border">').text('Data tidak ditemukan')).appendTo('#isiTable')
            }
        })
    }

})
    </script>
@endsection
