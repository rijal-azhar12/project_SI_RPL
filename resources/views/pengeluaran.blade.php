{{-- Ini adalah isi BARU untuk resources/views/expense.blade.php --}}
@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container">
    
    {{-- Header Halaman - sedikit berbeda dari menu --}}
    <div class="page-header page-header-expense">
        {{-- Sisi Kiri: Judul --}}
        <div>
            <h1 class="page-title">Manajemen Pengeluaran</h1>
            <p class="page-subtitle"></p>
        </div>
        
        {{-- Sisi Kanan: Kontrol (Total & Tombol Add) --}}
        <div class="header-controls">
            <div class="total-expenses-card">
                <span>Total Expenses (This Month)</span>
                <span class="total-amount">$875.50</span>
            </div>
            <button class="add-menu-btn" id="addExpenseBtn">
                <span class="plus-icon">+</span>
                <span>Add Expense</span>
            </button>
        </div>
    </div>

    {{-- Tabel Expense --}}
    <div class="menu-table">
        {{-- Header Tabel - Menggunakan grid 5 kolom baru --}}
        <div class="table-header expense-grid">
            <div>#</div>
            <div>Timestamp</div>
            <div>Description</div>
            <div style="text-align: right;">Amount</div>
            <div style="text-align: right;">Actions</div>
        </div>

        {{-- Loop untuk menampilkan data pengeluaran dari database --}}
        @forelse ($data_pengeluaran as $pengeluaran)
        <div class="table-row expense-grid">
            <div class="item-number">{{ $loop->iteration }}</div>
            <div class="item-timestamp">{{ \Carbon\Carbon::parse($pengeluaran->tanggal_pengeluaran)->format('d-M-Y, H:i:s') }}</div>
            <div class="item-description">{{ $pengeluaran->keterangan }}</div>
            <div class="item-price" style="text-align: right;">Rp {{ number_format($pengeluaran->jumlah_pengeluaran, 2, ',', '.') }}</div>
            <div class="item-actions">
                <button class="action-btn edit-expense-btn" data-id="{{ $pengeluaran->id_pengeluaran }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#C47E45" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                </button>
                <button class="action-btn delete-expense-btn" data-id="{{ $pengeluaran->id_pengeluaran }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#D9534F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                </button>
            </div>
        </div>
        @empty
        <div class="table-row" style="text-align: center; padding: 20px; grid-column: 1 / -1;">
            Tidak ada data pengeluaran untuk ditampilkan.
        </div>
        @endforelse

    </div>
</div>

{{-- ===============================================
   MODAL UNTUK EXPENSE (TERSEMBUNYI)
   =============================================== --}}

<div class="modal" id="expenseModal">
  <div class="modal-content">
    <div class="modal-header">
      <h2 class="modal-title" id="expenseModalTitle">Add Expense</h2>
      <span class="close-btn" id="closeExpenseModal">&times;</span>
    </div>
    <form id="expenseForm">
      <input type="hidden" id="expenseId" name="id_pengeluaran">
      <div class="form-group">
        <label for="expenseDescription">Description *</label>
        <textarea id="expenseDescription" required></textarea>
      </div>
      
      <div class="form-row">
        <div class="form-group">
          <label for="expenseAmount">Amount *</label>
          <input type="number" id="expenseAmount" step="0.01" placeholder="$0.00" required>
        </div>
        <div class="form-group">
          <label for="expenseTimestamp">Timestamp *</label>
          <input type="datetime-local" id="expenseTimestamp" required>
        </div>
      </div>
      
      <div class="form-actions">
        <button type="button" class="btn btn-secondary" id="cancelExpenseBtn">Cancel</button>
        <button type="submit" class="btn btn-primary">Save Expense</button>
      </div>
    </form>
  </div>
</div>

