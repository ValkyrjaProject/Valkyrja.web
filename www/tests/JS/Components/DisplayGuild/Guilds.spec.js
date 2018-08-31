import sinon from "sinon";
import {RouterLinkStub, mount} from '@vue/test-utils'
import Vue from 'vue';
import Vuex from "vuex";
import {expect} from "chai";
import Guilds from "components/DisplayGuilds/Guilds"
import {Guild} from "models/Guild";
import VueRouter from "vue-router"

let localVue = Vue.use(Vuex);

describe('Guilds', function () {
    let wrapper;
    let actions;
    let store;
    let state;
    let props;
    let guildCount;

    beforeEach(function () {
        Vue.use(VueRouter);
        actions = {
            retrieveGuilds: sinon.stub(),
        };
        guildCount = 5;

        state = {
            guilds: mockGuilds(guildCount)
        };
        store = new Vuex.Store({
            state,
            actions,
        });
        props = {
            skeletonCount: 10
        };
        wrapper = mount(Guilds, {
            store,
            localVue,
            stubs: {
                RouterLink: RouterLinkStub
            }
        });
        wrapper.setProps(props);
    });

    it('should display same amount of skeleton guilds as prop', function () {
        expect(wrapper.findAll(".skeleton-column").length).to.equal(props.skeletonCount);
    });

    it('should display skeleton guilds by default', function () {
        expect(wrapper.find(".skeleton-column").exists()).to.equal(true);
    });

    it('should call retrieveGuilds', function () {
        sinon.assert.calledOnce(actions.retrieveGuilds);
    });

    it('should show guilds when isLoading prop is false', function () {
        wrapper.setData({isLoading: false});
        expect(wrapper.findAll(".guild-column").length).to.equal(guildCount);
    });

    it('should show link to edit guild config for loaded guild', function () {
        wrapper.setData({isLoading: false});
        let id = state.guilds[0].id;
        expect(wrapper.find(RouterLinkStub).props().to.params.guildId).to.equal(id);
    });
});
function mockGuilds(count) {
    // mock guilds
    let guilds = [];
    for (let i = 0; i < count; i++) {
        guilds.push(sinon.stub(Guild.prototype, "name"));
    }
    return guilds;
}
