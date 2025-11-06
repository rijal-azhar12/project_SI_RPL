@extends('layouts.app')

@section('content')
<div class="container">
    
    <div class="page-header">
        <div>
            <h1 class="page-title">Menu Management</h1>
            <p class="page-subtitle">Manage your menu items</p>
        </div>
        
        <div class="add-menu-btn" id="addMenuBtn">
            <span class="plus-icon">+</span>
            <span>Add Menu Item</span>
        </div>
    </div>

    <div class="menu-table">
        <div class="table-header">
            <div>#</div>
            <div>Image</div>
            <div>Menu Name</div>
            <div>Units</div>
            <div>Description</div>
            <div>Category</div>
            <div>Price</div>
            <div style="text-align: right;">Actions</div>
        </div>

        {{-- Baris 1 --}}
        <div class="table-row">
            <div class="item-number">1</div>
            <div class="item-image">
                <img src="https://placehold.co/100x100/A0522D/FFFFFF?text=Espresso" alt="Espresso">
            </div>
            <div class="item-name">Espresso</div>
            <div class="item-units">50</div>
            <div class="item-description">Lorem ipsum dolor sit amet consectetur</div>
            <div class="item-category">Drink</div>
            <div class="item-price">$1.50</div>
            <div class="item-actions">
                <div class="action-btn edit-btn" data-id="1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#C47E45" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 20h9"></path>
                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                    </svg>
                </div>
                <div class="action-btn delete-btn" data-id="1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#D9534F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        <line x1="10" y1="11" x2="10" y2="17"></line>
                        <line x1="14" y1="11" x2="14" y2="17"></line>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Baris 2 --}}
        <div class="table-row">
            <div class="item-number">2</div>
            <div class="item-image">
                <img src="https://placehold.co/100x100/CD853F/FFFFFF?text=Cappuccino" alt="Cappuccino">
            </div>
            <div class="item-name">Cappuccino</div>
            <div class="item-units">50</div>
            <div class="item-description">Lorem ipsum dolor sit amet consectetur</div>
            <div class="item-category">Drink</div>
            <div class="item-price">$2.05</div>
            <div class="item-actions">
                {{-- PERBAIKAN: Tombol disalin ke sini --}}
                <div class="action-btn edit-btn" data-id="2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#C47E45" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 20h9"></path>
                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                    </svg>
                </div>
                <div class="action-btn delete-btn" data-id="2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#D9534F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        <line x1="10" y1="11" x2="10" y2="17"></line>
                        <line x1="14" y1="11" x2="14" y2="17"></line>
                    </svg>
                </div>
            </div>
        </div>
        
        {{-- Baris 3 --}}
        <div class="table-row">
            <div class="item-number">3</div>
            <div class="item-image">
                <img src="https://placehold.co/100x100/FFD700/000000?text=Fries" alt="French Fries">
            </div>
            <div class="item-name">French Fries</div>
            <div class="item-units">45</div>
            <div class="item-description">Lorem ipsum dolor sit amet consectetur</div>
            <div class="item-category">Food</div>
            <div class="item-price">$1</div>
            <div class="item-actions">
                {{-- PERBAIKAN: Tombol disalin ke sini --}}
                <div class="action-btn edit-btn" data-id="3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#C47E45" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 20h9"></path>
                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                    </svg>
                </div>
                <div class="action-btn delete-btn" data-id="3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#D9534F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        <line x1="10" y1="11" x2="10" y2="17"></line>
                        <line x1="14" y1="11" x2="14" y2="17"></line>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Baris 4 --}}
        <div class="table-row">
            <div class="item-number">4</div>
            <div class="item-image">
                <img src="https://placehold.co/100x100/D2B48C/FFFFFF?text=Latte" alt="Latte">
            </div>
            <div class="item-name">Latte</div>
            <div class="item-units">50</div>
            <div class="item-description">Lorem ipsum dolor sit amet consectetur</div>
            <div class="item-category">Drink</div>
            <div class="item-price">$1.75</div>
            <div class="item-actions">
                {{-- PERBAIKAN: Tombol disalin ke sini --}}
                <div class="action-btn edit-btn" data-id="4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#C47E45" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 20h9"></path>
                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                    </svg>
                </div>
                <div class="action-btn delete-btn" data-id="4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#D9534F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        <line x1="10" y1="11" x2="10" y2="17"></line>
                        <line x1="14" y1="11" x2="14" y2="17"></line>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Baris 5 --}}
        <div class="table-row">
            <div class="item-number">5</div>
            <div class="item-image">
                <img src="https://placehold.co/100x100/FFA500/000000?text=Nugget" alt="Chicken Nugget">
            </div>
            <div class="item-name">Chicken Nugget</div>
            <div class="item-units">30</div>
            <div class="item-description">Lorem ipsum dolor sit amet consectetur</div>
            <div class="item-category">Food</div>
            <div class="item-price">$3 / 10 pcs</div>
            <div class="item-actions">
                {{-- PERBAIKAN: Tombol disalin ke sini --}}
                <div class="action-btn edit-btn" data-id="5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#C47E45" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 20h9"></path>
                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                    </svg>
                </div>
                <div class="action-btn delete-btn" data-id="5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#D9534F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        <line x1="10" y1="11" x2="10" y2="17"></line>
                        <line x1="14" y1="11" x2="14" y2="17"></line>
                    </svg>
                </div>
            </div>
        </div>
        
    </div>
</div>

<div class="modal" id="menuModal">
  <div class="modal-content">
    <div class="modal-header">
      <h2 class="modal-title" id="modalTitle">Add Menu Item</h2>
      <span class="close-btn" id="closeModal">&times;</span>
    </div>
    <form id="menuForm">
      <div class="form-group">
        <label for="menuImage">Image (File/URL)</label>
        <input type="text" id="menuImage" placeholder="Enter image URL or upload file">
      </div>
      <div class="form-group">
        <label for="menuName">Menu Name *</label>
        <input type="text" id="menuName" required>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label for="menuUnits">Units *</label>
          <input type="number" id="menuUnits" required>
        </div>
        <div class="form-group">
          <label for="menuDescription">Description</label>
          <textarea id="menuDescription"></textarea>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label for="menuCategory">Category *</label>
          <select id="menuCategory" required>
            <option value="">Select Category</option>
            <option value="Drink">Drink</option>
            <option value="Food">Food</option>
          </select>
        </div>
        <div class="form-group">
          <label for="menuPrice">Price *</label>
          <input type="text" id="menuPrice" required>
        </div>
      </div>
      <div class="form-actions">
        <button type="button" class="btn btn-secondary" id="cancelBtn">Cancel</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>

<div class="modal confirmation-modal" id="deleteModal">
  <div class="modal-content">
    <div class="modal-header">
      <h2 class="modal-title">Delete Menu Item</h2>
      <span class="close-btn" id="closeDeleteModal">&times;</span>
    </div>
    <p class="confirmation-text">Are you sure you want to delete this menu item?</p>
    <div class="form-actions">
      <button type="button" class="btn btn-secondary" id="cancelDeleteBtn">Cancel</button>
      <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
    </div>
  </div>
</div>

{{-- Modal HTML (Tidak berubah, tapi ukuran font/padding di dalamnya akan mengecil karena CSS baru) --}}
<div class="modal" id="menuModal">
  {{-- ... Konten modal Anda ... --}}
</div>
<div class="modal confirmation-modal" id="deleteModal">
  {{-- ... Konten modal Anda ... --}}
</div>
@endsection