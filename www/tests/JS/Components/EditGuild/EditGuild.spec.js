import sinon from "sinon";
import {shallowMount} from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";
import {expect, assert} from "chai";
import EditGuild from "components/EditGuild/EditGuild";
import SubmitBar from "components/EditGuild/SubmitBar";
import ConfigNavbarItem from "components/EditGuild/ConfigNavbarItem";
import BasicConfig from "components/EditGuild/Sections/BasicConfig/BasicConfig";
import AntispamConfig from "components/EditGuild/Sections/Antispam/AntispamConfig";
import VueRouter from "vue-router";

let localVue = Vue.use(Vuex);
localVue.use(VueRouter);

describe("EditGuild", function () {
    let wrapper;
    let actions;
    let store;
    let state;
    let propsData;

    beforeEach(function () {
        propsData = {
            guildId: "guildId"
        };

        let retrieveConfig = sinon.stub();
        retrieveConfig.resolves();
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
        wrapper = shallowMount(EditGuild, {store, localVue});
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
        const allTabs = wrapper.vm.tabs.length;
        console.log(wrapper.html());
        expect(wrapper.findAll("router-link-stub").length).to.equal(allTabs);
    });

    it("should have tab index be within range of tabs", function () {
        const currentTabIndex = wrapper.vm.currentTab;
        const tabsLength = wrapper.vm.tabs.length;
        assert(currentTabIndex >= 0 && currentTabIndex < tabsLength);
    });

    it("should display is-active attribute for current tab in menu-list", function () {
        const currentTabIndex = wrapper.vm.currentTab;
        let tabs = wrapper.findAll(ConfigNavbarItem);

        for (let i = 0; i < tabs.length; i++) {
            expect(tabs.at(i).props().isActive).to.equal(currentTabIndex === i);
        }
    });

    it("should change current tab on click", function () {
        let routerView = wrapper.find("router-view-stub");
        expect(routerView, "previous tab should be active").to.equal(true);
    });

    it("should have fluid right column", function () {
        expect(wrapper.findAll(".columns .column").at(1).exists()).to.equal(true);
    });

    it("should display component for only the current tab", function () {
        expect(wrapper.findAll(".column.content .component").length).to.equal(1);
        expect(wrapper.find(BasicConfig).exists()).to.equal(true);
    });

    it("should switch current tab component on menu-list item click", function (done) {
        expect(wrapper.find(BasicConfig).exists(), "BasicConfig should be visible before click").to.equal(true);
        wrapper.findAll(ConfigNavbarItem).at(1).trigger("click");

        wrapper.vm.$nextTick(() => {
            expect(wrapper.find(AntispamConfig).exists(), "AntispamConfig should be visible after click").to.equal(true);
            done();
        });
    });

    it("should have name, icon and component properties for all tabs", function () {
        const tabs = wrapper.vm.tabs;
        for (const tab of tabs) {
            assert(tab.hasOwnProperty("name"), "tab should have name");
            assert(tab.hasOwnProperty("icon"), "tab should have icon");
            assert(tab.hasOwnProperty("component"), "tab should have component");
        }
    });

    it("should dispatch retrieveConfig", function () {
        expect(actions.retrieveConfig.calledOnce).to.equal(true);
    });

    it("should show loading indicator when created", function () {
        expect(false, "should show loading screen").to.equal(true);
    });

    it("should remove loading indicator when retrieveConfig Promise returns", function () {
        expect(false, "should show loading screen").to.equal(true);
    });
});