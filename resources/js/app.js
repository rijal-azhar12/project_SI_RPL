document.addEventListener("DOMContentLoaded", function () {
    const addMenuBtn = document.getElementById("addMenuBtn");

    if (addMenuBtn) {
        const menuModal = document.getElementById("menuModal");
        const deleteModal = document.getElementById("deleteModal");
        const closeModal = document.getElementById("closeModal");
        const cancelBtn = document.getElementById("cancelBtn");
        const closeDeleteModal = document.getElementById("closeDeleteModal");
        const cancelDeleteBtn = document.getElementById("cancelDeleteBtn");
        const confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
        const menuForm = document.getElementById("menuForm");
        const modalTitle = document.getElementById("modalTitle");

        const editButtons = document.querySelectorAll(".edit-btn");
        const deleteButtons = document.querySelectorAll(".delete-btn");

        let currentMenuItemId = null;

        addMenuBtn.addEventListener("click", () => {
            currentMenuItemId = null;
            modalTitle.textContent = "Add Menu Item";
            menuForm.reset();
            menuModal.classList.add("active");
        });

        closeModal.addEventListener("click", () => {
            menuModal.classList.remove("active");
        });

        cancelBtn.addEventListener("click", () => {
            menuModal.classList.remove("active");
        });

        closeDeleteModal.addEventListener("click", () => {
            deleteModal.classList.remove("active");
        });

        cancelDeleteBtn.addEventListener("click", () => {
            deleteModal.classList.remove("active");
        });

        editButtons.forEach((button) => {
            button.addEventListener("click", () => {
                currentMenuItemId = button.getAttribute("data-id");
                modalTitle.textContent = `Edit Menu Item #${currentMenuItemId}`;

                const row = button.closest(".table-row");
                const menuName = row.querySelector(".item-name").textContent;
                const menuUnits = row.querySelector(".item-units").textContent;
                const menuDescription =
                    row.querySelector(".item-description").textContent;
                const menuCategory =
                    row.querySelector(".item-category").textContent;
                const menuPrice = row.querySelector(".item-price").textContent;

                document.getElementById("menuName").value = menuName;
                document.getElementById("menuUnits").value = menuUnits;
                document.getElementById("menuDescription").value =
                    menuDescription;
                document.getElementById("menuCategory").value = menuCategory;
                document.getElementById("menuPrice").value = menuPrice;

                menuModal.classList.add("active");
            });
        });

        deleteButtons.forEach((button) => {
            button.addEventListener("click", () => {
                currentMenuItemId = button.getAttribute("data-id");
                deleteModal.classList.add("active");
            });
        });

        confirmDeleteBtn.addEventListener("click", () => {
            alert(`Menu item with ID ${currentMenuItemId} has been deleted.`);
            deleteModal.classList.remove("active");

            const rowToDelete = document
                .querySelector(`.delete-btn[data-id="${currentMenuItemId}"]`)
                .closest(".table-row");
            rowToDelete.remove();

            updateRowNumbers();
        });

        menuForm.addEventListener("submit", (e) => {
            e.preventDefault();

            const menuName = document.getElementById("menuName").value;
            const menuUnits = document.getElementById("menuUnits").value;
            const menuDescription =
                document.getElementById("menuDescription").value;
            const menuCategory = document.getElementById("menuCategory").value;
            const menuPrice = document.getElementById("menuPrice").value;

            if (currentMenuItemId) {
                const rowToEdit = document
                    .querySelector(`.edit-btn[data-id="${currentMenuItemId}"]`)
                    .closest(".table-row");
                rowToEdit.querySelector(".item-name").textContent = menuName;
                rowToEdit.querySelector(".item-units").textContent = menuUnits;
                rowToEdit.querySelector(".item-description").textContent =
                    menuDescription;
                rowToEdit.querySelector(".item-category").textContent =
                    menuCategory;
                rowToEdit.querySelector(".item-price").textContent = menuPrice;

                alert(`Menu item #${currentMenuItemId} has been updated.`);
            } else {
                alert(`New menu item "${menuName}" has been added.`);
            }

            menuModal.classList.remove("active");
            currentMenuItemId = null;
        });

        function updateRowNumbers() {
            const rows = document.querySelectorAll(".table-row");
            rows.forEach((row, index) => {
                row.querySelector(".item-number").textContent = index + 1;
            });
        }

        window.addEventListener("click", (e) => {
            if (e.target === menuModal) {
                menuModal.classList.remove("active");
            }
            if (e.target === deleteModal) {
                deleteModal.classList.remove("active");
            }
        });
    }

    const addExpenseBtn = document.getElementById("addExpenseBtn");

    if (addExpenseBtn) {
        const expenseModal = document.getElementById("expenseModal");
        const deleteExpenseModal =
            document.getElementById("deleteExpenseModal");
        const closeExpenseModal = document.getElementById("closeExpenseModal");
        const cancelExpenseBtn = document.getElementById("cancelExpenseBtn");
        const closeDeleteExpenseModal = document.getElementById(
            "closeDeleteExpenseModal"
        );
        const cancelDeleteExpenseBtn = document.getElementById(
            "cancelDeleteExpenseBtn"
        );
        const confirmDeleteExpenseBtn = document.getElementById(
            "confirmDeleteExpenseBtn"
        );
        const expenseForm = document.getElementById("expenseForm");
        const expenseModalTitle = document.getElementById("expenseModalTitle");

        const editExpenseButtons =
            document.querySelectorAll(".edit-expense-btn");
        const deleteExpenseButtons = document.querySelectorAll(
            ".delete-expense-btn"
        );

        let currentExpenseId = null;

        addExpenseBtn.addEventListener("click", () => {
            currentExpenseId = null;
            expenseModalTitle.textContent = "Add Expense";
            expenseForm.reset();
            expenseModal.classList.add("active");
        });

        closeExpenseModal.addEventListener("click", () =>
            expenseModal.classList.remove("active")
        );
        cancelExpenseBtn.addEventListener("click", () =>
            expenseModal.classList.remove("active")
        );
        closeDeleteExpenseModal.addEventListener("click", () =>
            deleteExpenseModal.classList.remove("active")
        );
        cancelDeleteExpenseBtn.addEventListener("click", () =>
            deleteExpenseModal.classList.remove("active")
        );

        editExpenseButtons.forEach((button) => {
            button.addEventListener("click", () => {
                currentExpenseId = button.getAttribute("data-id");
                expenseModalTitle.textContent = `Edit Expense #${currentExpenseId}`;

                const row = button.closest(".table-row");
                const timestamp =
                    row.querySelector(".item-timestamp").textContent;
                const description =
                    row.querySelector(".item-description").textContent;
                const amount = row
                    .querySelector(".item-price")
                    .textContent.replace("$", ""); // Hapus '$'

                document.getElementById("expenseDescription").value =
                    description;
                document.getElementById("expenseAmount").value = amount;

                expenseModal.classList.add("active");
            });
        });

        deleteExpenseButtons.forEach((button) => {
            button.addEventListener("click", () => {
                currentExpenseId = button.getAttribute("data-id");
                deleteExpenseModal.classList.add("active");
            });
        });

        confirmDeleteExpenseBtn.addEventListener("click", () => {
            alert(`Expense item with ID ${currentExpenseId} has been deleted.`);
            deleteExpenseModal.classList.remove("active");
        });

        expenseForm.addEventListener("submit", (e) => {
            e.preventDefault();
            if (currentExpenseId) {
                alert(`Expense #${currentExpenseId} has been updated.`);
            } else {
                alert("New expense has been added.");
            }
            expenseModal.classList.remove("active");
            currentExpenseId = null;
        });
    }

    const editIncomeButtons = document.querySelectorAll(".edit-income-btn");

    if (editIncomeButtons.length > 0) {
        const incomeModal = document.getElementById("incomeModal");
        const deleteIncomeModal = document.getElementById("deleteIncomeModal");
        const closeIncomeModal = document.getElementById("closeIncomeModal");
        const cancelIncomeBtn = document.getElementById("cancelIncomeBtn");
        const closeDeleteIncomeModal = document.getElementById(
            "closeDeleteIncomeModal"
        );
        const cancelDeleteIncomeBtn = document.getElementById(
            "cancelDeleteIncomeBtn"
        );
        const confirmDeleteIncomeBtn = document.getElementById(
            "confirmDeleteIncomeBtn"
        );
        const incomeForm = document.getElementById("incomeForm");
        const incomeModalTitle = document.getElementById("incomeModalTitle");
        const deleteIncomeButtons =
            document.querySelectorAll(".delete-income-btn");

        let currentIncomeId = null;

        closeIncomeModal.addEventListener("click", () =>
            incomeModal.classList.remove("active")
        );
        cancelIncomeBtn.addEventListener("click", () =>
            incomeModal.classList.remove("active")
        );
        closeDeleteIncomeModal.addEventListener("click", () =>
            deleteIncomeModal.classList.remove("active")
        );
        cancelDeleteIncomeBtn.addEventListener("click", () =>
            deleteIncomeModal.classList.remove("active")
        );

        editIncomeButtons.forEach((button) => {
            button.addEventListener("click", () => {
                currentIncomeId = button.getAttribute("data-id");
                incomeModalTitle.textContent = `Edit Income #${currentIncomeId}`;

                const row = button.closest(".table-row");
                const cashier = row.querySelector(".item-cashier").textContent;
                const menuName = row.querySelector(".item-name").textContent;
                const category =
                    row.querySelector(".item-category-tag").textContent;
                const unit = row.querySelector(".item-units").textContent;
                const unitPrice = row.querySelector(".item-price").textContent; // Ambil harga pertama (unit price)

                document.getElementById("incomeCashier").value = cashier;
                document.getElementById("incomeMenuName").value = menuName;
                document.getElementById("incomeCategory").value = category;
                document.getElementById("incomeUnit").value = unit;
                document.getElementById("incomeUnitPrice").value = unitPrice;

                incomeModal.classList.add("active");
            });
        });

        deleteIncomeButtons.forEach((button) => {
            button.addEventListener("click", () => {
                currentIncomeId = button.getAttribute("data-id");
                deleteIncomeModal.classList.add("active");
            });
        });

        confirmDeleteIncomeBtn.addEventListener("click", () => {
            alert(`Income record with ID ${currentIncomeId} has been deleted.`);
            deleteIncomeModal.classList.remove("active");
        });

        incomeForm.addEventListener("submit", (e) => {
            e.preventDefault();
            alert(`Income record #${currentIncomeId} has been updated.`);
            incomeModal.classList.remove("active");
            currentIncomeId = null;
        });
    }

    const addAccountBtn = document.getElementById("addAccountBtn");

    if (addAccountBtn) {
        const accountModal = document.getElementById("accountModal");
        const deleteAccountModal =
            document.getElementById("deleteAccountModal");
        const closeAccountModal = document.getElementById("closeAccountModal");
        const cancelAccountBtn = document.getElementById("cancelAccountBtn");
        const closeDeleteAccountModal = document.getElementById(
            "closeDeleteAccountModal"
        );
        const cancelDeleteAccountBtn = document.getElementById(
            "cancelDeleteAccountBtn"
        );
        const confirmDeleteAccountBtn = document.getElementById(
            "confirmDeleteAccountBtn"
        );
        const accountForm = document.getElementById("accountForm");
        const accountModalTitle = document.getElementById("accountModalTitle");

        const editAccountButtons =
            document.querySelectorAll(".edit-account-btn");
        const deleteAccountButtons = document.querySelectorAll(
            ".delete-account-btn"
        );

        let currentAccountId = null;

        addAccountBtn.addEventListener("click", () => {
            currentAccountId = null;
            accountModalTitle.textContent = "Add Account";
            accountForm.reset();
            accountModal.classList.add("active");
        });

        closeAccountModal.addEventListener("click", () =>
            accountModal.classList.remove("active")
        );
        cancelAccountBtn.addEventListener("click", () =>
            accountModal.classList.remove("active")
        );
        closeDeleteAccountModal.addEventListener("click", () =>
            deleteAccountModal.classList.remove("active")
        );
        cancelDeleteAccountBtn.addEventListener("click", () =>
            deleteAccountModal.classList.remove("active")
        );

        editAccountButtons.forEach((button) => {
            button.addEventListener("click", () => {
                currentAccountId = button.getAttribute("data-id");
                accountModalTitle.textContent = `Edit Account #${currentAccountId}`;

                const row = button.closest(".table-row");
                const name = row.querySelector(".item-name").textContent;
                const username =
                    row.querySelector(".item-username").textContent;

                document.getElementById("accountName").value = name;
                document.getElementById("accountUsername").value = username;
                document.getElementById("accountPassword").value = "";
                document.getElementById("accountPasswordConfirm").value = "";

                accountModal.classList.add("active");
            });
        });

        deleteAccountButtons.forEach((button) => {
            button.addEventListener("click", () => {
                currentAccountId = button.getAttribute("data-id");
                deleteAccountModal.classList.add("active");
            });
        });

        confirmDeleteAccountBtn.addEventListener("click", () => {
            alert(`Account with ID ${currentAccountId} has been deleted.`);
            deleteAccountModal.classList.remove("active");
        });

        accountForm.addEventListener("submit", (e) => {
            e.preventDefault();

            const pass = document.getElementById("accountPassword").value;
            const confirmPass = document.getElementById(
                "accountPasswordConfirm"
            ).value;

            if (pass !== confirmPass) {
                alert("Passwords do not match!");
                return;
            }

            if (currentAccountId) {
                alert(`Account #${currentAccountId} has been updated.`);
            } else {
                alert("New account has been added.");
            }
            accountModal.classList.remove("active");
            currentAccountId = null;
        });
    }

    const cashierPage = document.getElementById("cashier-page-wrapper");

    if (cashierPage) {
        const CART_KEY = cashierPage.dataset.cartKey;

        let cart = [];
        const cartItemsList = document.getElementById("cart-items-list");
        const addButtons = document.querySelectorAll(".btn-add-to-cart");
        const cartEmptyState = document.getElementById("cart-empty");
        const cartSubtotalEl = document.getElementById("cart-subtotal");
        const cartTotalEl = document.getElementById("cart-total");
        const btnCancelOrder = document.getElementById("btn-cancel-order");
        const btnCompleteOrder = document.getElementById("btn-complete-order");

        function renderCart() {
            cartItemsList.innerHTML = "";
            let subtotal = 0;

            if (cart.length === 0) {
                cartItemsList.appendChild(cartEmptyState);
            } else {
                cart.forEach((item) => {
                    const itemTotal = item.price * item.quantity;
                    subtotal += itemTotal;

                    const itemEl = document.createElement("div");
                    itemEl.className = "cart-item";
                    itemEl.innerHTML = `
            <div class="cart-item-header">
              <div class="cart-item-info">
                <span class="cart-item-name">${item.name}</span>
                <span class="cart-item-price">$${item.price.toFixed(2)}</span>
              </div>
              <button class="cart-item-remove" data-id="${item.id}">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 6H5H21" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M19 6V20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22H7C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20V6M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 11V17" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M14 11V17" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
              </button>
            </div>
            <div class="cart-item-footer">
              <div class="quantity-control">
                <button class="quantity-decrease" data-id="${
                    item.id
                }">-</button>
                <span>${item.quantity}</span>
                <button class="quantity-increase" data-id="${
                    item.id
                }">+</button>
              </div>
              <span class="cart-item-total">$${itemTotal.toFixed(2)}</span>
            </div>
          `;
                    cartItemsList.appendChild(itemEl);
                });
            }

            cartSubtotalEl.textContent = `$${subtotal.toFixed(2)}`;
            cartTotalEl.textContent = `$${subtotal.toFixed(2)}`;
        }

        function addToCart(id, name, price) {
            const existingItem = cart.find((item) => item.id === id);
            if (existingItem) {
                existingItem.quantity++;
            } else {
                cart.push({ id: id, name: name, price: price, quantity: 1 });
            }
            saveAndRenderCart();
        }

        function updateQuantity(id, change) {
            const item = cart.find((item) => item.id === id);
            if (item) {
                item.quantity += change;
                if (item.quantity <= 0) {
                    removeFromCart(id);
                } else {
                    saveAndRenderCart();
                }
            }
        }

        function removeFromCart(id) {
            cart = cart.filter((item) => item.id !== id);
            saveAndRenderCart();
        }

        function saveAndRenderCart() {
            localStorage.setItem(CART_KEY, JSON.stringify(cart));
            renderCart();
        }

        function loadCart() {
            const storedCart = localStorage.getItem(CART_KEY);
            if (storedCart) {
                cart = JSON.parse(storedCart);
            }
            renderCart();
        }

        function clearCart(confirmMessage) {
            if (confirm(confirmMessage)) {
                cart = [];
                saveAndRenderCart();
            }
        }

        addButtons.forEach((button) => {
            button.addEventListener("click", () => {
                const id = button.dataset.id;
                const name = button.dataset.name;
                const price = parseFloat(button.dataset.price);
                addToCart(id, name, price);
            });
        });

        btnCancelOrder.addEventListener("click", () => {
            clearCart(
                "Are you sure you want to cancel this order and clear the cart?"
            );
        });

        btnCompleteOrder.addEventListener("click", () => {
            clearCart("Order completed. Clear the cart?");
        });

        cartItemsList.addEventListener("click", (e) => {
            const target = e.target;
            if (target.classList.contains("quantity-increase")) {
                updateQuantity(target.dataset.id, 1);
            }
            if (target.classList.contains("quantity-decrease")) {
                updateQuantity(target.dataset.id, -1);
            }
            if (target.closest(".cart-item-remove")) {
                removeFromCart(target.closest(".cart-item-remove").dataset.id);
            }
        });

        loadCart();
    }
});
