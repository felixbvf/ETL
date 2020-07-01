
require('./bootstrap');
window.Vue = require('vue');
import Vuetify from 'vuetify';
import VueRouter from 'vue-router';
Vue.use(Vuetify);
Vue.use(VueRouter);

Vue.component('home-component', require('./components/HomeComponent.vue').default);

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
});
