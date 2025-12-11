describe("Menu Management", () => {
    beforeEach(() => {
        cy.visit("/login");
        cy.get('input[name="username"]').type("Notum");
        cy.get('input[name="password"]').type("qwertyuiop");
        cy.get('button[type="submit"]').click();
        cy.url().should("include", "/menu");
    });

    it("should allow owner to add a new menu item", () => {
        cy.get("#addMenuBtn").click();

        cy.get('input[name="nama_menu"]').type("Cypress Test Menu Item");
        cy.get('input[name="harga_menu"]').type("15000");
        cy.get('input[name="stok_menu"]').type("100");
        cy.get('textarea[name="deskripsi_menu"]').type("Test");
        cy.get('select[name="kategori_menu"]').select("Makanan");

        cy.get('button[type="submit"]').click();

        cy.contains("Cypress Test Menu Item").should("be.visible");
        cy.contains("15000").should("be.visible");
        cy.contains("100").should("be.visible");
        cy.contains("Makanan").should("be.visible");
    });

    it("should allow owner to edit an existing menu item", () => {
        cy.contains("Cypress Test Menu Item")
            .parents("tr")
            .find(".edit-btn")
            .click();

        cy.get('input[name="harga_menu"]').clear().type("20000");
        cy.get('input[name="stok_menu"]').clear().type("150");
        cy.get('select[name="kategori_menu"]').select("Minuman");

        cy.get('button[type="submit"]').click();

        cy.contains("Cypress Test Menu Item").should("be.visible");
        cy.contains("20000").should("be.visible");
        cy.contains("150").should("be.visible");
        cy.contains("Minuman").should("be.visible");
    });

    it("should allow owner to delete a menu item", () => {
        cy.contains("Cypress Test Menu Item")
            .parents("tr")
            .find(".delete-btn")
            .click();

        cy.on("window:confirm", (str) => {
            expect(str).to.equal("Apakah anda yakin ingin menghapus menu ini?");
            return true;
        });

        cy.contains("Cypress Test Menu Item").should("not.exist");
    });
});
