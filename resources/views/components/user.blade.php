@section('sidebar')
    <li class="sidebar-title">Menu</li>

    <li class="sidebar-item {{ request()->is('user/dashboard*') ? 'active' : '' }} ">
        <a href="{{ route('user.dashboard') }}" class='sidebar-link'>
            <i class="bi bi-house-fill"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="sidebar-item {{ request()->is('user/peminjaman*') ? 'active' : '' }} ">
        <a href="{{ route('user.peminjaman') }}" class='sidebar-link'>
            <i class="bi bi-arrow-left"></i>
            <span>Peminjaman</span>
        </a>
    </li>

    <li class="sidebar-item {{ request()->is('user/pengembalian*') ? 'active' : '' }} ">
        <a href="{{ route('user.pengembalian') }}" class='sidebar-link'>
            <i class="bi bi-arrow-left-right"></i>
            <span>Pengembalian</span>
        </a>
    </li>

    <li class="sidebar-item {{ request()->is('user/profile*') ? 'active' : '' }} ">
        <a href="{{ route('user.profile') }}" class='sidebar-link'>
            <i class="bi bi-person-fill"></i>
            <span>Profile</span>
        </a>
    </li>



    <li class="sidebar-item {{ request()->is('user/info*') ? 'active' : '' }} ">
        <a href="{{ route('user.info') }}" class='sidebar-link'>
            <i class="bi bi-info-circle-fill"></i>
            <span>Info Aplikasi</span>
        </a>
    </li>


    <li class="sidebar-item" style="margin-bottom:5rem;">
        <a href="{{ route('logout') }}" onclick="event.preventDefault();
document.getElementById('logout-form').submit();"
            class='sidebar-link'>
            <i class="bi bi-box-arrow-in-left"></i>
            <span>Logout</span>
        </a>
    </li>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
@endsection

@section('navbar')
    <nav class="navbar navbar-expand navbar-light navbar-top">
        <div class="container-fluid">
            <a href="#" class="burger-btn d-block">
                <i class="bi bi-justify fs-3"></i>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="user-menu d-flex">
                    <div class="user-name text-end me-3">
                        <h6 class="mb-0 text-gray-600">{{ Auth::user()->fullname }}</h6>
                        <p class="mb-0 text-sm text-gray-600">{{ Auth::user()->username }}</p>
                    </div>
                    <div class="user-img d-flex align-items-center">
                        <div class="avatar avatar-md">
                            <img src="{{ Auth::user()->foto }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
@endsection
