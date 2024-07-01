@extends('backend.layouts.master')

@section('main-content')
<div class="card shadow ml-2 mr-2">
  <div class="card-header py-3">
  <h4 class="font-weight-bold float-left">Maintenance Detail</h4>
  </div>
  <div class="card-body">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-12">
          @if($maintenances->asets->photo)
          @php
          $photo = explode(',', $maintenances->asets->photo);
          @endphp
          @if(isset($photo[0]))
          <img src="{{$photo[0]}}" class="img-fluid" style="max-width:450px" alt="{{$maintenances->asets->photo}}">
          @else
          <img src="{{asset('backend/img/thumbnail-default.jpg')}}" class="img-fluid" style="max-width:450px" alt="thumbnail-default.jpg">
          @endif
          @else
          <img src="{{asset('backend/img/thumbnail-default.jpg')}}" class="img-fluid" style="max-width:450px" alt="thumbnail-default.jpg">
          @endif

        </div>
        <div class="col-lg-6 col-12">
          <div class="aset-des">
            <div class="short">
              <h4>{{$maintenances->asets->title}}</h4>
              <p class="description">{!!($maintenances->asets->summary)!!}</p>
            </div>

            <div id="asets">
              @php
              // Calculate the difference in days and months
              $updated_at = \Carbon\Carbon::parse($maintenances->updated_at);
              $now = \Carbon\Carbon::now();
              $daysDiff = $now->diffInDays($updated_at);
              $monthsDiff = $now->diffInMonths($updated_at);
              $daysLate = $daysDiff - $maintenances->rentang;
              $daysLeft = $maintenances->rentang - $daysDiff;
              $monthsLate = $monthsDiff - $maintenances->ganti;
              $monthsLeft = $maintenances->ganti - $monthsDiff;
              @endphp

              @if($maintenances->mainStatus == 'Repair')
              <div id="asetBox">
                <p class="aset blink">Request Perbaikan Aset</p>
              </div>
              <h5>Keterangan : </h5>
              <p class="keterangan">{{ $maintenances->ket_main }}</p>
              @endif

              @if($maintenances->mainStatus == 'Sedang Diproses' || $maintenances->mainStatus == 'Maintenance')
              <div id="asetBox">
                <p class="aset">Lanjutkan Perbaikan</p>
              </div>
              <h5>Keterangan : </h5>
              <p class="keterangan">Lanjutkan</p>
              @endif

              @if($monthsDiff >= $maintenances->ganti)
              @if($monthsDiff > $maintenances->ganti)
              <div id="asetBox">
                <p class="aset blink">Sudah Telat Pergantian Selama {{$monthsLate}} Bulan</p>
              </div>
              @elseif($monthsDiff == $maintenances->ganti)
              <div id="asetBox">
                <p class="aset blink">Bulan ini waktunya pergantian</p>
              </div>
              @endif

              <h5>Keterangan : </h5>
              <p class="keterangan">Waktunya Pergantian</p>

              @elseif($daysDiff >= $maintenances->rentang)
              @if($daysDiff > $maintenances->rentang)
              <div id="asetBox">
                <p class="aset blink">Sudah Telat Perbaikan Selama {{$daysLate}} Hari</p>
              </div>
              @elseif($daysDiff == $maintenances->rentang)
              <div id="asetBox">
                <p class="aset blink">Hari ini waktunya perbaikan</p>
              </div>
              @endif

              <h5>Keterangan : </h5>
              <p class="keterangan">Waktunya Perbaikan</p>

              @elseif(($maintenances->mainStatus != 'Repair' && $maintenances->mainStatus != 'Sedang Diproses' && $maintenances->mainStatus != 'Maintenance') && $daysDiff <= $maintenances->rentang)
              <div id="asetBox">
                <p class="aset">Perbaikan dalam {{$daysLeft}} hari lagi</p>
              </div>

              @elseif(($maintenances->mainStatus != 'Repair' && $maintenances->mainStatus != 'Sedang Diproses' && $maintenances->mainStatus != 'Maintenance') && $monthsDiff <= $maintenances->ganti)
              <div id="asetBox">
                <p class="aset">Pergantian dalam {{$monthsLeft}} bulan lagi</p>
              </div>
              @endif

              <div class="mt-2 mb-2 text-center">
                <a href="#" id="maintenanceButton" class="btn btn-primary">Perbaiki</a>
              </div>
              
              <div class="text-center">
                <form method="POST" action="{{route('maintenance.destroy',[$maintenances->asets->id])}}">
                @csrf
                @method('delete')
                <button class="btn btn-primary gnt" data-id="{{$maintenances->asets->id}}" data-toggle="tooltip" data-placement="bottom" >Ganti Aset</button>
              </form>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Form maintenance -->
    <div class="card">
      <div id="maintenanceForm" class="mt-3 mb-3 text-center" style="display: none;">

        <form action="{{ route('maintenance.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <input type="hidden" name="aset_id" value="{{ $maintenances->aset_id }}">
            <label for="mainStatus">Kondisi Terakhir:</label>
            <div class="mainPhoto mb-2">
              <img src="{{ asset('mainPhoto/' . $maintenances->mainPhoto) }}" class="img-fluid zoom" style="max-width:200px;max-height: 200px;" alt="Main Photo">
            </div>
            @if($maintenances->mainStatus == 'Repair')
            <input type="hidden" name="mainStatus" value="Maintenance">
            <p>Aset perlu perbaikan, tambahkan foto untuk proses perbaikan aset.</p>
            @elseif($maintenances->mainStatus == 'Sedang Diproses')
            <input type="hidden" name="mainStatus" value="Maintenance">
            <p>Saat ini sedang diproses, tambahkan foto untuk melanjutkan tahap maintenance.</p>
            @elseif($maintenances->mainStatus == 'Maintenance')
            <input type="hidden" name="mainStatus" value="Selesai">
            <p>Saat ini dalam tahap maintenance, tambahkan foto untuk menyelesaikan maintenance.</p>
            @else
            <input type="hidden" name="mainStatus" value="Sedang Diproses">
            <p>Tambahkan foto untuk melanjutkan maintenance.</p>
            @endif
          </div>
          <div class="form-group">
            <label for="mainPhoto">Foto:</label>
            <input type="file" name="mainPhoto" id="mainPhoto" class="form-control-file" onchange="previewImage(event)">
            <div id="imagePreview" class="mt-2">
              <img id="preview" src="" alt="Preview Image" style="max-width: 200px;">
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>

  </div>
