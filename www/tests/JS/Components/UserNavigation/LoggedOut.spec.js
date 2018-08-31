import {shallowMount} from '@vue/test-utils'
import {expect} from "chai";
import LoggedOut from "components/UserNavigation/LoggedOut";

describe('LoggedOut', function () {
    let wrapper;

    beforeEach(function () {
        wrapper = shallowMount(LoggedOut);
    });

    it('should show link to login', function () {
        expect(wrapper.find('a[href="/login"').exists()).to.equal(true);
    });

    it('should display "Login"', function () {
        expect(wrapper.find('.logged-out').text()).to.equal("Login");
    });

    it('should display mdi-account', function () {
        expect(wrapper.find('.mdi-account').exists()).to.equal(true);
    });
});