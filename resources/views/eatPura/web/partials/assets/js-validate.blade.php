<script id="init-validate-vue">
    Vue.use(Vuelidate);//https://jsfiddle.net/sg2zd9mf/
    Vue.use(Vuelidate.default);//https://vuelidate.netlify.com/#sub-without-v-model
    var required = Validators.required;
    var minLength = Validators.minLength;
    var minValue = Validators.minValue;
    var between = Validators.between;
    var email = Validators.email;

</script>
