{{-- Ini adalah isi BARU untuk resources/views/expense.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    
    {{-- Header Halaman - sedikit berbeda dari menu --}}
    <div class="page-header page-header-expense">
        {{-- Sisi Kiri: Judul --}}
        <div>
            <h1 class="page-title">Expense Management</h1>
            <p class="page-subtitle">Manage your expenses</p>
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

        {{-- Baris Data 1 --}}
        <div class="table-row expense-grid">
            <div class="item-number">1</div>
            <div class="item-timestamp">18-Oct-2025, 15:00:15</div>
            <div class="item-description">Lorem ipsum dolor sit amet consectetur adipiscing elit.</div>
            <div class="item-price" style="text-align: right;">$185.00</div>
            <div class="item-actions">
                <button class="action-btn edit-expense-btn" data-id="1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#C47E45" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                </button>
                <button class="action-btn delete-expense-btn" data-id="1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#D9534F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                </button>
            </div>
        </div>

        {{-- Baris Data 2 --}}
        <div class="table-row expense-grid">
            <div class="item-number">2</div>
            <div class="item-timestamp">19-Oct-2025, 17:30:42</div>
            <div class="item-description">Pembelian bahan baku (Tepung, Gula)</div>
            <div class="item-price" style="text-align: right;">$120.50</div>
            <div class="item-actions">
                <button class="action-btn edit-expense-btn" data-id="2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#C47E45" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                </button>
                <button class="action-btn delete-expense-btn" data-id="2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#D9534F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                </button>
            </div>
        </div>
        
        {{-- Baris Data 3 --}}
        <div class="table-row expense-grid">
            <div class="item-number">3</div>
            <div class="item-timestamp">20-Oct-2025, 07:25:50</div>
            <div class="item-description">Biaya Listrik & Air</div>
            <div class="item-price" style="text-align: right;">$75.00</div>
            <div class="item-actions">
                <button class="action-btn edit-expense-btn" data-id="3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#C47E45" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                </button>
                <button class="action-btn delete-expense-btn" data-id="3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#D9534F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                </button>
            </div>
        </div>

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