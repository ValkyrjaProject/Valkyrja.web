import sinon from "sinon";
import {shallowMount} from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";
import {expect} from "chai";
import ReactionRolesForm from "components/EditGuild/Sections/RoleAssignment/ReactionRoles/ReactionRolesForm";
let localVue = Vue.use(Vuex);

describe("ReactionRolesForm", function () {
    let wrapper;
    let actions;
    let store;
    let state;
    let getters;
    let propsData;

    beforeEach(function () {
        propsData = {};

        actions = {};
        state = {};
        getters = {};
        store = new Vuex.Store({
            state,
            actions,
            getters
        });
        wrapper = shallowMount(ReactionRolesForm, {propsData, store, localVue});
    });

    describe("styling", function () {
        it("should have .panel as root element", function () {
            expect(wrapper.find(".panel").exists()).to.be.true;
        });

        it("should have a heading with 'Selected Message'", function () {
            expect(wrapper.find(".panel > .panel-heading").text()).to.equal("Selected Message");
        });

        it("should have a panel block with a text input field ", function () {
            expect(wrapper.find(".panel > .panel-block input[type='text']").exists()).to.be.true;
        });

        it("should have a label connected with input", function () {
            let label = wrapper.find("label");
            let input = wrapper.find("input");

            expect(label.attributes("for")).to.equal(input.attributes("id"));
        });

        it("should have input with placeholder 'Message ID'", function () {
            expect(wrapper.find("input").attributes("placeholder")).to.equal("Message ID");
        });

        it("should have label with help class", function () {
            expect(wrapper.find("label").classes()).to.contain("help");
        });

        it("should have label with description text", function () {
            expect(wrapper.find("label").text()).to.equal("ID of a message where to watch for reactions. (Use DevMode enabled in the settings of Discord client, right-click a message and copy ID.)");
        });

        it("should have a paddingless panel-block with reaction-roles-emoji", function () {
            expect(wrapper.find(".panel-block.is-paddingless > reactionrolesemoji-stub").exists()).to.be.true;
        });
    });

    it("should have name of 'ReactionRolesForm'", function () {
        expect(wrapper.name()).to.equal("ReactionRolesForm");
    });
});
