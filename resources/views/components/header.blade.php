<header class="header">
    <div class="logo">
        <img src="{{ asset('logo_papacino.jpg') }}" alt="Papacino Logo" class="logo-img">
        <!-- <img src="views/logo_papacino.jpg" alt="Papacino Logo" class="logo-img"> -->
        <div class="logo-text">Papacino Snacks & Drinks</div>
    </div>

    <nav class="nav-menu">
        {{--
            Logika untuk 'active' class di Laravel:
            menggunakan fungsi request()->is('nama_route') 
            untuk mengecek halaman mana yang sedang aktif.
        --}}
        <a href=""
            class="nav-item ">
            <span>&#9776;</span>
            <span>Menu</span>
        </a>

        <a href=""
            class="nav-item ">
            <span>$</span>
            <span>Expenses</span>
        </a>

        <a href=""
            class="nav-item ">
            <span>$</span>
            <span>Incomes</span>
        </a>

        <a href=""
            class="nav-item ">
            <span>&#128100;</span>
            <span>Accounts</span>
        </a>

        <a href="#" class="nav-item owner">
            <span>&#128100;</span>
            <span>Owner</span>
        </a>

        <a href="#" class="nav-item logout">
            <span>&#10162;</span>
            <span>Logout</span>
        </a>
    </nav>
</header>