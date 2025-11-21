<header class="header">
    <div class="logo">
        <img src="{{ asset('image/logo_papacino.jpg') }}" alt="Papacino Logo" class="logo-img">
        <div class="logo-text">Papacino Snacks & Drinks</div>
    </div>

    <nav class="nav-menu">
        <a href="{{ url('/menu') }}" class="nav-item ">
            <img src="{{ asset('image/icon_menu.png') }}">
            <span>Menu</span>
        </a>

        <a href="{{ url('/pengeluaran') }}" class="nav-item ">
            <img src="{{ asset('image/icon_pengeluaran.png') }}">
            <span>Pengeluaran</span>
        </a>

        <a href="{{ url('/pemasukan') }}" class="nav-item ">
            <img src="{{ asset('image/icon_pemasukan.png') }}">
            <span>Pemasukan</span>
        </a>

        <a href="{{ url('/accounts') }}" class="nav-item ">
            <img src="{{ asset('image/icon_akun.png') }}">
            <span>Akun</span>
        </a>

        <a href="" class="nav-item owner">
            <img src="{{ asset('image/icon_owner.png') }}">
            <span>Owner</span>
        </a>

        <a href="" class="nav-item logout">
            <img src="{{ asset('image/icon_logout.png') }}">
            <span>Logout</span>
        </a>
    </nav>
</header>