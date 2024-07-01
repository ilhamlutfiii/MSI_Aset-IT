@extends('backend.layouts.master')

@section('main-content')

@if ($errors->any())
<div class="alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

<div class="card shadow ml-2 mr-2">
  <h5 class="card-header">Edit User</h5>
  <div class="card-body">
    <form method="post" action="{{ route('users.update', $users->id) }}">
      @csrf
      @method('PATCH')
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="inputTitle" class="col-form-label">User NID</label>
            <input id="inputTitle" type="text" name="user_nid" placeholder="Masukkan User NID ..." value="{{ $users->user_nid }}" class="form-control">
            @error('user_nid')
            <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="inputTitle" class="col-form-label">Nama User</label>
            <input id="inputTitle" type="text" name="user_nama" placeholder="Masukkan Nama User ..." value="{{ $users->user_nama }}" class="form-control">
            @error('user_nama')
            <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="inputTitle" class="col-form-label">Jabatan</label>
            <input id="inputTitle" type="text" name="jabatan" placeholder="Masukkan Jabatan ..." value="{{ $users->jabatan }}" class="form-control">
            @error('jabatan')
            <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="inputTitle" class="col-form-label">Bidang</label>
            <input id="inputTitle" type="text" name="bidang" placeholder="Masukkan Bidang ..." value="{{ $users->bidang }}" class="form-control">
            @error('bidang')
            <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="inputTitle" class="col-form-label">Fungsi</label>
            <input id="inputTitle" type="text" name="fungsi" placeholder="Masukkan Fungsi ..." value="{{ $users->fungsi }}" class="form-control">
            @error('fungsi')
            <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          <!-- <div class="form-group">
            <label for="jabatan" class="col-form-label">Jabatan</label>
            <select name="jabatan_id" class="form-control">
                <option value="">---- Pilih Jabatan ----</option>
                @foreach($jabatans as $jabatan)
                        <option value="{{ $jabatan->jabatan_id }}" {{ $jabatan->jabatan_id == $users->jabatan_id ? 'selected' : '' }}>
                            {{ $jabatan->jabatan_name }}
                        </option>
                @endforeach
            </select>
          @error('jabatan_id')
          <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
            <label for="bidang" class="col-form-label">Bidang</label>
            <select name="bidang_id" class="form-control">
                <option value="">---- Pilih Bidang ----</option>
                @foreach($bidangs as $bidang)
                        <option value="{{ $bidang->bidang_id }}" {{ $bidang->bidang_id == $users->bidang_id ? 'selected' : '' }}>
                            {{ $bidang->bidang_name }}
                        </option>
                @endforeach
            </select>
          @error('bidang_id')
          <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
            <label for="fungsi" class="col-form-label">Fungsi</label>
            <select name="fungsi_id" class="form-control">
                <option value="">---- Pilih Fungsi ----</option>
                @foreach($fungsis as $fungsi)
                        <option value="{{ $fungsi->fungsi_id }}" {{ $fungsi->fungsi_id == $users->fungsi_id ? 'selected' : '' }}>
                            {{ $fungsi->fungsi_name }}
                        </option>
                @endforeach
            </select>
          @error('fungsi_id')
          <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
         -->
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="inputPhoto" class="col-form-label">Foto</label>
            <div><img id="preview" src="{{ $users->photo }}" alt="Preview Image" style="max-width: 200px;"></div>
            <div class="input-group mt-2">
              <span class="input-group-btn">
                <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary" style="color: white;">
                  <i class="fa fa-image"></i> Ganti
                </a>
              </span>
              <input id="thumbnail" class="form-control" type="text" name="photo" value="{{ $users->photo }}">
            </div>
            <div id="holder" style="margin-top:15px;max-height:100px;"></div>
            
            @error('photo')
            <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="role" class="col-form-label">Role</label>
            <select name="role" class="form-control" id="role">
              <option value="">---- Pilih Role ----</option>
              <option value="admin" {{ $users->role == 'admin' ? 'selected' : '' }}>Admin</option>
              <option value="user" {{ $users->role == 'user' ? 'selected' : '' }}>User</option>
            </select>
            @error('role')
            <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group" id="noTelpField" style="{{ $users->role == 'admin' ? '' : 'display:none' }}">
            <label for="inputTelp" class="col-form-label">No Telepon</label>
            <input id="inputTelp" type="number" name="noTelpon" placeholder="Masukkan No Telpon ... (ex. 08....)" value="{{ old('noTelpon', $users->noTelpon) }}" class="form-control">
            @error('noTelpon')
            <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="status" class="col-form-label">Status</label>
            <select name="status" class="form-control">
              <option value="active" {{ $users->status == 'active' ? 'selected' : '' }}>Aktif</option>
              <option value="inactive" {{ $users->status == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
            @error('status')
            <span class="text-danger">{{ $message }}</span>
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

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
  $('#lfm').filemanager('image');

  $('#role').change(function() {
    if ($(this).val() == 'admin') {
      $('#noTelpField').show();
    } else {
      $('#noTelpField').hide();
    }
  });
</script>
@endpush