@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Edit Jabatan</h5>
    <div class="card-body">
      <form method="post" action="{{route('jabatans.update',$jabatan->jabatan_id)}}">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Nama Jabatan</label>
        <input id="inputTitle" type="text" name="jabatan_name" placeholder="Enter Nama Jabatan"  value="{{$jabatan->jabatan_name}}" class="form-control">
        @error('jabatan_name')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group mb-3">
           <button class="btn btn-success" type="submit">Update</button>
        </div>
      </form>
    </div>
</div>
@endsection
