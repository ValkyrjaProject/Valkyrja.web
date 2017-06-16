import Sticky from './sticky'
import Vue from 'vue'
import Vuex from 'vuex'
import idSelector from './components/id-selector.vue'

Vue.use(Vuex);

new Vue({
    el:'#app',
    components:{
        idSelector
    }
});