{{-- Ini adalah isi BARU untuk resources/views/incomes.blade.php --}}
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

    {{-- 1. KARTU STATISTIK --}}
    <div class="stat-cards-container">
        <div class="stat-card">
            <span class="stat-title">Total Revenue</span>
            <span class="stat-value stat-revenue">$400</span>
            <span class="stat-subtitle">Day ... Period</span>
        </div>
        <div class="stat-card">
            <span class="stat-title">Total Units Sold</span>
            <span class="stat-value">8</span>
            <span class="stat-subtitle">Across ... Transactions</span>
        </div>
        <div class="stat-card">
            <span class="stat-title">Top Selling Item</span>
            <span class="stat-value">Cappucino</span>
            <span class="stat-subtitle">... Units Sold</span>
        </div>
    </div>

    {{-- 2. FILTER BAR (HTML Sederhana) --}}
    <div class="filter-bar">
        <div class="search-field">
            {{-- Icon Search (SVG) --}}
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.16667 15.8333C12.8486 15.8333 15.8333 12.8486 15.8333 9.16667C15.8333 5.48477 12.8486 2.5 9.16667 2.5C5.48477 2.5 2.5 5.48477 2.5 9.16667C2.5 12.8486 5.48477 15.8333 9.16667 15.8333Z" stroke="#AAAAAA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M17.5 17.5L13.875 13.875" stroke="#AAAAAA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <input type="text" placeholder="Search by ID, Menu, Category, or Price...">
        </div>
        <div class="filter-controls">
            <input type="text" class="filter-datepicker" value="23-Oct-2025, 10:00:00">
            <button class="filter-btn">Day</button>
            <button class="filter-btn">Week</button>
            <button class="filter-btn active">Month</button>
            <select class="filter-group-by">
                <option>Group by: Month</option>
            </select>
        </div>
    </div>

    {{-- 3. TABEL INCOMES (9 Kolom) --}}
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

        {{-- Baris 1 --}}
        <div class="table-row income-grid">
            <div class="item-number">1</div>
            <div class="item-cashier">1 - Qholdi</div>
            <div class="item-timestamp">23-Oct-2025, 18:00:05</div>
            <div class="item-name">Sandwich</div>
            <div class="item-category-cell"><div class="item-category-tag">Food</div></div>
            <div class="item-units">2</div>
            <div class="item-price">$2</div>
            <div class="item-price">$4</div>
            <div class="item-actions">
                <button class="btn-action-edit edit-income-btn" data-id="1">Edit</button>
                <button class="btn-action-delete delete-income-btn" data-id="1">Delete</button>
            </div>
        </div>

        {{-- Baris 2 --}}
        <div class="table-row income-grid">
            <div class="item-number">2</div>
            <div class="item-cashier">1 - Qholdi</div>
            <div class="item-timestamp">23-Oct-2025, 19:20:35</div>
            <div class="item-name">Espresso</div>
            <div class="item-category-cell"><div class="item-category-tag">Drink</div></div>
            <div class="item-units">5</div>
            <div class="item-price">$1.50</div>
            <div class="item-price">$7.50</div>
            <div class="item-actions">
                <button class="btn-action-edit edit-income-btn" data-id="2">Edit</button>
                <button class="btn-action-delete delete-income-btn" data-id="2">Delete</button>
            </div>
        </div>
        
        {{-- Baris 3 --}}
        <div class="table-row income-grid">
            <div class="item-number">3</div>
            <div class="item-cashier">2 - Rasya</div>
            <div class="item-timestamp">24-Oct-2025, 19:35:00</div>
            <div class="item-name">Cappucino</div>
            <div class="item-category-cell"><div class="item-category-tag">Drink</div></div>
            <div class="item-units">1</div>
            <div class="item-price">$2.05</div>
            <div class="item-price">$2.05</div>
            <div class="item-actions">
                <button class="btn-action-edit edit-income-btn" data-id="3">Edit</button>
                <button class="btn-action-delete delete-income-btn" data-id="3">Delete</button>
            </div>
        </div>

    </div>
</div>


{{-- ===============================================
   MODAL UNTUK INCOMES (TERSEMBUNYI)
   =============================================== --}}

<!-- Add/Edit Income Modal -->
<div class="modal" id="incomeModal">
  <div class="modal-content">
    <div class="modal-header">
      <h2 class="modal-title" id="incomeModalTitle">Edit Income #...</h2>
      <span class="close-btn" id="closeIncomeModal">&times;</span>
    </div>
    <form id="incomeForm">
      
      <div class="form-row">
        <div class="form-group">
            <label for="incomeCashier"># - Cashier *</label>
            <select id="incomeCashier" required>
                <option value="">Pilih Kasir</option>
                <option value="1 - Qholdi">1 - Qholdi</option>
                <option value="2 - Rasya">2 - Rasya</option>
            </select>
        </div>
        <div class="form-group">
            <label for="incomeTimestamp">Timestamp *</label>
            <input type="datetime-local" id="incomeTimestamp" required>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="incomeMenuName">Menu Name *</label>
          <input type="text" id="incomeMenuName" required>
        </div>
        <div class="form-group">
            <label for="incomeCategory">Category *</label>
            <select id="incomeCategory" required>
                <option value="">Pilih Kategori</option>
                <option value="Food">Food</option>
                <option value="Drink">Drink</option>
            </select>
        </div>
      </div>
      
      <div class="form-row">
        <div class="form-group">
          <label for="incomeUnit">Unit *</label>
          <input type="number" id="incomeUnit" required>
        </div>
        <div class="form-group">
          <label for="incomeUnitPrice">Unit Price*</label>
          <input type="text" id="incomeUnitPrice" placeholder="$0.00" required>
        </div>
      </div>
      
      <div class="form-actions">
        <button type="button" class="btn btn-secondary" id="cancelIncomeBtn">Cancel</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>

<!-- Delete Income Confirmation Modal -->
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