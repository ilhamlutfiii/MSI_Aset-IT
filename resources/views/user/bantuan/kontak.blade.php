@extends('user.layouts.master')

@section('title', 'Kontak Staff IT')

@section('main-content')
<div class="card shadow ml-2 mr-2 mb-2">
    <div class="card-header py-3">
    <h4 class="font-weight-bold float-left">Kontak Staff IT</h4>
    </div>
    <div class="card-body">
        <div class="container">
            <div class="row">
                @foreach ($users as $user)
                @if($user->role == 'admin')
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            @if($user->photo)
                            @php
                            $photo = explode(',', $user->photo);
                            @endphp
                            @if(isset($photo[0]))
                            <img src="{{$photo[0]}}" class="img-fluid mb-3" style="max-width:120px; max-height:120px;" alt="{{$user->photo}}">
                            @else
                            <img src="{{asset('backend/img/thumbnail-default.jpg')}}" class="img-fluid mb-3" style="max-width:100px; max-height:100px; border-radius: 50%;" alt="thumbnail-default.jpg">
                            @endif
                            @else
                            <img src="{{asset('backend/img/thumbnail-default.jpg')}}" class="img-fluid mb-3" style="max-width:100px; max-height:100px; border-radius: 50%;" alt="thumbnail-default.jpg">
                            @endif

                            <h5 class="card-title">{{$user->user_nama}}</h5>
                            <p class="card-text">{{$user->user_nid}}</p>
                            @php
                            $noTelpon = '+62' . substr($user->noTelpon, 1);
                            @endphp

                            <a href="https://wa.me/{{$noTelpon}}" target="_blank" class="btn btn-primary btn-sm float-center" data-toggle="tooltip" data-placement="bottom" title="Tambah User"><i class="fas fa-phone"></i> Hubungi</a>



                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection