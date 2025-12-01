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
        <div class="table-header account">
            <div>#</div>
            <div>Nama</div>
            <div>Username</div>
            <div>Peran</div>
            <div>Aksi</div>
        </div>

        @forelse ($users as $user)
        <div class="table-row">
            <div class="item-iduser">{{ $user->id_user }}</div>
            <div class="item-nameuser">{{ $user->nama }}</div>
            <div class="item-usernameuser">{{ $user->username }}</div>
            <div class="item-roleuser">{{ $user->peran }}</div>
            <div class="item-actions">
                <button class="action-btn edit-btn" data-id="{{ $user->id_user }}" data-nama="{{ $user->nama }}"
                    data-username="{{ $user->username }}" data-peran="{{ $user->peran }}">
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
        <form id="accountForm" method="POST" action="">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
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
                    <option value="">Pilih Peran</option>
                    <option value="Owner">Owner</option>
                    <option value="Kasir">Kasir</option>
                </select>
            </div>
            <div class="form-group">
                <label for="accountPassword">Password</label>
                <input type="password" id="accountPassword" name="password">
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
            <h2 class="modal-title" id="deleteModalTitle"></h2>
            <span class="close-btn" id="closeDeleteAccountModal">X</span>
        </div>
        <p class="confirmation-text">Apakah anda yakin ingin menghapus akun ini?</p>
        <div class="form-actions">
            <button type="button" class="btn btn-secondary" id="cancelDeleteAccountBtn">Batal</button>
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const accountModal = document.getElementById('accountModal');
        const deleteAccountModal = document.getElementById('deleteAccountModal');
        const accountForm = document.getElementById('accountForm');
        const deleteForm = document.getElementById('deleteForm');
        const accountModalTitle = document.getElementById('accountModalTitle');
        const deleteModalTitle = document.getElementById('deleteModalTitle');
        const formMethod = document.getElementById('formMethod');

        const addAccountBtn = document.getElementById('addAccountBtn');
        const closeAccountModal = document.getElementById('closeAccountModal');
        const cancelAccountBtn = document.getElementById('cancelAccountBtn');
        const closeDeleteAccountModal = document.getElementById('closeDeleteAccountModal');
        const cancelDeleteAccountBtn = document.getElementById('cancelDeleteAccountBtn');

        addAccountBtn.addEventListener('click', () => {
            accountForm.reset();
            accountModalTitle.textContent = 'Tambah Akun';
            accountForm.setAttribute('action', '{{ route("account.store") }}');
            document.getElementById('accountPassword').required = true;
            accountModal.style.display = 'block';
        });

        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const nama = this.dataset.nama;
                const username = this.dataset.username;
                const peran = this.dataset.peran;

                accountModalTitle.textContent = `Edit Akun #${id}`;
                accountForm.setAttribute('action', `/account/${id}`);
                formMethod.value = 'PUT';

                document.getElementById('accountName').value = nama;
                document.getElementById('accountUsername').value = username;
                document.getElementById('accountRole').value = peran;
                document.getElementById('accountPassword').required = false;

                accountModal.style.display = 'block';
            });
        });

        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                deleteModalTitle.textContent = `Hapus Akun #${id}`;
                deleteForm.setAttribute('action', `/account/${id}`);
                deleteAccountModal.style.display = 'block';
            });
        });

        function closeModal() {
            accountModal.style.display = 'none';
            deleteAccountModal.style.display = 'none';
        }

        closeAccountModal.addEventListener('click', closeModal);
        cancelAccountBtn.addEventListener('click', closeModal);
        closeDeleteAccountModal.addEventListener('click', closeModal);
        cancelDeleteAccountBtn.addEventListener('click', closeModal);

        window.addEventListener('click', function(event) {
            if (event.target == accountModal) {
                closeModal();
            }
            if (event.target == deleteAccountModal) {
                closeModal();
            }
        });
    });
</script>
@endsection