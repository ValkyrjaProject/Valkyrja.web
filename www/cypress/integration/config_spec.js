describe("Config page", function () {
    beforeEach(function () {
        cy.clearCookies();
    });
    describe.skip("with server response", function () {
        beforeEach(function () {
            cy.visit("/login");
            cy.url().should("match", /config/);
        });

        it("displays servers", function () {
            cy.get(".guild-column").find("img.image").should("have.class", "is-circular");
        });

        it("can visit the config page", async () =>  {
            let secondServer = await cy.get(".guild-column:nth-child(2) .tooltip");
            cy.get(".guild-column:nth-child(2)").click();
            cy.contains(`Editing ${secondServer.attr("data-tooltip")}`);
        });
    });

    describe("without server response", function () {
        let guildResponse;
        let commandPrefix = "%%";

        beforeEach(async () => {
            guildResponse = await cy.fixture("editGuildResponse");
            cy.server();
            cy.route({
                method: "GET",
                url: "/api/user",
                response: {"name":"Amelie O'Hara","avatar":null}
            });
            cy.route({
                method: "GET",
                url: "/api/server/1",
                response: guildResponse
            }).as("getConfig");
            cy.visit("/config/1");
        });

        it.skip("visits the config page", async () => {
            cy.contains(`Editing ${guildResponse["guild"]["name"]}`);
        });

        it("should display newly changed command prefix on all config pages", function () {
            cy.wait("@getConfig");
            let prefix = cy.get("#command_prefix");
            prefix.clear();
            prefix.parent().siblings().contains("Cannot be empty");
            cy.get("#command_prefix").type(commandPrefix).type("1{backspace}");

            cy.get("#editGuildNav").contains("Antispam").click();
            cy.contains(`${commandPrefix}permit @people`);

            cy.get("#editGuildNav").contains("Moderation").click();
            cy.contains(`${commandPrefix}permissions`);
            cy.contains(`${commandPrefix}join`);
            cy.contains(`${commandPrefix}op`);
            cy.contains(`${commandPrefix}quickban`);
            cy.contains(`${commandPrefix}ban`);
        });
    });
});
