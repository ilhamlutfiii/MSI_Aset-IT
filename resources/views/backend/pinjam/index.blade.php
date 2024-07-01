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
    <h4 class="font-weight-bold float-left">Peminjaman</h4>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      @if($pinjams->count() > 0)
      <table class="table table-bordered" id="pinjam-dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Pinjam No.</th>
            <th>Nama</th>
            <th>Aset</th>
            <th>Waktu Pinjam</th>
            <th>Status</th>
            <th>Opsi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($pinjams as $pinjam)
          <tr>
            <td>{{$pinjam->pinjam_number}}</td>
            <td>{{$pinjam->users->user_nama}}</td>
            <td>{{$pinjam->asets->title}}</td>
            <td>{{$pinjam->created_at->setTimezone('Asia/Jakarta')->format('d-m-Y')}}, {{$pinjam->created_at->setTimezone('Asia/Jakarta')->format('H:i')}} </td>
            
            <td>
              @if($pinjam->status=='Baru')
              <span class="badge badge-primary">{{$pinjam->status}}</span>
              @elseif($pinjam->status=='Diproses')
              <span class="badge badge-warning">{{$pinjam->status}}</span>
              @elseif($pinjam->status=='Siap Diambil')
              <span class="badge badge-success">{{$pinjam->status}}</span>
              @elseif($pinjam->status=='Telah Diambil')
              <span class="badge badge-info">{{$pinjam->status}}</span>
              @elseif($pinjam->status=='Dikembalikan')
              <span class="badge badge-secondary">{{$pinjam->status}}</span>
              @elseif($pinjam->status=='Cek Kondisi Aset')
              <span class="badge badge-warning">{{$pinjam->status}}</span>
              @elseif($pinjam->status=='Dibatalkan')
              <span class="badge badge-danger">{{$pinjam->status}}</span>
              @else
              <span class="badge badge-danger">{{$pinjam->status}}</span>
              @endif
            </td>
            <td>
            <a href="{{route('pinjam.show',$pinjam->id)}}" class="btn btn-warning btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>
              @if($pinjam->status!='Dikembalikan' && $pinjam->status!='Dibatalkan')
              <a href="{{route('pinjam.edit',$pinjam->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
              <form method="POST" action="{{route('pinjam.destroy',[$pinjam->id])}}" class="deleteForm">
                @csrf
                @method('delete')
                <input type="hidden" name="reason" class="deleteReason">
                <button class="btn btn-danger btn-sm dltBtn" data-id="{{$pinjam->id}}" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Batalkan"><i class="fas fa-trash-alt"></i></button>
              </form>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div class="d-flex justify-content-center">
        {{ $pinjams->links('pagination::bootstrap-4') }} <!-- Pagination links with Bootstrap 4 style -->
      </div>
      @else
      <h6 class="text-center">Peminjaman Kosong !!! Belum Ada Peminjaman Aset</h6>
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
  $('#pinjam-dataTable').DataTable({
    "columnDefs": [{
      "orderable": false,
      "targets": [4, 5]
    }],
    "paging": false,
    "info": false
  });

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
        title: "Apakah anda yakin?",
        text: "Sekali dibatalkan, Anda tidak dapat mengembalikan data ini! Harap berikan alasan pembatalan:",
        content: {
          element: "input",
          attributes: {
            placeholder: "Masukkan alasan pembatalan",
            type: "text",
          },
        },
        icon: "warning",
        buttons: true,
        dangerMode: true,
      }).then((value) => {
        if (value) {
          $(form).find('.deleteReason').val(value);
          swal("Peminjaman telah dibatalkan dengan alasan: " + value, {
            icon: "success",
          }).then(() => {
            form.submit();
          });
        } else {
          swal("Peminjaman aman!");
        }
      });
    });
  });
</script>
@endpush