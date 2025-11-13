@extends('layouts.app')

@section('content')
<div class="container">

    <div class="page-header">
        <div>
            <h1 class="page-title">Manajemen Menu</h1>
            <p class="page-subtitle">Kelola item menu Anda</p>
        </div>

        <div class="add-menu-btn" id="addMenuBtn">
            <span class="plus-icon">+</span>
            <span>Tambah Item Menu</span>
        </div>
    </div>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="menu-table">
        <div class="table-header">
            <div>#</div>
            <div>Gambar</div>
            <div>Nama Menu</div>
            <div>Stok</div>
            <div>Deskripsi</div>
            <div>Kategori</div>
            <div>Harga</div>
            <div style="text-align: right;">Aksi</div>
        </div>

        @forelse ($menus as $menu)
        <div class="table-row">
            <div class="item-number">{{ $loop->iteration }}</div>
            <div class="item-image">
                <img src="{{ $menu->gambar_menu }}" alt="{{ $menu->nama_menu }}"
                    style="width: 100px; height: 100px; object-fit: cover;">
            </div>
            <div class="item-name">{{ $menu->nama_menu }}</div>
            <div class="item-units">{{ $menu->stok_menu }}</div>
            <div class="item-description">{{ $menu->deskripsi_menu }}</div>
            <div class="item-category">{{ $menu->kategori_menu }}</div>
            <div class="item-price">Rp{{ number_format($menu->harga_menu, 0, ',', '.') }}</div>
            <div class="item-actions">
                <div class="action-btn edit-btn" data-id="{{ $menu->id_menu }}"
                    data-gambar_menu="{{ $menu->gambar_menu }}" data-nama_menu="{{ $menu->nama_menu }}"
                    data-stok_menu="{{ $menu->stok_menu }}" data-deskripsi_menu="{{ $menu->deskripsi_menu }}"
                    data-kategori_menu="{{ $menu->kategori_menu }}" data-harga_menu="{{ $menu->harga_menu }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="#C47E45" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 20h9"></path>
                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                    </svg>
                </div>
                <div class="action-btn delete-btn" data-id="{{ $menu->id_menu }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="#D9534F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        <line x1="10" y1="11" x2="10" y2="17"></line>
                        <line x1="14" y1="11" x2="14" y2="17"></line>
                    </svg>
                </div>
            </div>
        </div>
        @empty
        <div class="table-row">
            <div class="item-number" style="grid-column: 1 / -1; text-align: center;">Tidak ada item menu ditemukan.
            </div>
        </div>
        @endforelse
    </div>
</div>

{{-- Add/Edit Menu Modal --}}
<div class="modal" id="menuModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title" id="modalTitle">Tambah Item Menu</h2>
            <span class="close-btn" id="closeModal">&times;</span>
        </div>
        <form id="menuForm" method="POST" action="{{ route('menu.store') }}">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="form-group">
                <label for="gambar_menu_file">Unggah Gambar</label>
                <input type="file" id="gambar_menu_file" name="gambar_menu_file" accept="image/*">
                <input type="hidden" id="gambar_menu_base64" name="gambar_menu">
                <img id="gambar_menu_preview" src="" alt="Pratinjau Gambar"
                    style="max-width: 100px; max-height: 100px; margin-top: 10px; display: none;">
            </div>
            <div class="form-group">
                <label for="nama_menu">Nama Menu *</label>
                <input type="text" id="nama_menu" name="nama_menu" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="stok_menu">Stok *</label>
                    <input type="number" id="stok_menu" name="stok_menu" required>
                </div>
                <div class="form-group">
                    <label for="deskripsi_menu">Deskripsi</label>
                    <textarea id="deskripsi_menu" name="deskripsi_menu" style="resize: none;"></textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="kategori_menu">Kategori *</label>
                    <select id="kategori_menu" name="kategori_menu" required>
                        <option value="">Pilih Kategori</option>
                        <option value="Drink">Minuman</option>
                        <option value="Food">Makanan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="harga_menu">Harga *</label>
                    <input type="number" step="0.01" id="harga_menu" name="harga_menu" required>
                </div>
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" id="cancelBtn">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div class="modal confirmation-modal" id="deleteModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Hapus Item Menu</h2>
            <span class="close-btn" id="closeDeleteModal">&times;</span>
        </div>
        <p class="confirmation-text">Apakah Anda yakin ingin menghapus item menu ini?</p>
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

<style>
.modal {
    display: none;
    /* Hidden by default */
    position: fixed;
    /* Stay in place */
    z-index: 1;
    /* Sit on top */
    left: 0;
    top: 0;
    width: 100%;
    /* Full width */
    height: 100%;
    /* Full height */
    overflow: auto;
    /* Enable scroll if needed */
    background-color: rgba(0, 0, 0, 0.4);
    /* Black w/ opacity */
}

