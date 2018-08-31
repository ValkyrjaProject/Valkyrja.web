import {shallowMount} from '@vue/test-utils'
import Vue from 'vue';
import Vuex from "vuex";
import {expect} from "chai";
import ConfigNavbarItem from "components/EditGuild/ConfigNavbarItem"

let localVue = Vue.use(Vuex);

describe('ConfigNavbarItem', function () {
    let wrapper;
    let propsData;

    beforeEach(function () {
        propsData = {
            item: {
                name: "name",
                item: "icon"
            }
        };
        wrapper = shallowMount(ConfigNavbarItem, {propsData, localVue});
    });

    it('should display icon from prop', function () {
        expect(wrapper.find(`span[class="icon mdi mdi-${propsData.item.icon}"`).exists()).to.equal(true);
    });

    it('should display name from prop', function () {
        expect(wrapper.find("a").text()).to.equal(propsData.item.name);
    });

    it('should not display isActive-class by default', function () {
        expect(wrapper.find('a[class="isActive"]').exists()).to.equal(false);
    });

    it('should display isActive-class if isActive prop is true', function () {
        wrapper.props({isActive: true});
        expect(wrapper.find('a[class="isActive"]').exists()).to.equal(false);
    });

    it('should not display isActive-class if isActive prop is false', function () {
        wrapper.props({isActive: false});
        expect(wrapper.find('a[class="isActive"]').exists()).to.equal(false);
    });
});