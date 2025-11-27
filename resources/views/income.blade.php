{{-- Ini adalah isi BARU untuk resources/views/pemasukan.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Header Halaman --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Incomes Management</h1>
            <p class="page-subtitle">Manage your incomes</p>
        </div>
    </div>

    {{-- 1. KARTU STATISTIK (DINAMIS) --}}
    <div class="stat-cards-container">
        <div class="stat-card">
            <span class="stat-title">Total Revenue</span>
            {{-- Data Dinamis --}}
            <span class="stat-value stat-revenue">${{ number_format($totalRevenue, 2) }}</span>
            <span class="stat-subtitle">{{ $filter }} ({{ $filterPeriod }})</span>
        </div>
        <div class="stat-card">
            <span class="stat-title">Total Units Sold</span>
            {{-- Data Dinamis --}}
            <span class="stat-value">{{ $totalUnitsSold }}</span>
            <span class="stat-subtitle">Across transactions</span>
        </div>
        <div class="stat-card">
            <span class="stat-title">Top Selling Item</span>
            {{-- Data Dinamis (Cek jika ada) --}}
            @if($topSellingItem)
            <span class="stat-value">{{ $topSellingItem->nama_menu }}</span>
            <span class="stat-subtitle">{{ $topSellingItem->total_terjual }} Units Sold</span>
            @else
            <span class="stat-value">-</span>
            <span class="stat-subtitle">No sales yet</span>
            @endif
        </div>
    </div>

    {{-- 2. FILTER BAR (Search bar dihapus, Tombol jadi link) --}}
    <div class="filter-bar">
        {{-- Search Bar Dihapus Sesuai Permintaan --}}
        <div class="search-field" style="flex-grow: 1;">
            {{-- Kosong, atau bisa diisi info lain --}}
        </div>

        <div class="filter-controls">
            {{-- Tombol filter kini menjadi link (<a>) --}}
            <a href="{{ route('pemasukan.index', ['filter' => 'Day']) }}"
                class="filter-btn {{ $filter == 'Day' ? 'active' : '' }}">Day</a>

            <a href="{{ route('pemasukan.index', ['filter' => 'Week']) }}"
                class="filter-btn {{ $filter == 'Week' ? 'active' : '' }}">Week</a>

            <a href="{{ route('pemasukan.index', ['filter' => 'Month']) }}"
                class="filter-btn {{ $filter == 'Month' ? 'active' : '' }}">Month</a>

            {{-- Hapus 'Group by' jika tidak diperlukan, atau sesuaikan nanti --}}
        </div>
    </div>

    {{-- 3. TABEL INCOMES (DINAMIS) --}}
    <div class="menu-table">
        <div class="table-header income-grid">
            <div>#</div>
            <div># - Cashier</div>
            <div>Timestamp</div>
            <div>Menu Name</div>
            <div>Category</div>
            <div>Units</div>
            <div>Unit Price</div>
            <div>Total Price</div>
            <div style="text-align: right;">Actions</div>
        </div>

        {{-- Loop data dari controller --}}
        @forelse($incomes as $income)
        <div class="table-row income-grid" id="income-row-{{ $income->id_detail }}">
            <div class="item-number">{{ $loop->iteration }}</div>
            {{-- Cek jika relasi ada untuk menghindari error --}}
            <div class="item-cashier">{{ $income->transaksi->user->id_user ?? 'N/A' }} -
                {{ $income->transaksi->user->nama ?? 'N/A' }}</div>
            <div class="item-timestamp">
                {{ \Carbon\Carbon::parse($income->transaksi->tanggal_transaksi)->format('d-M-Y, H:i:s') }}</div>
            <div class="item-name">{{ $income->menu->nama_menu ?? 'Menu Dihapus' }}</div>
            <div class="item-category-cell">
                <div class="item-category-tag">{{ $income->menu->kategori_menu ?? 'N/A' }}</div>
            </div>
            <div class="item-units">{{ $income->jumlah_item }}</div>
            <div class="item-price">${{ number_format($income->menu->harga_menu ?? 0, 2) }}</div>
            <div class="item-price">${{ number_format($income->subtotal, 2) }}</div>
            <div class="item-actions">
                {{-- Tombol Edit Dihapus Sesuai Permintaan --}}
                <button class="btn-action-delete delete-income-btn" data-id="{{ $income->id_detail }}">Delete</button>
            </div>
        </div>
        @empty
        <div class="table-row">
            <div style="text-align: center; grid-column: 1 / -1; padding: 20px;">
                No income data found for this period.
            </div>
        </div>
        @endforelse

    </div>

    {{-- Link Paginasi --}}
    <div class="pagination-links" style="margin-top: 20px;">
        {{ $incomes->appends(request()->query())->links() }}
    </div>

</div>

{{-- Modal Edit Dihapus Sesuai Permintaan --}}

<div class="modal confirmation-modal" id="deleteIncomeModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Delete Income</h2>
            <span class="close-btn" id="closeDeleteIncomeModal">&times;</span>
        </div>
        <p class="confirmation-text">Are you sure you want to delete this income record?</p>
        <div class="form-actions">
            <button type="button" class="btn btn-secondary" id="cancelDeleteIncomeBtn">Cancel</button>
            <button type="button" class="btn btn-danger" id="confirmDeleteIncomeBtn">Delete</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Kita akan push JS kustom ke layout app.blade.php --}}
