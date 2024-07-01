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
        <h4 class="font-weight-bold float-left">Maintenance Log History</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            @if($logs->count() > 0)
            <table class="table table-bordered" id="maintenance-dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Aset</th>
                        <th>Foto Kondisi</th>
                        <th>Keterangan</th>
                        <th>Waktu Diselesaikan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                    <tr>
                        <td>{{ $log->asets->title }}</td>
                        <td><img src="{{ asset('mainPhoto/' . $log->mainPhoto) }}" class="img-fluid zoom" style="max-width:200px;max-height: 200px;" alt="Main Photo"></td>
                        <td>{{ $log->ket_main }}</td>
                        <td>{{ $log->created_at->setTimezone('Asia/Jakarta')->format('d-m-Y')}}, {{$log->created_at->setTimezone('Asia/Jakarta')->format('H:i')}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $logs->links('pagination::bootstrap-4') }}
            </div>
            @else
            <h6 class="text-center">Log History Kosong!!!</h6>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />

@endpush
@push('styles')
<style>
    .zoom {
        transition: transform .2s;
        /* Animation */
    }

    .zoom:hover {
        transform: scale(2);
    }
</style>
@endpush

@push('scripts')

<!-- Page level plugins -->
<script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- Page level custom scripts -->
<script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
<script>
    $('#maintenance-dataTable').DataTable({
        "scrollX": false,
        "columnDefs": [{
            "orderable": false,
            "targets": [0]
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