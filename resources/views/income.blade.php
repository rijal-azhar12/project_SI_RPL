@extends('layouts.app')

@section('content')
<div class="container">

    <div class="page-header">
        <div>
            <h1 class="page-title">Manajemen Pemasukan</h1>
            <p class="page-subtitle">Kelola data transaksi pemasukan</p>
        </div>

        <div class="add-btn" id="addIncomeBtn">
            <span>+</span>
            <span>Tambah Pemasukan</span>
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


    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="table">
        <div class="table-header income-grid">
            <div>#</div>
            <div># Kasir</div>
            <div>Tanggal</div>
            <div>Nama Menu</div>
            <div>Kategori</div>
            <div>Jumlah</div>
            <div>Harga</div>
            <div>Total Harga</div>
            <div>Aksi</div>
        </div>

        @forelse ($incomes as $transaksi)
        <div class="table-row income-grid">
            <div class="item-idtransaction">{{ $transaksi->id_transaksi }}</div>
            <div class="item-idcashier">{{ $transaksi->user->id_user }} - {{ $transaksi->user->nama ?? 'N/A' }}</div>
            <div class="item-datetransaction">{{ $transaksi->tanggal_transaksi }}</div>
            <div class="item-namemenu">{{ $transaksi->details->first()->menu->nama_menu ?? 'N/A' }}</div>
            <div class="item-categorymenu">{{ $transaksi->details->first()->menu->kategori_menu ?? 'N/A' }}</div>
            <div class="item-itemtransaction">{{ $transaksi->details->sum('jumlah_item') }}</div>
            <div class="item-pricemenu">
                Rp{{ number_format($transaksi->details->sum('subtotal'), 0, ',', '.') }}
            </div>
            <div class="item-pricetransaction">
                Rp{{ number_format($transaksi->details->sum(function ($d) {return $d->subtotal * $d->jumlah_item;}), 0, ',', '.') }}
            </div>
            <div class="item-actions">
                <div class="action-btn edit-btn" data-id="{{ $transaksi->id_transaksi }}"
                    data-details="{{ json_encode($transaksi) }}">
                    <img src="{{ asset('image/icon_edit.png') }}" alt="Edit">
                </div>
                <div class="action-btn delete-btn" data-id="{{ $transaksi->id_transaksi }}">
                    <img src="{{ asset('image/icon_delete.png') }}" alt="Delete">
                </div>
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

<div class="modal" id="incomeModal">
    <div class="modal-content large">
        <div class="modal-header">
            <h2 class="modal-title" id="modalTitle"></h2>
            <span class="close-btn" id="closeModal">X</span>
        </div>
        <form id="incomeForm" method="POST" action="">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">

            <div class="form-row">
                <div class="form-group">
                    <label for="id_user">Kasir *</label>
                    <select id="id_user" name="id_user" required>
                        <option value="">Pilih Kasir</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id_user }}">{{ $user->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="tanggal_transaksi">Tanggal Transaksi *</label>
                    <input type="datetime-local" id="tanggal_transaksi" name="tanggal_transaksi" required>
                </div>
            </div>

            <hr>
            <h3 class="sub-header">Detail Item</h3>

            <div id="menu_items_container">
                {{-- Baris item akan ditambahkan oleh JS --}}
            </div>

            <button type="button" class="btn btn-secondary" id="addMenuItemBtn" style="margin-bottom: 20px;">+
                Tambah
                Item</button>

            <div class="form-actions">
                <button type="button" class="btn btn-secondary" id="cancelBtn">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Konfirmasi Hapus --}}
<div class="modal confirmation-modal" id="deleteModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title" id="modalDeleteTitle"></h2>
            <span class="close-btn" id="closeDeleteModal">X</span>
        </div>
        <p class="confirmation-text">Apakah anda yakin ingin menghapus data transaksi ini?</p>
        <div class="form-actions">
            <button type="button" class="btn btn-secondary" id="cancelDeleteBtn">Batal</button>
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Hapus</button>
            </form>
        </div>
    </div>
</div>

