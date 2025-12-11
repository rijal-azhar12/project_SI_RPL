describe("Income Management", () => {
    beforeEach(() => {
        cy.visit("/login");
        cy.get('input[name="username"]').type("Notum");
        cy.get('input[name="password"]').type("qwertyuiop");
        cy.get('button[type="submit"]').click();
        cy.url().should("include", "/menu");

        cy.visit("/income");
    });

    it("should display income management page and check statistic cards", () => {
        cy.contains("h1", "Manajemen Pemasukan").should("be.visible");

        cy.get(".stat-card").should("have.length", 3);
        cy.get(".stat-card").eq(0).contains(".stat-title", "Total Pendapatan");
        cy.get(".stat-card")
            .eq(1)
            .contains(".stat-title", "Total Stok Terjual");
        cy.get(".stat-card")
            .eq(2)
            .contains(".stat-title", "Barang Paling Laris");
    });

    it("should verify the total price calculation for each transaction", () => {
        const parseCurrency = (text) => {
            if (!text) return 0;
            return parseInt(text.replace(/[^0-9]/g, ""), 10);
        };

        const parseQuantity = (text) => {
            if (!text) return 0;
            return parseInt(text.split("x")[0], 10);
        };

        cy.get("body").then(($body) => {
            if ($body.find(".table-row.income-grid").length > 0) {
                cy.get(".table-row.income-grid").each(($row) => {
                    const nameMenuHtml = $row.find(".item-namemenu").html();
                    const priceMenuHtml = $row.find(".item-pricemenu").html();
                    const displayedTotalText = $row
                        .find(".item-pricetransaction")
                        .text();

                    const quantities = nameMenuHtml
                        .split("<br>")
                        .map((item) => item.trim())
                        .filter((item) => item)
                        .map(parseQuantity);

                    const prices = priceMenuHtml
                        .split("<br>")
                        .map((item) => item.trim())
                        .filter((item) => item)
                        .map(parseCurrency);

                    let calculatedTotal = 0;
                    for (let i = 0; i < quantities.length; i++) {
                        calculatedTotal += quantities[i] * prices[i];
                    }

                    const displayedTotal = parseCurrency(displayedTotalText);

                    expect(calculatedTotal).to.equal(displayedTotal);
                });
            } else {
                cy.log("No income transactions found to test.");
                cy.contains("Tidak ada pemasukan ditemukan.").should(
                    "be.visible"
                );
            }
        });
    });
});
