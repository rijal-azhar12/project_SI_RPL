@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container">
    
    {{-- Header Halaman --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Manajemen Akun</h1>
            <!-- <p class="page-subtitle">Manage your accounts</p> -->
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
            <div>Role</div>
            <div style="text-align: right;">Actions</div>
        </div>

        @forelse ($users as $user)
        <div class="table-row account-grid">
            <div class="item-number">{{ $loop->iteration }}</div>
            <div class="item-name">{{ $user->name }}</div>
            <div class="item-username">{{ $user->username }}</div>
            <div class="item-role">{{ $user->role }}</div>
            <div class="item-actions">
                <button class="action-btn edit-account-btn" data-id="{{ $user->id }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#C47E45" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                </button>
                <button class="action-btn delete-account-btn" data-id="{{ $user->id }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#D9534F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                </button>
            </div>
        </div>
        @empty
        <div class="table-row" style="text-align: center; padding: 20px; grid-column: 1 / -1;">
            Tidak ada data akun untuk ditampilkan.
        </div>
        @endforelse

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
      <input type="hidden" id="accountId" name="id">
      
      <div class="form-group">
        <label for="accountName">Name *</label>
        <input type="text" id="accountName" name="name" required>
      </div>

      <div class="form-group">
        <label for="accountUsername">Username *</label>
        <input type="text" id="accountUsername" name="username" required>
      </div>

      <div class="form-group">
        <label for="accountRole">Role *</label>
        <select id="accountRole" name="role" required>
            <option value="owner">Owner</option>
            <option value="cashier">Cashier</option>
        </select>
      </div>
      
      <div class="form-row">
        <div class="form-group">
          <label for="accountPassword">Password *</label>
          <input type="password" id="accountPassword" name="password">
        </div>
        <div class="form-group">
          <label for="accountPasswordConfirm">Confirm Password *</label>
          <input type="password" id="accountPasswordConfirm" name="password_confirmation">
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

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Modals
    const accountModal = document.getElementById('accountModal');
    const deleteAccountModal = document.getElementById('deleteAccountModal');

    // Form elements
    const accountForm = document.getElementById('accountForm');
    const accountIdField = document.getElementById('accountId');
    const accountNameField = document.getElementById('accountName');
    const accountUsernameField = document.getElementById('accountUsername');
    const accountRoleField = document.getElementById('accountRole');
    const accountPasswordField = document.getElementById('accountPassword');
    const accountPasswordConfirmField = document.getElementById('accountPasswordConfirm');
    const accountModalTitle = document.getElementById('accountModalTitle');

    // Buttons
    const addAccountBtn = document.getElementById('addAccountBtn');
    const closeAccountModal = document.getElementById('closeAccountModal');
    const cancelAccountBtn = document.getElementById('cancelAccountBtn');
    const closeDeleteAccountModal = document.getElementById('closeDeleteAccountModal');
    const cancelDeleteAccountBtn = document.getElementById('cancelDeleteAccountBtn');
    const confirmDeleteAccountBtn = document.getElementById('confirmDeleteAccountBtn');

    let currentAccountId = null; // To store ID for update/delete

    // Function to close all modals
    const closeModal = () => {
        accountModal.classList.remove('active');
        deleteAccountModal.classList.remove('active');
    };

    // Open Add Account Modal
    addAccountBtn.addEventListener('click', () => {
        accountForm.reset();
        accountIdField.value = '';
        accountModalTitle.textContent = 'Add Account';
        accountPasswordField.required = true; // Password is required for new accounts
        accountPasswordConfirmField.required = true;
        accountModal.classList.add('active');
        accountForm.setAttribute('data-action', 'add');
    });

    // Open Edit Account Modal
    document.querySelectorAll('.edit-account-btn').forEach(button => {
        button.addEventListener('click', function () {
            currentAccountId = this.getAttribute('data-id');
            
            fetch(`/accounts/${currentAccountId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    accountIdField.value = data.id;
                    accountNameField.value = data.name;
                    accountUsernameField.value = data.username;
                    accountRoleField.value = data.role;
                    accountPasswordField.value = ''; // Clear password fields for security
                    accountPasswordConfirmField.value = '';
                    accountPasswordField.required = false; // Password not required for edit unless changed
                    accountPasswordConfirmField.required = false;

                    accountModalTitle.textContent = 'Edit Account';
                    accountModal.classList.add('active');
                    accountForm.setAttribute('data-action', 'edit');
                })
                .catch(error => {
                    console.error('Error fetching account data:', error);
                    alert('Failed to fetch account details. Please try again.');
                });
        });
    });

    // Open Delete Account Confirmation Modal
    document.querySelectorAll('.delete-account-btn').forEach(button => {
        button.addEventListener('click', function () {
            currentAccountId = this.getAttribute('data-id');
            deleteAccountModal.classList.add('active');
        });
    });

    // Close modal event listeners
    closeAccountModal.addEventListener('click', closeModal);
    cancelAccountBtn.addEventListener('click', closeModal);
    closeDeleteAccountModal.addEventListener('click', closeModal);
    cancelDeleteAccountBtn.addEventListener('click', closeModal);

    // Handle form submission for Add and Edit
    accountForm.addEventListener('submit', function (event) {
        event.preventDefault();
        
        const action = accountForm.getAttribute('data-action');
        const id = accountIdField.value;
        let url = '{{ route("accounts.store") }}';
        let method = 'POST';

        if (action === 'edit') {
            url = `/accounts/${id}`;
            method = 'PUT';
        }

        const formData = {
            name: accountNameField.value,
            username: accountUsernameField.value,
            role: accountRoleField.value,
            password: accountPasswordField.value,
            password_confirmation: accountPasswordConfirmField.value,
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
                let errorMessage = 'Failed to save account. Please check your input.';
                if (data.errors) {
                    errorMessage += '\n\n' + Object.values(data.errors).map(e => e.join(', ')).join('\n');
                }
                alert(errorMessage);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred on the server.');
        });
    });

    // Handle Delete Confirmation
    confirmDeleteAccountBtn.addEventListener('click', function () {
        fetch(`/accounts/${currentAccountId}`, {
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
                alert('Failed to delete account.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred on the server.');
        });
    });
});
</script>
@endsection