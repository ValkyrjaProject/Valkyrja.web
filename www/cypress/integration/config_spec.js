describe("Config page", function () {
    beforeEach(function () {
        cy.clearCookies();
    });
    describe.skip("with server response", function () {
        beforeEach(function () {
            cy.visit("/login");
            cy.url().should("match", /config/);
        });

        it("should display servers", function () {
            cy.get(".guild-column").find("img.image").should("have.class", "is-circular");
        });

        it("visits the config page", async () =>  {
            let secondServer = await cy.get(".guild-column:nth-child(2) .tooltip");
            cy.get(".guild-column:nth-child(2)").click();
            cy.contains(`Editing ${secondServer.attr("data-tooltip")}`);
        });
    });

    describe("without server response", function () {
        beforeEach(function () {
            cy.server();
            cy.route({
                method: "GET",
                url: "/api/user",
                response: {"name":"Amelie O'Hara","avatar":null}
            });
            cy.route({
                method: "GET",
                url: "/api/server/1",
                response: {
                    guild: {
                        "id":"1",
                        "name":"Test",
                        "icon":null,
                        "owner":1,
                        "owner_id":"2263975",
                        "permissions":32,
                        "roles": [],
                        "channels": [],
                    },
                    config: {
                        "serverId": "1",
                    }
                }
            });
            cy.visit("/config/1");
        });

        it("visits the config page", async () => {
            let secondServer = await cy.get(".guild-column:nth-child(2) .tooltip");
            cy.get(".guild-column:nth-child(2)").click();
            cy.contains("Editing Test");
        });
    });
});
