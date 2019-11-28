import sinon from "sinon";
import {shallowMount} from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";
import {expect} from "chai";
import IgnoredChannels from "components/EditGuild/Sections/Logging/IgnoredChannels/IgnoredChannels";
import * as _ from "lodash";
import PanelList from "components/shared/structure/PanelList/PanelList";
import {Channel} from "models/Channel";

let localVue = Vue.use(Vuex);

describe("IgnoredChannels", function () {
    let wrapper;
    let actions;
    let store;
    let state;
    let getters;
    let propsData;

    beforeEach(function () {
        propsData = {};
        actions = {
            addChannel: sinon.stub(),
            removeChannel: sinon.stub(),
        };
        state = {
            availableChannels: [],
            ignoredChannels: [],
        };
        getters = {
            availableChannels: () => state.availableChannels,
            ignoredChannels: () => state.ignoredChannels,
        };
        store = new Vuex.Store({
            modules: {
                ignoredChannels: {
                    namespaced: true,
                    state,
                    actions,
                    getters
                }
            }
        });
        wrapper = shallowMount(IgnoredChannels, {propsData, store, localVue});
    });

    it("should have 2 PanelLists", function () {
        expect(wrapper.findAll(PanelList)).to.have.lengthOf(2);
    });

    it("sends available channels to left panel-list", function () {
        expect(wrapper.findAll(PanelList).at(0).props().value).to.equal(getters.availableChannels());
        state.availableChannels.push(Channel.createNewChannel(1));
        state.availableChannels.push(Channel.createNewChannel(2));
        expect(wrapper.findAll(PanelList).at(0).props().value).to.equal(getters.availableChannels());
    });

    it("sends ignored channels to right panel-list", function () {
        expect(wrapper.findAll(PanelList).at(1).props().value).to.equal(getters.ignoredChannels());
        state.ignoredChannels.push(Channel.createNewChannel(1));
        state.ignoredChannels.push(Channel.createNewChannel(2));
        expect(wrapper.findAll(PanelList).at(1).props().value).to.equal(getters.ignoredChannels());
    });

    it("should not dispatch add channel when availableChannels is not called", function () {
        expect(actions.addChannel.calledOnce).to.equal(false);
    });

    it("should dispatch add channel when availableChannels is called", function () {
        wrapper.vm.availableChannels = "Test";
        expect(actions.addChannel.calledOnce).to.equal(true);
    });

    it("should not dispatch remove channel when addedRoles is not called", function () {
        expect(actions.removeChannel.calledOnce).to.equal(false);
    });

    it("should dispatch remove channel when ignoredChannels is called", function () {
        wrapper.vm.ignoredChannels = "Test";
        expect(actions.removeChannel.calledOnce).to.equal(true);
    });

    it("should display everything in a box", function () {
        expect(wrapper.classes()).to.contain("box");
    });

    it("should have 2 columns in box", function () {
        expect(wrapper.find(".box").findAll(".columns > .column")).to.have.lengthOf(2);
    });

    it("should have name of RoleSelector", function () {
        expect(wrapper.name()).to.equal("IgnoredChannels");
    });

    it("send MDI icon 'pound' to all PanelLists itemIcon prop", function () {
        let panelLists = wrapper.findAll(PanelList);
        for (let i = 0; i < panelLists.length; i++) {
            expect(panelLists.at(i).props().itemIcon).to.equal("pound");
        }
    });
});
