describe("Config page", function () {
    describe("with server response", function () {
        beforeEach(function () {
            cy.visit("/login");
            cy.url().should("match", /config/);
        });

        it("displays servers", function () {
            cy.get(".guild-column").find("img.image").should("have.class", "is-circular");
        });

        it("can visit the config page", function () {
            cy.get(".guild-column:nth-child(2) .tooltip").then(secondServer => {
                cy.get(".guild-column:nth-child(2)").click();
                cy.contains(`Editing ${secondServer.attr("data-tooltip")}`);
            });
        });
    });

    describe("without server response", function () {
        let commandPrefix = "%%";

        beforeEach(function () {
            cy.server();
            cy.route({
                method: "GET",
                url: "/api/user",
                response: {"name":"Amelie O'Hara","avatar":null}
            }).as("getUser");
            cy.fixture("editGuildResponse").then(guildRes => {
                cy.route({
                    method: "GET",
                    url: "/api/server/1",
                    response: guildRes
                }).as("getConfig");
            });
            cy.route({
                method: "POST",
                url: "/api/server/1",
                status: 204,
                response: ""
            }).as("postConfig");
        });

        it("visits the config page", function () {
            cy.visit("/config/1");
            cy.wait("@getConfig");
            cy.wait("@getUser");
            cy.fixture("editGuildResponse").then(guildResponse => {
                cy.contains("h1#guild-heading", `Editing ${guildResponse["guild"]["name"]}`);
            });
        });

        it("should display newly changed command prefix on all config pages", function () {
            cy.visit("/config/1");
            cy.wait("@getConfig");
            cy.wait("@getUser");
            let prefix = cy.get("#command_prefix");
            prefix.clear();
            prefix.parent().siblings().contains("Cannot be empty");

            cy.get("#command_prefix").type(commandPrefix).type("1{backspace}");

            cy.get("#editGuildNav").contains("Antispam").click();
            cy.contains("code", `${commandPrefix}permit @people`);

            cy.get("#editGuildNav").contains("Moderation").click();
            cy.contains("code", `${commandPrefix}permissions`);
            cy.contains("code", `${commandPrefix}join`);
            cy.contains("code", `${commandPrefix}op`);
            cy.contains("code", `${commandPrefix}quickban`);
            cy.contains("code", `${commandPrefix}ban`);

            cy.get("#editGuildNav").contains("Role Assignment").click();
            cy.contains("code", `${commandPrefix}join`);

            cy.get("#editGuildNav").contains("Logging").click();
            cy.contains("code", `${commandPrefix}addWarning`);
            cy.contains("code", `${commandPrefix}issueWarning`);
            cy.contains("code", `${commandPrefix}join`);
            cy.contains("code", `${commandPrefix}leave`);
            cy.contains("code", `${commandPrefix}promote`);
            cy.contains("code", `${commandPrefix}demote`);

            cy.get("#editGuildNav").contains("New User / Verification").click();
            cy.contains("code", `${commandPrefix}verify`);

            cy.get("#editGuildNav").contains("Social (Levels & Karma)").click();
            cy.contains("code", `${commandPrefix}memo`);
            cy.contains("code", `${commandPrefix}give`);
            cy.contains("code", `${commandPrefix}alias`);
            cy.contains("code", `${commandPrefix}cookies`);
            cy.contains("code", `${commandPrefix}nom`);

            cy.get("#editGuildNav").contains("Custom Commands").click();
            cy.contains("code", `${commandPrefix}help`);
        });

        it("submits changes to the API", function () {
            cy.visit("/config/1");
            cy.wait("@getConfig");
            cy.wait("@getUser");

            let prefix = cy.get("#command_prefix");
            prefix.clear();
            prefix.type(commandPrefix);
            cy.get("#execute_on_edit").siblings("label").click();

            cy.get("#editGuildNav").contains("Logging").click();
            cy.get("#embed_modchannel").siblings("label").click();

            cy.get("#editGuildNav").contains("Role Assignment").click();
            cy.get("#publicRoleSelector .add-public-group").click();
            cy.get("#publicRoleSelector").get(".groupName").clear().type("groupName");
            for (let i = 0; i < 3; i++) {
                cy.get("#publicRoleSelector").get(".availableRoles .listItem").eq(i).click({force: true});
            }


            cy.get("#editGuildNav").contains("Moderation").click();
            let quickBanReason = cy.get("#quickban_reason");
            quickBanReason.clear();
            quickBanReason.type("text message");

            cy.get("#submitButton").click();
            cy.wait("@postConfig").then(xhr => {
                expect(xhr.request.body).to.deep.equal({
                    "command_prefix": commandPrefix,
                    "embed_modchannel": 1,
                    "quickban_reason": "text message",
                    "role_groups": {
                        "1": {
                            "groupid": 1,
                            "name": "groupName",
                            "role_limit": 1
                        }
                    },
                    "roles": {
                        "8197542": {
                            "antispam_ignored": 0,
                            "level": 0,
                            "logging_ignored": 0,
                            "permission_level": 1,
                            "public_id": 1,
                            "roleid": "8197542"
                        },
                        "17710063": {
                            "antispam_ignored": 0,
                            "level": 0,
                            "logging_ignored": 0,
                            "permission_level": 1,
                            "public_id": 1,
                            "roleid": "17710063"
                        },
                        "71420240": {
                            "antispam_ignored": 0,
                            "level": 0,
                            "logging_ignored": 0,
                            "permission_level": 1,
                            "public_id": 1,
                            "roleid": "71420240"
                        }
                    }
                });
            });
        });
    });
});
