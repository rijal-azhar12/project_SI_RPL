@extends('layouts.app')

@section('content')
<div class="container">

    <div class="page-header">
        <div>
            <h1 class="page-title">Manajemen Akun</h1>
            <p class="page-subtitle">Kelola akun anda</p>
        </div>

        <div class="add-btn" id="addAccountBtn">
            <span>+</span>
            <span>Tambah Akun</span>
        </div>
    </div>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="table">
        <div class="table-header account">
            <div>#</div>
            <div>Nama</div>
            <div>Username</div>
            <div>Peran</div>
            <div>Aksi</div>
        </div>

        @forelse ($users as $user)
        <div class="table-row account">
            <div class="item-number">{{ $loop->iteration }}</div>
            <div class="item-name">{{ $user->nama }}</div>
            <div class="item-username">{{ $user->username }}</div>
            <div class="item-peran">{{ $user->peran }}</div>
            <div class="item-actions">
                <button class="action-btn edit-btn" data-id="{{ $user->id_user }}">
                    <img src="{{ asset('image/icon_edit.png') }}" alt="Edit">
                </button>
                <button class="action-btn delete-btn" data-id="{{ $user->id_user }}">
                    <img src="{{ asset('image/icon_delete.png') }}" alt="Delete">
                </button>
            </div>
        </div>
        @empty
        <div class="table-row">
            <div class="item-number" style="grid-column: 1 / -1; text-align: center;">Tidak ada akun ditemukan.
            </div>
        </div>
        @endforelse

    </div>
</div>

<div class="modal" id="accountModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title" id="accountModalTitle"></h2>
            <span class="close-btn" id="closeAccountModal">X</span>
        </div>
        <form id="accountForm">
            <input type="hidden" id="accountId" name="id">
            <div class="form-group">
                <label for="accountName">Nama *</label>
                <input type="text" id="accountName" name="nama" required>
            </div>
            <div class="form-group">
                <label for="accountUsername">Username *</label>
                <input type="text" id="accountUsername" name="username" required>
            </div>
            <div class="form-group">
                <label for="accountRole">Peran *</label>
                <select id="accountRole" name="peran" required>
                    <option value="owner">Owner</option>
                    <option value="kasir">Kasir</option>
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
                <button type="button" class="btn btn-secondary" id="cancelAccountBtn">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div class="modal confirmation-modal" id="deleteAccountModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Hapus Akun</h2>
            <span class="close-btn" id="closeDeleteAccountModal">&times;</span>
        </div>
        <p class="confirmation-text">Apakah anda yakin ingin menghapus akun ini?</p>
        <div class="form-actions">
            <button type="button" class="btn btn-secondary" id="cancelDeleteAccountBtn">Batal</button>
            <button type="button" class="btn btn-danger" id="confirmDeleteAccountBtn">Hapus</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const accountModal = document.getElementById('accountModal');
    const deleteAccountModal = document.getElementById('deleteAccountModal');

    const accountForm = document.getElementById('accountForm');
    const accountIdField = document.getElementById('accountId');
    const accountNameField = document.getElementById('accountName');
    const accountUsernameField = document.getElementById('accountUsername');
    const accountRoleField = document.getElementById('accountRole');
    const accountPasswordField = document.getElementById('accountPassword');
    const accountPasswordConfirmField = document.getElementById('accountPasswordConfirm');
    const accountModalTitle = document.getElementById('accountModalTitle');

    const addAccountBtn = document.getElementById('addAccountBtn');
    const closeAccountModal = document.getElementById('closeAccountModal');
    const cancelAccountBtn = document.getElementById('cancelAccountBtn');
    const closeDeleteAccountModal = document.getElementById('closeDeleteAccountModal');
    const cancelDeleteAccountBtn = document.getElementById('cancelDeleteAccountBtn');
    const confirmDeleteAccountBtn = document.getElementById('confirmDeleteAccountBtn');

    let currentAccountId = null;

    const closeModal = () => {
        accountModal.classList.remove('active');
        deleteAccountModal.classList.remove('active');
    };

    addAccountBtn.addEventListener('click', () => {
        accountForm.reset();
        accountIdField.value = '';
        accountModalTitle.textContent = 'Add Account';
        accountPasswordField.required = true;
        accountPasswordConfirmField.required = true;
        accountModal.classList.add('active');
        accountForm.setAttribute('data-action', 'add');
    });

    // Open Edit Account Modal
    document.querySelectorAll('.edit-account-btn').forEach(button => {
        button.addEventListener('click', function() {
            currentAccountId = this.getAttribute('data-id');

            fetch(`/accounts/${currentAccountId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    accountIdField.value = data.id_user;
                    accountNameField.value = data.nama;
                    accountUsernameField.value = data.username;
                    accountRoleField.value = data.peran;
                    accountPasswordField.value = ''; // Clear password fields for security
                    accountPasswordConfirmField.value = '';
                    accountPasswordField.required =
                        false; // Password not required for edit unless changed
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
        button.addEventListener('click', function() {
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
    accountForm.addEventListener('submit', function(event) {
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
            nama: accountNameField.value,
            username: accountUsernameField.value,
            peran: accountRoleField.value,
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
                        errorMessage += '\n\n' + Object.values(data.errors).map(e => e.join(', '))
                            .join('\n');
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
    confirmDeleteAccountBtn.addEventListener('click', function() {
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