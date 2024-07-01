<!DOCTYPE html>
<html lang="en">

<head>
  <title>MSI || Login</title>
  @include('backend.layouts.head')

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9 mt-5">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              @php
              $settings = DB::table('settings')->first();
              @endphp

              <div class="col-lg-6 d-none d-lg-block bg-login-image" style="background: url('{{ $settings->logo }}'); background-position: center; background-size: contain;background-repeat: no-repeat;"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Selamat Datang Kembali!</h1>
                  </div>
                  <form class="user" method="POST" action="{{ route('login.submit') }}">
                    @csrf
                    <div class="form-group">
                      <input type="user_nid" class="form-control form-control-user @error('user_nid') is-invalid @enderror" name="user_nid" value="{{ old('user_nid') }}" placeholder="User NID" autofocus>
                      @error('user_nid')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" id="exampleInputPassword" placeholder="Password" name="password" required autocomplete="current-password">
                      @error('password')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                      @enderror

                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                      Login
                    </button>
                  </form>
                  <hr>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>
</body>

</html>