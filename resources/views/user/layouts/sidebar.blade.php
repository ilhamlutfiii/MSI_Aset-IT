<ul class="navbar-nav bg-light sidebar sidebar-light accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('user')}}">
        <div class="sidebar-brand-icon">
            @php
            $settings=DB::table('settings')->get();
            @endphp
            <img src="@foreach($settings as $data) {{$data->photo}} @endforeach" style="width: 55px; height: 55px;" alt="logo">
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{route('user')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Pinjaman
    </div>
    <!--Pinjams -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('user.pinjam.index')}}">
            <i class="fas fa-clipboard-list fa-chart-area"></i>
            <span>Pinjamanku</span>
        </a>
    </li>

    <!-- Reviews -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('user.asetreview.index')}}">
            <i class="fas fa-comments"></i>
            <span>Reviews</span></a>
    </li>

    <!-- Bantuan -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#bantuanCollapse" aria-expanded="true" aria-controls="bantuanCollapse">
            <i class="fas fa-question-circle"></i>
            <span>Bantuan</span>
        </a>
        <div id="bantuanCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Opsi Bantuan:</h6>
                <a class="collapse-item" href="{{route('user.bantuan.index')}}">Perbaikan</a>
                <a class="collapse-item" href="{{route('user.bantuan.kontak')}}">Hubungi Staff IT</a>
            </div>
        </div>
    </li>

</ul>