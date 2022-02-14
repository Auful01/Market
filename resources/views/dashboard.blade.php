@extends('layout.app')

@section('content')
<div class="content">

    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators" id="indikator">
          {{-- <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li> --}}
        </ol>
        <div class="carousel-inner" id="highlits">

        </div>
        <button class="carousel-control-prev" type="button" data-target="#carouselExampleIndicators" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-target="#carouselExampleIndicators" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </button>
    </div>

    <hr>
    <div class="container">
        <h3 style="font-weight: 700">Informasi Harga Per Lokasi Pasar</h3>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Pasar</label>
                    <select name="pasar" id="pasar" class="form-control"></select>
                </div>
                <div class="form-group">
                    <label for="">Tanggal</label>
                    {{-- <select t name="tanggal" id="tanggal" class="form-control"></select> --}}
                    <input type="date" name="tanggal" id="tanggal" class="form-control">
                </div>

                <button class="btn btn-info" id="load-info-ds">Lihat Data</button>
            </div>
            <div class="col-md-8 ">
                <div class="alert alert-info border-info border-top-0 border-right-0 border-bottom-0" style="border-left: 5px solid">
                    <p id="tgl">Tanggal Periode </p>
                    <p id="psr">Nama Pasar    </p>
                </div>
                <div class="table table-success border-success border-top-0 border-right-0 border-bottom-0" style="border-left: 5px solid ">
                    <table class="table alert alert-success" id="isiTable" >
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Komoditas</th>
                                <th id="th-tgl"></th>
                            </tr>
                        </thead>
                        <tbody id="isi-info"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="chart m-4">
        <canvas id="myChart" width="2000" height="300"></canvas>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.js"></script>
{{-- <script>
    const ctx = document.getElementById('myChart');

    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor:'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)'

                ,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script> --}}
  <script>
      $.ajax({
          url : '/load-dashboard',
          type : 'GET',
          success : function (data) {
            // console.log(data['pasar']);
            $.each(data, function (k, v) {
                // console.log(k);
                $('#indikator').append($('<li data-target="#carouselExampleIndicators" data-slide-to="'+k+'" {{'+k+' == 0 ? "active" : ""}}></li>'))
                $('#highlits').append(`
                <div class="carousel-item `+data[k]['pasar']['id_jenis_pasar']+`" id=`+data[k]['pasar']['id_jenis_pasar']+`>
                    <div class="row d-flex justify-content-center text-center mt-3">
                        <h3>Informasi Harga `+data[k]['pasar']['nama_jenis_pasar']+`</h3>
                        <div class="card bg-light shadow mt-3" style="width: 80%; height: 700px;"  >
                            <div class="row px-4 py-5 " id="isi-highlits-`+data[k]['pasar']['id_jenis_pasar']+`">
                            </div>
                        </div>
                    </div>
                </div>`)
                // console.log(v.id_jenis_pasar);
                $('body #1').addClass('active')
                // $.each(v.info, function (k,v) {
                //     console.log($('.carousel-item').attr('id'));
                //     if ($('body #'+v.id_jenis_pasar+'')) {
                //         $('body #isi-highlits').append(`

                //                 <div class="col-md-3">
                //                     <div class="card">
                //                         <div class="card-header border-0 alert alert-success">`+v.nama_kategori+`</div>
                //                         <div class="card-body">`+v.harga+`/`+v.satuan+`</div>
                //                         <div class="card-footer">Naik</div>
                //                     </div>
                //                 </div>
                //             `)
                //             }
                //         })

            })

            $.each(data, function (k,v) {
                        console.log(v);
                        $.each(v.info, function (k,v) {

                    if ($('body #'+v.id_jenis_pasar+'')) {
                        console.log(v.selisih);
                        $('body #isi-highlits-'+v.id_jenis_pasar+'').append(`

                                <div class="col-md-3">
                                    <div class="card">
                                        <div class="card-header border-0 alert alert-success">`+v.nama_kategori+`</div>
                                         <div class="card-body">
                                            <img src="{{asset('storage/`+ v.gambar +`')}}" style="height:100px">
                                            <br>
                                            `+v.harga+`/`+v.satuan+`
                                            </div>
                                      <div class="card-footer alert alert-success"> ${v.selisih === 0 ? 'stabil' : v.selisih > 0 ? 'naik' : 'turun' } (Rp. ` + v.selisih +`)</div>
                                    </div>
                                </div>
                            `)
                            }
                        })
                        // $.each
                        // if ('body #'+v.id_jenis_pasar+'') {
                        // }
                    })

          }
      })


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


        $('#load-info-ds').on('click', function () {
    $('#isi-info').empty()
    console.log('test');
    var arharga= [];
    var arkomo = [];
    var pasar = $('#pasar').val()
    var pasarTxt = $('#pasar').find(':selected').text()
    var tanggal = $('#tanggal').val()
    console.log(pasarTxt, tanggal);
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
        // $('#body-laporan').empty()
                $('#tgl').empty()
                $('#th-tgl').empty()
                $('#th-tgl').append(tanggal)
        // $('#pasar').append(tanggal)
                $('#tgl').append('Per Tanggal:' + tanggal)
                $('#psr').append(':' + pasarTxt)
        $.ajax({
            url : '/load-laporan',
            type : 'GET',
            data : {
                'pasar' : pasar,
                'tanggal' : tanggal
            },
            success : function (data) {
                console.log(data.length);
            $('#isi-info').empty()

                const ctx = document.getElementById('myChart');
            if (data.length == 0) {

                $('<tr>').append($('<td colspan=3 class="text-center border"> ').text('Data tidak ditemukan')).appendTo('#isiTable')
            }

                $.each(data , function (k, v) {
                    console.log(data);
                    a = 1;
                    b = 0;
                    // arharga[b] = []
                    var tr = $('<tr>').append(
                $('<td>').text(a),
                $('<td>').text(v.nama_komoditas + '('+v.nama_kategori+')'),
                // $.each()
                $('<td>').text(v.harga)
                ).appendTo('#isiTable')
                // console.log([k]);

                 arharga.push(v.harga)
                 arkomo.push(v.nama_kategori)
                 console.log(arharga, arkomo);
                b++;
                a++;


                })



                const myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: arkomo,
                        datasets: [{
                            label: 'Harga',
                            data: arharga,
                            backgroundColor:'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)'

                            ,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });


            },
            error : function (data) {
                $('<tr>').append($('<td colspan=9 class="text-center border">').text('Data tidak ditemukan')).appendTo('#isiTable')
            }
        })
    }

})
  </script>
@endsection
