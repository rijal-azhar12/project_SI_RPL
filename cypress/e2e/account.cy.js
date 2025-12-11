describe("Account Management", () => {
    beforeEach(() => {
        cy.visit("/login");
        cy.get('input[name="username"]').type("Notum");
        cy.get('input[name="password"]').type("qwertyuiop");
        cy.get('button[type="submit"]').click();
        cy.url().should("include", "/menu");
    });

    it("should allow owner to create, edit, and delete an account", () => {
        cy.visit("/account");
        cy.get("h1.page-title").should("contain", "Manajemen Akun");

        cy.get("#addAccountBtn").click();
        cy.get("#accountModal").should("be.visible");
        cy.get("#accountModalTitle").should("contain", "Tambah Akun");

        cy.get("#accountName").type("Test User");
        cy.get("#accountUsername").type("testUser");
        cy.get("#accountPassword").type("password123");
        cy.get("#accountRole").select("Kasir");
        cy.get('#accountForm button[type="submit"]').click();

        cy.get(".alert-success").should(
            "contain",
            "Akun berhasil ditambahkan!"
        );
        cy.get(".table-row.account").contains("testUser").should("be.visible");

        cy.get(".table-row.account")
            .contains("testUser")
            .parent()
            .within(() => {
                cy.get(".edit-btn").click();
            });

        cy.get("#accountModal").should("be.visible");
        cy.get("#accountModalTitle").should("contain", "Edit Akun");
        cy.get("#accountUsername")
            .clear()
            .type("testUser" + "_edited");
        cy.get('#accountForm button[type="submit"]').click();

        cy.get(".alert-success").should("contain", "Akun berhasil diperbarui!");
        cy.get(".table-row.account")
            .contains("testUser_edited")
            .should("be.visible");

        cy.get(".table-row.account")
            .contains("testUser_edited")
            .parent()
            .within(() => {
                cy.get(".delete-btn").click();
            });

        cy.get("#deleteAccountModal").should("be.visible");
        cy.get('#deleteForm button[type="submit"]').click();

        cy.get(".alert-success").should("contain", "Akun berhasil dihapus!");
        cy.get(".table-row.account")
            .contains("testUser_edited")
            .should("not.exist");
    });

    it("should prevent cashier from accessing account management page", () => {
        cy.get(".logout").click();

        cy.visit("/login");
        cy.get('input[name="username"]').type("Qol");
        cy.get('input[name="password"]').type("qwertyuiop");
        cy.get('button[type="submit"]').click();
        cy.url().should("include", "/cashier");

        cy.visit("/account");

        cy.url().should("not.include", "/account");
        cy.get("body").should("not.contain", "Manajemen Akun");
    });
});
