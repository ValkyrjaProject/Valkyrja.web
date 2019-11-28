import {expect} from "chai";
import { shallowMount } from "@vue/test-utils";
import sinon from "sinon";
import UserNavigation from "components/UserNavigation/UserNavigation";
import LoggedIn from "components/UserNavigation/LoggedIn";
import LoggedOut from "components/UserNavigation/LoggedOut";
import Vue from "vue";
import Vuex from "vuex";

let localVue = Vue.use(Vuex);

describe("UserNavigation", function () {
    let wrapper;
    let actions;
    let store;
    let state;

    beforeEach(function () {
        actions = {
            retrieveUser: sinon.stub(),
            initializeUser: sinon.stub(),
        };
        state = {
            user: {
                name: "test"
            }
        };
        store = new Vuex.Store({
            state,
            actions,
        });
        wrapper = shallowMount(UserNavigation, {store, localVue});
    });

    it("should show LoggedOut-component when logged out", function () {
        store.state.user.name = null;
        expect(wrapper.find(LoggedOut).exists()).to.equal(true);
    });

    it("should show LoggedIn-component when logged in", function () {
        expect(wrapper.find(LoggedIn).exists()).to.equal(true);
    });

    it("should dispatch retrieveUser action once", function () {
        sinon.assert.calledOnce(actions.retrieveUser);
    });

    it("should dispatch initializeUser action once", function () {
        sinon.assert.calledOnce(actions.initializeUser);
    });
});