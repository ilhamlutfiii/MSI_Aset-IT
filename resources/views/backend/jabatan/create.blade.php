@extends('backend.layouts.master')

@section('main-content')

<div class="card shadow ml-2 mr-2">
    <h5 class="card-header">Tambah Jabatan</h5>
    <div class="card-body">
      <form method="post" action="{{route('jabatans.store')}}">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Nama Jabatan</label>
        <input id="inputTitle" type="text" name="jabatan_name" placeholder="Masukkan Nama Jabatan ..."  value="{{old('jabatan_name')}}" class="form-control">
        @error('jabatan_name')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning">Reset</button>
           <button class="btn btn-success" type="submit">Submit</button>
        </div>
      </form>
    </div>
</div>

@endsection