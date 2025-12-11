describe("Login Page", () => {
    beforeEach(() => {
        cy.visit("/login");
    });

    it("should display the login form", () => {
        cy.get("h1.title").should(
            "contain",
            'Kasir & Manajemen "Papacino Snacks & Drinks"'
        );
        cy.get('input[name="username"]').should("be.visible");
        cy.get('input[name="password"]').should("be.visible");
        cy.get('button[type="submit"]').should("contain", "Login");
    });

    it("should allow a user to log in with valid credentials (as owner)", () => {
        cy.get('input[name="username"]').type("Notum");
        cy.get('input[name="password"]').type("qwertyuiop");
        cy.get('button[type="submit"]').click();

        cy.url().should("include", "/menu");
    });

    it("should allow a user to log in with valid credentials (as cashier)", () => {
        cy.get('input[name="username"]').type("Qol");
        cy.get('input[name="password"]').type("qwertyuiop");
        cy.get('button[type="submit"]').click();

        cy.url().should("include", "/cashier");
    });

    it("should show an error message with invalid credentials", () => {
        cy.get('input[name="username"]').type("invaliduser");
        cy.get('input[name="password"]').type("wrongpassword");
        cy.get('button[type="submit"]').click();

        cy.get("div").should(
            "contain",
            "The provided credentials do not match our records."
        );
    });

    it("should show validation errors for empty fields", () => {
        cy.get('button[type="submit"]').click();

        cy.get("span").should("contain", "The username field is required.");
        cy.get("span").should("contain", "The password field is required.");
    });
});
