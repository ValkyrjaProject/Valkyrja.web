import {shallowMount} from "@vue/test-utils";
import {expect} from "chai";
import PanelListSearch from "components/shared/structure/PanelList/PanelListSearch";

describe("PanelListSearch", function () {
    let wrapper;
    let propsData;

    beforeEach(function () {
        propsData = {
            value: ""
        };
        wrapper = shallowMount(PanelListSearch, {propsData});
    });

    it("should have div.panel-block as root element", function () {
        expect(wrapper.find("div.panel-block").exists()).to.be.true;
    });

    it("should have one child with .field.has-addons.control classes under .panel-block", function () {
        expect(wrapper.findAll("div.panel-block > .field.has-addons.control").length).to.equal(1);
    });

    it("should have two .control children under .has-addons", function () {
        expect(wrapper.findAll(".has-addons > .control").length).to.equal(2);
    });

    it("should have a small full-width search input on left side", function () {
        expect(wrapper.find(".has-icons-left").classes()).to.contain("is-expanded");
    });

    it("should have 'Search' as placeholder for search input", function () {
        expect(wrapper.find(".input").attributes().placeholder).to.equal("Search");
    });

    it("should emit 'input' with value on search input change", function () {
        expect(wrapper.emitted().input).to.be.undefined;
        wrapper.find(".input").setValue("test");
        expect(wrapper.emitted().input.length).to.equal(1);
        expect(wrapper.emitted().input[0]).to.deep.equal(["test"]);
    });

    it("should have a small magnifying class search input on left side of input", function () {
        expect(wrapper.find(".has-icons-left > .icon").classes()).to.contain("is-left");
    });

    it("should have a small close button on right side with .is-info class", function () {
        expect(wrapper.findAll(".field > .control").at(1).find(".button").classes()).to.contain("is-small");
    });

    it("should emit 'clear' on close button click", function () {
        expect(wrapper.emitted().clear).to.be.undefined;
        wrapper.find(".button").trigger("click");
        expect(wrapper.emitted().clear.length).to.equal(1);
    });

    it("should have cross icon for close button", function () {
        expect(wrapper.findAll(".field > .control").at(1).find(".button .mdi").classes()).to.contain("mdi-close");
    });
});
