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
    <h4 class="font-weight-bold float-left">Maintenance</h4>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      @if($maintenances->count() > 0)
      <table class="table table-bordered" id="maintenance-dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Aset</th>
            <th>Kategori</th>
            <th>Sub Kategori</th>
            <th>Foto</th>
            <th>Opsi</th>
          </tr>
        </thead>
        <tbody>

          @foreach($maintenances as $maintenance)
          @php
          $sub_cat_info = DB::table('categories')->select('title')->where('id', $maintenance->asets->child_cat_id)->get();
          @endphp
          <tr>
            <td>{{ $maintenance->asets->title }}</td>
            <td>{{ $maintenance->asets->cat_info['title'] }}</td>
            <td>{{ $maintenance->asets->sub_cat_info['title'] }}</td>
            <td>
              @if($maintenance->asets->photo)
              @php
              $photo = explode(',', $maintenance->asets->photo);
              @endphp
              <img src="{{ $photo[0] }}" class="img-fluid" style="max-width:80px" alt="{{ $maintenance->asets->photo }}">
              @else
              <img src="{{ asset('backend/img/thumbnail-default.jpg') }}" class="img-fluid" style="max-width:80px" alt="avatar.png">
              @endif
            </td>
            <td>
              <a href="{{ route('maintenance.show', $maintenance->asets->id) }}" class="btn btn-warning btn-sm float-left mr-1" data-toggle="tooltip" title="show" data-placement="bottom"><i class="fas fa-eye"></i> Status</a>
              <a href="{{ route('maintenance.indexLog', $maintenance->id) }}" class="btn btn-primary btn-sm float-left mr-1" data-toggle="tooltip" title="history" data-placement="bottom">Log History</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div class="d-flex justify-content-center">
        {{ $maintenances->links('pagination::bootstrap-4') }}
      </div>
      @else
      <h6 class="text-center">Maintenance Kosong!!! Tolong Tambah Aset Dahulu</h6>
      @endif
    </div>
  </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
@endpush

@push('scripts')

<!-- Page level plugins -->
<script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('backend/js/demo/datatables-demo.js') }}"></script>
<script>
  $('#maintenance-dataTable').DataTable({
    "scrollX": false,
    "columnDefs": [{
      "orderable": false,
      "targets": [3, 4]
    }],
    "paging": false,
    "info": false
  });

  // Sweet alert

  function deleteData(id) {}
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
      e.preventDefault();
      swal({
          title: "Are you sure?",
          text: "Once deleted, you will not be able to recover this data!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            form.submit();
          } else {
            swal("Your data is safe!");
          }
        });
    })
  })
</script>
@endpush