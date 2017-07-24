import Vue from 'vue'
import store from './vuex/store.js'
import {updateBotwinderCommands, updateRoles, updateChannels, clearAPIError} from './vuex/actions'

import Sticky from './sticky'
import IdSelector from './components/IdSelector.vue'
import TextField from './components/TextField.vue'
import TypeSelector from './components/TypeSelector.vue'
import CustomInputList from './components/CustomInputList.vue'
import CustomCommands from './components/CustomCommands.vue'
import Modal from './components/Modal.vue'

new Vue({
    store,
    el:'#app',
    components:{
        IdSelector,
        TextField,
        TypeSelector,
        CustomInputList,
        CustomCommands,
        Modal
    },
    computed: {
        /**
         * @return {string}
         */
        CommandCharacter () {
            return this.$store.state.commandCharacter
        },
        roles () {
            return this.$store.state.roles;
        },
        channels () {
            return this.$store.state.channels;
        },
        errors: {
            get () {
                return this.$store.state.errors;
            },
            set () {
                this.$store.dispatch('clearAPIError')
            }
        }
    },
    methods: {
        updateCommandCharacter (e) {
            this.$store.dispatch('updateCommandCharacter', e.target.value)
        },
    },
    created() {
        const partArray = window.location.pathname.split( '/' );
        if (partArray[2] === 'edit') {
            this.$store.dispatch('editServerId', partArray[3]);
            this.$store.dispatch('updateRoles');
            this.$store.dispatch('updateChannels');
            this.$store.dispatch('updateBotwinderCommands');
        }
    }
});

function getUrlParameter(sParam) {
    let sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
}
$(function() {
    const navSelector = '#toc';
    const $myNav = $(navSelector);
    let $scope = $('body');
    $scope.scrollspy({
        target: navSelector
    });
    $myNav.find('a:first').tab('show');
    $scope.scrollspy('refresh');

    if (window.location.pathname === '/features' || window.location.pathname === '/docs'){
        setStickySize($myNav);
        new Sticky('.scrollspy');
        // Fucking ugly code to fix something removing active class FOR SOME FUCKING REASON. Pls fix
        // TODO: I'm going to find you, and I'm going to fix you
        $('header nav.navbar a.nav-link').filter('[href="/features"],[href="/docs"]').addClass('active');
    }
});
$(window).resize(function () {
    if (window.location.pathname === '/features'){
        const $toc = $('#toc');
        setStickySize($toc);
    }
});

$(document).scroll(function () {
    if (window.location.pathname === '/features'){
        const $toc = $('#toc');
        setStickySize($toc);
    }
});

function setStickySize($element) {
    $element.css('height', ($(window).height() - $element.offset().top + $(document).scrollTop()));
}