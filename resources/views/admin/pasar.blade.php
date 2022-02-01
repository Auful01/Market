@extends('layout.app')

@section('content')
<div class="container mt-5">
    <div class="row d-flex justify-content-between mb-3">
        <h3>Jenis Pasar</h3>
        <button class="btn btn-primary" id="tambah-pasar">+ Tambah Pasar</button>
    </div>

    <table id="myTable" class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Jenis Pasar</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="body-pasar">
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
    $('#myTable').DataTable();
} );


    $('#tambah-pasar').on('click', function () {
        $('#modal-tambah-pasar').modal('show');
    })

    $('body').on('click','#edit-pasar', function () {
        var id = $(this).data('id')
        var pasar = $(this).data('pasar')
        $('#modal-edit-pasar').modal('show');
        $('.jenis_pasar').val(pasar)

    })

    $('body').on('click','#delete-pasar', function () {
        var id = $(this).data('id')

        const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: 'btn btn-success',
    cancelButton: 'btn btn-danger'
  },
  buttonsStyling: false
})

swalWithBootstrapButtons.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonText: 'Yes, delete it!',
  cancelButtonText: 'No, cancel!',
  reverseButtons: true
}).then((result) => {
  if (result.isConfirmed) {
    swalWithBootstrapButtons.fire(
      'Deleted!',
      'Your file has been deleted.',
      'success'
    )
  } else if (
    /* Read more about handling dismissals below */
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'Cancelled',
      'Your imaginary file is safe :)',
      'error'
    )
  }
})

    })
    </script>
@endsection


@section('modal')
{{-- TAMBAH PASAR --}}
<div class="modal fade" id="modal-tambah-pasar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
              <div class="form-group">
                  <label for="">Jenis Pasar</label>
                <input type="text" class="form-control" id="jenis_pasar" name="jenis_pasar">
              </div>

              <button type="button" id="save-pasar" class="btn btn-primary">
                  save
              </button>
          </form>
        </div>

      </div>
    </div>
  </div>


  {{-- EDIT PASAR --}}
<div class="modal fade" id="modal-edit-pasar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
              <div class="form-group">
                  <label for="">Jenis Pasar</label>
                <input type="text" class="form-control jenis_pasar" id="jenis_pasar" name="jenis_pasar">
              </div>

              <button type="button" id="save-pasar" class="btn btn-primary">
                  save
              </button>
          </form>
        </div>

      </div>
    </div>
  </div>


  <script>

    setTimeout(loadPasar,2000);

      $('#save-pasar').on('click', function () {
        var pasar = $('#jenis_pasar').val()

        $.ajax({
            type : "POST",
            url : "/pasar",
            data : {
                "_token" : "{{ csrf_token() }}",
                "jenis_pasar" : pasar
            },
            success : function (data) {
                $('#modal-tambah-pasar').modal('hide')
                Swal.fire({
                    title: 'Sukses!',
                    text: 'Pasar baru telah ditambahkan',
                    icon: 'success',
                    timer : 2000,
                    confirmButtonText : false,
                    timerProgressBar : true
                })
                setTimeout(loadPasar, 2000);
            },
            error :function(){
                alert('error')
            }
        })
      })

      function loadPasar() {

          $.ajax({
              type:"GET",
              url : "/load-pasar",
              success : function (data) {
                  $('#body-pasar').empty()
                $.each(data, function (k ,v) {
                   var tr = $('<tr>').append(
                       $('<td>').text(v.id_jenis_pasar),
                       $('<td>').text(v.nama_jenis_pasar),
                       $('<td>').append($('<div class="row d-flex justify-content-start">').append($('<button class="btn btn-warning mr-2" id="edit-pasar" data-id="'+v.id_jenis_pasar+'" data-pasar="'+v.nama_jenis_pasar+'">').append($('<i class="far fa-trash-alt"></i>')), $('<button class="btn btn-danger" id="delete-pasar" data-pasar="'+v.id_jenis_pasar+'">').append($('<i class="far fa-trash-alt"></i>')) ))
                   ).appendTo('#myTable')
                })
              }
          })
      }
  </script>
@endsection
