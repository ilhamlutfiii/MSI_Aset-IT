<ul class="navbar-nav bg-light sidebar sidebar-light accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center " href="{{route('admin')}}">
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
    <a class="nav-link" href="{{route('admin')}}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">
  <!-- Heading -->
  <div class="sidebar-heading">
    Manajemen
  </div>

  <!-- Users -->
  <li class="nav-item">
    <a class="nav-link" href="{{route('users.index')}}">
      <i class="fas fa-user"></i>
      <span>User</span>
    </a>
  </li>
  <!-- Categories -->
  <li class="nav-item">
    <a class="nav-link" href="{{route('category.index')}}">
      <i class="fas fa-sitemap"></i>
      <span>Kategori</span>
    </a>
  </li>

  <!-- Aset IT -->
  <li class="nav-item">
    <a class="nav-link" href="{{route('aset.index')}}">
      <i class="fas fa-desktop"></i>
      <span>Aset</span>
    </a>
  </li>

  <!--Peminjaman -->
  <li class="nav-item">
    <a class="nav-link" href="{{route('pinjam.index')}}">
      <i class="fas fa-clipboard-list"></i>
      <span>Peminjaman</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="{{route('maintenance.index')}}">
      <i class="fas fa-wrench"></i>
      <span>Maintenance</span>
    </a>
  </li>

  <!-- Reviews -->
  <li class="nav-item">
    <a class="nav-link" href="{{route('review.index')}}">
      <i class="fas fa-comments"></i>
      <span>Reviews</span></a>
  </li>

  <!-- Divider -->
  <!-- <hr class="sidebar-divider d-none d-md-block"> -->
  <!-- Heading -->
  <!-- <div class="sidebar-heading">
    General Settings
  </div> -->

  <!-- General settings -->
  <!-- <li class="nav-item">
    <a class="nav-link" href="{{route('settings')}}">
      <i class="fas fa-cog"></i>
      <span>Settings</span></a>
  </li> -->



</ul>