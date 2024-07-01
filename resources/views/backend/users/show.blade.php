@extends('backend.layouts.master')

@section('main-content')
<div class="card">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary float-left">User Detail</h6>
  </div>
  <div class="card-body">
    <div class="container">
      <div class="row">
        <div class="col-lg-5 col-12 text-center">
          @if($users->photo)
          @php
          $photo = explode(',', $users->photo);
          @endphp
          @if(isset($photo[0]))
          <img src="{{$photo[0]}}" class="img-fluid" style="max-width:450px; max-height:400px;" alt="{{$users->photo}}">
          @else
          <img src="{{asset('backend/img/thumbnail-default.jpg')}}" class="img-fluid" style="max-width:450px" alt="thumbnail-default.jpg">
          @endif
          @else
          <img src="{{asset('backend/img/thumbnail-default.jpg')}}" class="img-fluid" style="max-width:450px" alt="thumbnail-default.jpg">
          @endif

        </div>
        <!-- Blade Template -->
        <div class="col-lg-6 col-12">
          <div class="aset-des card p-4 mb-4 shadow-sm">
            <div class="short">
              <h4 class="font-weight-bold mb-3">{{ $users->user_nama }}</h4>
              <h5 class="font-weight mb-3">{{ $users->user_nid }}</h5>
              <br>
              <p class="description mb-2"><strong>Jabatan</strong><span class="data">: {!! $users->jabatan !!}</span></p>
              <p class="description mb-2"><strong>Bidang</strong><span class="data">: {!! $users->bidang !!}</span></p>
              <p class="description mb-2"><strong>Fungsi</strong><span class="data">: {!! $users->fungsi !!}</span></p>
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
  .aset-des {
    background-color: #f8f9fa;
    border-radius: 8px;
  }

  .aset-des h4 {
    color: #343a40;
  }

  .aset-des .description {
    color: #6c757d;
    margin-bottom: 0.5rem;
    /* Margin bottom between description lines */
  }

  .aset-des .description strong {
    display: inline-block;
    width: 80px;
    /* Fixed width for labels to align consistently */
  }

  .aset-des .description .data {
    margin-left: 10px;
    /* Space between label and data */
    display: inline-block;
  }
</style>
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