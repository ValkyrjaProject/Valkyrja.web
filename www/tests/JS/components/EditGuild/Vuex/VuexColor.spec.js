import sinon from "sinon";
import {shallowMount} from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";
import {expect} from "chai";
import VuexColor from "components/EditGuild/Vuex/VuexColor";
import {Compact} from "vue-color";
import {ConfigData} from "../../../../../resources/assets/js/models/ConfigData";

let localVue = Vue.use(Vuex);

describe("VuexColor", function () {
    let wrapper;
    let actions;
    let store;
    let state;
    let getters;
    let propsData;
    let inputValue = 16776960; // #ffff00 - arbitrary value
    let configInput;

    beforeEach(function () {
        propsData = {
            storeName: "name"
        };
        actions = {
            changeConfig: sinon.stub()
        };
        state = {};
        configInput = sinon.stub();
        configInput.returns(ConfigData.newInstance("id", inputValue));
        getters = {
            configInput: () => configInput,
        };
        store = new Vuex.Store({
            namespaced: true,
            state,
            actions,
            getters
        });
        wrapper = shallowMount(VuexColor, {propsData, store, localVue});
    });

    it("should have Compact color picker", function() {
        expect(wrapper.find(Compact).exists()).to.equal(true);
    });

    it("should have VuexColor name", function () {
        expect(wrapper.name()).to.equal("VuexColor");
    });

    it("should have set of default colors in data field", function () {
        expect(wrapper.find(Compact).props().palette).to.deep.equal([
            "#4D4D4D", "#999999", "#FFFFFF", "#F44E3B", "#FE9200", "#FCDC00",
            "#DBDF00", "#A4DD00", "#68CCCA", "#73D8FF", "#AEA1FF", "#FDA1FF",
            "#333333", "#808080", "#CCCCCC", "#D33115", "#E27300", "#FCC400",
            "#B0BC00", "#68BC00", "#16A5A5", "#009CE0", "#7B64FF", "#FA28FF",
            "#000000", "#666666", "#B3B3B3", "#9F0500", "#C45100", "#FB9E00",
            "#808900", "#194D33", "#0C797D", "#0062B1", "#653294", "#AB149E",
            "#00FF00", "#00FFFF", "#0000FF", "#FF0000", "#FFFF00"
        ]);
    });

    it("should retrieve color from configInput getter", function () {
        expect(configInput.calledOnce).to.be.true;
        expect(wrapper.vm.color).to.deep.equal({hex: "#" + inputValue.toString(16).padStart(6, "0")});
    });

    it("should format retrieved color to hex color", function () {
        wrapper.vm.color = {hex: "#" + inputValue.toString(16).padStart(6, "0")};
        expect(actions.changeConfig.getCall(0).args[1]).to.contain({
            storeName: propsData.storeName,
            value: inputValue
        });
    });
});