</div>
@endsection

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

@push('styles')
<style>
  .aset-info,
  .shipping-info {
    background: #ECECEC;
    padding: 20px;
  }

  .aset-info h4,
  .shipping-info h4 {
    text-decoration: underline;
  }

  #asetBox {
    padding: 10px;
    width: fit-content;
    background-color: #f2f2f2;

  }

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

@push('scripts')
<script>
  document.getElementById('maintenanceButton').addEventListener('click', function() {
    document.getElementById('maintenanceForm').style.display = 'block';

    setTimeout(function() {
      // Scroll to the bottom of the page with smooth behavior
      window.scrollTo({
        top: document.body.scrollHeight,
        behavior: 'smooth'
      });
    }, 100);
  });
</script>
@endpush

@push('scripts')
<script>
  function previewImage(event) {
    var reader = new FileReader(); // Membuat objek FileReader
    reader.onload = function() {
      var output = document.getElementById('preview'); // Mendapatkan elemen img untuk pratinjau
      output.src = reader.result; // Menetapkan sumber pratinjau gambar
    }
    reader.readAsDataURL(event.target.files[0]); // Membaca file gambar sebagai URL
  }
</script>
@endpush
@push('scripts')
<!-- Page level plugins -->
<script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
  $(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.gnt').click(function(e) {
        e.preventDefault();
        var form = $(this).closest('form');
        var dataID = $(this).data('id');

        swal({
            title: "Apakah kamu yakin?",
            text: "Dengan mengganti aset ini, aset yang lama akan terhapus!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                form.submit();
            } else {
                swal("Data Aset Aman!");
            }
        });
    });
});
</script>
@endpush