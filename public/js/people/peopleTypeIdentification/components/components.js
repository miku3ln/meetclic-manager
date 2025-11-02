const Validator = SimpleVueValidation.Validator;
var required = Validators.required;
var minLength = Validators.minLength;
var minValue = Validators.minValue;
var between = Validators.between;
var email=Validators.email;
/*https://flaviocopes.com/vue-components-communication/*/
// define the tree-item component
Vue.use(SimpleVueValidation);//https://bootstrap-vue.js.org/docs/reference/validation/
Vue.use(Vuelidate);//https://jsfiddle.net/sg2zd9mf/
Vue.use(Vuelidate.default);//https://vuelidate.netlify.com/#sub-without-v-model
Vue.component("v-select", VueSelect.VueSelect);
Vue.component('date-picker', VueBootstrapDatetimePicker);
Vue.use(VueTimepicker);//https://uiv.wxsm.space/getting-started

