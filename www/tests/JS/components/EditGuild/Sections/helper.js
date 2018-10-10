import {expect} from "chai";

export function expectInput(wrapper, selector, storeName) {
    let wrappers = wrapper.findAll(selector);
    let hasElement = false;
    let nextWrapper;
    for (let i = 0; i < wrappers.length; i++) {
        nextWrapper = wrappers.at(i);
        if (nextWrapper.props().storeName === storeName) {
            hasElement = true;
            break;
        }
    }
    expect(hasElement, `should have ${selector.name} with storeName ${storeName}`).to.equal(true);
    return nextWrapper;
}