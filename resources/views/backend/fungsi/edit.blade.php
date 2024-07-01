@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Edit Fungsi</h5>
    <div class="card-body">
      <form method="post" action="{{route('fungsis.update',$fungsis->fungsi_id)}}">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Nama Fungsi</label>
        <input id="inputTitle" type="text" name="fungsi_name" placeholder="Enter Nama fungsi"  value="{{$fungsis->fungsi_name}}" class="form-control">
        @error('fungsi_name')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        
        <div class="form-group">
          <label for="unit" class="col-form-label">Nama Unit</label>
          <select name="unit_id" class="form-control" required>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->unit_id }}" {{ $unit->unit_id == $fungsis->unit_id ? 'selected' : '' }}>
                            {{ $unit->unit_nama }}
                        </option>
                    @endforeach
                </select>
        @error('fungsi_name')
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
