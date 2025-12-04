@extends('layouts.cashier')

@section('content')
<div id="cashier-page-wrapper" data-cart-key="mainCart">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @foreach ($menus as $kategori => $items)
    <h2 class="product-category-title">{{ ucfirst($kategori) }}</h2>
    <div class="product-grid">
        @foreach ($items as $menu)
        <div class="product-card">
            <img class="product-image" src="{{ $menu->gambar_menu }}">
            <div class="product-info">
                <span class="product-name">{{ $menu->nama_menu }}</span>
                <span class="product-price">Rp {{ number_format($menu->harga_menu, 0, ',', '.') }}</span>
                <span class="product-stock">Stok: {{ $menu->stok_menu }}</span>
            </div>
            <button class="btn-add-to-cart" data-id="{{ $menu->id_menu }}" data-name="{{ $menu->nama_menu }}"
                data-price="{{ $menu->harga_menu }}" data-stock="{{ $menu->stok_menu }}">
                + Tambah
            </button>
        </div>
        @endforeach
    </div>
    @endforeach
</div>

<form id="checkout-form" action="{{ route('cashier.checkout') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="items" id="checkout-items">
    <input type="hidden" name="total" id="checkout-total">
</form>
@endsection