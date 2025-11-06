<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Papacino - Menu Management</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: #F2E3D5;
      color: #5E3A2F;
      min-height: 100vh;
    }

    /* Header Styles */
    .header {
      width: 100%;
      height: 125px;
      background: white;
      box-shadow: 0px 2px 4px -2px rgba(0, 0, 0, 0.10);
      display: flex;
      align-items: center;
      padding: 0 20px;
      position: relative;
    }

    .logo {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    /* PERUBAHAN: Style untuk tag <img> logo */
    .logo-img {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      background: #ddd;
      /* Fallback jika gambar tidak ada */
      object-fit: cover;
      /* Memastikan gambar pas */
    }

    .logo-text {
      font-size: 32px;
      font-weight: 400;
    }

    .nav-menu {
      display: flex;
      gap: 15px;
      margin-left: auto;
    }

    /* PERUBAHAN: Selector diubah dari 'div.nav-item' menjadi 'a.nav-item' */
    .nav-item {
      width: 175px;
      height: 50px;
      background: rgba(229, 229, 229, 0.5);
      border-radius: 20px;
      border: 1px solid #E5E5E5;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      font-size: 24px;
      cursor: pointer;
      transition: all 0.3s;
      /* TAMBAHAN: Style untuk tag <a> */
      text-decoration: none;
      color: #5E3A2F;
    }

    .nav-item.active {
      background: #C47E45;
      color: white;
    }

    .nav-item:hover:not(.active) {
      background: rgba(229, 229, 229, 0.9);
    }

    .nav-item.logout {
      background: rgba(229, 229, 229, 0.25);
      color: #FE0000;
    }

    .nav-item.logout:hover {
      background: rgba(229, 229, 229, 0.5);
    }

    .nav-item.owner {
      background: #5E3A2F;
      color: white;
    }

    .nav-item.owner:hover {
      background: #4a2e25;
    }

    /* Main Content */
    .container {
      max-width: 1850px;
      margin: 0 auto;
      padding: 20px;
    }

    .page-header {
      margin-bottom: 30px;
    }

    .page-title {
      font-size: 48px;
      font-weight: 600;
      margin-bottom: 10px;
    }

    .page-subtitle {
      font-size: 24px;
      opacity: 0.7;
    }

    .add-menu-btn {
      width: 350px;
      height: 75px;
      background: #C47E45;
      border-radius: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 15px;
      color: white;
      font-size: 24px;
      font-weight: 500;
      cursor: pointer;
      margin-left: auto;
      margin-bottom: 20px;
      box-shadow: 0px 2px 4px -2px rgba(0, 0, 0, 0.10);
      transition: all 0.3s;
    }

    .add-menu-btn:hover {
      background: #b36d35;
    }

    /* PERUBAHAN: Style untuk icon '+' baru */
    .add-menu-btn .plus-icon {
      font-size: 40px;
      font-weight: 300;
      line-height: 1;
    }

    /* Table Styles */
    .menu-table {
      width: 100%;
      background: white;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .table-header {
      display: grid;
      grid-template-columns: 80px 150px 1fr 100px 1fr 175px 120px 150px;
      padding: 20px 30px;
      background: white;
      font-size: 24px;
      font-weight: 500;
      border-bottom: 1px solid #E5E5E5;
    }

    .table-row {
      display: grid;
      grid-template-columns: 80px 150px 1fr 100px 1fr 175px 120px 150px;
      padding: 20px 30px;
      align-items: center;
      border-bottom: 1px solid #E5E5E5;
    }

    .table-row:last-child {
      border-bottom: none;
    }

    .item-number {
      font-size: 20px;
      font-weight: 500;
      text-align: center;
    }

    .item-image {
      width: 100px;
      height: 100px;
      border-radius: 10px;
      background: #ddd;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }

    .item-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .item-name {
      font-size: 20px;
      font-weight: 500;
    }

    .item-units {
      font-size: 20px;
      font-weight: 500;
      text-align: center;
    }

    .item-description {
      font-size: 20px;
      color: #5E3A2F;
    }

    .item-category {
      width: 175px;
      height: 75px;
      background: #F2E3D5;
      border-radius: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      font-weight: 500;
    }

    .item-price {
      font-size: 20px;
      font-weight: 500;
    }

    .item-actions {
      display: flex;
      gap: 15px;
      justify-content: flex-end;
    }

    .action-btn {
      width: 75px;
      height: 75px;
      background: rgba(229, 229, 229, 0.5);
      border-radius: 20px;
      border: 1px solid #E5E5E5;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.3s;
    }

    .action-btn:hover {
      background: rgba(229, 229, 229, 0.8);
    }


    /* TAMBAHAN: Style untuk ikon SVG di dalam tombol aksi */
    .action-btn svg {
      width: 30px;
      height: 30px;
    }

    /* Modal Styles */
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 1000;
      align-items: center;
      justify-content: center;
    }

    .modal.active {
      display: flex;
    }

    .modal-content {
      background-color: white;
      border-radius: 20px;
      width: 90%;
      max-width: 800px;
      padding: 30px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .modal-title {
      font-size: 32px;
      font-weight: 600;
    }

    .close-btn {
      font-size: 28px;
      cursor: pointer;
      color: #5E3A2F;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      font-size: 20px;
      margin-bottom: 10px;
      font-weight: 500;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
      width: 100%;
      padding: 15px;
      border: 1px solid #E5E5E5;
      border-radius: 10px;
      font-size: 18px;
      font-family: 'Poppins', sans-serif;
    }

    .form-group textarea {
      height: 100px;
      resize: vertical;
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }

    .form-actions {
      display: flex;
      justify-content: flex-end;
      gap: 15px;
      margin-top: 30px;
    }

    .btn {
      padding: 15px 30px;
      border-radius: 10px;
      font-size: 20px;
      font-weight: 500;
      cursor: pointer;
      border: none;
      transition: all 0.3s;
    }

    .btn-primary {
      background-color: #C47E45;
      color: white;
    }

    .btn-primary:hover {
      background-color: #b36d35;
    }

    .btn-secondary {
      background-color: #E5E5E5;
      color: #5E3A2F;
    }

    .btn-secondary:hover {
      background-color: #d4d4d4;
    }

    .btn-danger {
      background-color: #D9534F;
      color: white;
    }

    .btn-danger:hover {
      background-color: #c9302c;
    }

    /* Confirmation Modal */
    .confirmation-modal .modal-content {
      max-width: 500px;
      text-align: center;
    }

    .confirmation-text {
      font-size: 24px;
      margin-bottom: 30px;
    }

    /* Responsive Styles (Tidak ada perubahan di sini) */
    @media (max-width: 1600px) {

      .table-header,
      .table-row {
        grid-template-columns: 60px 120px 1fr 80px 1fr 150px 100px 130px;
        padding: 15px 20px;
      }

      .header {
        padding: 0 15px;
      }

      .nav-item {
        width: 150px;
        font-size: 20px;
      }
    }

    @media (max-width: 1200px) {

      .table-header,
      .table-row {
        grid-template-columns: 50px 100px 1fr 70px 1fr 130px 90px 110px;
        font-size: 18px;
        padding: 12px 15px;
      }

      .item-image {
        width: 80px;
        height: 80px;
      }

      .item-category {
        width: 175px;
        height: 75px;
        background: #F2E3D5;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        font-weight: 500;
        justify-self: center;
      }

      .action-btn {
        width: 60px;
        height: 60px;
      }

      .action-btn svg {
        width: 24px;
        height: 24px;
      }

      .nav-menu {
        gap: 10px;
      }

      .nav-item {
        width: 130px;
        font-size: 18px;
      }
    }

    @media (max-width: 768px) {
      .container {
        padding: 10px;
      }

      .page-title {
        font-size: 36px;
      }

      .add-menu-btn {
        width: 100%;
        margin-bottom: 15px;
      }

      .table-header {
        display: none;
      }

      .table-row {
        grid-template-columns: 1fr;
        gap: 10px;
        padding: 15px;
        border: 1px solid #E5E5E5;
        border-radius: 10px;
        margin-bottom: 10px;
      }

      .item-info {
        display: grid;
        grid-template-columns: 80px 1fr;
        gap: 10px;
        align-items: center;
      }

      .item-details {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
      }

      .item-actions {
        justify-content: center;
        margin-top: 10px;
      }

      .header {
        height: auto;
        padding: 15px;
        flex-direction: column;
        gap: 15px;
      }

      .nav-menu {
        margin-left: 0;
        flex-wrap: wrap;
        justify-content: center;
      }

      .form-row {
        grid-template-columns: 1fr;
      }
    }

    /* BARU: Menengahkan heading tabel tertentu */
    .table-header>div:nth-child(4),
    .table-header>div:nth-child(6),
    .table-header>div:nth-child(7) {
      text-align: center;
    }
  </style>
</head>

<body>
  <header class="header">
    <div class="logo">
      <img src="https://placehold.co/80x80/D9534F/FFFFFF?text=Logo" alt="Papacino Logo" class="logo-img">
      <div class="logo-text">Papacino Snacks & Drinks</div>
    </div>

    <nav class="nav-menu">
      <a href="menu.html" class="nav-item active">
        <span>&#9776;</span> Menu
      </a>
      <a href="expenses.html" class="nav-item">
        <span>$</span>
        Expenses
      </a>
      <a href="incomes.html" class="nav-item">
        <span>$</span>
        Incomes
      </a>
      <a href="accounts.html" class="nav-item">
        <span>&#128100;</span> Accounts
      </a>
      <a href="owner.html" class="nav-item owner">
        <span>&#128100;</span> Owner
      </a>
      <a href="logout.html" class="nav-item logout">
        <span>&#10162;</span> Logout
      </a>
    </nav>
  </header>

  <main class="container">
    <div class="page-header">
      <h1 class="page-title">Menu Management</h1>
      <p class="page-subtitle">Manage your menu items</p>
    </div>

    <div class="add-menu-btn" id="addMenuBtn">
      <span class="plus-icon">+</span>
      <span>Add Menu Item</span>
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
  </main>

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

  <script>
    // TIDAK ADA PERUBAHAN PADA JAVASCRIPT
    // Logika Anda untuk modal dan aksi tombol sudah solid dan 
    // tidak terpengaruh oleh perubahan struktur HTML ringan di atas.

    // DOM Elements
    const addMenuBtn = document.getElementById('addMenuBtn');
    const menuModal = document.getElementById('menuModal');
    const deleteModal = document.getElementById('deleteModal');
    const closeModal = document.getElementById('closeModal');
    const cancelBtn = document.getElementById('cancelBtn');
    const closeDeleteModal = document.getElementById('closeDeleteModal');
    const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    const menuForm = document.getElementById('menuForm');
    const modalTitle = document.getElementById('modalTitle');

    // Edit and Delete buttons
    const editButtons = document.querySelectorAll('.edit-btn');
    const deleteButtons = document.querySelectorAll('.delete-btn');

    // Current menu item being edited or deleted
    let currentMenuItemId = null;

    // Event Listeners
    addMenuBtn.addEventListener('click', () => {
      modalTitle.textContent = 'Add Menu Item';
      menuForm.reset();
      menuModal.classList.add('active');
    });

    closeModal.addEventListener('click', () => {
      menuModal.classList.remove('active');
    });

    cancelBtn.addEventListener('click', () => {
      menuModal.classList.remove('active');
    });

    closeDeleteModal.addEventListener('click', () => {
      deleteModal.classList.remove('active');
    });

    cancelDeleteBtn.addEventListener('click', () => {
      deleteModal.classList.remove('active');
    });

    // Edit button click
    editButtons.forEach(button => {
      button.addEventListener('click', () => {
        currentMenuItemId = button.getAttribute('data-id');
        modalTitle.textContent = `Edit Menu Item #${currentMenuItemId}`;

        // In a real application, you would fetch the menu item data
        // For this example, we'll just populate with dummy data
        const row = button.closest('.table-row');
        const menuName = row.querySelector('.item-name').textContent;
        const menuUnits = row.querySelector('.item-units').textContent;
        const menuDescription = row.querySelector('.item-description').textContent;
        const menuCategory = row.querySelector('.item-category').textContent;
        const menuPrice = row.querySelector('.item-price').textContent;

        document.getElementById('menuName').value = menuName;
        document.getElementById('menuUnits').value = menuUnits;
        document.getElementById('menuDescription').value = menuDescription;
        document.getElementById('menuCategory').value = menuCategory;
        document.getElementById('menuPrice').value = menuPrice;

        menuModal.classList.add('active');
      });
    });

    // Delete button click
    deleteButtons.forEach(button => {
      button.addEventListener('click', () => {
        currentMenuItemId = button.getAttribute('data-id');
        deleteModal.classList.add('active');
      });
    });

    // Confirm delete
    confirmDeleteBtn.addEventListener('click', () => {
      // In a real application, you would send a delete request to the server
      alert(`Menu item with ID ${currentMenuItemId} has been deleted.`);
      deleteModal.classList.remove('active');

      // Remove the row from the table
      const rowToDelete = document.querySelector(`.delete-btn[data-id="${currentMenuItemId}"]`).closest('.table-row');
      rowToDelete.remove();

      // Update the numbering of remaining rows
      updateRowNumbers();
    });

    // Form submission
    menuForm.addEventListener('submit', (e) => {
      e.preventDefault();

      // In a real application, you would send the form data to the server
      const menuName = document.getElementById('menuName').value;
      const menuUnits = document.getElementById('menuUnits').value;
      const menuDescription = document.getElementById('menuDescription').value;
      const menuCategory = document.getElementById('menuCategory').value;
      const menuPrice = document.getElementById('menuPrice').value;

      if (currentMenuItemId) {
        // Editing existing item
        const rowToEdit = document.querySelector(`.edit-btn[data-id="${currentMenuItemId}"]`).closest('.table-row');
        rowToEdit.querySelector('.item-name').textContent = menuName;
        rowToEdit.querySelector('.item-units').textContent = menuUnits;
        rowToEdit.querySelector('.item-description').textContent = menuDescription;
        rowToEdit.querySelector('.item-category').textContent = menuCategory;
        rowToEdit.querySelector('.item-price').textContent = menuPrice;

        alert(`Menu item #${currentMenuItemId} has been updated.`);
      } else {
        // Adding new item
        alert(`New menu item "${menuName}" has been added.`);
        // In a real application, you would add the new row to the table
      }

      menuModal.classList.remove('active');
      currentMenuItemId = null;
    });

    // Function to update row numbers after deletion
    function updateRowNumbers() {
      const rows = document.querySelectorAll('.table-row');
      rows.forEach((row, index) => {
        row.querySelector('.item-number').textContent = index + 1;
      });
    }

    // Close modals when clicking outside
    window.addEventListener('click', (e) => {
      if (e.target === menuModal) {
        menuModal.classList.remove('active');
      }
      if (e.target === deleteModal) {
        deleteModal.classList.remove('active');
      }
    });
  </script>
</body>

</html>