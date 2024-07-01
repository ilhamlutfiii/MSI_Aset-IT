@extends('user.layouts.master')

@section('main-content')
<div class="container mt-4">
    <div class="card shadow ml-2 mr-2">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-12 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            @php
                                $photo = $reviews->asets->photo ? explode(',', $reviews->asets->photo) : [];
                                $photoUrl = isset($photo[0]) ? $photo[0] : asset('backend/img/thumbnail-default.jpg');
                            @endphp
                            <img src="{{ $photoUrl }}" class="img-fluid" style="max-width: 335px;" alt="{{ $reviews->asets->title }}">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h4>{{ $reviews->asets->title }}</h4>
                            <p class="description">{!! $reviews->asets->summary !!}</p>
                            <p class="pinjam">No. Pinjam: {{ $reviews->pinjams->pinjam_number }}</p>

                            <div class="single-rating">
                                <div class="rating-author d-flex ">
                                    
                                <img src="{{ isset($reviews->user_info['photo']) ? $reviews->user_info['photo'] : asset('backend/img/avatar.png') }}" alt="User Photo" class="rounded-circle mr-3" style="width: 50px; height: 50px; ">
                                    <div class="user-info">
                                        <h6 class="font-weight-bold mb-0">{{ $reviews->user_info['user_nama'] ?? 'Unknown' }}</h6>
                                        <div class="ratings d-flex align-items-center">
                                            <ul class="rating-stars d-flex list-unstyled mb-0">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <li class="mr-1"><i class="{{ $i <= $reviews->rate ? 'fas fa-star' : 'far fa-star' }}"></i></li>
                                                @endfor
                                            </ul>
                                        </div>
                                        <p>{{ $reviews->review }}</p>
                                        <img id="preview" src="{{ asset('photoStatus/' . $reviews->pinjams->photoStatus) }}" alt="Preview Image" class="mr-3 mb-2" style="width: 100px; height: 100px">
                                        <h6>{{$reviews->created_at->setTimezone('Asia/Jakarta')->format('d-m-Y')}}, {{$reviews->created_at->setTimezone('Asia/Jakarta')->format('H:i')}}</h6>
                                    </div>
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
    .rating-stars i {
        color: #F7941D;
    }
</style>
@endpush

@push('scripts')
<script>
    document.getElementById('maintenanceButton').addEventListener('click', function() {
        document.getElementById('maintenanceForm').style.display = 'block';
    });

    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('preview');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endpush
