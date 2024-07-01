@extends('user.layouts.master')

@section('title','Pinjam Detail')

@section('main-content')
<div class="card shadow mb-4 mr-2 ml-2">
    <div class="card-body">
        @if($pinjam)
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Pinjam No.</th>
                    <th>Nama</th>
                    <th>Aset</th>
                    <th>QTY</th>
                    <th>Waktu Pinjam</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$pinjam->pinjam_number}}</td>
                    <td>{{$pinjam->users->user_nama}}</td>
                    <td>{{$pinjam->asets->title}}</td>
                    <td>{{$pinjam->quantity}}</td>
                    <td>{{$pinjam->created_at->setTimezone('Asia/Jakarta')->format('d-m-Y')}}, {{$pinjam->created_at->setTimezone('Asia/Jakarta')->format('H:i')}} </td>
                    <td>
                        @if($pinjam->status=='Telah Diambil')
                        <span class="badge badge-success">Ready</span>
                        @endif
                    </td>

                </tr>
            </tbody>
        </table>

        @if($main->mainStatus != 'Repair' && $main->mainStatus != 'Sedang Diproses' && $main->mainStatus != 'Maintenance')
        <div id="bantuanForm" class="mt-3">
            <form action="{{ route('user.bantuan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="main_id" value="{{ $main->id }}">
                <input type="hidden" name="pinjam_id" value="{{ $pinjam->id }}">
                <input type="hidden" name="aset_id" value="{{ $pinjam->asets->id }}">
                <input type="hidden" name="user_id" value="{{ $pinjam->users->id }}">
                <div class="form-group">
                    <label for="ket_main" class="mb-2">Keterangan Kerusakan: </label>
                    <textarea id="ket_main" name="ket_main" rows="6" class="form-control" placeholder="Masukkan Keterangan..."></textarea>
                </div>
                <input type="hidden" name="mainStatus" value="Repair">
                <div class="form-group">
                    <label for="mainPhoto">Foto Kerusakan:</label>
                    <input type="file" name="mainPhoto" id="mainPhoto" class="form-control-file" onchange="previewImage(event)">
                    <div id="imagePreview" class="mt-2">
                        <img id="preview" src="" alt="Preview Image" style="max-width: 200px;">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        @else
        <div class="form-group" style="text-align:center">
            <h6>Update Kondisi: </h6>
            <div class="mainPhoto mt-3">
                <img src="{{ asset('mainPhoto/' . $main->mainPhoto) }}" class="img-fluid zoom" style="max-width:200px;max-height: 200px;" alt="Main Photo">
            </div><br>
            <h6>Status Maintenance: {{$main->mainStatus}}</h6>
        </div>
        @endif

        @endif
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

    /* text area */
    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
        resize: vertical;
        /* Biarkan textarea dapat diubah ukurannya secara vertikal */
    }

    /* Rating */
    .rating_box {
        display: inline-flex;
    }

    .star-rating {
        font-size: 0;
        padding-left: 10px;
        padding-right: 10px;
    }

    .star-rating__wrap {
        display: inline-block;
        font-size: 1rem;
    }

    .star-rating__wrap:after {
        content: "";
        display: table;
        clear: both;
    }

    .star-rating__ico {
        float: right;
        padding-left: 2px;
        cursor: pointer;
        color: #aaa;
        font-size: 16px;
        margin-top: 5px;
    }

    .star-rating__ico:last-child {
        padding-left: 0;
    }

    .star-rating__input {
        display: none;
    }

    .star-rating__ico:hover:before,
    .star-rating__ico:hover~.star-rating__ico:before,
    .star-rating__input:checked~.star-rating__ico:before,
    .star-rating__input:checked~.star-rating__ico:hover:before {
        content: "\F005";
        color: #F7941D;
        /* Warna kuning */
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