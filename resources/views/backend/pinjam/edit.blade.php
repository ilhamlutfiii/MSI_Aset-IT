@extends('backend.layouts.master')

@section('title','pinjam Detail')

@section('main-content')
<div class="card shadow ml-2 mr-2">
  <h5 class="card-header">Pinjam Edit</h5>
  <div class="card-body">
    <form action="{{ route('pinjam.update', $pinjam->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PATCH')
      <div class="form-group">
      
        <label for="status">Status Peminjaman:</label>
        @if($pinjam->status != 'Baru')
        <p><img src="{{ asset('photoStatus/' . $pinjam->photoStatus) }}" class="img-fluid" style="max-width:200px" alt="Photo Status"></p>
        @endif

        @if($pinjam->status == 'Diproses')
        <input type="hidden" name="status" value="Siap Diambil">
        <p>Saat ini sedang diproses, tambahkan photo untuk melanjutkan ke tahap siap diambil .</p>

        @elseif($pinjam->status == 'Siap Diambil')
        <input type="hidden" name="status" value="Telah Diambil">
        <p>Saat ini aset siap diambil, tambahkan photo jika aset sudah diambil .</p>

        @elseif($pinjam->status == 'Telah Diambil')
        <p>Tunggu Pengembalian Aset.</p>

        @elseif($pinjam->status == 'Cek Kondisi Aset')
        <p>Saat ini dalam pengecekan kondisi aset, pilih untuk menyelesaikan status peminjaman.</p>
        <div class="form-group">
          <label for="status">Status Aset:</label><br>
          <input type="radio" name="status" value="Selesai" {{ old('status') == 'Selesai' ? 'checked' : '' }}>
          <label for="Selesai">Aman</label><br>
          <!-- Menambahkan input tersembunyi untuk menyimpan informasi tentang keamanan aset -->
          <input type="hidden" name="is_asset_safe" value="1">
        </div>

        @elseif($pinjam->status == 'Baru')
        <input type="hidden" name="status" value="Diproses">
        <p>Baru, Silakan tambah photo untuk melanjutkan ke tahap diproses.</p>

        @elseif($pinjam->status == 'Dikembalikan')
        <p>Saat ini dalam tahap dikembalikan.</p>

        @elseif($pinjam->status == 'Selesai')
        <p>Saat ini sudah selesai peminjaman.</p>
        @endif
      </div>

      @if($pinjam->status != 'Telah Diambil' && $pinjam->status != 'Cek Kondisi Aset' && $pinjam->status != 'Dikembalikan' && $pinjam->status != 'Selesai')
      <div class="form-group">
        <label for="photoStatus">Photo:</label>
        <input type="file" name="photoStatus" id="photoStatus" class="form-control-file" onchange="previewImage(event)">
        <div id="imagePreview" class="mt-2">
          <img id="preview" src="" alt="Preview Image" style="max-width: 200px;">
        </div>
      </div>
      @endif

      @if($pinjam->status != 'Dikembalikan' && $pinjam->status != 'Telah Diambil' && $pinjam->status != 'Selesai')
      <button type="submit" class="btn btn-primary">Update</button>
      @endif

    </form>
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
@push('styles')
<style>
  .photoStatus-input {
    display: none;
  }

  .photoStatus-label {
    font-size: 12px;
    color: #4caf50;
    cursor: pointer;
  }

  .photoStatus-preview {
    max-width: 100px;
    max-height: 100px;
    margin-top: 5px;
  }
</style>
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