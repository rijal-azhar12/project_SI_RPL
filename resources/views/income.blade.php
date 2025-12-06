@extends('layouts.app')

@section('content')
<div class="container">

    <div class="page-header">
        <div>
            <h1 class="page-title">Manajemen Pemasukan</h1>
            <p class="page-subtitle">Kelola data transaksi pemasukan</p>
        </div>
    </div>

    <div class="stat-cards-container">
        <div class="stat-card">
            <span class="stat-title">Total Pendapatan</span>
            <span class="stat-value stat-revenue">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</span>
            <span class="stat-subtitle">{{ $filter }} ({{ $filterPeriod }})</span>
        </div>
        <div class="stat-card">
            <span class="stat-title">Total Stok Terjual</span>
            <span class="stat-value">{{ $totalUnitsSold }}</span>
            <span class="stat-subtitle">Dari seluruh transaksi</span>
        </div>
        <div class="stat-card">
            <span class="stat-title">Barang Paling Laris</span>
            @if($topSellingItem)
            <span class="stat-value">{{ $topSellingItem->nama_menu }}</span>
            <span class="stat-subtitle">{{ $topSellingItem->total_terjual }} Stok Terjual</span>
            @else
            <span class="stat-value">-</span>
            <span class="stat-subtitle">Belum ada penjualan</span>
            @endif
        </div>
    </div>

    <div class="filter-bar">
        <div style="flex-grow: 1;"></div>
        <div class="filter-controls">
            <a href="{{ route('income.index', ['filter' => 'Day']) }}"
                class="filter-btn {{ $filter == 'Day' ? 'active' : '' }}">Harian</a>
            <a href="{{ route('income.index', ['filter' => 'Week']) }}"
                class="filter-btn {{ $filter == 'Week' ? 'active' : '' }}">Mingguan</a>
            <a href="{{ route('income.index', ['filter' => 'Month']) }}"
                class="filter-btn {{ $filter == 'Month' ? 'active' : '' }}">Bulanan</a>
        </div>
    </div>

    <div class="table">
        <div class="table-header income-grid">
            <div>#</div>
            <div># Kasir</div>
            <div>Tanggal</div>
            <div>Nama Menu</div>
            <div>Harga per Menu</div>
            <div>Total Menu</div>
            <div>Total Harga</div>
        </div>

        @forelse ($incomes as $transaksi)
        <div class="table-row income-grid">
            <div class="item-idtransaction">{{ $transaksi->id_transaksi }}</div>
            <div class="item-idcashier">{{ $transaksi->user->id_user }} - {{ $transaksi->user->nama ?? 'N/A' }}</div>
            <div class="item-datetransaction">{{ $transaksi->tanggal_transaksi }}</div>
            <div class="item-namemenu">
                @if ($transaksi->details->isNotEmpty())
                @foreach ($transaksi->details as $detail)
                {{ $detail->jumlah_item }}x {{ $detail->menu->nama_menu ?? 'Menu tidak ditemukan' }}<br>
                @endforeach
                @else
                N/A
                @endif
            </div>
            <div class="item-pricemenu">
                @if ($transaksi->details->isNotEmpty())
                @foreach ($transaksi->details as $detail)
                Rp{{ number_format($detail->subtotal, 0, ',', '.') }}<br>
                @endforeach
                @else
                N/A
                @endif
            </div>
            <div class="item-itemtransaction">{{ $transaksi->details->sum('jumlah_item') }}</div>
            <div class="item-pricetransaction">
                Rp{{ number_format($transaksi->details->sum(function ($d) {return $d->subtotal * $d->jumlah_item;}), 0, ',', '.') }}
            </div>
        </div>
        @empty
        <div class="table-row">
            <div class="item-number" style="grid-column: 1 / -1; text-align: center;">Tidak ada pemasukan
                ditemukan.</div>
        </div>
        @endforelse
    </div>
    <div class="pagination-links" style="margin-top: 20px;">
        {{ $incomes->appends(request()->query())->links() }}
    </div>
</div>

@endsection