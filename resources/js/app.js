
require('./bootstrap');
window.Vue = require('vue');
import Vuetify from 'vuetify';
Vue.use(Vuetify);

Vue.component('home-component', require('./components/HomeComponent.vue').default);

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
});