{{-- Template untuk baris item menu --}}
<template id="menu_item_template">
    <div class="form-row menu-item-row">
        <input type="hidden" name="menu_items[][id_detail]" class="menu_item_id_detail">
        <div class="form-group">
            <label>Menu *</label>
            <select name="menu_items[][id_menu]" class="form-control menu_item_id_menu" required>
                <option value="">Pilih Menu</option>
                @foreach($menusForForm as $menu)
                <option value="{{ $menu->id_menu }}" data-harga="{{ $menu->harga_menu }}">{{ $menu->nama_menu }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Jumlah *</label>
            <input type="number" name="menu_items[][jumlah_item]" class="form-control menu_item_jumlah" min="1"
                value="1" required>
        </div>
        <div class="form-group">
            <label>Harga Satuan</label>
            <input type="number" name="menu_items[][harga_item]" class="form-control menu_item_harga" readonly>
        </div>
        <div class="form-group" style="display:flex; align-items: flex-end;">
            <button type="button" class="btn btn-danger remove-menu-item-btn">Hapus</button>
        </div>
    </div>
</template>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elemen Modal Utama
    const incomeModal = document.getElementById('incomeModal');
    const closeModal = document.getElementById('closeModal');
    const cancelBtn = document.getElementById('cancelBtn');
    const modalTitle = document.getElementById('modalTitle');
    const incomeForm = document.getElementById('incomeForm');
    const formMethod = document.getElementById('formMethod');

    // Tombol Halaman
    const addIncomeBtn = document.getElementById('addIncomeBtn');
    const editBtns = document.querySelectorAll('.edit-btn');
    const deleteBtns = document.querySelectorAll('.delete-btn');

    // Elemen Modal Hapus
    const deleteModal = document.getElementById('deleteModal');
    const closeDeleteModal = document.getElementById('closeDeleteModal');
    const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
    const deleteForm = document.getElementById('deleteForm');
    const modalDeleteTitle = document.getElementById('modalDeleteTitle');

    // Form Item Dinamis
    const menuItemsContainer = document.getElementById('menu_items_container');
    const addMenuItemBtn = document.getElementById('addMenuItemBtn');
    const menuItemTemplate = document.getElementById('menu_item_template');

    // --- Logika Item Menu Dinamis ---
    function createMenuItemRow() {
        const templateContent = menuItemTemplate.content.cloneNode(true);
        const newRow = templateContent.querySelector('.menu-item-row');

        newRow.querySelector('.remove-menu-item-btn').addEventListener('click', function() {
            newRow.remove();
        });

        const menuSelect = newRow.querySelector('.menu_item_id_menu');
        const hargaInput = newRow.querySelector('.menu_item_harga');
        menuSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const harga = selectedOption.dataset.harga || 0;
            hargaInput.value = harga;
        });

        menuItemsContainer.appendChild(newRow);
        return newRow;
    }

    addMenuItemBtn.addEventListener('click', createMenuItemRow);

    function populateForm(transaksi) {
        incomeForm.reset();
        menuItemsContainer.innerHTML = ''; // Hapus item lama

        // Isi field utama
        document.getElementById('id_user').value = transaksi.id_user;
        // Format tanggal untuk input datetime-local (YYYY-MM-DDTHH:mm)
        if (transaksi.tanggal_transaksi) {
            const date = new Date(transaksi.tanggal_transaksi.replace(' ', 'T'));
            document.getElementById('tanggal_transaksi').value = date.toISOString().slice(0, 16);
        }

        // Isi detail item
        if (transaksi.details && Array.isArray(transaksi.details)) {
            transaksi.details.forEach(detail => {
                const newRow = createMenuItemRow();
                newRow.querySelector('.menu_item_id_detail').value = detail.id_detail;
                newRow.querySelector('.menu_item_id_menu').value = detail.id_menu;
                newRow.querySelector('.menu_item_jumlah').value = detail.jumlah_item;
                // Ambil harga dari menu saat ini, bukan dari detail lama
                const selectedMenu = newRow.querySelector('.menu_item_id_menu').options[newRow
                    .querySelector('.menu_item_id_menu').selectedIndex];
                newRow.querySelector('.menu_item_harga').value = selectedMenu.dataset.harga ||
                    detail
                    .subtotal / detail.jumlah_item;
            });
        }
    }


    // --- Logika Modal ---
    function showModal(display) {
        incomeModal.style.display = display;
    }

    addIncomeBtn.addEventListener('click', function() {
        modalTitle.textContent = 'Tambah Pemasukan';
        incomeForm.setAttribute('action', "{{ route('income.store') }}");
        formMethod.value = 'POST';
        incomeForm.reset();
        menuItemsContainer.innerHTML = '';
        createMenuItemRow(); // Tambah satu baris kosong saat membuat baru
        showModal('block');
    });

    editBtns.forEach(button => {
        button.addEventListener('click', function() {
            const transaksi = JSON.parse(this.dataset.details);
            const id = this.dataset.id;

            modalTitle.textContent = `Edit Pemasukan #${id}`;
            incomeForm.setAttribute('action', `/income/${id}`);
            formMethod.value = 'PUT';

            populateForm(transaksi);
            showModal('block');
        });
    });

    closeModal.addEventListener('click', () => showModal('none'));
    cancelBtn.addEventListener('click', () => showModal('none'));

    // --- Logika Modal Hapus ---
    function showDeleteModal(display) {
        deleteModal.style.display = display;
    }

    deleteBtns.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            modalDeleteTitle.textContent = `Hapus Transaksi #${id}`;
            deleteForm.setAttribute('action', `/income/${id}`);
            showDeleteModal('block');
        });
    });

    closeDeleteModal.addEventListener('click', () => showDeleteModal('none'));
    cancelDeleteBtn.addEventListener('click', () => showDeleteModal('none'));

    window.addEventListener('click', function(event) {
        if (event.target == incomeModal) {
            showModal('none');
        }
        if (event.target == deleteModal) {
            showDeleteModal('none');
        }
    });
});
</script>
@endpush