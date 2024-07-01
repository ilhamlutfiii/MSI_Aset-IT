@extends('backend.layouts.master')

@section('title','Pinjam Detail')

@section('main-content')
<div class="card shadow ml-2 mr-2 mb-4">
  <div class="card-body">
    @if($pinjam)
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>Pinjam No.</th>
          <th>Nama</th>
          <th>Aset</th>
          <th>Waktu Pinjam</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
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
            @else
            <span class="badge badge-danger">{{$pinjam->status}}</span>
            @endif
          </td>
        </tr>
      </tbody>
    </table>
    @endif

    <div class="card">
      <div class="card-body">
        <div class="container">
          <div class="row">
          @if($pinjam->status != 'Baru' && $pinjam->status != 'Dibatalkan')
            <div class="col-lg-6 col-12">
              <img src="{{ asset('photoStatus/' . $pinjam->photoStatus) }}" class="img-fluid zoom" style="max-width:400px" alt="Photo Status">
            </div>
          @endif
            <div class="col-lg-6 col-12">
              <div class="aset-des">
                <div class="short">
                  <p class="pinjam">No. Pinjam : {{$pinjam->pinjam_number}}</p>
                  <p class="status">Status Peminjaman : {{$pinjam->status}}</p>
                  @if($pinjam->status == 'Dibatalkan')
                  <p class="keterangan">Alasan Pembatalan : {{$pinjam->keterangan}}</p>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
  .pinjam-info,
  .shipping-info {
    background: #ECECEC;
    padding: 20px;
  }

  .pinjam-info h4,
  .shipping-info h4 {
    text-decoration: underline;
  }
</style>
@endpush