@extends('layout.app')

@section('content')
<div class="container-fluid p-5">
    <div class="row">
        <div class="col-md-5">
            <div class="card shadow" >
                <div class="card-body">
                    <div class="row d-flex justify-content-between mb-3">
                        <h3>Komoditas</h3>
                        <button class="btn btn-primary" id="tambah-komoditas">+ Tambah komoditas</button>

                    </div>
                    <table id="komoditasTable" class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Komoditas</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="body-komoditas">
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
            </div>
        </div>

        <div class="col-md-7">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row d-flex justify-content-between mb-3">
                        <h3>Kategori</h3>
                        <button class="btn btn-primary" id="tambah-kategori">+ Tambah Kategori</button>
                    </div>

                    <table id="kategoriTable" class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Komoditas</th>
                                <th>Kategori</th>
                                <th>Satuan</th>
                                <th>Harga Normal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="body-kategori">
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
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
    <script>

        setTimeout(loadKomoditas, 2000);
        setTimeout(loadKategori, 2000);

          $(document).ready( function () {
    // $('#komoditasTable').DataTable();
    // $('#kategoriTable').DataTable();
} );


        function loadKomoditas() {

$.ajax({
    type:"GET",
    url : "/load-komoditas",
    success : function (data) {
        // $('#komoditasTable').empty()
        $('#komoditasTable').DataTable({
            "data" : data,
            stateSave: true,
            "bDestroy": true,
            "columns" : [
                {'data' : 'id_komoditas'},
                {'data' : 'nama_komoditas'},
                {'data' : 'id_komoditas',
                    'render' : function (data) {
                        return '<div class="row d-flex justify-content-start"><button class="btn btn-warning mr-2" id="edit-komoditas" data-id="'+data+'" data-komoditas="'+data+'"><i class="far fa-trash-alt"></i><button class="btn btn-danger" id="delete-komoditas" data-komoditas="'+data+'"><i class="far fa-trash-alt"></i>'
                    }}
            ]
        })
    //   $.each(data, function (k ,v) {
    //      var tr = $('<tr>').append(
    //          $('<td>').text(v.id_komoditas),
    //          $('<td>').text(v.nama_komoditas),
    //          $('<td>').append($('<div class="row d-flex justify-content-start">').append($('<button class="btn btn-warning mr-2" id="edit-komoditas" data-id="'+v.id_komoditas+'" data-komoditas="'+v.nama_komoditas+'">').append($('<i class="far fa-trash-alt"></i>')), $('<button class="btn btn-danger" id="delete-komoditas" data-komoditas="'+v.id_komoditas+'">').append($('<i class="far fa-trash-alt"></i>')) ))
    //      ).appendTo('#komoditasTable')
    //   })
    }
})
}

        function loadKategori() {

                $.ajax({
                    type:"GET",
                    url : "/load-kategori",
                    success : function (data) {
                        // $('#body-kategori').empty()
                        $('#kategoriTable').DataTable({
                            "data" : data,
                            "paging" : true,
                            "search" : true,
                            "columns" : [
                                {'data' : 'id_kategori'},
                                {'data' : 'nama_komoditas'},
                                {'data' : 'nama_kategori'},
                                {'data' : 'satuan'},
                                {'data' : 'harga_normal'},
                                {'data' : 'id_kategori',
                                    'render' : function (data, type, row) {
                                        return '<div class="row d-flex justify-content-start"><button class="btn btn-warning mr-2" id="edit-kategori" data-id='+data+' data-komoditas='+data+'><i class="far fa-trash-alt"></i><button class="btn btn-danger" id="delete-kategori" data-komoditas='+data+'><i class="far fa-trash-alt"></i>'
                                    }}
                                // {'data' : 'id_kategori'}
                            ]
                        }
                        )
                    }
                    // $.each(data, function (k ,v) {
                    //     var tr = $('<tr>').append(
                    //         $('<td>').text(v.id_kategori),
                    //         $('<td>').text(v.nama_komoditas),
                    //         $('<td>').text(v.nama_kategori),
                    //         $('<td>').text(v.satuan),
                    //         $('<td>').text(v.harga_normal),
                    //         $('<td>').append($('<div class="row d-flex justify-content-start">').append($('<button class="btn btn-warning mr-2" id="edit-kategori" data-id="'+v.id_kategori+'" data-komoditas="'+v.id_kategori+'">').append($('<i class="far fa-trash-alt"></i>')), $('<button class="btn btn-danger" id="delete-kategori" data-komoditas="'+v.id_kategori+'">').append($('<i class="far fa-trash-alt"></i>')) ))
                    //     ).appendTo('#kategoriTable')
                    // })
                    // }
                })
        }

        $('#tambah-kategori').on('click', function () {
            $('#modal-tambah-kategori').modal('show')

        })

        $('#tambah-komoditas').on('click', function () {
            $('#modal-tambah-komoditas').modal('show')


        })

        $('body').on('click', '#save-komoditas', function () {
            var komoditas = $('#nama_komoditas').empty()
            var komoditas = $('#nama_komoditas').val()

            $.ajax({
                url : '/komoditas',
                type: 'POST',
                data : {
                    '_token' : "{{ csrf_token() }}",
                    'nama_komoditas' : komoditas
                },
                success : function (data) {
                    $('#modal-tambah-komoditas').modal('hide')
                    Swal.fire({
                    title: 'Sukses!',
                    text: 'Komoditas baru telah ditambahkan',
                    icon: 'success',
                    timer : 2000,
                    showConfirmButton: false,
                    confirmButtonText : false,
                    timerProgressBar : true
                })
                    setTimeout(loadKomoditas, 2000);
                    $('#form-komoditas').reset()
                }
            })
        })


        $('body').on('click', '#save-kategori', function () {
            var komoditas = $('#komoditas').val()
            var nama_kategori = $('#nama_kategori').val()
            var satuan = $('#satuan').val()
            var harga_normal = $('#harga_normal').val()

            $.ajax({
                url : '/kategori',
                type: 'POST',
                data : {
                    '_token' : "{{ csrf_token() }}",
                    'id_komoditas' : komoditas,
                    'nama_kategori' : nama_kategori,
                    'satuan' : satuan,
                    'harga_normal' : harga_normal
                },
                success : function (data) {
                    $('#modal-tambah-kategori').modal('hide')
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
                    // setTimeout(loadKategori, 2000);
                    // $('#form-kategori').reset()
                }
            })
        })

    </script>


