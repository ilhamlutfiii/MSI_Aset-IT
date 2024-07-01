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
    <h4 class="font-weight-bold float-left">Aset</h4>
    <a href="{{route('aset.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Tambah Aset</a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      @if(count($asets)>0)
      <table class="table table-bordered" id="aset-dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Nama Aset</th>
            <th>Kategori</th>
            <th>Sub Kategori</th>
            <th>Stok</th>
            <th>Foto</th>
            <th>Rentang Maintenance</th>
            <th>Rentang Pergantian</th>
            <th>Status</th>
            <th>Opsi</th>
          </tr>
        </thead>
        <tbody>

          @foreach($asets as $aset)
          @php
          $sub_cat_info=DB::table('categories')->select('title')->where('id',$aset->child_cat_id)->get();
          // dd($sub_cat_info);
          @endphp
          <tr>
            <td>{{$aset->title}}</td>
            <td>{{$aset->cat_info['title']}}</td>
            <td>{{$aset->sub_cat_info['title']}}</td>
            <td>
              @if($aset->stock>0)
              <span class="badge badge-primary">{{$aset->stock}}</span>
              @else
              <span class="badge badge-danger">{{$aset->stock}}</span>
              @endif
            </td>
            <td>
              @if($aset->photo)
              @php
              $photo=explode(',',$aset->photo);
              // dd($photo);
              @endphp
              <img src="{{$photo[0]}}" class="img-fluid" style="max-width:80px" alt="{{$aset->photo}}">
              @else
              <img src="{{asset('backend/img/thumbnail-default.jpg')}}" class="img-fluid" style="max-width:80px" alt="avatar.png">
              @endif
            </td>
            <td>{{$aset->rentang}} Hari</td>
            <td>{{$aset->ganti}} Bulan</td>
            <td>
              @if($aset->status=='active')
              <span class="badge badge-success">{{$aset->status}}</span>
              @else
              <span class="badge badge-warning">{{$aset->status}}</span>
              @endif
            </td>
            <td>
              <a href="{{route('aset.edit',$aset->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>

              <form method="POST" action="{{route('aset.destroy',[$aset->id])}}">
                @csrf
                @method('delete')
                <button class="btn btn-danger btn-sm dltBtn" data-id="{{$aset->id}}" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div class="d-flex justify-content-center">
        {{ $asets->links('pagination::bootstrap-4') }} <!-- Pagination links with Bootstrap 4 style -->
      </div>
      @else
      <h6 class="text-center">Aset Kosong !!! Tolong Tambah Aset</h6>
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
  $('#aset-dataTable').DataTable({
    "scrollX": false,
    "columnDefs": [{
      "orderable": false,
      "targets": [7, 8]
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
          text: "Dengan menghapus aset ini, kamu tidak bisa mengembalikannya!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            form.submit();
          } else {
            swal("Data Aset Aman!");
          }
        });
    })
  })
</script>
@endpush