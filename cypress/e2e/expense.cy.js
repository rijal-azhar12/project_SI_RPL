describe("Expense Management", () => {
    beforeEach(() => {
        cy.visit("/login");

        cy.get('input[name="username"]').type("Notum");
        cy.get('input[name="password"]').type("qwertyuiop");
        cy.get('button[type="submit"]').click();

        cy.visit("/expense");
    });

    it("should display the expense management page", () => {
        cy.get("h1.page-title").should("contain", "Manajemen Pengeluaran");
        cy.get(".add-btn").should("contain", "Tambah Pengeluaran");
        cy.get(".table").should("be.visible");
    });

    it("should allow a user to add a new expense and then delete it", () => {
        cy.get("#addExpenseBtn").click();

        cy.get("#expenseModal").should("be.visible");
        cy.get("#modalTitle").should("contain", "Tambah Pengeluaran");

        cy.get("#keterangan").type("Beli Gula Pasir");
        cy.get("#jumlah_pengeluaran").type("25000");
        cy.get("#tanggal_pengeluaran").type("2025-12-10");

        cy.get("#expenseForm").submit();

        cy.get(".alert-success").should(
            "contain",
            "Pengeluaran berhasil ditambahkan!"
        );
        cy.get(".table").should("contain", "Beli Gula Pasir");
        cy.get(".table").should("contain", "25.000");

        cy.contains(".table-row", "Beli Gula Pasir")
            .find(".delete-btn")
            .click();

        cy.get(".alert-success").should(
            "contain",
            "Pengeluaran berhasil dihapus!"
        );
        cy.get(".table").should("not.contain", "Beli Gula Pasir");
    });

    it("should show validation errors if the form is submitted empty", () => {
        cy.get("#addExpenseBtn").click();

        cy.get("#expenseForm").submit();

        cy.get(".alert-danger").should("be.visible");
        cy.get(".alert-danger").should(
            "contain",
            "The keterangan field is required."
        );
        cy.get(".alert-danger").should(
            "contain",
            "The jumlah pengeluaran field is required."
        );
        cy.get(".alert-danger").should(
            "contain",
            "The tanggal pengeluaran field is required."
        );
    });
});
