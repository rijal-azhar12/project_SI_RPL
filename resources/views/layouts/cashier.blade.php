<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Papacino Snacks & Drinks</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="cashier-body">

    <header class="header header-cashier">
        <div class="logo">
            <img src="{{ asset('image/logo_papacino.jpg') }}" alt="Papacino Logo" class="logo-img">
            <div class="logo-text">Papacino Snacks & Drinks</div>
        </div>

        <nav class="nav-menu nav-menu-right" style="margin-left: auto;">
            <a href="" class="nav-item status">
                <img src="{{ asset('image/icon_cashier.png') }}">
                <span>Cashier</span>
            </a>
            <form action="{{ route('logout') }}" method="POST" style="display: none;" id="logout">
                @csrf
            </form>
            <a href="" class="nav-item logout"
                onclick="event.preventDefault(); document.getElementById('logout').submit();">
                <img src="{{ asset('image/icon_logout.png') }}">
                <span>Logout</span>
            </a>
        </nav>
    </header>

    <div class="cashier-container">

        <main class="cashier-content">
            @yield('content')
        </main>

        <aside class="order-sidebar">
            <div class="order-header">
                <span class="order-title">Pesanan</span>
            </div>

            <div class="order-list" id="cart-items-list">
                <div class="cart-empty-state" id="cart-empty">
                    <img src="{{ asset('image/icon_cart.png') }}">
                    <span>Belum ada pesanan yang ditambahkan</span>
                </div>
            </div>

            <div class="order-footer">
                <div class="order-total-row">
                    <span>Subtotal</span>
                    <span id="cart-subtotal"></span>
                </div>
                <div class="order-total-row total">
                    <span>Total</span>
                    <span id="cart-total">/span>
                </div>
                <button class="btn-complete-order" id="btn-complete-order">Selesai & Cetak Struk</button>
                <button class="btn-cancel-order" id="btn-cancel-order">Batal Pesanan</button>
            </div>
        </aside>

    </div>

</body>

</html>