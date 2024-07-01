@extends('backend.layouts.master')

@section('main-content')
<!-- DataTales Example -->
<div class="card shadow mb-4 ml-2 mr-2">
  <div class="row">
    <div class="col-md-12">
      @include('backend.layouts.notification')
    </div>
  </div>
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary float-left">Daftar Jabatan</h6>
    <a href="{{route('jabatans.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Tambah Jabatan"><i class="fas fa-plus"></i> Tambah Jabatan</a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      @if($jabatans->count() > 0)
      <table class="table table-bordered" id="jabatan-dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Nama Jabatan</th>
            <th>Opsi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($jabatans as $jb)
          <tr>
            <td>{{$jb->jabatan_name}}</td>
            <td>
              <a href="{{route('jabatans.edit',$jb->jabatan_id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
              <form method="POST" action="{{route('jabatans.destroy',[$jb->jabatan_id])}}">
                @csrf
                @method('delete')
                <button class="btn btn-danger btn-sm dltBtn" data-id="{{$jb->jabatan_id}}" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
              </form>
            </td>

          </tr>
          @endforeach
        </tbody>
      </table>
      <div class="d-flex justify-content-center">
        {{ $jabatans->links('pagination::bootstrap-4') }}
      </div>
      @else
      <h6 class="text-center">Jabatan Kosong!!! Tolong Tambah Jabatan</h6>
      @endif
    </div>
  </div>
</div>
@endsection

@push('styles')
<link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
@endpush

@push('scripts')

<!-- Page level plugins -->
<script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- Page level custom scripts  -->
  <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
<script>
  $('#jabatan-dataTable').DataTable({
    "columnDefs": [{
      "orderable": false,
      "targets": [0, 1]
    }],
    "paging": false,
    "info": false
  });

  // Sweet alert

  function deleteData(jabatan_id) {

  }
</script>
<script>
  $(document).ready(function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $('.dltBtn').click(function(e) {
      var form = $(this).closest('form');
      var dataID = $(this).data('jabatan_id');
      // alert(dataID);
      e.preventDefault();
      swal({
          title: "Apakah kamu yakin?",
          text: "Dengan menghapus ini, kamu tidak bisa mengembalikannya!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            form.submit();
          } else {
            swal("Data Aman!");
          }
        });
    })
  })
</script>
@endpush