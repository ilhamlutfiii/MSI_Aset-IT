@extends('backend.layouts.master')
@section('title','MSI || All Notifications')
@section('main-content')
<div class="card shadow ml-2 mr-2">
  <div class="row">
    <div class="col-md-12">
      @include('backend.layouts.notification')
    </div>
  </div>
  <h5 class="card-header">Notifikasi</h5>
  <div class="card-body">
    @if($notifications->count() > 0)
    <table class="table table-hover admin-table" id="notification-dataTable">
      <thead>
        <tr>
          <th scope="col">No.</th>
          <th scope="col">Waktu</th>
          <th scope="col">Notifikasi</th>
          <th scope="col">Opsi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($notifications as $notification)
        <tr class="@if($notification->unread()) bg-light border-left-light @else border-left-success @endif">
          <td scope="row">{{$loop->index +1}}</td>
          <td>{{$notification->created_at->setTimezone('Asia/Jakarta')->format('d-m-Y')}}, {{$notification->created_at->setTimezone('Asia/Jakarta')->format('H:i')}}</td>
          <td>{{$notification->data['title']}}</td>
          <td>
            <a href="{{route('admin.notification', $notification->id) }}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>
            <form method="POST" action="{{ route('notification.delete', $notification->id) }}">
              @csrf
              @method('delete')
              <button class="btn btn-danger btn-sm dltBtn" data-id="{{$notification->id}}" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {{ $notifications->links('pagination::bootstrap-4') }} <!-- Pagination links with Bootstrap 4 style -->
    </div>
    @else
    <h6 class="text-center">Notifikasi Kosong!</h6>
    @endif
  </div>
</div>
@endsection
@push('styles')
<link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
@endpush
@push('scripts')
<script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- Page level custom scripts -->
<script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
<script>
  $(document).ready(function() {
    $('#notification-dataTable').DataTable({
      "paging": false, // Disable paging to allow Laravel pagination
      "info": false,
      "columnDefs": [{
        "orderable": false,
        "targets": [2,3]
      }],
      "scrollX": false
    });

    // Sweet alert
    $('.dltBtn').click(function(e) {
      var form = $(this).closest('form');
      var dataID = $(this).data('id');
      e.preventDefault();
      swal({
        title: "Apakah kamu yakin?",
        text: "Dengan menghapus notifikasi ini, kamu tidak bisa mengembalikannya!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          form.submit();
        } else {
          swal("Notifikasi Aman!");
        }
      });
    });
  });
</script>
@endpush
