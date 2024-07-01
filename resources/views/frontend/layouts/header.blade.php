<header class="header asetit">
    <!-- Topbar -->
    <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-12">
                    <!-- Top Left -->
                    <div class="top-left">
                        <ul class="list-main">
                            @php
                            $settings=DB::table('settings')->get();
                            @endphp
                            <li><i class="ti-headphone-alt"></i>@foreach($settings as $data) {{$data->phone}} @endforeach</li>
                            <a href="{{route('cache.clear')}}" class=" btn-danger btn-sm mr-3 text-white">
                                <i class="ti-reload"></i> Hapus Cache
                            </a>
                        </ul>
                    </div>
                    <!--/ End Top Left -->
                </div>
                <div class="col-lg-6 col-md-12 col-12">
                    <!-- Top Right -->
                    <div class="right-content">
                        <ul class="list-main">
                            @auth
                            <li><i class="ti-power-off"></i> <a href="{{route('user.logout')}}">Logout</a></li>

                            @else
                            <li><i class="ti-power-off"></i><a href="{{route('login.form')}}">Login</a></li>
                            @endauth
                        </ul>
                    </div>
                    <!-- End Top Right -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Topbar -->
    <div class="middle-inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-12">
                    <!-- Logo -->
                    <div class="logo mt-0">
                        @php
                        $settings=DB::table('settings')->get();
                        @endphp
                        <a href="{{route('home')}}"><img src="@foreach($settings as $data) {{$data->logo}} @endforeach" style="max-width: 220%;" alt="logo"></a>
                    </div>
                    <!--/ End Logo -->
                    <div class="mobile-nav"></div>
                </div>
                <div class="col-lg-8 col-md-7 col-12">
                    <!-- Empty space for centering logo and search -->
                </div>
                <div class="col-lg-2 col-md-3 col-12">
                    <div class="right-bar d-flex align-items-center">

                        <div class="sinlge-bar asetitping">
                            <a class="single-icon"><i class="ti-shopping-cart"></i> <span class="total-count">{{count(Helper::getAllAsetFromCart())}}</span></a>
                            <!-- Shopping Item -->
                            @auth
                            <div class="asetitping-item">
                                <div class="dropdown-cart-header mb-5">
                                    <a href="{{route('cart')}}">Lihat Keranjang</a>
                                </div>
                                <ul class="asetitping-list">
                                    {{-- {{Helper::getAllAsetFromCart()}} --}}
                                    @foreach(Helper::getAllAsetFromCart() as $data)
                                    @php
                                    $photo=explode(',',$data->aset['photo']);
                                    @endphp
                                    <li>
                                        <a href="{{route('cart-delete',$data->id)}}" class="remove" title="Remove this item"><i class="fa fa-remove"> Remove</i></a>
                                        <a class="cart-img" href="{{route('aset-detail',$data->aset['slug'])}}"><img src="{{$photo[0]}}" alt="{{$photo[0]}}"></a>
                                        <h4><a href="{{route('aset-detail',$data->aset['slug'])}}">{{$data->aset['title']}}</a></h4>
                                    </li>
                                    @endforeach
                                </ul>
                                <div class="bottom">
                                    <div class="total">
                                        <span>Total</span>
                                        <span class="total-amount">{{count(Helper::getAllAsetFromCart())}} Aset</span>
                                    </div>
                                    <a href="{{route('cart')}}" class="btn animate">Keranjang</a>
                                </div>
                            </div>
                            @endauth
                            <!--/ End Shopping Item -->
                        </div>

                        <div class="sinlge-bar asetitping">
                            <a class="single-icon" id="searchDropdown">
                                <a class="single-icon"><i class="ti-search"></i></a>
                            </a>

                            <div class="asetitping-item">
                                <div class="dropdown-cart-header" aria-labelledby="searchDropdown">
                                    <select class="form-control mb-2 r-0">
                                        <option>Kategori</option>
                                        @foreach(Helper::getAllCategory() as $cat)
                                        <option>{{$cat->title}}</option>
                                        @endforeach
                                    </select>
                                    <form method="POST" action="{{route('aset.search')}}">
                                        @csrf
                                        <input name="search" placeholder="Cari Aset IT....." type="search" class="form-control mb-2">
                                        <button class="btn btn-primary btn-block" type="submit"><i class="ti-search"></i> Cari</button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header Inner -->
    <div class="header-inner">
        <div class="container">
            <div class="cat-nav-head">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <div class="menu-area">
                            <!-- Main Menu -->
                            <nav class="navbar navbar-expand-lg">
                                <div class="navbar-collapse">
                                    <div class="nav-inner">
                                        <ul class="nav main-menu menu navbar-nav">
                                            <li class="{{Request::path()=='home' ? 'active' : ''}}"><a href="{{route('home')}}">Home</a></li>
                                            <li class="@if(Request::path()=='aset-grids'||Request::path()=='aset-lists')  active  @endif"><a href="{{route('aset-grids')}}">Aset IT</a></li>
                                            {{Helper::getHeaderCategory()}}
                                            @auth
                                            @if(Auth::user()->role=='admin')
                                            <li> <a href="{{route('admin')}}">Dashboard</a></li>
                                            @else
                                            <li> <a href="{{route('user')}}">Dashboard</a></li>
                                            @endif
                                            @endauth
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                            <!--/ End Main Menu -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ End Header Inner -->
</header>