<script>
// Pastikan DOM sudah dimuat
document.addEventListener('DOMContentLoaded', function() {

    // --- 1. Ambil CSRF Token ---
    // (Pastikan Anda punya <meta name="csrf-token" content="{{ csrf_token() }}"> di <head> layout Anda)
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const deleteIncomeModal = document.getElementById("deleteIncomeModal");
    const closeDeleteIncomeModal = document.getElementById("closeDeleteIncomeModal");
    const cancelDeleteIncomeBtn = document.getElementById("cancelDeleteIncomeBtn");
    const confirmDeleteIncomeBtn = document.getElementById("confirmDeleteIncomeBtn");
    const deleteIncomeButtons = document.querySelectorAll(".delete-income-btn");

    let currentIncomeId = null; // Variabel untuk menyimpan ID yang akan dihapus

    if (deleteIncomeModal) { // Cek jika modal ada
        // --- 2. Logic Tombol Hapus (Buka Modal) ---
        deleteIncomeButtons.forEach((button) => {
            button.addEventListener("click", () => {
                currentIncomeId = button.getAttribute("data-id");
                deleteIncomeModal.classList.add("active");
            });
        });

        // --- 3. Logic Tombol Tutup Modal ---
        closeDeleteIncomeModal.addEventListener("click", () =>
            deleteIncomeModal.classList.remove("active")
        );
        cancelDeleteIncomeBtn.addEventListener("click", () =>
            deleteIncomeModal.classList.remove("active")
        );

        // --- 4. Logic Konfirmasi Hapus (AJAX/Fetch) ---
        confirmDeleteIncomeBtn.addEventListener("click", () => {
            if (!currentIncomeId) return;

            const url = `/pemasukan/${currentIncomeId}`;

            fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    }
                    throw new Error('Something went wrong.');
                })
                .then(data => {
                    console.log(data.message); // "Income record deleted successfully."

                    // Hapus baris dari tabel di UI
                    const rowToRemove = document.getElementById(`income-row-${currentIncomeId}`);
                    if (rowToRemove) {
                        rowToRemove.remove();
                    }

                    deleteIncomeModal.classList.remove("active");
                    currentIncomeId = null;

                    // (Opsional) Tampilkan notifikasi sukses
                    // alert('Data berhasil dihapus!');

                    // (Opsional) Jika Anda ingin me-reload statistik, reload halaman
                    // location.reload(); 
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal menghapus data.');
                    deleteIncomeModal.classList.remove("active");
                });
        });
    }

    // --- HAPUS SEMUA KODE MODAL EDIT ---
    // (Kode 'editIncomeButtons', 'incomeModal', 'incomeForm' sudah dihapus)
});
</script>
@endpush