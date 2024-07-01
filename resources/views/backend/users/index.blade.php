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
    <h4 class="font-weight-bold float-left">User</h4>
    <a href="{{route('users.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Tambah User"><i class="fas fa-plus"></i> Tambah User</a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      @if($users->count() > 0)
      <table class="table table-bordered" id="user-dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>User NID</th>
            <th>Nama User</th>
            <th>Foto</th>
            <th>Role</th>
            <th>Status</th>
            <th>Opsi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $user)
          <tr>
            <td>{{$user->user_nid}}</td>
            <td>{{$user->user_nama}}</td>
            <td>
              @if($user->photo)
              <img src="{{$user->photo}}" class="img-fluid " style="max-width:50px;" alt="{{$user->photo}}">
              @else
              <img src="{{asset('backend/img/avatar.png')}}" class="img-fluid " style="max-width:50px" alt="avatar.png">
              @endif
            </td>
            <td>{{$user->role}}</td>
            <td>
              @if($user->status=='active')
              <span class="badge badge-success">{{$user->status}}</span>
              @else
              <span class="badge badge-warning">{{$user->status}}</span>
              @endif
            </td>
            <td>
              <a href="{{route('users.show',$user->id)}}" class="btn btn-warning btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>

              <a href="{{route('users.edit',$user->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
              <form method="POST" action="{{route('users.destroy',[$user->id])}}">
                @csrf
                @method('delete')
                <button class="btn btn-danger btn-sm dltBtn" data-id="{{$user->id}}" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
              </form>
            </td>

          </tr>
          @endforeach
        </tbody>
      </table>
      <div class="d-flex justify-content-center">
        {{ $users->links('pagination::bootstrap-4') }}
      </div>
      @else
      <h6 class="text-center">Users Kosong!!! Tolong Tambah User</h6>
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

<!-- Page level custom scripts -->
<script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
<script>
  $('#user-dataTable').DataTable({
    "scrollX": false,
    "columnDefs": [{
      "orderable": false,
      "targets": [4, 5]
    }],
    "paging": false,
    "info": false
  });

  // Sweet alert

  function deleteData(id) {

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
      var dataID = $(this).data('id');
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