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

}); // --- Akhir dari 'DOMContentLoaded' ---