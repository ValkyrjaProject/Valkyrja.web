import sinon from "sinon";
import {shallowMount} from '@vue/test-utils';
import Vue from 'vue';
import Vuex from "vuex";
import {expect} from "chai";
import RoleSelectorType from "components/EditGuild/Sections/Moderation/RoleSelector/RoleSelectorType";

let localVue = Vue.use(Vuex);

describe('RoleSelectorType', function () {
    let wrapper;
    let actions;
    let store;
    let state;
    let getters;
    let propsData;
    let heading;

    beforeEach(function () {
        heading = "example header";
        propsData = {
            title: heading
        };

        actions = {
            changeSelectedType: sinon.stub()
        };
        state = {
            selectedType: 1,
            types: {
                Public: 1,
                Member: 2,
                SubModerator: 3,
                Moderator: 4,
                Admin: 5
            }
        };
        getters = {};
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
        wrapper = shallowMount(RoleSelectorType, {propsData, store, localVue});
    });

    it('should display panel', function () {
        expect(wrapper.find("nav.panel").exists()).to.equal(true);
    });

    it('should display a select field', function () {
        expect(wrapper.find(".select select").exists()).to.equal(true);
    });

    it('should display title as panel-heading from title prop', function () {
        expect(wrapper.find(".panel-heading").text()).to.equal(heading)
    });

    it('should take title as a required prop', function () {
        let title = wrapper.vm.$options.props.title;
        expect(title.required).to.equal(true);
    });

    it('should display option-field for each type', function () {
        for (let name of Object.keys(state.types)) {
            expect(wrapper.find(`option[value="${state.types[name]}"`).text()).to.equal(name);
        }
    });

    it('should dispatch changeSelectedType when changing type', function () {
        wrapper.vm.selectedType = state.types.Moderator;
        expect(actions.changeSelectedType.calledOnce).to.equal(true);
    });

    it('should display the selected type in select-field', function () {
        expect(wrapper.find("select").element.value).to.not.equal(String(state.types.Moderator));
        state.selectedType = state.types.Moderator;
        expect(wrapper.find("select").element.value).to.equal(String(state.types.Moderator));
    });
});
