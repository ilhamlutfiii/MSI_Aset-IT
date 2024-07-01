@extends('backend.layouts.master')

@section('main-content')

<div class="card shadow ml-2 mr-2">
    <h5 class="card-header">Tambah Fungsi</h5>
    <div class="card-body">
      <form method="post" action="{{route('fungsis.store')}}">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Nama Fungsi</label>
        <input id="inputTitle" type="text" name="fungsi_name" placeholder="Masukkan Nama fungsi ..."  value="{{old('fungsi_name')}}" class="form-control">
        @error('fungsi_name')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
          <label for="unit" class="col-form-label">Nama Unit</label>
          <select name="unit_id" class="form-control" required>
          <option value="">---- Pilih Unit-----</option>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->unit_id }}">{{ $unit->unit_nama }}</option>
                    @endforeach
                </select>
        @error('unit_nama')
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