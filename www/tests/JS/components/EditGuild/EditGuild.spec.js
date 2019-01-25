import sinon from "sinon";
import {shallowMount, RouterLinkStub} from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";
import {expect, assert} from "chai";
import EditGuild from "components/EditGuild/EditGuild";
import SubmitBar from "components/EditGuild/SubmitBar";
import Buefy from "buefy";

let localVue = Vue.use(Vuex);
localVue.use(Buefy);

describe("EditGuild", function () {
    let wrapper;
    let actions;
    let store;
    let state;
    let propsData;

    beforeEach(function () {
        propsData = {
            guildId: "guildId",
        };

        let retrieveConfig = sinon.stub();
        retrieveConfig.resolves("test");
        actions = {
            retrieveConfig: retrieveConfig
        };
        state = {
            guild: {
                example: "text"
            }
        };
        store = new Vuex.Store({
            state,
            actions,
        });
        wrapper = shallowMount(EditGuild, {store, propsData, localVue,
            stubs: {
                RouterLink: RouterLinkStub,
                RouterView: "<div class=\"RouterView\"></div>",
            }
        });
    });

    it("should have submit-bar component", function () {
        expect(wrapper.find(SubmitBar).exists()).to.equal(true);
    });

    it("should send guild as prop to submit-bar component", function () {
        expect(wrapper.find(SubmitBar).props().guild).to.equal(state.guild);
    });

    it("should have fixed left column", function () {
        expect(wrapper.find(".columns .column.is-3").exists()).to.equal(true);
    });

    it("should have aside-field with menu class", function () {
        expect(wrapper.find("aside.menu").exists()).to.equal(true);
    });

    it("should display menu-list items of all tabs", function () {
        const allTabs = wrapper.vm.$data.tabs.length;
        expect(wrapper.findAll("ul.menu-list > li").length).to.equal(allTabs);
    });

    it("should display is-active attribute for current tab in menu-list", function () {
        const currentTabIndex = wrapper.vm.currentTab;
        let tabs = wrapper.findAll("ConfigNavbarItem");

        for (let i = 0; i < tabs.length; i++) {
            expect(tabs.at(i).props().isActive).to.equal(currentTabIndex === i);
        }
    });

    it("should have fluid right column", function () {
        expect(wrapper.findAll(".columns .column").at(1).exists()).to.equal(true);
    });

    it("should have name, icon and component properties for all tabs", function () {
        const tabs = wrapper.vm.tabs;
        for (const tab of tabs) {
            assert(tab.hasOwnProperty("name"), "tab should have name");
            assert(tab.hasOwnProperty("icon"), "tab should have icon");
            assert(tab.hasOwnProperty("component"), "tab should have component");
        }
    });

    it("should dispatch retrieveConfig with guildId", function () {
        expect(actions.retrieveConfig.calledOnce).to.equal(true);
        expect(actions.retrieveConfig.getCall(0).args[1]).to.equal(propsData.guildId);
    });

    it("should show loading indicator when created", function () {
        expect(wrapper.vm.loadingElement.isActive).to.be.true;
    });

    it("should remove loading indicator when retrieveConfig Promise returns", async () => {
        expect(wrapper.vm.loadingElement.isActive).to.be.true;
        await wrapper.vm.$nextTick();
        expect(wrapper.vm.loadingElement.isActive).to.be.false;
    });
});
