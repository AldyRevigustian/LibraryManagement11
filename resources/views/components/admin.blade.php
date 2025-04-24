@section('sidebar')
    <li class="sidebar-title">Menu</li>

    <li class="sidebar-item {{ request()->is('admin/dashboard*') ? 'active' : '' }}">
        <a href="{{ route('admin.dashboard') }}" class='sidebar-link'>
            <i class="bi bi-house-fill"></i>
            <span>Dashboard</span>
        </a>
    </li>


    <li class="sidebar-item has-sub {{ request()->is('admin/master*') ? 'active' : '' }}">
        <a href="#" class="sidebar-link">
            <i class="bi bi-collection-fill"></i>
            <span>Master Data</span>
        </a>
        <ul class="submenu {{ request()->is('admin/master*') ? 'active' : '' }}">
            <li class="submenu-item {{ request()->is('admin/master/anggota') ? 'active' : '' }}">
                <a href="{{ route('admin.anggota') }}">Data Anggota</a>
            </li>
            @if (Auth::user()->role == 'superadmin')
                <li class="submenu-item {{ request()->is('admin/master/administrator*') ? 'active' : '' }}">
                    <a href="{{ route('admin.administrator') }}">Data Admin</a>
                </li>
            @endif
        </ul>
    </li>

    <li class="sidebar-item has-sub {{ request()->is('admin/katalog*') ? 'active' : '' }}">
        <a href="#" class="sidebar-link">
            <i class="bi bi-book-fill"></i>
            <span>Katalog Buku</span>
        </a>
        <ul class="submenu {{ request()->is('admin/katalog*') ? 'active' : '' }}">
            <li class="submenu-item {{ request()->is('admin/katalog/kategori*') ? 'active' : '' }}">
                <a href="{{ route('admin.kategori') }}">Data Kategori</a>
            </li>
            <li class="submenu-item {{ request()->is('admin/katalog/penerbit*') ? 'active' : '' }}">
                <a href="{{ route('admin.penerbit') }}">Data Penerbit</a>
            </li>
            <li class="submenu-item {{ request()->is('admin/katalog/buku*') ? 'active' : '' }}">
                <a href="{{ route('admin.buku') }}">Data Buku</a>
            </li>
        </ul>
    </li>

    <li class="sidebar-item has-sub {{ request()->is('admin/transaksi*') ? 'active' : '' }}">
        <a href="#" class="sidebar-link">
            <i class="bi bi-arrow-left-right"></i>
            <span>Transaksi</span>
        </a>
        <ul class="submenu {{ request()->is('admin/transaksi*') ? 'active' : '' }}">
            <li class="submenu-item {{ request()->is('admin/transaksi/peminjaman*') ? 'active' : '' }}">
                <a href="{{ route('admin.peminjaman') }}">Data Peminjaman</a>
            </li>
            <li class="submenu-item {{ request()->is('admin/transaksi/pengembalian*') ? 'active' : '' }}">
                <a href="{{ route('admin.pengembalian') }}">Data Pengembalian</a>
            </li>
        </ul>
    </li>

    <li class="sidebar-item {{ request()->is('admin/laporan*') ? 'active' : '' }}">
        <a href="{{ route('admin.laporan') }}" class='sidebar-link'>
            <i class="bi bi-file-earmark-excel-fill"></i>
            <span>Laporan Perpustakaan</span>
        </a>
    </li>


    <li class="sidebar-item {{ request()->is('admin/aturan*') ? 'active' : '' }}">
        <a href="{{ route('admin.aturan') }}" class='sidebar-link'>
            <i class="bi bi-info-lg"></i>
            <span>Aturan Aplikasi</span>
        </a>
    </li>

    <li class="sidebar-item" style="margin-bottom:5rem;">
        <a href="{{ route('admin.logout') }}"
            onclick="event.preventDefault();
document.getElementById('logout-form').submit();" class='sidebar-link'>
            <i class="bi bi-box-arrow-in-left"></i>
            <span>Logout</span>
        </a>
    </li>
    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
        @csrf
    </form>
@endsection

@section('navbar')
    <nav class="navbar navbar-expand navbar-light navbar-top">
        <div class="container-fluid">
            <a href="#" class="burger-btn d-block">
                <i class="bi bi-justify fs-3"></i>
            </a>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <div class="user-menu navbar-nav ms-auto mb-lg-0 align-items-center" >
                    <div class="user-name text-end me-3">
                        <h6 class="mb-0 text-gray-600">{{ Auth::user()->nama }}</h6>
                        <p class="mb-0 text-sm text-gray-600" style="line-height: 10px;">{{ Auth::user()->role }}</p>
                    </div>
                    <div class="user-img d-flex align-items-center">
                        <div class="avatar avatar-md">
                            <img src="/assets/images/faces/2.jpg">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
@endsection
