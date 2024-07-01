@extends('backend.layouts.master')

@section('title','Admin Profile')

@section('main-content')

<div class="card  shadow ml-2 mr-2">
    <div class="row">
        <div class="col-md-12">
            @include('backend.layouts.notification')
        </div>
    </div>
    <div class="card-header py-3">
        <h4 class="font-weight-bold float-left">Profil</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    @if($profile->photo)
                    <img class=" img-fluid mt-4" style="max-width:200px;margin:auto;" src="{{$profile->photo}}" alt="profile picture">
                    @else
                    <img class="img-fluid mt-4" style="max-width:200px;margin:auto;" src="{{asset('backend/img/avatar.png')}}" alt="profile picture">
                    @endif
                    <div class="card-body mt-2 ml-2">
                        <h5 class="card-title text-left"><small><i class="fas fa-user"></i> {{$profile->user_nama}}</small></h5>
                        <p class="card-text text-left"><small><i class="fas fa-id-card"></i> {{$profile->user_nid}}</small></p>
                        <p class="card-text text-left"><small class="text-muted"><i class="fas fa-hammer"></i> {{$profile->role}}</small></p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <form class="border px-4 pt-2 pb-3" method="POST" action="{{route('profile-update',$profile->id)}}">
                    @csrf

                    <div class="form-group">
                        <label for="inputTitle" class="col-form-label">User NID</label>
                        <input id="inputTitle" type="text" name="user_nid" placeholder="Masukkan User NID ..." value="{{$profile->user_nid}}" class="form-control">
                        @error('user_nid')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="inputTitle" class="col-form-label">Nama User</label>
                        <input id="inputTitle" type="text" name="user_nama" placeholder="Masukkan Nama User ..." value="{{$profile->user_nama}}" class="form-control">
                        @error('user_nama')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="inputPhoto" class="col-form-label">Foto</label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary" style="color: white;">
                                    <i class="fa fa-image"></i>Upload
                                </a>
                            </span>
                            <input id="thumbnail" class="form-control" type="text" name="photo" value="{{$profile->photo}}">
                        </div>
                        @error('photo')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="role" class="col-form-label">Role</label>
                        <div class="aset-des">
                            <div class="short">
                                <h4>{{$profile->role}}</h4>
                            </div>
                        </div>
                        @error('role')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success btn-sm">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

<style>
    .breadcrumbs {
        list-style: none;
    }

    .breadcrumbs li {
        float: left;
        margin-right: 10px;
    }

    .breadcrumbs li a:hover {
        text-decoration: none;
    }

    .breadcrumbs li .active {
        color: red;
    }

    .breadcrumbs li+li:before {
        content: "/\00a0";
    }

    i {
        font-size: 14px;
        padding-right: 8px;
    }
</style>

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
    $('#lfm').filemanager('image');
</script>
@endpush