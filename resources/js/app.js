document.addEventListener("DOMContentLoaded", function () {
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
