{{-- Ini adalah isi BARU untuk resources/views/account.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    
    {{-- Header Halaman --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Account Management</h1>
            <p class="page-subtitle">Manage your accounts</p>
        </div>
        
        {{-- Tombol Add Account (Sama seperti halaman Menu) --}}
        <button class="add-menu-btn" id="addAccountBtn">
            <span class="plus-icon">+</span>
            <span>Add Account</span>
        </button>
    </div>

    {{-- Tabel Akun --}}
    <div class="menu-table">
        {{-- Header Tabel - Menggunakan grid 5 kolom baru --}}
        <div class="table-header account-grid">
            <div>#</div>
            <div>Name</div>
            <div>Username</div>
            <div>Password</div>
            <div style="text-align: right;">Actions</div>
        </div>

        {{-- Baris Data 1 --}}
        <div class="table-row account-grid">
            <div class="item-number">1</div>
            <div class="item-name">Owner</div>
            <div class="item-username">owner123</div>
            <div class="item-password">234234134</div>
            <div class="item-actions">
                <button class="action-btn edit-account-btn" data-id="1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#C47E45" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                </button>
                <button class="action-btn delete-account-btn" data-id="1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#D9534F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                </button>
            </div>
        </div>

        {{-- Baris Data 2 --}}
        <div class="table-row account-grid">
            <div class="item-number">2</div>
            <div class="item-name">Cashier</div>
            <div class="item-username">cashier456</div>
            <div class="item-password">31413434</div>
            <div class="item-actions">
                <button class="action-btn edit-account-btn" data-id="2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#C47E45" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                </button>
                <button class="action-btn delete-account-btn" data-id="2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#D9534F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                </button>
            </div>
        </div>

    </div>
</div>


{{-- ===============================================
   MODAL UNTUK ACCOUNT (TERSEMBUNYI)
   =============================================== --}}

<!-- Add/Edit Account Modal -->
<div class="modal" id="accountModal">
  <div class="modal-content">
    <div class="modal-header">
      <h2 class="modal-title" id="accountModalTitle">Add Account</h2>
      <span class="close-btn" id="closeAccountModal">&times;</span>
    </div>
    <form id="accountForm">
      
      <div class="form-group">
        <label for="accountName">Name *</label>
        <input type="text" id="accountName" required>
      </div>

      <div class="form-group">
        <label for="accountUsername">Username *</label>
        <input type="text" id="accountUsername" required>
      </div>
      
      <div class="form-row">
        <div class="form-group">
          <label for="accountPassword">Password *</label>
          <input type="password" id="accountPassword" required>
        </div>
        <div class="form-group">
          <label for="accountPasswordConfirm">Confirm Password *</label>
          <input type="password" id="accountPasswordConfirm" required>
        </div>
      </div>
      
      <div class="form-actions">
        <button type="button" class="btn btn-secondary" id="cancelAccountBtn">Cancel</button>
        <button type="submit" class="btn btn-primary">Save Account</button>
      </div>
    </form>
  </div>
</div>

<!-- Delete Account Confirmation Modal -->
<div class="modal confirmation-modal" id="deleteAccountModal">
  <div class="modal-content">
    <div class="modal-header">
      <h2 class="modal-title">Delete Account</h2>
      <span class="close-btn" id="closeDeleteAccountModal">&times;</span>
    </div>
    <p class="confirmation-text">Are you sure you want to delete this account?</p>
    <div class="form-actions">
      <button type="button" class="btn btn-secondary" id="cancelDeleteAccountBtn">Cancel</button>
      <button type="button" class="btn btn-danger" id="confirmDeleteAccountBtn">Delete</button>
    </div>
  </div>
</div>
@endsection