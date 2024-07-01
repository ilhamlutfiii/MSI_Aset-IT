@extends('backend.layouts.master')

@section('main-content')

<div class="card shadow ml-2 mr-2">
  <h5 class="card-header">Tambah User</h5>
  <div class="card-body">
    <form method="post" action="{{route('users.store')}}">
      {{csrf_field()}}
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="inputTitle" class="col-form-label">User NID</label>
            <input id="inputTitle" type="text" name="user_nid" placeholder="Masukkan User NID ..." value="{{old('user_nid')}}" class="form-control">
            @error('user_nid')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="inputTitle" class="col-form-label">Nama User</label>
            <input id="inputTitle" type="text" name="user_nama" placeholder="Masukkan Nama User ..." value="{{old('user_nama')}}" class="form-control">
            @error('name')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="inputTitle" class="col-form-label">Jabatan</label>
            <input id="inputTitle" type="text" name="jabatan" placeholder="Masukkan Jabatan ..." value="{{old('jabatan')}}" class="form-control">
            @error('jabatan')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="inputTitle" class="col-form-label">Bidang</label>
            <input id="inputTitle" type="text" name="bidang" placeholder="Masukkan Bidang ..." value="{{old('bidang')}}" class="form-control">
            @error('bidang')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="inputTitle" class="col-form-label">Fungsi</label>
            <input id="inputTitle" type="text" name="fungsi" placeholder="Masukkan Fungsi ..." value="{{old('fungsi')}}" class="form-control">
            @error('fungsi')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>

          <!-- <div class="form-group">
        <label for="jabatan" class="col-form-label">Jabatan</label>
        <select name="jabatan_id" class="form-control" required>
          <option value="">---- Pilih Jabatan ----</option>
          @foreach ($jabatans as $jabatan)
          <option value="{{ $jabatan->jabatan_id }}">{{ $jabatan->jabatan_name }}</option>
          @endforeach
        </select>
        @error('jabatan_name')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="bidang" class="col-form-label">Bidang</label>
        <select name="bidang_id" class="form-control" required>
          <option value="">---- Pilih Bidang ----</option>
          @foreach ($bidangs as $bidang)
          <option value="{{ $bidang->bidang_id }}">{{ $bidang->bidang_name }}</option>
          @endforeach
        </select>
        @error('bidang_name')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="fungsi" class="col-form-label">Fungsi</label>
        <select name="fungsi_id" class="form-control" required>
          <option value="">---- Pilih Fungsi ----</option>
          @foreach ($fungsis as $fungsi)
          <option value="{{ $fungsi->fungsi_id }}">{{ $fungsi->fungsi_name }}</option>
          @endforeach
        </select>
        @error('fungsi_name')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div> -->
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label for="inputPassword" class="col-form-label">Password</label>
            <input id="inputPassword" type="password" name="password" placeholder="Masukkan Password..." value="{{old('password')}}" class="form-control">
            @error('password')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="inputPhoto" class="col-form-label">Foto</label>
            <div class="input-group">
              <span class="input-group-btn">
                <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary" style="color: white;">
                  <i class="fa fa-image"></i> Upload
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
            <label for="role" class="col-form-label">Role</label>
            <select name="role" id="role" class="form-control">
              <option value="">-- Pilih Role --</option>
              <option value="admin">Admin</option>
              <option value="user">User</option>
            </select>
            @error('role')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>

          <div class="form-group d-none" id="noTelpField">
            <label for="inputTelp" class="col-form-label">No Telepon</label>
            <input id="inputTelp" type="number" name="noTelpon" placeholder="Masukkan No Telpon ... (ex. 0812....)" value="{{old('noTelpon')}}" class="form-control">
            @error('noTelpon')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="status" class="col-form-label">Status</label>
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

  $('#role').change(function() {
    if ($(this).val() == 'admin') {
      $('#noTelpField').removeClass('d-none');
    } else {
      $('#noTelpField').addClass('d-none');
    }
  });
</script>
@endpush