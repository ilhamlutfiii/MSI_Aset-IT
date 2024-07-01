@extends('backend.layouts.master')
@section('title', 'MSI || DASHBOARD')
@section('main-content')
<div class="container-fluid">
  @include('backend.layouts.notification')

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h2 class="font-weight-bold float-left">Dashboard</h2>
  </div>

  <!-- Content Row -->
  <div class="row">
    <!-- User -->
    <div class="col-xl-3 col-md-6 mb-4">
      <a href="{{ route('users.index') }}" style="text-decoration: none;">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">User</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\User::countActiveUser() }}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-user fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </a>
    </div>

    <!-- Asets -->
    <div class="col-xl-3 col-md-6 mb-4">
      <a href="{{ route('aset.index') }}" style="text-decoration: none;">
        <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Asets</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Aset::countActiveAset() }}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-cubes fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </a>
    </div>

    <!-- Pinjam -->
    <div class="col-xl-3 col-md-6 mb-4">
      <a href="{{ route('pinjam.index') }}" style="text-decoration: none;">
        <div class="card border-left-warning shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pinjam</div>
                <div class="row no-gutters align-items-center">
                  <div class="col-auto">
                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ \App\Models\Pinjam::countActivePinjam() }}</div>
                  </div>
                </div>
              </div>
              <div class="col-auto">
                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </a>
    </div>


    <!-- Review -->
    <div class="col-xl-3 col-md-6 mb-4">
      <a href="{{ route('review.index') }}" style="text-decoration: none;">
        <div class="card border-left-danger shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Review</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\AsetReview::countActiveReview() }}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-comments fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
    </div>
    </a>
  </div>
  <!-- Content Row -->
  @php
  $showMaintenanceTable = false;
  foreach($maintenances as $maintenance) {
  $updated_at = \Carbon\Carbon::parse($maintenance->updated_at);
  $now = \Carbon\Carbon::now();
  $daysDiff = $now->diffInDays($updated_at);
  if($daysDiff >= $maintenance->rentang || $maintenance->mainStatus == 'Repair') {
  $showMaintenanceTable = true;
  break;
  }
  }
  @endphp

  @if($showMaintenanceTable)
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header py-3">
          <a href="{{ route('maintenance.index') }}" style="text-decoration: none;">
            <h4 class="font-weight-bold float-left">Maintenance</h4>
          </a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="main-dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Nama Aset</th>
                  <th>Foto</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($maintenances as $maintenance)
                @php
                $updated_at = \Carbon\Carbon::parse($maintenance->updated_at);
                $now = \Carbon\Carbon::now();
                $daysDiff = $now->diffInDays($updated_at);
                $daysLate = $daysDiff - $maintenance->rentang;
                $daysDiffs = $updated_at->diffInDays($now);
                $daysLeft = $maintenance->rentang - $daysDiffs;
                @endphp

                @if($daysDiff >= $maintenance->rentang || $maintenance->mainStatus == 'Repair')
                <tr>
                  <td>{{ $maintenance->asets->title }}</td>
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
                    @if($maintenance->mainStatus == 'Repair')
                    <p class="aset blink">Request Repair - {{ $maintenance->ket_main }}</p>
                    @endif
                    @if($daysDiff > $maintenance->rentang)
                    <p class="aset blink">Sudah Telat Maintenance Selama {{ $daysLate }} Hari</p>
                    @elseif($daysDiff == $maintenance->rentang && $maintenance->mainStatus != 'Repair')
                    <p class="aset blink">Hari ini waktunya maintenance</p>
                    @endif
                  </td>
                  <td>
                    <a href="{{ route('maintenance.show', $maintenance->asets->id) }}" class="btn btn-danger btn-sm float-left mr-1" data-toggle="tooltip" title="show" data-placement="bottom">Maintenance</a>
                  </td>
                </tr>
                @endif
                @endforeach
              </tbody>
            </table>
            <div class="d-flex justify-content-center">
              {{ $maintenances->links('pagination::bootstrap-4') }} <!-- Pagination links with Bootstrap 4 style -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif
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
  $(document).ready(function() {
    $('#main-dataTable').DataTable({
      "scrollX": false,
      "columnDefs": [{
        "orderable": false,
        "targets": [2, 3]
      }],
      "paging": false,
      "info": false
    });
  });

  // Sweet alert
  function deleteData(id) {
    // Function implementation
  }
</script>
@endpush

@push('styles')
<style>
  .aset-info,
  .aset-info h4,
  .keterangan {
    color: red;
  }

  .aset {
    color: green;
  }

  @keyframes blink {
    0% {
      opacity: 1;
    }

    50% {
      opacity: 0;
    }

    100% {
      opacity: 1;
    }
  }

  .blink {
    animation: blink 1s infinite;
    color: red;
  }
</style>
@endpush