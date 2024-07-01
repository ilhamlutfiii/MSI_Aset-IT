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
    <h4 class="font-weight-bold float-left">Kategori</h4>
    <a href="{{route('category.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Tambah Kategori</a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      @if(count($categories)>0)
      <table class="table table-bordered" id="banner-dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Nama Kategori</th>
            <th>Parent Kategori</th>
            <th>Kategori</th>
            <th>Foto</th>
            <th>Status</th>
            <th>Opsi</th>
          </tr>
        </thead>
        <tbody>

          @foreach($categories as $category)
          @php
          @endphp
          <tr>
            <td>{{$category->title}}</td>
            <td>{{(($category->is_parent==1)? 'Yes': 'No')}}</td>
            <td>
              {{$category->parent_info->title ?? ''}}
            </td>
            <td>
              @if($category->photo)
              <img src="{{$category->photo}}" class="img-fluid" style="max-width:80px" alt="{{$category->photo}}">
              @else
              <img src="{{asset('backend/img/thumbnail-default.jpg')}}" class="img-fluid" style="max-width:80px" alt="avatar.png">
              @endif
            </td>
            <td>
              @if($category->status=='active')
              <span class="badge badge-success">{{$category->status}}</span>
              @else
              <span class="badge badge-warning">{{$category->status}}</span>
              @endif
            </td>
            <td>
              <a href="{{route('category.edit',$category->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
              <form method="POST" action="{{route('category.destroy',[$category->id])}}">
                @csrf
                @method('delete')
                <button class="btn btn-danger btn-sm dltBtn" data-id={{$category->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div class="d-flex justify-content-center">
        {{ $categories->links('pagination::bootstrap-4') }}
      </div>
      @else
      <h6 class="text-center">Kategori Kosong !!! Tolong Tambah Kategori</h6>
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
  $('#banner-dataTable').DataTable({
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
          text: "Dengan menghapus kategori ini, kamu tidak bisa mengembalikannya!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            form.submit();
          } else {
            swal("Data Kategori Aman!");
          }
        });
    })
  })
</script>
@endpush