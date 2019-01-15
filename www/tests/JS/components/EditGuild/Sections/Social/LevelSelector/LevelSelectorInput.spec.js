import sinon from "sinon";
import {mount} from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";
import {expect} from "chai";
import LevelSelectorInput from "components/EditGuild/Sections/Social/LevelSelector/LevelSelectorInput";
import VueMultiselect from "vue-multiselect";

let localVue = Vue.use(Vuex);

describe("LevelSelectorInput", function () {
    let wrapper;
    let actions;
    let store;
    let state;
    let getters;
    let propsData;

    beforeEach(function () {
        propsData = {};

        actions = {
            changeSelectedLevel: sinon.stub(),
            addLevel: sinon.stub()
        };
        state = {
            levels: [],
            selectedLevel: null,
        };
        getters = {};
        store = new Vuex.Store({
            modules: {
                levelSelector: {
                    namespaced: true,
                    state,
                    actions,
                    getters
                }
            }
        });
        wrapper = mount(LevelSelectorInput, {propsData, store, localVue});
    });

    it("should have a panel-heading with 'Levels' text", function () {
        expect(wrapper.find(".panel .panel-heading").text()).to.equal("Levels");
    });

    it("should have two panel blocks with white background", function () {
        expect(wrapper.findAll(".panel > .panel-block")).to.have.length(2);
    });

    it("should have a field with addons in first panel block", function () {
        expect(wrapper.findAll(".panel-block").at(0).find(".field.has-addons").exists()).to.be.true;
    });

    it("should have one static addon in first panel block", function () {
        let field = wrapper.findAll(".panel-block").at(0).find(".field.has-addons");
        expect(field.findAll(".control > .button.is-static")).to.have.length(1);
    });

    it("should have static button as first addon in first panel block", function () {
        let field = wrapper.findAll(".panel-block").at(0).find(".field.has-addons");
        let button = field.findAll(".control").at(0);
        expect(button.find(".control > .button.is-static").exists()).to.be.true;
    });

    it("should 'Level' as text on first addon in first panel block", function () {
        let field = wrapper.findAll(".panel-block").at(0).find(".field.has-addons");
        expect(field.find(".button.is-static").text()).to.equal("Level");
    });

    it("should have number input with input class as second addon in first panel block", function () {
        let field = wrapper.findAll(".panel-block").at(0).find(".field.has-addons");
        let input = field.findAll(".control").at(1);
        expect(input.find(".control.is-expanded > input.input[type='number']").exists()).to.be.true;
    });

    it("should default number input in first panel block to 1", function () {
        let field = wrapper.findAll(".panel-block").at(0).find(".field.has-addons");
        let input = field.findAll(".control").at(1);
        expect(input.find("input[type='number']").element.value).to.equal("1");
    });

    it("should set number input value in first panel block to selectedLevelValue data field", function () {
        wrapper.setData({currentLevelValue: "5"});
        let field = wrapper.findAll(".panel-block").at(0).find(".field.has-addons");
        let input = field.findAll(".control").at(1);
        expect(input.find("input[type='number']").element.value).to.equal(wrapper.vm.currentLevelValue);
    });

    it("should selectedLevelValue field when changing number input value in first panel block", function () {
        let field = wrapper.findAll(".panel-block").at(0).find(".field.has-addons");
        let input = field.findAll(".control").at(1);
        expect(wrapper.vm.currentLevelValue).to.equal("1");
        input.find("input[type='number']").setValue("5");
        expect(wrapper.vm.currentLevelValue).to.equal("5");
    });

    it("should minimum number input in first panel block to 1", function () {
        let field = wrapper.findAll(".panel-block").at(0).find(".field.has-addons");
        let input = field.findAll(".control").at(1);
        expect(input.find("input[type='number']").attributes("min")).to.equal("1");
    });

    it("should set 'Level' as placeholder for number input in first panel block", function () {
        let field = wrapper.findAll(".panel-block").at(0).find(".field.has-addons");
        let input = field.findAll(".control").at(1);
        expect(input.find("input[type='number']").attributes("placeholder")).to.equal("Level");
    });

    it("should have add button as third addon in first panel block", function () {
        let field = wrapper.findAll(".panel-block").at(0).find(".field.has-addons");
        let input = field.findAll(".control").at(2);
        expect(input.find(".control > a.button.is-success > .mdi.mdi-plus").exists()).to.be.true;
    });

    it("should dispatch levelSelector/addLevel with input number value when clicking third addon button in first panel block", function () {
        let field = wrapper.findAll(".panel-block").at(0).find(".field.has-addons");
        let button = field.findAll(".control").at(2).find(".control > a.button.is-success");
        button.trigger("click");
        expect(actions.addLevel.getCall(0).args[1]).to.equal(parseInt(wrapper.vm.currentLevelValue));
    });

    it("should not dispatch levelSelector/addLevel when clicking third addon button in first panel block if level exists", function () {
        let field = wrapper.findAll(".panel-block").at(0).find(".field.has-addons");
        let button = field.findAll(".control").at(2).find(".control > a.button.is-success");
        state.levels = [1];
        button.trigger("click");
        expect(actions.addLevel.notCalled).to.be.true;
    });

    it("should have a VueMultiselect component in second panel block", function () {
        expect(wrapper.findAll(".panel-block").at(1).find(VueMultiselect).exists()).to.be.true;
    });

    it("should set 'Select level' as placeholder for VueMultiselect in second panel block", function () {
        let select = wrapper.findAll(".panel-block").at(1).find(VueMultiselect);
        expect(select.props("placeholder")).to.equal("Select level");
    });

    it("should set 'vue-multiselect' as class for VueMultiselect in second panel block", function () {
        let select = wrapper.findAll(".panel-block").at(1).find(VueMultiselect);
        expect(select.classes()).to.contain("vue-multiselect");
    });

    it("should dispatch levelSelector/changeSelectedLevel when VueMultiselect in second panel block emits input", function () {
        let select = wrapper.findAll(".panel-block").at(1).find(VueMultiselect);
        select.vm.$emit("input", 5);
        expect(actions.changeSelectedLevel.getCall(0).args[1]).to.equal(5);
    });

    it("should prepend 'Level ' to VueMultiselect in second panel block when number is selected", function () {
        expect(wrapper.vm.levelName(5)).to.equal("Level 5");
        expect(wrapper.find(VueMultiselect).props("customLabel")).to.equal(wrapper.vm.levelName);
    });
});
