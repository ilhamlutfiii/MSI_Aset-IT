@extends('backend.layouts.master')

@section('main-content')

<div class="card shadow ml-2 mr-2">
  <h5 class="card-header">Tambah Aset</h5>
  <div class="card-body">
    <form method="post" action="{{route('aset.store')}}" enctype="multipart/form-data">
      {{csrf_field()}}

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="inputTitle" class="col-form-label">Nama Aset<span class="text-danger">*</span></label>
            <input id="inputTitle" type="text" name="title" placeholder="Masukkan nama aset.." value="{{old('title')}}" class="form-control">
            @error('title')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="summary" class="col-form-label">Ringkasan <span class="text-danger">*</span></label>
            <textarea class="form-control" id="summary" placeholder="Masukkan ringkasan.." name="summary">{{old('summary')}}</textarea>
            @error('summary')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="description" class="col-form-label">Deskripsi <span class="text-danger">*</span></label>
            <textarea class="form-control" id="description" placeholder="Masukkan deskripsi.." name="description">{{old('description')}}</textarea>
            @error('description')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="cat_id">Kategori <span class="text-danger">*</span></label>
            <select name="cat_id" id="cat_id" class="form-control">
              <option value="">--- Pilih Kategori ---</option>
              @foreach($categories as $key=>$cat_data)
              <option value='{{$cat_data->id}}'>{{$cat_data->title}}</option>
              @endforeach
            </select>
            @error('cat_id')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>

          <div class="form-group d-none" id="child_cat_div">
            <label for="child_cat_id">Sub Kategori <span class="text-danger">*</span></label>
            <select name="child_cat_id" id="child_cat_id" class="form-control">
              <option value="">--- Pilih Sub Kategori ---</option>
            </select>
            @error('child_cat_id')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
        </div>

        <div class="col-md-6 mt-2">
          <div class="form-group">
            <label for="stock">Jumlah Aset <span class="text-danger">*</span></label>
            <input id="quantity" type="number" name="stock" min="0" placeholder="Masukkan jumlah aset.." value="{{old('stock')}}" class="form-control">
            @error('stock')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>

          <div class="form-group ">
            <label for="rentang">Rentang Perbaikan<span class="text-danger">*</span></label>
            <input id="rentang" type="number" name="rentang" min="0" placeholder="Masukkan rentang perbaikan dalam hari.." value="{{old('rentang')}}" class="form-control">
            @error('rentang')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>

          <div class="form-group ">
            <label for="ganti">Rentang Pergantian<span class="text-danger">*</span></label>
            <input id="ganti" type="number" name="ganti" min="0" placeholder="Masukkan rentang pergantian dalam bulan.." value="{{old('ganti')}}" class="form-control">
            @error('ganti')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="inputPhoto" class="col-form-label">Foto</label>
            <div class="input-group">
              <span class="input-group-btn">
                <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary" style="color: white;">
                  <i class="fas fa-image"></i> Upload
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

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>
    $('#lfm').filemanager('image');
</script>

<script>
  
  $('#cat_id').change(function() {
    var cat_id = $(this).val();
    if (cat_id != null) {
      $.ajax({
        url: "/admin/category/" + cat_id + "/child",
        data: {
          _token: "{{csrf_token()}}",
          id: cat_id
        },
        type: "POST",
        success: function(response) {
          if (typeof(response) != 'object') {
            response = $.parseJSON(response)
          }
          var html_option = "<option value=''>--- Pilih Sub Kategori ---</option>"
          if (response.status) {
            var data = response.data;
            if (response.data) {
              $('#child_cat_div').removeClass('d-none');
              $.each(data, function(id, title) {
                html_option += "<option value='" + id + "'>" + title + "</option>"
              });
            }
          } else {
            $('#child_cat_div').addClass('d-none');
          }
          $('#child_cat_id').html(html_option);
        }
      });
    }
  });
</script>
@endpush
