import {shallowMount} from '@vue/test-utils'
import Vue from 'vue';
import Vuex from "vuex";
import {expect} from "chai";
import SubmitBar from "components/EditGuild/SubmitBar"

let localVue = Vue.use(Vuex);

describe('SubmitBar', function () {
    let wrapper;
    let propsData;

    beforeEach(function () {
        propsData = {
            guild: {
                name: "name",
                icon: "icon"
            }
        };
        wrapper = shallowMount(SubmitBar, {propsData, localVue});
    });

    it('should have submit button and display "Submit"', function () {
        let button = wrapper.find("button");
        expect(button.exists()).to.equal(true);
        expect(button.text()).to.equal("Submit");
    });
    it('should have navigation level', function () {
        expect(wrapper.find("nav.level").exists()).to.equal(true);
    });

    it('should have image on left level', function () {
        expect(wrapper.find(".level-left img").exists()).to.equal(true);
    });

    it('should have heading on left level', function () {
        expect(wrapper.find(".level-left .title").exists()).to.equal(true);
    });

    it('should have submit on right level', function () {
        expect(wrapper.find(".level-right button").exists()).to.equal(true);
    });

    it('should display header based on prop', function () {
        expect(wrapper.find(".level-left .title").text()).to.equal(`Editing ${propsData.guild.name}`);
    });

    it('should display figure and image based on prop', function () {
        expect(wrapper.find(`figure.image img[src="${propsData.guild.icon}"]`).exists()).to.equal(true);
    });
});