@extends('backend.layouts.master')

@section('main-content')

<div class="card shadow ml-2 mr-2">
  <h5 class="card-header">Tambah Kategori</h5>
  <div class="card-body">
    <form method="post" action="{{route('category.store')}}">
      {{csrf_field()}}

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="inputTitle" class="col-form-label">Nama Kategori <span class="text-danger">*</span></label>
            <input id="inputTitle" type="text" name="title" placeholder="Masukkan nama kategori.." value="{{old('title')}}" class="form-control">
            @error('title')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="summary">Ringkasan <span class="text-danger">*</span></label>
            <textarea class="form-control" cols="20" rows="10" id="summary" placeholder="Masukkan ringkasan.." name="summary">{{old('summary')}}</textarea>
            @error('summary')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label for="is_parent">Parent Kategori</label><br>
            <input type="checkbox" name='is_parent' id='is_parent' value='1' checked> Yes
          </div>
          {{-- {{$parent_cats}} --}}

          <div class="form-group d-none" id='parent_cat_div'>
            <label for="parent_id">Kategori <span class="text-danger">*</span></label>
            <select name="parent_id" class="form-control">
              <option value="">--Pilih Kategori--</option>
              @foreach($parent_cats as $key=>$parent_cat)
              <option value='{{$parent_cat->id}}'>{{$parent_cat->title}}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="inputPhoto" class="col-form-label">Foto <span class="text-danger">*</span></label>
            <div class="input-group">
              <span class="input-group-btn">
                <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary" style="color: white;">
                  <i class="fa fa-picture-o"></i> Upload
                </a>
              </span>
              <input id="thumbnail" class="form-control" type="text" name="photo" value="{{old('photo')}}">
            </div>
            <div id="holder" style="margin-top:15px;max-height:100px;"></div>

            @error('photo')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
            <select name="status" class="form-control">
              <option value="active">Aktif</option>
              <option value="inactive">Tidak Aktif</option>
            </select>
            @error('status')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
        </div>
      </div>
      <div class="form-group mb-3 text-center">
        <button type="reset" class="btn btn-warning">Reset</button>
        <button class="btn btn-success" type="submit">Submit</button>
      </div>
    </form>
  </div>
</div>

@endsection

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
  $('#lfm').filemanager('image');
</script>

<script>
  $('#is_parent').change(function() {
    var is_checked = $('#is_parent').prop('checked');
    // alert(is_checked);
    if (is_checked) {
      $('#parent_cat_div').addClass('d-none');
      $('#parent_cat_div').val('');
    } else {
      $('#parent_cat_div').removeClass('d-none');
    }
  })
</script>
@endpush