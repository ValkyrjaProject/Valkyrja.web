import sinon from "sinon";
import {shallowMount} from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";
import {expect} from "chai";
import RoleSelector from "../../../../../../../resources/assets/js/components/EditGuild/Sections/Moderation/RoleSelector/RoleSelector";

let localVue = Vue.use(Vuex);

describe("RoleSelector", function () {
    let wrapper;
    let actions;
    let store;
    let state;
    let getters;
    let propsData;

    beforeEach(function () {
        propsData = {};
        actions = {
            addRole: sinon.stub(),
            removeRole: sinon.stub(),
        };
        state = {
            roles: []
        };
        getters = {
            availableRoles: () => state.roles,
            addedRoles: () => state.roles,
        };
        store = new Vuex.Store({
            modules: {
                roleSelector: {
                    namespaced: true,
                    state,
                    actions,
                    getters
                }
            }
        });
        wrapper = shallowMount(RoleSelector, {propsData, store, localVue});
    });

    it("should ", function () {
    });
});