.modal-content {
    background-color: #fefefe;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    /* Could be adjusted */
    max-width: 500px;
    /* Max width for better appearance */
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    animation-name: animatetop;
    animation-duration: 0.4s;
    position: relative;
    /* Needed for top/left/transform */
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    margin: 0;
    /* Reset margin to allow transform to center */
}

/* Add animation */
@-webkit-keyframes animatetop {
    from {
        top: -300px;
        opacity: 0
    }

    to {
        top: 50%;
        opacity: 1
    }

    /* Adjust 'to' top to match final position */
}

@keyframes animatetop {
    from {
        top: -300px;
        opacity: 0
    }

    to {
        top: 50%;
        opacity: 1
    }

    /* Adjust 'to' top to match final position */
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const addMenuBtn = document.getElementById('addMenuBtn');
    const menuModal = document.getElementById('menuModal');
    const closeModal = document.getElementById('closeModal');
    const cancelBtn = document.getElementById('cancelBtn');
    const modalTitle = document.getElementById('modalTitle');
    const menuForm = document.getElementById('menuForm');
    const formMethod = document.getElementById('formMethod');

    const deleteModal = document.getElementById('deleteModal');
    const closeDeleteModal = document.getElementById('closeDeleteModal');
    const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
    const deleteForm = document.getElementById('deleteForm');

    // Image upload elements
    const gambarMenuFile = document.getElementById('gambar_menu_file');
    const gambarMenuBase64 = document.getElementById('gambar_menu_base64');
    const gambarMenuPreview = document.getElementById('gambar_menu_preview');

    // Function to reset image preview
    function resetImagePreview() {
        gambarMenuFile.value = '';
        gambarMenuBase64.value = '';
        gambarMenuPreview.src = '';
        gambarMenuPreview.style.display = 'none';
    }

    // Handle image file selection
    gambarMenuFile.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                gambarMenuPreview.src = e.target.result;
                gambarMenuPreview.style.display = 'block';
                gambarMenuBase64.value = e.target.result; // Store base64 string
            };
            reader.readAsDataURL(file);
        } else {
            resetImagePreview();
        }
    });

    // Open Add Menu Modal
    addMenuBtn.addEventListener('click', function() {
        modalTitle.textContent = 'Tambah Item Menu';
        menuForm.setAttribute('action', "{{ route('menu.store') }}");
        formMethod.value = 'POST';
        menuForm.reset(); // Clear form fields
        resetImagePreview(); // Clear image preview
        menuModal.style.display = 'block';
    });

    // Open Edit Menu Modal
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const gambar_menu = this.dataset.gambar_menu; // This will be the base64 string
            const nama_menu = this.dataset.nama_menu;
            const stok_menu = this.dataset.stok_menu;
            const deskripsi_menu = this.dataset.deskripsi_menu;
            const kategori_menu = this.dataset.kategori_menu;
            const harga_menu = this.dataset.harga_menu;

            modalTitle.textContent = 'Edit Item Menu';
            menuForm.setAttribute('action', `/menu/${id}`); // Use dynamic route
            formMethod.value = 'PUT';

            // Set image preview and hidden input
            if (gambar_menu) {
                gambarMenuPreview.src = gambar_menu;
                gambarMenuPreview.style.display = 'block';
                gambarMenuBase64.value = gambar_menu;
            } else {
                resetImagePreview();
            }

            document.getElementById('nama_menu').value = nama_menu;
            document.getElementById('stok_menu').value = stok_menu;
            document.getElementById('deskripsi_menu').value = deskripsi_menu;
            document.getElementById('kategori_menu').value = kategori_menu;
            document.getElementById('harga_menu').value = harga_menu;

            menuModal.style.display = 'block';
        });
    });

    // Open Delete Confirmation Modal
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            deleteForm.setAttribute('action', `/menu/${id}`); // Use dynamic route
            deleteModal.style.display = 'block';
        });
    });

    // Close Modals
    closeModal.addEventListener('click', function() {
        menuModal.style.display = 'none';
    });
    cancelBtn.addEventListener('click', function() {
        menuModal.style.display = 'none';
    });
    closeDeleteModal.addEventListener('click', function() {
        deleteModal.style.display = 'none';
    });
    cancelDeleteBtn.addEventListener('click', function() {
        deleteModal.style.display = 'none';
    });

    window.addEventListener('click', function(event) {
        if (event.target == menuModal) {
            menuModal.style.display = 'none';
        }
        if (event.target == deleteModal) {
            deleteModal.style.display = 'none';
        }
    });
});
</script>
@endsection