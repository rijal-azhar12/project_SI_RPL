@extends('layouts.app')

@section('content')
<div class="container">

    <div class="page-header">
        <div>
            <h1 class="page-title">Manajemen Pengeluaran</h1>
            <p class="page-subtitle">Kelola pengeluaran anda</p>
        </div>

        <div class="add-btn" id="addExpenseBtn">
            <span>+</span>
            <span>Tambah Pengeluaran</span>
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
        <div class="table-header">
            <div>#</div>
            <div>Keterangan</div>
            <div>Jumlah</div>
            <div>Tanggal</div>
            <div>Aksi</div>
        </div>

        @forelse ($expenses as $expense)
        <div class="table-row">
            <div>{{ $expense->id_pengeluaran }}</div>
            <div>{{ $expense->keterangan }}</div>
            <div>Rp{{ number_format($expense->jumlah_pengeluaran, 0, ',', '.') }}</div>
            <div>{{ $expense->tanggal_pengeluaran }}</div>
            <div class="item-actions">
                <div class="action-btn edit-btn"
                    data-id="{{ $expense->id_pengeluaran }}"
                    data-keterangan="{{ $expense->keterangan }}"
                    data-jumlah_pengeluaran="{{ $expense->jumlah_pengeluaran }}"
                    data-tanggal_pengeluaran="{{ $expense->tanggal_pengeluaran }}">
                    <img src="{{ asset('image/icon_edit.png') }}" alt="Edit">
                </div>
                <form action="{{ route('expense.destroy', $expense->id_pengeluaran) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="action-btn delete-btn" onclick="return confirm('Apakah anda yakin ingin menghapus pengeluaran ini?')">
                        <img src="{{ asset('image/icon_delete.png') }}" alt="Delete">
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="table-row">
            <div style="grid-column: 1 / -1; text-align: center;">Tidak ada pengeluaran ditemukan.</div>
        </div>
        @endforelse
    </div>
</div>

<div class="modal" id="expenseModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title" id="modalTitle"></h2>
            <span class="close-btn" id="closeModal">X</span>
        </div>
        <form id="expenseForm" method="POST" action="">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="form-group">
                <label for="keterangan">Keterangan *</label>
                <input type="text" id="keterangan" name="keterangan" required>
            </div>
            <div class="form-group">
                <label for="jumlah_pengeluaran">Jumlah Pengeluaran *</label>
                <input type="number" id="jumlah_pengeluaran" name="jumlah_pengeluaran" required>
            </div>
            <div class="form-group">
                <label for="tanggal_pengeluaran">Tanggal Pengeluaran *</label>
                <input type="date" id="tanggal_pengeluaran" name="tanggal_pengeluaran" required>
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" id="cancelBtn">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addExpenseBtn = document.getElementById('addExpenseBtn');
        const expenseModal = document.getElementById('expenseModal');
        const closeModal = document.getElementById('closeModal');
        const cancelBtn = document.getElementById('cancelBtn');
        const modalTitle = document.getElementById('modalTitle');
        const expenseForm = document.getElementById('expenseForm');
        const formMethod = document.getElementById('formMethod');

        addExpenseBtn.addEventListener('click', function() {
            modalTitle.textContent = 'Tambah Pengeluaran';
            expenseForm.setAttribute('action', "{{ route('expense.store') }}");
            expenseForm.reset();
            formMethod.value = 'POST';
            expenseModal.style.display = 'block';
        });

        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const keterangan = this.dataset.keterangan;
                const jumlah_pengeluaran = this.dataset.jumlah_pengeluaran;
                const tanggal_pengeluaran = this.dataset.tanggal_pengeluaran.split(' ')[0]; // Ambil bagian tanggal saja

                modalTitle.textContent = `Edit Pengeluaran #${id}`;
                expenseForm.setAttribute('action', `/expense/${id}`);
                formMethod.value = 'PUT';

                document.getElementById('keterangan').value = keterangan;
                document.getElementById('jumlah_pengeluaran').value = jumlah_pengeluaran;
                document.getElementById('tanggal_pengeluaran').value = tanggal_pengeluaran;

                expenseModal.style.display = 'block';
            });
        });

        closeModal.addEventListener('click', function() {
            expenseModal.style.display = 'none';
        });
        cancelBtn.addEventListener('click', function() {
            expenseModal.style.display = 'none';
        });

        window.addEventListener('click', function(event) {
            if (event.target == expenseModal) {
                expenseModal.style.display = 'none';
            }
        });
    });
</script>
@endsection
