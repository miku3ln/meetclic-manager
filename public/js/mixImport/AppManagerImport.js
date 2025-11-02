import Vue from 'vue'; // Importa Vue desde node_modules


import { useVuelidate } from '@vuelidate/core';
import * as Validators  from '@vuelidate/validators';
import axios from 'axios';
window.axios=axios;

// Usamos Composition API en Vue 2
//Vue.use(VueCompositionAPI);
function miguelnAlex(){

}
const VueManager={
    Validators:Validators,
    Vuelidate:9,
    useVuelidate:useVuelidate
};
window.miguelnAlex=miguelnAlex;
window.VueManager=VueManager;
window.axios=axios;
//Vue.use(useVuelidate);

//Vue.use(Vuelidate);//https://jsfiddle.net/sg2zd9mf/
//Vue.use(Vuelidate.default);//https://vuelidate.netlify.com/#sub-without-v-model
