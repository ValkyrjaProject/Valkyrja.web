import {shallowMount} from "@vue/test-utils";
import {expect} from "chai";
import PanelListItem from "components/shared/structure/PanelList/PanelListItem";

describe("PanelListItem", function () {
    let wrapper;
    let propsData;

    beforeEach(function () {
        propsData = {
            item: {
                toString() {
                    return "Lorem ipsum dolor sit amet.";
                }
            }
        };

        wrapper = shallowMount(PanelListItem, {propsData});
    });

    it("should have element 'a' with .panel-block class as root-element", function () {
        expect(wrapper.is("a.panel-block")).to.be.true;
    });

    it("should emit 'click' with item on root-element click", function () {
        expect(wrapper.emitted().click).to.be.undefined;
        wrapper.find("a.panel-block").vm.$emit("click");
        expect(wrapper.emitted().click.length).to.equal(1);
    });

    it("should have Material Design icon on left side if itemIcon prop is set", function () {
        wrapper.setProps({itemIcon: "test"});
        expect(wrapper.find("a .panel-icon i").classes()).to.contain("mdi-test");
    });

    it("should shorten 'item' toString value to 25 characters directly under root-element", function () {
        expect(wrapper.find("a.panel-block").text()).to.equal(propsData.item.toString().substring(0, 25));
    });

    it("should trim whitespace of 'item' toString", function () {
        wrapper.setProps({
            item: {
                toString() {
                    return " test ";
                }
            }
        });
        expect(wrapper.find("a.panel-block").text()).to.equal("test");
    });
});
