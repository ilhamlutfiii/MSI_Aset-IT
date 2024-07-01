@extends('user.layouts.master')

@section('main-content')
<!-- DataTales Example -->
<div class="card shadow mb-4 ml-2 mr-2">
  <div class="row">
    <div class="col-md-12">
      @include('backend.layouts.notification')
    </div>
  </div>
  <div class="card-header py-3">
    <h4 class="font-weight-bold float-left">Review</h4>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      @if(count($reviews)>0)
      <table class="table table-bordered" id="order-dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Review By</th>
            <th>Aset</th>
            <th>Pinjam No</th>
            <th>Waktu</th>
            <th>Status</th>
            <th>Opsi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($reviews as $review)
          <tr>
            <td>{{$review->user_info['user_nama']}}</td>
            <td>{{$review->asets->title}}</td>
            <td>{{$review->pinjams->pinjam_number}}</td>
            <td>{{$review->created_at->setTimezone('Asia/Jakarta')->format('d-m-Y')}}, {{$review->created_at->setTimezone('Asia/Jakarta')->format('H:i')}}</td>
            <td>
              @if($review->status=='active')
              <span class="badge badge-success">{{$review->status}}</span>
              @else
              <span class="badge badge-warning">{{$review->status}}</span>
              @endif
            </td>
            <td>
              <a href="{{route('user.asetreview.show',$review->id)}}" class="btn btn-warning btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="show" data-placement="bottom"><i class="fas fa-eye"></i></a>
              <a href="{{route('user.asetreview.edit',$review->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
              <form method="POST" action="{{route('user.asetreview.delete',[$review->id])}}">
                @csrf
                @method('delete')
                <button class="btn btn-danger btn-sm dltBtn" data-id="{{$review->id}}" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div class="d-flex justify-content-center">
        {{ $reviews->links('pagination::bootstrap-4') }} <!-- Pagination links with Bootstrap 4 style -->
      </div>
      @else
      <h6 class="text-center">Reviews Kosong!!!</h6>
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
  $('#order-dataTable').DataTable({
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
          text: "Dengan menghapus data review ini, anda tidak akan bisa mengembalikannya lagi!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            form.submit();
          } else {
            swal("Reviewmu aman!");
          }
        });
    })
  })
</script>
@endpush