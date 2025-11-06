/*
  Bungkus utama: 
  Hanya jalankan kode di dalamnya setelah halaman HTML selesai dimuat.
*/
document.addEventListener('DOMContentLoaded', function() {

  // --- Seleksi Elemen Menu ---
  // Kita cek, "Apakah kita di halaman menu?"
  // dengan mencari tombol 'Add Menu'.
  const addMenuBtn = document.getElementById('addMenuBtn');
  
  // Jika tombol itu ada, jalankan semua skrip untuk modal.
  if (addMenuBtn) {

    // --- Ini adalah semua kode JavaScript Anda dari awal ---

    // DOM Elements
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
    
    // Variabel untuk melacak item mana yang sedang di-edit/hapus
    let currentMenuItemId = null;
    
    // Event Listeners
    addMenuBtn.addEventListener('click', () => {
      currentMenuItemId = null; // Pastikan ini item baru
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
        
        // Ambil data dari baris tabel yang diklik
        const row = button.closest('.table-row');
        const menuName = row.querySelector('.item-name').textContent;
        const menuUnits = row.querySelector('.item-units').textContent;
        const menuDescription = row.querySelector('.item-description').textContent;
        const menuCategory = row.querySelector('.item-category').textContent;
        const menuPrice = row.querySelector('.item-price').textContent;
        
        // Isi form modal dengan data
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
      // (Di aplikasi nyata, kirim delete request ke server di sini)
      alert(`Menu item with ID ${currentMenuItemId} has been deleted.`);
      deleteModal.classList.remove('active');
      
      // Hapus baris dari tabel
      const rowToDelete = document.querySelector(`.delete-btn[data-id="${currentMenuItemId}"]`).closest('.table-row');
      rowToDelete.remove();
      
      // Perbarui nomor urut
      updateRowNumbers();
    });
    
    // Form submission (untuk Add atau Edit)
    menuForm.addEventListener('submit', (e) => {
      e.preventDefault();
      
      const menuName = document.getElementById('menuName').value;
      const menuUnits = document.getElementById('menuUnits').value;
      const menuDescription = document.getElementById('menuDescription').value;
      const menuCategory = document.getElementById('menuCategory').value;
      const menuPrice = document.getElementById('menuPrice').value;
      
      if (currentMenuItemId) {
        // --- LOGIKA EDIT ---
        // (Di aplikasi nyata, kirim update request ke server)
        const rowToEdit = document.querySelector(`.edit-btn[data-id="${currentMenuItemId}"]`).closest('.table-row');
        rowToEdit.querySelector('.item-name').textContent = menuName;
        rowToEdit.querySelector('.item-units').textContent = menuUnits;
        rowToEdit.querySelector('.item-description').textContent = menuDescription;
        rowToEdit.querySelector('.item-category').textContent = menuCategory;
        rowToEdit.querySelector('.item-price').textContent = menuPrice;
        
        alert(`Menu item #${currentMenuItemId} has been updated.`);
      } else {
        // --- LOGIKA ADD ---
        // (Di aplikasi nyata, kirim create request ke server)
        alert(`New menu item "${menuName}" has been added.`);
        // (Di aplikasi nyata, Anda akan menambah baris baru ke tabel)
      }
      
      menuModal.classList.remove('active');
      currentMenuItemId = null;
    });
    
    // Fungsi untuk memperbarui nomor urut setelah delete
    function updateRowNumbers() {
      const rows = document.querySelectorAll('.table-row');
      rows.forEach((row, index) => {
        row.querySelector('.item-number').textContent = index + 1;
      });
    }
    
    // Menutup modal jika klik di luar area modal
    window.addEventListener('click', (e) => {
      if (e.target === menuModal) {
        menuModal.classList.remove('active');
      }
      if (e.target === deleteModal) {
        deleteModal.classList.remove('active');
      }
    });

  } // --- Akhir dari 'if (addMenuBtn)' ---

  // ===============================================
// TAMBAHKAN KODE INI DI DALAM LISTENER DOMContentLoaded
// (di bawah blok 'if (addMenuBtn)')
// ===============================================

  // --- Seleksi Elemen Expense ---
  const addExpenseBtn = document.getElementById('addExpenseBtn');

  // Jika tombol 'Add Expense' ada, jalankan skrip modal expense
  if (addExpenseBtn) {

    // DOM Elements
    const expenseModal = document.getElementById('expenseModal');
    const deleteExpenseModal = document.getElementById('deleteExpenseModal');
    const closeExpenseModal = document.getElementById('closeExpenseModal');
    const cancelExpenseBtn = document.getElementById('cancelExpenseBtn');
    const closeDeleteExpenseModal = document.getElementById('closeDeleteExpenseModal');
    const cancelDeleteExpenseBtn = document.getElementById('cancelDeleteExpenseBtn');
    const confirmDeleteExpenseBtn = document.getElementById('confirmDeleteExpenseBtn');
    const expenseForm = document.getElementById('expenseForm');
    const expenseModalTitle = document.getElementById('expenseModalTitle');

    const editExpenseButtons = document.querySelectorAll('.edit-expense-btn');
    const deleteExpenseButtons = document.querySelectorAll('.delete-expense-btn');

    let currentExpenseId = null;

    // Event Listeners
    addExpenseBtn.addEventListener('click', () => {
      currentExpenseId = null;
      expenseModalTitle.textContent = 'Add Expense';
      expenseForm.reset();
      expenseModal.classList.add('active');
    });

    closeExpenseModal.addEventListener('click', () => expenseModal.classList.remove('active'));
    cancelExpenseBtn.addEventListener('click', () => expenseModal.classList.remove('active'));
    closeDeleteExpenseModal.addEventListener('click', () => deleteExpenseModal.classList.remove('active'));
    cancelDeleteExpenseBtn.addEventListener('click', () => deleteExpenseModal.classList.remove('active'));

    // Edit button click
    editExpenseButtons.forEach(button => {
      button.addEventListener('click', () => {
        currentExpenseId = button.getAttribute('data-id');
        expenseModalTitle.textContent = `Edit Expense #${currentExpenseId}`;
        
        const row = button.closest('.table-row');
        const timestamp = row.querySelector('.item-timestamp').textContent;
        const description = row.querySelector('.item-description').textContent;
        const amount = row.querySelector('.item-price').textContent.replace('$', ''); // Hapus '$'
        
        // Perlu format 'YYYY-MM-DDTHH:mm' untuk input datetime-local
        // Ini adalah contoh, mungkin perlu penyesuaian format tanggal
        // const formattedTimestamp = new Date(timestamp).toISOString().slice(0, 16);
        
        document.getElementById('expenseDescription').value = description;
        document.getElementById('expenseAmount').value = amount;
        // document.getElementById('expenseTimestamp').value = formattedTimestamp;
        
        expenseModal.classList.add('active');
      });
    });

    // Delete button click
    deleteExpenseButtons.forEach(button => {
      button.addEventListener('click', () => {
        currentExpenseId = button.getAttribute('data-id');
        deleteExpenseModal.classList.add('active');
      });
    });

    // Confirm delete
    confirmDeleteExpenseBtn.addEventListener('click', () => {
      alert(`Expense item with ID ${currentExpenseId} has been deleted.`);
      deleteExpenseModal.classList.remove('active');
      // Logika hapus baris...
    });

    // Form submission
    expenseForm.addEventListener('submit', (e) => {
      e.preventDefault();
      if (currentExpenseId) {
        alert(`Expense #${currentExpenseId} has been updated.`);
      } else {
        alert('New expense has been added.');
      }
      expenseModal.classList.remove('active');
      currentExpenseId = null;
    });
  }

  // ===============================================
// TAMBAHKAN KODE INI DI DALAM LISTENER DOMContentLoaded
// (di bawah blok 'if (addExpenseBtn)')
// ===============================================

  // --- Seleksi Elemen Income ---
  const editIncomeButtons = document.querySelectorAll('.edit-income-btn');
  
  // Kita cek berdasarkan tombol edit, karena tidak ada tombol 'Add' di header
  if (editIncomeButtons.length > 0) {
    
    // DOM Elements
    const incomeModal = document.getElementById('incomeModal');
    const deleteIncomeModal = document.getElementById('deleteIncomeModal');
    const closeIncomeModal = document.getElementById('closeIncomeModal');
    const cancelIncomeBtn = document.getElementById('cancelIncomeBtn');
    const closeDeleteIncomeModal = document.getElementById('closeDeleteIncomeModal');
    const cancelDeleteIncomeBtn = document.getElementById('cancelDeleteIncomeBtn');
    const confirmDeleteIncomeBtn = document.getElementById('confirmDeleteIncomeBtn');
    const incomeForm = document.getElementById('incomeForm');
    const incomeModalTitle = document.getElementById('incomeModalTitle');
    const deleteIncomeButtons = document.querySelectorAll('.delete-income-btn');
    
    let currentIncomeId = null;

    // Event Listeners
    closeIncomeModal.addEventListener('click', () => incomeModal.classList.remove('active'));
    cancelIncomeBtn.addEventListener('click', () => incomeModal.classList.remove('active'));
    closeDeleteIncomeModal.addEventListener('click', () => deleteIncomeModal.classList.remove('active'));
    cancelDeleteIncomeBtn.addEventListener('click', () => deleteIncomeModal.classList.remove('active'));

    // Edit button click
    editIncomeButtons.forEach(button => {
      button.addEventListener('click', () => {
        currentIncomeId = button.getAttribute('data-id');
        incomeModalTitle.textContent = `Edit Income #${currentIncomeId}`;
        
        const row = button.closest('.table-row');
        const cashier = row.querySelector('.item-cashier').textContent;
        // const timestamp = row.querySelector('.item-timestamp').textContent;
        const menuName = row.querySelector('.item-name').textContent;
        const category = row.querySelector('.item-category-tag').textContent;
        const unit = row.querySelector('.item-units').textContent;
        const unitPrice = row.querySelector('.item-price').textContent; // Ambil harga pertama (unit price)
        
        // Isi form modal
        document.getElementById('incomeCashier').value = cashier;
        document.getElementById('incomeMenuName').value = menuName;
        document.getElementById('incomeCategory').value = category;
        document.getElementById('incomeUnit').value = unit;
        document.getElementById('incomeUnitPrice').value = unitPrice;
        // (Timestamp perlu parsing, sama seperti expense)
        
        incomeModal.classList.add('active');
      });
    });

    // Delete button click
    deleteIncomeButtons.forEach(button => {
      button.addEventListener('click', () => {
        currentIncomeId = button.getAttribute('data-id');
        deleteIncomeModal.classList.add('active');
      });
    });

    // Confirm delete
    confirmDeleteIncomeBtn.addEventListener('click', () => {
      alert(`Income record with ID ${currentIncomeId} has been deleted.`);
      deleteIncomeModal.classList.remove('active');
      // Logika hapus baris...
    });

    // Form submission
    incomeForm.addEventListener('submit', (e) => {
      e.preventDefault();
      alert(`Income record #${currentIncomeId} has been updated.`);
      incomeModal.classList.remove('active');
      currentIncomeId = null;
    });
  }


}); // --- Akhir dari 'DOMContentLoaded' ---