<div class="modal confirmation-modal" id="deleteExpenseModal">
  <div class="modal-content">
    <div class="modal-header">
      <h2 class="modal-title">Delete Expense</h2>
      <span class="close-btn" id="closeDeleteExpenseModal">&times;</span>
    </div>
    <p class="confirmation-text">Are you sure you want to delete this expense record?</p>
    <div class="form-actions">
      <button type="button" class="btn btn-secondary" id="cancelDeleteExpenseBtn">Cancel</button>
      <button type="button" class="btn btn-danger" id="confirmDeleteExpenseBtn">Delete</button>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Modal utama untuk Add/Edit
    const expenseModal = document.getElementById('expenseModal');
    const expenseModalTitle = document.getElementById('expenseModalTitle');
    const closeExpenseModal = document.getElementById('closeExpenseModal');
    const cancelExpenseBtn = document.getElementById('cancelExpenseBtn');
    const expenseForm = document.getElementById('expenseForm');
    const expenseIdField = document.getElementById('expenseId');

    // Tombol Add
    const addExpenseBtn = document.getElementById('addExpenseBtn');

    // Modal konfirmasi hapus
    const deleteExpenseModal = document.getElementById('deleteExpenseModal');
    const closeDeleteExpenseModal = document.getElementById('closeDeleteExpenseModal');
    const cancelDeleteExpenseBtn = document.getElementById('cancelDeleteExpenseBtn');
    const confirmDeleteExpenseBtn = document.getElementById('confirmDeleteExpenseBtn');

    let currentExpenseId = null; // Untuk menyimpan ID saat akan update atau delete

    // Fungsi untuk menutup semua modal
    const closeModal = () => {
        expenseModal.classList.remove('active');
        deleteExpenseModal.classList.remove('active');
    };

    // Buka modal untuk Add
    addExpenseBtn.addEventListener('click', () => {
        expenseForm.reset();
        expenseIdField.value = '';
        expenseModalTitle.textContent = 'Add Expense';
        expenseModal.classList.add('active');
        expenseForm.setAttribute('data-action', 'add');
    });

    // Buka modal untuk Edit
    document.querySelectorAll('.edit-expense-btn').forEach(button => {
        button.addEventListener('click', function () {
            currentExpenseId = this.getAttribute('data-id');
            
            fetch(`/pengeluaran/${currentExpenseId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    expenseIdField.value = data.id_pengeluaran;
                    document.getElementById('expenseDescription').value = data.keterangan;
                    document.getElementById('expenseAmount').value = data.jumlah_pengeluaran;
                    
                    // Format tanggal untuk input datetime-local
                    // Laravel's timestamps are usually in UTC. Convert to local timezone for correct display.
                    const date = new Date(data.tanggal_pengeluaran);
                    // Buat tanggal baru dengan mengimbangi zona waktu
                    const timezoneOffset = date.getTimezoneOffset() * 60000; // offset in milliseconds
                    const localDate = new Date(date.getTime() - timezoneOffset);
                    const formattedDate = localDate.toISOString().slice(0, 16);
                    document.getElementById('expenseTimestamp').value = formattedDate;

                    expenseModalTitle.textContent = 'Edit Expense';
                    expenseModal.classList.add('active');
                    expenseForm.setAttribute('data-action', 'edit');
                })
                .catch(error => {
                    console.error('Error fetching expense data:', error);
                    alert('Failed to fetch expense details. Please try again.');
                });
        });
    });

    // Buka modal konfirmasi Delete
    document.querySelectorAll('.delete-expense-btn').forEach(button => {
        button.addEventListener('click', function () {
            currentExpenseId = this.getAttribute('data-id');
            deleteExpenseModal.classList.add('active');
        });
    });

    // Event listener untuk tombol close dan cancel
    closeExpenseModal.addEventListener('click', closeModal);
    cancelExpenseBtn.addEventListener('click', closeModal);
    closeDeleteExpenseModal.addEventListener('click', closeModal);
    cancelDeleteExpenseBtn.addEventListener('click', closeModal);

    // Handle form submission untuk Add dan Edit
    expenseForm.addEventListener('submit', function (event) {
        event.preventDefault();
        
        const action = expenseForm.getAttribute('data-action');
        const id = expenseIdField.value;
        let url = '{{ route("pengeluaran.store") }}';
        let method = 'POST';

        if (action === 'edit') {
            // Laravel expects a POST request with a _method field for PUT.
            // So we can use POST and add the _method field.
            // However, modern JS can send PUT, and Laravel handles it.
            url = `/pengeluaran/${id}`;
            method = 'PUT';
        }

        const formData = {
            keterangan: document.getElementById('expenseDescription').value,
            jumlah_pengeluaran: document.getElementById('expenseAmount').value,
            tanggal_pengeluaran: document.getElementById('expenseTimestamp').value,
        };

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                window.location.reload();
            } else {
                // Simple error handling for validation
                let errorMessage = 'Gagal menyimpan data. Periksa kembali isian Anda.';
                if (data.errors) {
                    errorMessage += '\n\n' + Object.values(data.errors).join('\n');
                }
                alert(errorMessage);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan pada server.');
        });
    });

    // Handle konfirmasi delete
    confirmDeleteExpenseBtn.addEventListener('click', function () {
        fetch(`/pengeluaran/${currentExpenseId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                window.location.reload();
            } else {
                alert('Gagal menghapus data.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan pada server.');
        });
    });
});
</script>
@endsection