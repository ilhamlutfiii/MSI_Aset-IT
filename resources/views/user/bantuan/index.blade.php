@extends('user.layouts.master')

@section('main-content')
<!-- DataTales Example -->
<div class="card shadow mb-4 mr-2 ml-2">
    <div class="row">
        <div class="col-md-12">
            @include('user.layouts.notification')
        </div>
    </div>
    <div class="card-header py-3">
        <h4 class="font-weight-bold float-left">Repair</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            @if(count($pinjams)>0)

            @php
            $siapDiambilExists = $pinjams->firstWhere('status', 'Telah Diambil') !== null;
            @endphp

            @if($siapDiambilExists)
            <table class="table table-bordered" id="order-dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Pinjam No.</th>
                        <th>Nama</th>
                        <th>Aset</th>
                        <th>QTY</th>
                        <th>Waktu Pinjam</th>
                        <th>Status</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pinjams as $pinjam)
                    @if($pinjam->status == 'Telah Diambil')
                    <tr>
                        <td>{{$pinjam->pinjam_number}}</td>
                        <td>{{$pinjam->users->user_nama}}</td>
                        <td>{{$pinjam->asets->title}}</td>
                        <td>{{$pinjam->quantity}}</td>
                        <td>{{$pinjam->created_at->setTimezone('Asia/Jakarta')->format('d-m-Y')}}, {{$pinjam->created_at->setTimezone('Asia/Jakarta')->format('H:i')}} </td>
                        <td>
                            @if($pinjam->status=='Telah Diambil')
                            <span class="badge badge-success">Ready</span>
                            @else
                            <span class="badge badge-danger">{{$pinjam->status}}</span>
                            @endif
                        </td>
                        <td>
                            @php
                            $maintenance = DB::table('maintenances')->where('aset_id', $pinjam->aset_id)->first();
                            $status = $maintenance ? $maintenance->mainStatus : null;
                            @endphp

                            @if ($status == 'Repair' || $status == 'Sedang Diproses' || $status == 'Maintenance')
                            <a href="{{ route('user.bantuan.show', $pinjam->id) }}" class="btn btn-secondary btn-sm float-left mr-1" data-toggle="tooltip" title="View" data-placement="bottom"><i class="fas fa-eye"></i> Cek</a>
                            @else
                            <a href="{{ route('user.bantuan.show', $pinjam->id) }}" class="btn btn-danger btn-sm float-left mr-1" data-toggle="tooltip" title="View" data-placement="bottom"><i class="fas fa-tools"></i> Repair</a>
                            @endif
                        </td>

                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $pinjams->links('pagination::bootstrap-4') }} <!-- Pagination links with Bootstrap 4 style -->
            </div>
            @else
            <h6 class="text-center">Tidak ada peminjaman yang ready!!!</h6>
            @endif
            @else
            <h6 class="text-center">Peminjaman Kosong!!!</h6>
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
            "targets": [5, 6]
        }],
        "paging": false,
        "info": false
    });
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
                    text: "Dengan membatalkan peminjamanan aset ini?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    } else {
                        swal("Peminjamanmu Aman!");
                    }
                });
        })
    })
</script>
@endpush