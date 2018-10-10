import { shallowMount } from "@vue/test-utils";
import LoggedIn from "components/UserNavigation/LoggedIn";
import Vue from "vue";
import Vuex from "vuex";
import { expect } from "chai";

let localVue = Vue.use(Vuex);

describe("LoggedIn", function () {
    let wrapper;
    let store;
    let state;

    beforeEach(function () {
        state = {
            user: {
                name: "test"
            }
        };
        store = new Vuex.Store({
            state,
        });
        wrapper = shallowMount(LoggedIn, {store, localVue});
    });

    it("should display username", function () {
        expect(wrapper.find(".navbar-link").text()).to.equal(state.user.name);
    });

    it("should display avatar if it exists and not mdi-account", function () {
        Vue.set(state.user, "avatar", "test");
        expect(wrapper.find("img.avatar").exists()).to.equal(true);
        expect(!wrapper.find(".mdi-account").exists()).to.equal(true);
    });

    it("should display mdi-account if avatar does not exist", function () {
        Vue.set(state.user, "avatar", null);
        expect(!wrapper.find("img.avatar").exists(), "Avatar should not exist").to.equal(true);
        expect(wrapper.find(".mdi-account").exists(), "Account icon should exist").to.equal(true);
    });
});