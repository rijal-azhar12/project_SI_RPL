@extends('layouts.app')

@section('content')
<div class="container">

    <div class="page-header">
        <div>
            <h1 class="page-title">Manajemen Menu</h1>
            <p class="page-subtitle">Kelola menu anda</p>
        </div>

        <div class="add-btn" id="addMenuBtn">
            <span>+</span>
            <span>Tambah Menu</span>
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
        <div class="table-header">
            <div>#</div>
            <div>Gambar</div>
            <div>Nama Menu</div>
            <div>Stok</div>
            <div>Deskripsi</div>
            <div>Kategori</div>
            <div>Harga</div>
            <div>Aksi</div>
        </div>

        @forelse ($menus as $menu)
        <div class="table-row">
            <div class="item-number">{{ $user->id_user }}</div>
            <div class="item-image">
                <img src="{{ $menu->gambar_menu }}">
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
                    <img src="{{ asset('image/icon_edit.png') }}" alt="Edit">
                </div>
                <div class="action-btn delete-btn" data-id="{{ $menu->id_menu }}">
                    <img src="{{ asset('image/icon_delete.png') }}" alt="Delete">
                </div>
            </div>
        </div>
        @empty
        <div class="table-row">
            <div class="item-number" style="grid-column: 1 / -1; text-align: center;">Tidak ada menu ditemukan.
            </div>
        </div>
        @endforelse
    </div>
</div>

<div class="modal" id="menuModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title" id="modalTitle"></h2>
            <span class="close-btn" id="closeModal">X</span>
        </div>
        <form id="menuForm" method="POST" action="{{ route('menu.store') }}">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="form-group">
                <label for="gambar_menu_file">Unggah Gambar</label>
                <input type="file" id="gambar_menu_file" name="gambar_menu_file" accept="image/*">
                <input type="hidden" id="gambar_menu_base64" name="gambar_menu">
                <img id="gambar_menu_preview" src=""
                    style="max-width: 200px; max-height: 200px; margin-top: 5px; display: none;">
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
                    <textarea id="deskripsi_menu" name="deskripsi_menu"></textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="kategori_menu">Kategori *</label>
                    <select id="kategori_menu" name="kategori_menu" required>
                        <option value="">Pilih Kategori</option>
                        <option value="Makanan">Makanan</option>
                        <option value="Minuman">Minuman</option>
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

<div class="modal confirmation-modal" id="deleteModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title" id="modalDeleteTitle"></h2>
            <span class="close-btn" id="closeDeleteModal">X</span>
        </div>
        <p class="confirmation-text">Apakah anda yakin ingin menghapus menu ini?</p>
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

        const gambarMenuFile = document.getElementById('gambar_menu_file');
        const gambarMenuBase64 = document.getElementById('gambar_menu_base64');
        const gambarMenuPreview = document.getElementById('gambar_menu_preview');

        function resetImagePreview() {
            gambarMenuFile.value = '';
            gambarMenuBase64.value = '';
            gambarMenuPreview.src = '';
            gambarMenuPreview.style.display = 'none';
        }

        gambarMenuFile.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    gambarMenuPreview.src = e.target.result;
                    gambarMenuPreview.style.display = 'block';
                    gambarMenuBase64.value = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                resetImagePreview();
            }
        });

        addMenuBtn.addEventListener('click', function() {
            modalTitle.textContent = 'Tambah Menu';
            menuForm.setAttribute('action', "{{ route('menu.store') }}");
            formMethod.value = 'PUT';
            menuForm.reset();
            resetImagePreview();
            menuModal.style.display = 'block';
        });

        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const gambar_menu = this.dataset.gambar_menu;
                const nama_menu = this.dataset.nama_menu;
                const stok_menu = this.dataset.stok_menu;
                const deskripsi_menu = this.dataset.deskripsi_menu;
                const kategori_menu = this.dataset.kategori_menu;
                const harga_menu = this.dataset.harga_menu;

                modalTitle.textContent = `Edit Menu #${id}`;
                menuForm.setAttribute('action', `/menu/${id}`);
                formMethod.value = 'PUT';

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

        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;

                modalDeleteTitle.textContent = `Hapus Menu #${id}`;
                deleteForm.setAttribute('action', `/menu/${id}`)
                deleteModal.style.display = 'block';
            });
        });

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