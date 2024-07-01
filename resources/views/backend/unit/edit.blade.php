@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Edit Unit</h5>
    <div class="card-body">
      <form method="post" action="{{route('units.update',$unit->unit_id)}}">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Nama Unit</label>
        <input id="inputTitle" type="text" name="unit_nama" placeholder="Enter Nama Unit"  value="{{$unit->unit_nama}}" class="form-control">
        @error('unit_nama')
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
