<header class="header">
    <div class="logo">
        <img src="{{ asset('image/logo_papacino.jpg') }}" alt="Papacino Logo" class="logo-img">
        <div class="logo-text">Papacino Snacks & Drinks</div>
    </div>

    <nav class="nav-menu">
        <a href="{{ url('/menu') }}" class="nav-item ">
            <span>&#9776;</span>
            <span>Menu</span>
        </a>

        <a href="{{ url('/pengeluaran') }}" class="nav-item ">
            <span>$</span>
            <span>Pengeluaran</span>
        </a>

        <a href="{{ url('/pemasukan') }}" class="nav-item ">
            <span>$</span>
            <span>Pemasukan</span>
        </a>

        <a href="{{ url('/accounts') }}" class="nav-item ">
            <span>&#128100;</span>
            <span>Akun</span>
        </a>

        <a href="" class="nav-item owner">
            <span>&#128100;</span>
            <span>Owner</span>
        </a>

        <a href="" class="nav-item logout">
            <span>&#10162;</span>
            <span>Logout</span>
        </a>
    </nav>
</header>