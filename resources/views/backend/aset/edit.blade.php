@extends('backend.layouts.master')

@section('main-content')

<div class="card shadow ml-2 mr-2">
  <h5 class="card-header">Edit Aset</h5>
  <div class="card-body">
    <form method="post" action="{{route('aset.update',$aset->id)}}">
      @csrf
      @method('PATCH')
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="inputTitle" class="col-form-label">Nama Aset <span class="text-danger">*</span></label>
            <input id="inputTitle" type="text" name="title" placeholder="Masukkan nama aset.." value="{{$aset->title}}" class="form-control">
            @error('title')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="summary" class="col-form-label">Ringkasan <span class="text-danger">*</span></label>
            <textarea class="form-control" placeholder="Masukkan ringkasan.." id="summary" name="summary">{{$aset->summary}}</textarea>
            @error('summary')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="description" class="col-form-label">Deskripsi <span class="text-danger">*</span></label>
            <textarea class="form-control" placeholder="Masukkan deskripsi.." id="description" name="description">{{$aset->description}}</textarea>
            @error('description')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>

          {{-- {{$categories}} --}}

          <div class="form-group">
            <label for="cat_id">Kategori <span class="text-danger">*</span></label>
            <select name="cat_id" id="cat_id" class="form-control">
              <option value="">-- Pilih Kategori --</option>
              @foreach($categories as $key=>$cat_data)
              <option value='{{$cat_data->id}}' {{(($aset->cat_id==$cat_data->id)? 'selected' : '')}}>{{$cat_data->title}}</option>
              @endforeach
            </select>
          </div>
          @php
          $sub_cat_info=DB::table('categories')->select('title')->where('id',$aset->child_cat_id)->get();
          // dd($sub_cat_info);

          @endphp
          {{-- {{$aset->child_cat_id}} --}}
          <div class="form-group {{(($aset->child_cat_id)? '' : 'd-none')}}" id="child_cat_div">
            <label for="child_cat_id">Sub Kategori <span class="text-danger">*</span></label>
            <select name="child_cat_id" id="child_cat_id" class="form-control">
              <option value="">--Pilih Sub Kategori--</option>
            </select>
          </div>
        </div>

        <div class="col-md-6 mt-2">
          <div class="form-group">
            <label for="stock">Jumlah Aset <span class="text-danger">*</span></label>
            <input id="quantity" type="number" name="stock" min="0" placeholder="Masukkan jumlah aset.." value="{{$aset->stock}}" class="form-control">
            @error('stock')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="rentang">Rentang Perbaikan<span class="text-danger">*</span></label>
            <input id="rentang" type="number" name="rentang" min="0" placeholder="Masukkan rentang perbaikan dalam hari.." value="{{$aset->rentang}}" class="form-control">
            @error('rentang')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="ganti">Rentang Pergantian<span class="text-danger">*</span></label>
            <input id="ganti" type="number" name="ganti" min="0" placeholder="Masukkan rentang pergantian dalam bulan.." value="{{$aset->ganti}}" class="form-control">
            @error('ganti')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="inputPhoto" class="col-form-label">Foto <span class="text-danger">*</span>
          </label>
          <div>
          <img id="preview" src="{{ $aset->photo }}" alt="Preview Image" style="max-width: 200px;">
          </div>
            <div class="input-group mt-2">
              <span class="input-group-btn">
                <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                  <i class="fas fa-image"></i> Ganti
                </a>
              </span>
              <input id="thumbnail" class="form-control" type="text" name="photo" value="{{$aset->photo}}">
            </div>
            <div id="holder" style="margin-top:15px;max-height:100px;"></div>
            @error('photo')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
            <select name="status" class="form-control">
              <option value="active" {{(($aset->status=='active')? 'selected' : '')}}>Aktif</option>
              <option value="inactive" {{(($aset->status=='inactive')? 'selected' : '')}}>Tidak Aktif</option>
            </select>
            @error('status')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
        </div>
      </div>
      <div class="form-group mb-3 text-center">
        <button class="btn btn-success" type="submit">Update</button>
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
  var child_cat_id = '{{$aset->child_cat_id}}';
  // alert(child_cat_id);
  $('#cat_id').change(function() {
    var cat_id = $(this).val();

    if (cat_id != null) {
      // ajax call
      $.ajax({
        url: "/admin/category/" + cat_id + "/child",
        type: "POST",
        data: {
          _token: "{{csrf_token()}}"
        },
        success: function(response) {
          if (typeof(response) != 'object') {
            response = $.parseJSON(response);
          }
          var html_option = "<option value=''>--Select any one--</option>";
          if (response.status) {
            var data = response.data;
            if (response.data) {
              $('#child_cat_div').removeClass('d-none');
              $.each(data, function(id, title) {
                html_option += "<option value='" + id + "' " + (child_cat_id == id ? 'selected ' : '') + ">" + title + "</option>";
              });
            } else {
              console.log('no response data');
            }
          } else {
            $('#child_cat_div').addClass('d-none');
          }
          $('#child_cat_id').html(html_option);

        }
      });
    } else {

    }

  });
  if (child_cat_id != null) {
    $('#cat_id').change();
  }
</script>
@endpush