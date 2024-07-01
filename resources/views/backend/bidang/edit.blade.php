@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Edit bidang</h5>
    <div class="card-body">
      <form method="post" action="{{route('bidangs.update',$bidang->bidang_id)}}">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Nama Bidang</label>
        <input id="inputTitle" type="text" name="bidang_name" placeholder="Enter Nama Bidang"  value="{{$bidang->bidang_name}}" class="form-control">
        @error('bidang_name')
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
