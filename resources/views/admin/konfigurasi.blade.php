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


    {{-- <div class="modal fade" id="modal-edit-komoditas" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              ...
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div> --}}


    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
    <script>

        // $('')

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
                    'render' : function (data, type, row) {
                        // console.log(data);
                        return '<div class="row d-flex justify-content-start"><button class="btn btn-warning mr-2" id="edit-komoditas" data-id="'+data+'" data-komoditas="'+row['nama_komoditas']+'"><i class="fas fa-pencil-alt"></i></button><button class="btn btn-danger" id="delete-komoditas" data-kmdts='+data+'><i class="far fa-trash-alt"></i></button>'
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
                        // console.log(data);
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
                                {'data' : 'id_komoditas',
                                    'render' : function (data, type,  row) {
                                        // console.log(row['nama_kategori']);
                                        var tbl = `<div class="row d-flex justify-content-start"><button class="btn btn-warning mr-2" id="edit-kategori" data-id-kat=`+row['id_kategori']+` data-id-kom=`+data+` data-komoditas=`+row['nama_komoditas']+` data-satuan=`+row['satuan']+` data-harga=`+row['harga_normal']+` data-kategori="${row.nama_kategori}"><i class="fas fa-pencil-alt"></i></button><button class="btn btn-danger" id="delete-kategori" data-kategori=`+row['id_kategori']+` ><i class="far fa-trash-alt"></i></button>`
                                        return tbl
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

        $('body').on('click', '#delete-kategori', function () {
            // alert('ceck')
            var kategori = $(this).data('kategori');
            console.log(kategori);
            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url : '/delete-kategori',
                    type : 'DELETE',
                    data : {
                        '_token' : '{{csrf_token()}}',
                        'kategori' : kategori
                    },
                    success : function () {

                        Swal.fire({
                        title: 'Deleted!',
                        text : 'Your file has been deleted.',
                        icon : 'success',
                        timer : 2000,
                        showConfirmButton: false,
                        confirmButtonText : false,
                        timerProgressBar : true
                        })

                        setTimeout(() => {
                        window.location.reload()
                        }, 2000);
                    }

                })
            }
            })
        })


        $('body').on('click', '#delete-komoditas', function () {
            // alert('ceck')
            var kmdts = $(this).data('kmdts');
            console.log(kmdts);
            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url : '/delete-komoditas',
                    type : 'DELETE',
                    data : {
                        '_token' : '{{csrf_token()}}',
                        'komoditas' : kmdts
                    },
                    success : function () {

                        Swal.fire({
                        title: 'Deleted!',
                        text : 'Your file has been deleted.',
                        icon : 'success',
                        timer : 2000,
                        showConfirmButton: false,
                        confirmButtonText : false,
                        timerProgressBar : true
                        })

                        setTimeout(() => {
                        window.location.reload()
                        }, 2000);
                    }

                })
            }
            })
        })

        $('body').on('click','#edit-kategori', function () {
            $('#modal-edit-kategori').modal('show')

            var nama = $(this).data('kategori')
            var harga = $(this).data('harga')
            var satuan = $(this).data('satuan')
            var idKat = $(this).data('id-kat')
            var idKom = $(this).data('id-kom')

            // console.log($(this).data('kategori'));
            console.log(nama,harga,satuan,idKat,idKom);
            $('body #nama_kategori-edit').val(nama)
            $('body #harga_normal-edit').val(harga)
            $('body #satuan-edit').val(satuan)
            $('body #ktgr').val(idKat)
            $('#kmdt').empty()
            $.ajax({
                url : '/load-komoditas',
                type: 'GET',
                success: function (data) {
                    $.each(data, function (k, v) {
                    $('#kmdt').append(`<option value=`+v.id_komoditas+` ${v.id_komoditas == idKom ? 'selected' : ''}>`+v.nama_komoditas+`</option>`)
                    })
                }
            })

            // $('body #komoditas').val().
            // $('body #nama_kategori').val(nama)

            // $.ajax({
            //     url : ""
            // })

        })

        $('body').on('click', '#edit-komoditas', function () {
            $('#modal-edit-komoditas').modal('show')
            var nama = $(this).data('komoditas')
            var id = $(this).data('id')
            // console.log(nama);
            // console.log(id);
            $('body #nm_komoditas').val(nama)
            $('body #id_komoditas').val(id)



        })

        $('body').on('click', '#update-komoditas', function () {
            console.log(true);
            var nama = $('body #nm_komoditas').val()
            // consolelog(nama_kom);
            var id = $('#id_komoditas').val()
            $.ajax({
                url : '/update-komoditas',
                type : 'PUT',
                data : {
                    '_token' : '{{csrf_token()}}',
                    'nama' : nama,
                    'id' : id
                },
                success : function () {
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
                    setTimeout(() => {
                        window.location.reload()
                    }, 2000);

                }
            })
        })

        $('body').on('click', '#update-kategori', function () {
            console.log(true);
            var nama_kategori = $('body #nama_kategori-edit').val()
            var harga_normal = $('body #harga_normal-edit').val()
            var satuan = $('body #satuan-edit').val()
            var id_kategori = $('body #ktgr').val()
            var id_komoditi = $('body #kmdt').find(':selected').val()
            // consolelog(nama_kom);
            // var id = $('#id_komoditas').val()
            $.ajax({
                url : '/update-kategori',
                type : 'PUT',
                data : {
                    '_token' : '{{csrf_token()}}',
                    'nama_kategori' : nama_kategori,
                    'harga_normal' : harga_normal,
                    'satuan' : satuan,
                    'id_kategori' : id_kategori,
                    'id_komoditas' : id_komoditi
                },
                success : function () {
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
                    setTimeout(() => {
                        window.location.reload()
                    }, 2000);

                }
            })
        })

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

                setTimeout(() => {
                    window.location.reload()
                }, 2000);

                //
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
                    // window.location.reload()
                    Swal.fire({
                    title: 'Sukses!',
                    text: 'Komoditas baru telah ditambahkan',
                    icon: 'success',
                    timer : 2000,
                    showConfirmButton: false,
                    confirmButtonText : false,
                    timerProgressBar : true
                })

                setTimeout(() => {
                        window.location.reload()
                        }, 2000);
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

<div class="modal fade" id="modal-edit-komoditas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <input type="text" class="form-control" id="nm_komoditas" name="nm_komoditas">
                <input type="text" class="form-control" id="id_komoditas" name="id_komoditas" hidden>
              </div>

              <button type="button" id="update-komoditas" class="btn btn-primary">
                  save
              </button>
          </form>
        </div>

      </div>
    </div>
  </div>

  {{-- TAMBAH EDIT KATEGORI --}}

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

<div class="modal fade" id="modal-edit-kategori" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                  <select name="kmdt" id="kmdt" class="form-control"></select>
                {{-- <input type="text" class="form-control" id="jenis_pasar" name="jenis_pasar"> --}}
              </div>
              <input type="text" id="ktgr" hidden>
              <div class="form-group">
                  <label for="">Nama Kategori</label>
                  <input type="text" name="nama_kategori" id="nama_kategori-edit" class="form-control">
              </div>
              <div class="form-group">
                  <label for="">Satuan</label>
                  <input type="text" name="satuan" id="satuan-edit" class="form-control">
              </div>
              <div class="form-group">
                  <label for="">Harga Normal</label>
                  <input type="text" name="harga_normal" id="harga_normal-edit" class="form-control">
              </div>

              <button type="button" id="update-kategori" class="btn btn-primary">
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
