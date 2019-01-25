import sinon from "sinon";
import {shallowMount} from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";
import {expect} from "chai";
import ProfileEditor from "components/EditGuild/Sections/Social/ProfileEditor/ProfileEditor";
import PanelList from "components/shared/structure/PanelList/PanelList";
import {Profile} from "../../../../../../../resources/assets/js/models/Profile";

let localVue = Vue.use(Vuex);

describe("ProfileEditor", function () {
    let wrapper;
    let actions;
    let store;
    let state;
    let getters;
    let profileArray = [];

    beforeEach(function () {
        actions = {
            setSelectedProfile: sinon.stub(),
            changeField: sinon.stub(),
            addProfile: sinon.stub(),
        };
        state = {
            selectedProfile: null
        };
        let profiles = sinon.stub();
        profiles.returns(profileArray);
        getters = {
            profiles: profiles
        };
        store = new Vuex.Store({
            modules: {
                profileEditor: {
                    namespaced: true,
                    state,
                    actions,
                    getters
                }
            }
        });
        wrapper = shallowMount(ProfileEditor, {store, localVue});
    });

    it("should have two columns", function () {
        expect(wrapper.findAll(".box .columns > .column").length).to.equal(2);
    });

    it("should have profiles list on left column", function () {
        expect(wrapper.findAll(".box .columns > .column").at(0).props().value).to.equal(profileArray);
    });

    it("should have selected profile options on right column", function () {
        let column = wrapper.findAll(".box .columns > .column").at(1);
        expect(column.find("div.panel.panel-parent").exists()).to.be.true;
    });

    it("should have a PanelList with list of profiles", function () {
        expect(wrapper.find(PanelList).props().value).to.deep.equal([]);
    });

    it("should have a PanelList with add button", function () {
        expect(wrapper.find(PanelList).props().addButton).to.be.true;
    });

    it("should disable inputs if profile is not selected", function () {
        state.selectedProfile = null;
        let inputs = wrapper.findAll("input");
        expect(inputs.length, "Not all profile elements were found").to.equal(5);
        for (let i = 0; i < inputs.length; i++) {
            expect(inputs.at(i).attributes("disabled"), "should be undefined if input is enabled").to.not.be.undefined;
        }
    });

    it("should enable inputs if profile is selected", function () {
        state.selectedProfile = {};
        let inputs = wrapper.findAll("input");
        expect(inputs.length, "Not all profile elements were found").to.equal(5);
        for (let i = 0; i < inputs.length; i++) {
            expect(inputs.at(i).attributes("disabled"), "should be undefined if input is enabled").to.be.undefined;
        }
    });

    it("should dispatch changeField if 'option' input changes", function () {
        state.selectedProfile = {};
        expect(actions.changeField.calledOnce).to.be.false;
        wrapper.findAll("input").at(0).setValue("value");
        expect(actions.changeField.calledOnce).to.be.true;
        expect(actions.changeField.args[0][1]).to.deep.equal({field: "option", value: "value"});
    });

    it("should dispatch changeField if 'option_alt' input changes", function () {
        state.selectedProfile = {};
        expect(actions.changeField.calledOnce).to.be.false;
        wrapper.findAll("input").at(1).setValue("value");
        expect(actions.changeField.calledOnce).to.be.true;
        expect(actions.changeField.args[0][1]).to.deep.equal({field: "option_alt", value: "value"});
    });


    it("should dispatch changeField if 'label' input changes", function () {
        state.selectedProfile = {};
        expect(actions.changeField.calledOnce).to.be.false;
        wrapper.findAll("input").at(2).setValue("value");
        expect(actions.changeField.calledOnce).to.be.true;
        expect(actions.changeField.args[0][1]).to.deep.equal({field: "label", value: "value"});
    });

    it("should dispatch changeField if 'property_order' input changes", function () {
        state.selectedProfile = {};
        expect(actions.changeField.calledOnce).to.be.false;
        wrapper.findAll("input").at(3).setValue(5);
        expect(actions.changeField.calledOnce).to.be.true;
        expect(actions.changeField.args[0][1]).to.deep.equal({field: "property_order", value: "5"});
    });

    it("should dispatch changeField if 'inline' input changes", function () {
        state.selectedProfile = {};
        expect(actions.changeField.calledOnce).to.be.false;
        wrapper.findAll("input").at(4).trigger("click");
        expect(actions.changeField.calledOnce).to.be.true;
        expect(actions.changeField.args[0][1]).to.deep.equal({field: "inline", value: 1});
    });

    it("should create ProfileOption class when clicking new profile button", function () {
        expect(actions.addProfile.calledOnce).to.be.false;
        wrapper.findAll(".box .columns > .column").at(0).vm.$emit("add");
        expect(actions.addProfile.calledOnce).to.be.true;
        expect(actions.addProfile.args[0][1]).to.be.instanceof(Profile);
        expect(actions.addProfile.args[0][1].option).to.equal(`Profile ${profileArray.length + 1}`);
    });

    it("should make newly created ProfileOption active", function () {
        expect(actions.setSelectedProfile.calledOnce).to.be.false;
        wrapper.findAll(".box .columns > .column").at(0).vm.$emit("add");
        expect(actions.setSelectedProfile.calledOnce).to.be.true;
        expect(actions.setSelectedProfile.args[0][1]).to.be.instanceof(Profile);
    });

    it("should send selected profile to PanelList", function () {
        state.selectedProfile = {};
        expect(wrapper.find(PanelList).props().selectedItem).to.equal(state.selectedProfile);
    });
});
