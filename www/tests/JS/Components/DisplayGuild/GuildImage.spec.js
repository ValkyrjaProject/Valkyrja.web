import {shallowMount} from '@vue/test-utils'
import Vue from 'vue';
import Vuex from "vuex";
import {expect} from "chai";
import GuildImage from "components/DisplayGuilds/GuildImage"

let localVue = Vue.use(Vuex);

describe('GuildImage', function () {
    let wrapper;

    beforeEach(function () {
        wrapper = shallowMount(GuildImage, {localVue});
    });

    it('should display image if prop is set', function () {
        wrapper.setProps({
            image: 'image'
        });
        expect(wrapper.find("img").exists()).to.equal(true);
        expect(wrapper.find("div.image").exists()).to.equal(false);
    });

    it('should display loading skeleton image if no props are given', function () {
        expect(wrapper.find("img").exists()).to.equal(false);
        expect(wrapper.find(".skeleton-circle").exists()).to.equal(false);
        expect(wrapper.find(".skeleton-circle-animated").exists()).to.equal(true);
    });

    it('should display skeleton image if imageText prop is given', function () {
        wrapper.setProps({
            imageText: 'imageText'
        });
        expect(wrapper.find("img").exists()).to.equal(false);
        expect(wrapper.find(".skeleton-circle").exists()).to.equal(true);
        expect(wrapper.find(".skeleton-circle-animated").exists()).to.equal(false);
    });

    it('should display tooltip if imageText is given', function () {
        let imageText = 'imageText';
        wrapper.setProps({
            imageText: imageText
        });
        expect(wrapper.find(`.tooltip[data-tooltip="${imageText}"]`).exists()).to.equal(true);
    });
});