describe("Cashier Process", () => {
    beforeEach(() => {
        cy.visit("/login");
        cy.get('input[name="username"]').type("Qol");
        cy.get('input[name="password"]').type("qwertyuiop");
        cy.get('button[type="submit"]').click();

        cy.url().should("include", "/cashier");
    });

    it("should be able to add items to cart, adjust quantity, and remove items", () => {
        cy.get(".product-card:first-child .btn-add-to-cart").first().click();
        cy.get("#cart-items-list").should("contain", "1");

        cy.get(".quantity-increase").click();
        cy.get("#cart-items-list").should("contain", "2");

        cy.get(".quantity-decrease").click();
        cy.get("#cart-items-list").should("contain", "1");

        cy.get(".cart-item-remove").click();
        cy.get("#cart-empty").should("be.visible");
    });

    it("should be able to clear the cart", () => {
        cy.get(".product-card:first-child .btn-add-to-cart").first().click();
        cy.get("#cart-items-list").should("not.contain", "Keranjang kosong!");

        cy.get("#btn-cancel-order").click();
        cy.on("window:confirm", () => true);

        cy.get("#cart-empty").should("be.visible");
    });

    it("should be able to complete an order", () => {
        cy.intercept("POST", "/cashier/checkout", {
            statusCode: 200,
            body: { success: true, message: "Transaksi berhasil!" },
        }).as("checkoutRequest");

        cy.get(".product-card:first-child .btn-add-to-cart").first().click();
        cy.get("#cart-items-list").should("not.contain", "Keranjang kosong!");

        cy.get("#btn-complete-order").click();
        cy.on("window:confirm", () => true);

        cy.wait("@checkoutRequest")
            .its("request.body")
            .should("include", "items");

        cy.on("window:alert", (str) => {
            expect(str).to.equal("Transaksi berhasil!");
        });
        cy.get("#cart-empty").should("be.visible");
    });
});
