require('./bootstrap');

import Vue from 'vue'

import Vuelidate from 'vuelidate'
Vue.use(Vuelidate)

import VueSweetalert2 from 'vue-sweetalert2';

// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';

Vue.use(VueSweetalert2);

Vue.component(
    'people-component',
    require('./pages/PeopleComponent.vue').default
);

const app = new Vue({
    el: '#app'
});
