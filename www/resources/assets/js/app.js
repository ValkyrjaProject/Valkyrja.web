import Vue from "vue";
window.Vue = Vue;

import loglevel from "loglevel";
loglevel.setLevel(loglevel.levels.DEBUG);
window.log = loglevel;

import initSubHeaders from "./docs";

import DisplayGuilds from "./components/DisplayGuilds/DisplayGuilds";
import EditGuild from "./components/EditGuild/EditGuild";
import UserNavigation from "./components/UserNavigation/UserNavigation";

import store from "./store/index.js";
import Vuelidate from "vuelidate";
import VueRouter from "vue-router";

initSubHeaders();

Vue.use(Vuelidate);
Vue.use(VueRouter);

new Vue({
    el: "#navigation",
    store,
    components: {
        UserNavigation
    }
});

new Vue({
    el: "#app",
    store,
    components: {
        DisplayGuilds,
        EditGuild
    }
});

document.addEventListener("DOMContentLoaded", function () {

    // Get all "navbar-burger" elements
    let $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll(".navbar-burger"), 0);

    // Check if there are any navbar burgers
    if ($navbarBurgers.length > 0) {

        // Add a click event on each of them
        $navbarBurgers.forEach(function ($el) {
            $el.addEventListener("click", function () {

                // Get the target from the "data-target" attribute
                let target = $el.dataset.target;
                let $target = document.getElementById(target);

                // Toggle the class on both the "navbar-burger" and the "navbar-menu"
                $el.classList.toggle("is-active");
                $target.classList.toggle("is-active");

            });
        });
    }

});
