<!DOCTYPE html>
<html lang="en">

<head>
  <title>MSI || Login</title>
  @include('backend.layouts.head')

</head>

<body style="background-image: url('../storage/photos/bg.jpg'); background-repeat: no-repeat; background-size: cover;">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9 mt-5">

        <div class="o-hidden border-0 shadow-lg my-5">
          <div class="p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">

              @php
              $settings = DB::table('settings')->first();
              @endphp

              
              <div class="col-lg-6 d-none d-lg-block bg-light" style="background: url('{{ $settings->logo }}'); background-position: center; background-size: 400px 120px; background-repeat: no-repeat;"></div>
              <div class="col-lg-6">
                <div class="pt-4 pb-4 pl-5 pr-5 " style="background-color:rgba(0, 0, 0, 0.5);">
                  <div class="text-center">
                    <h2 class="text-white">Selamat Datang!</h2>
                    <img src="../storage/photos/user.png" style="max-width: 100px;">
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