@extends('user.layouts.master')

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
            @elseif($pinjam->status=='Selesai')
            <span class="badge badge-danger">{{$pinjam->status}}</span>
            @endif
          </td>

        </tr>
      </tbody>
    </table>
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
    <br>
    @php
    $hasReview = false;
    // Cek apakah ada review untuk pinjaman ini
    if(auth()->check()) {
    $userReview = App\Models\AsetReview::where('user_id', auth()->user()->id)
    ->where('pinjam_id', $pinjam->id)
    ->first();
    if($userReview) {
    $hasReview = true;
    }
    }
    @endphp

    @if($pinjam->status == 'Dikembalikan' && !$hasReview)
    <!-- Review -->
    <div id="review-section" class="comment-review">
      <div class="add-review">
        <h5>Review</h5>
      </div>

      <h4>Berikan Ratingmu! <span class="text-danger">*</span></h4>
      <div class="review-inner">
        <!-- Form -->
        @auth
        <form class="form" method="post" action="{{route('review.store',$pinjam->asets->slug)}}" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="id_pinjam" value="{{ $pinjam->id }}">
          <div class="row">
            <div class="col-lg-12 col-12">
              <div class="rating_box">
                <div class="star-rating">
                  <div class="star-rating__wrap">
                    <input class="star-rating__input" id="star-rating-5" type="radio" name="rate" value="5">
                    <label class="star-rating__ico fa fa-star" for="star-rating-5" title="5 out of 5 stars"></label>
                    <input class="star-rating__input" id="star-rating-4" type="radio" name="rate" value="4">
                    <label class="star-rating__ico fa fa-star" for="star-rating-4" title="4 out of 5 stars"></label>
                    <input class="star-rating__input" id="star-rating-3" type="radio" name="rate" value="3">
                    <label class="star-rating__ico fa fa-star" for="star-rating-3" title="3 out of 5 stars"></label>
                    <input class="star-rating__input" id="star-rating-2" type="radio" name="rate" value="2">
                    <label class="star-rating__ico fa fa-star" for="star-rating-2" title="2 out of 5 stars"></label>
                    <input class="star-rating__input" id="star-rating-1" type="radio" name="rate" value="1">
                    <label class="star-rating__ico fa fa-star" for="star-rating-1" title="1 out of 5 stars"></label>
                    @error('rate')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-12 col-12">
              <div class="form-group">
                <label for="photoStatus">Photo:</label>
                <input type="file" name="photoStatus" id="photoStatus" class="form-control-file" onchange="previewImage(event)">
                <div id="imagePreview" class="mt-2">
                  <img id="preview" src="" alt="Preview Image" style="max-width: 200px;">
                </div>
              </div>
            </div>
            <div class="col-lg-12 col-12">
              <div class="form-group">
                <label for="review" class="mb-2">Tulis Reviewmu</label>
                <textarea id="review" name="review" rows="6" class="form-control" placeholder="Tulis reviewmu di sini..."></textarea>
              </div>
            </div>
            <div class="col-lg-12 col-12">
              <div class="form-group button5">
                <button type="submit" class="btn btn-primary">Kirim</button>
              </div>
            </div>
          </div>
        </form>
        @else
        <p class="text-center p-5">
          You need to <a href="{{route('login.form')}}" style="color:rgb(54, 54, 204)">Login</a> OR <a style="color:blue" href="{{route('register.form')}}">Register</a>
        </p>
        <!--/ End Form -->
        @endauth
      </div>
    </div>
    <!--/ End Review -->
    @elseif($pinjam->status == 'Dikembalikan' || $pinjam->status == 'Cek Kondisi Aset' || $pinjam->status == 'Selesai' && $hasReview)
    <div>Sudah Direview</div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="order-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Review By</th>
              <th>Aset</th>
              <th>Pinjam No</th>
              <th>Review</th>
              <th>Rate</th>
              <th>Waktu</th>
              <th>Status</th>
              <th>Opsi</th>
            </tr>
          </thead>
          <tbody>
            @php
            $reviews = App\Models\AsetReview::where('user_id', auth()->user()->id)
            ->where('pinjam_id', $pinjam->id)
            ->get();
            @endphp
            @foreach($reviews as $review)
            <tr>
              <td>{{$review->user_info['user_nama']}}</td>
              <td>{{$review->asets->title}}</td>
              <td>{{$review->pinjams->pinjam_number}}</td>
              <td>{{$review->review}}</td>
              <td>
                <ul style="list-style:none" class="d-flex">
                  @for($i=1; $i<=5;$i++) @if($review->rate >=$i)
                    <li style="float:left;color:#F7941D;"><i class="fa fa-star"></i></li>
                    @else
                    <li style="float:left;color:#F7941D;"><i class="far fa-star"></i></li>
                    @endif
                    @endfor
                </ul>
              </td>
              <td>{{$review->created_at->setTimezone('Asia/Jakarta')->format('d-m-Y')}}, {{$review->created_at->setTimezone('Asia/Jakarta')->format('H:i')}} </td>
              <td>
                @if($review->status=='active')
                <span class="badge badge-success">{{$review->status}}</span>
                @else
                <span class="badge badge-warning">{{$review->status}}</span>
                @endif
              </td>
              <td>
                <a href="{{route('user.asetreview.edit',$review->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                @if($review->pinjams->status !='Cek Kondisi Aset' && $review->pinjams->status !='Selesai')
                <form method="POST" action="{{route('user.asetreview.delete',[$review->id])}}">
                  @csrf
                  @method('delete')
                  <button class="btn btn-danger btn-sm dltBtn" data-id="{{$review->id}}" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                </form>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @else
      </div>
    </div>
    @endif
    @endif

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
  $(document).ready(function() {
    if (window.location.hash === "#review-section") {
      $('html, body').animate({
        scrollTop: $("#review-section").offset().top
      }, 1000, 'swing');
    }

    $('[data-toggle="tooltip"]').tooltip();
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