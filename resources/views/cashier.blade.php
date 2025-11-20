{{-- Ini adalah resources/views/cashier_food.blade.php (Sekarang berisi SEMUA produk) --}}
@extends('layouts.cashier') {{-- Tetap menggunakan layout kasir --}}

@section('content')

{{--
  Wrapper PENTING:
  Kita gunakan "mainCart" sebagai satu-satunya keranjang.
--}}
<div id="cashier-page-wrapper" data-cart-key="mainCart">

    {{-- ===============================================
       BAGIAN MAKANAN (FOODS)
       =============================================== --}}
    <h2 class="product-category-title">Foods</h2>

    <div class="product-grid">

        {{-- Contoh Kartu Makanan 1 --}}
        <div class="product-card">
            <img class="product-image" src="https://placehold.co/400x300/A0522D/FFFFFF?text=Takoyaki" alt="Takoyaki">
            <div class="product-info">
                <span class="product-tag">Food</span>
                <span class="product-name">Takoyaki</span>
                <span class="product-price">$4.50</span>
            </div>
            <button class="btn-add-to-cart" data-id="101" data-name="Takoyaki" data-price="4.50">
                + Add
            </button>
        </div>

        {{-- Contoh Kartu Makanan 2 --}}
        <div class="product-card">
            <img class="product-image" src="https://placehold.co/400x300/A0522D/FFFFFF?text=Croissant" alt="Croissant">
            <div class="product-info">
                <span class="product-tag">Food</span>
                <span class="product-name">Croissant</span>
                <span class="product-price">$5.00</span>
            </div>
            <button class="btn-add-to-cart" data-id="102" data-name="Croissant" data-price="5.00">
                + Add
            </button>
        </div>

        {{-- (Tambahkan kartu makanan lainnya di sini) --}}
    </div>


    {{-- ===============================================
       BAGIAN MINUMAN (DRINKS)
       =============================================== --}}
    <h2 class="product-category-title">Drinks</h2>

    <div class="product-grid">

        {{-- Contoh Kartu Minuman 1: Espresso --}}
        <div class="product-card">
            <img class="product-image" src="https://placehold.co/400x300/6F4E37/FFFFFF?text=Espresso" alt="Espresso">
            <div class="product-info">
                <span class="product-tag">Drinks</span>
                <span class="product-name">Espresso</span>
                <span class="product-price">$3.50</span>
            </div>
            <button class="btn-add-to-cart" data-id="201" data-name="Espresso" data-price="3.50">
                + Add
            </button>
        </div>

        {{-- Contoh Kartu Minuman 2: Cappuccino --}}
        <div class="product-card">
            <img class="product-image" src="https://placehold.co/400x300/8B6B5C/FFFFFF?text=Cappuccino"
                alt="Cappuccino">
            <div class="product-info">
                <span class="product-tag">Drinks</span>
                <span class="product-name">Cappuccino</span>
                <span class="product-price">$4.50</span>
            </div>
            <button class="btn-add-to-cart" data-id="202" data-name="Cappuccino" data-price="4.50">
                + Add
            </button>
        </div>

        {{-- (Tambahkan kartu minuman lainnya di sini) --}}
    </div>
</div>
@endsection