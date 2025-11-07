{{-- Ini adalah layout BARU di resources/views/layouts/cashier.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Papacino - Kasir</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    {{-- Memuat CSS & JS kita --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="cashier-body"> {{-- Kita tambahkan kelas baru di body --}}

    {{--
      HEADER BARU KHUSUS KASIR
    --}}
    <header class="header header-cashier">
        <div class="logo">
            <img src="https://placehold.co/60x60/D9534F/FFFFFF?text=Logo" alt="Papacino Logo" class="logo-img">
            <div class="logo-text">Papacino Snacks & Drinks</div>
        </div>

        {{-- Navigasi Akun (di kanan) --}}
        <nav class="nav-menu nav-menu-right" style="margin-left: auto;">
            <a href="{{ url('/account') }}" class="nav-item">
                <span>&#128100;</span> Accounts
            </a>
            <a href="#" class="nav-item owner">
                <span>&#128100;</span> Cashier
            </a>
            <a href="#" class="nav-item logout">
                <span>&#10162;</span> Logout
            </a>
        </nav>
    </header>

    {{--
      LAYOUT 2 KOLOM UNTUK HALAMAN KASIR
    --}}
    <div class="cashier-container">

        {{-- Kolom Kiri: Konten Utama (Grid Makanan/Minuman) --}}
        <main class="cashier-content">
            @yield('content') {{-- Di sinilah grid menu kita akan masuk --}}
        </main>

        {{-- Kolom Kanan: Sidebar Keranjang (Current Order) --}}
        <aside class="order-sidebar">
            <div class="order-header">
                <span class="order-title">Current Order</span>
            </div>

            <div class="order-list" id="cart-items-list">
                {{-- Template Awal Saat Kosong --}}
                <div class="cart-empty-state" id="cart-empty">
                    <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.6667 61.3333C17.2 61.3333 16 60.1333 16 58.6667V13.3333H8V8H24V5.33333C24 3.86667 25.2 2.66667 26.6667 2.66667H37.3333C38.8 2.66667 40 3.86667 40 5.33333V8H56V13.3333H48V58.6667C48 60.1333 46.8 61.3333 45.3333 61.3333H18.6667ZM42.6667 13.3333H21.3333V56H42.6667V13.3333Z" fill="#E8D5C3" />
                    </svg>
                    <span>No items added yet</span>
                </div>
            </div>

            <div class="order-footer">
                <div class="order-total-row">
                    <span>Subtotal</span>
                    <span id="cart-subtotal">$0.00</span>
                </div>
                <div class="order-total-row total">
                    <span>Total</span>
                    <span id="cart-total">$0.00</span>
                </div>
                <button class="btn-complete-order" id="btn-complete-order">Complete & Print Receipt</button>
                <button class="btn-cancel-order" id="btn-cancel-order">Cancel Order</button>
            </div>
        </aside>

    </div>

</body>

</html>