</div>

@endsection


@section('modal')
{{-- ADD COMODITY --}}
<div class="modal fade" id="modal-tambah-komoditas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="form-komoditas">
              <div class="form-group">
                  <label for="">Nama Komoditas</label>
                <input type="text" class="form-control" id="nama_komoditas" name="nama_komoditas">
              </div>

              <button type="button" id="save-komoditas" class="btn btn-primary">
                  save
              </button>
          </form>
        </div>

      </div>
    </div>
  </div>

<div class="modal fade" id="modal-tambah-kategori" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="form-kategori">
              <div class="form-group">
                  <label for="">Pilih Komoditas</label>
                  <select name="komoditas" id="komoditas" class="form-control"></select>
                {{-- <input type="text" class="form-control" id="jenis_pasar" name="jenis_pasar"> --}}
              </div>

              <div class="form-group">
                  <label for="">Nama Kategori</label>
                  <input type="text" name="nama_kategori" id="nama_kategori" class="form-control">
              </div>
              <div class="form-group">
                  <label for="">Satuan</label>
                  <input type="text" name="satuan" id="satuan" class="form-control">
              </div>
              <div class="form-group">
                  <label for="">Harga Normal</label>
                  <input type="text" name="harga_normal" id="harga_normal" class="form-control">
              </div>

              <button type="button" id="save-kategori" class="btn btn-primary">
                  save
              </button>
          </form>
        </div>

      </div>
    </div>
  </div>

  <script>
      $('#tambah-kategori').on('click', function () {

      $.ajax({
                url : '/load-komoditas',
                type: 'GET',
                success: function (data) {
                    $.each(data, function (k, v) {
                    $('#komoditas').append('<option value='+v.id_komoditas+'>'+v.nama_komoditas+'</option>')
                    })
                }
            })
      })
  </script>
@endsection
