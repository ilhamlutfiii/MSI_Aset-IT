@extends('user.layouts.master')

@section('main-content')
<div class="container-fluid">
  @include('user.layouts.notification')
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
  </div>

  <div class="row">

    <div class="col-xl-3 col-md-6 mb-4">
      <a href="{{ route('user.pinjam.index') }}" style="text-decoration: none;">
        <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pinjam</div>
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

    <div class="col-xl-3 col-md-6 mb-4">
      <a href="{{ route('user.asetreview.index') }}" style="text-decoration: none;">
        <div class="card border-left-warning shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Review</div>
                <div class="row no-gutters align-items-center">
                  <div class="col-auto">
                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ \App\Models\AsetReview::countActiveReview() }}</div>
                  </div>
                </div>
              </div>
              <div class="col-auto">
                <i class="fas fa-comments fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </a>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
      <a href="{{ route('user.bantuan.index') }}" style="text-decoration: none;">
        <div class="card border-left-danger shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Bantuan Perbaikan</div>
                <div class="row no-gutters align-items-center">
                  <div class="col-auto">
                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ \App\Models\Pinjam::countActiveRepair() }}</div>
                  </div>
                </div>
              </div>
              <div class="col-auto">
                <i class="fas fa-question-circle fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </a>
    </div>

  </div>
</div>
@endsection