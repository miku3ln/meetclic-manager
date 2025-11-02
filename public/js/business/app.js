/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
// Define a new component called button-counter
var database = firebase.database();
var refCurrent = "business";
var db = firebase.database();
var firebaseOrdersCollection = database.ref().child(refCurrent);
database.ref(refCurrent).on('child_added', function (data) {
    console.log("child_ad");
});
database.ref(refCurrent).on('child_changed', function (data) {
    //update_data_table(data.val().username, data.val().profile_picture, data.val().email, data.key)
    console.log("child_changed");

});
database.ref(refCurrent).on('child_removed', function (data) {
    //remove_data_table(data.key)
});

Vue.component('button-counter', {
    data: function () {
        return {
            count: 0
        }
    },
    template: '<button v-on:click="count++">You clicked me {{ count }} times.</button>'
});

Vue.component(
    'business-management-component',

    {
        props: ['business'],
        template: '#businessManagament',
        data() {
            return {
                checked: false,
                title: 'Check me',
                /*    data: [{
                        "id": 1,
                        "name": "ALEX",

                    }]*/
            }
        },
        methods: {
            ...$methodsFormValid,

            check() {
                this.checked = !this.checked;
            },
            editRow(info) {
                var id = info ['.key'];

                editRegister(id);
            }
        }
    }
);
Vue.component('btn-create-component', {
    data: function () {
        return {
            count: 0
        }
    },
    template: getBtnCreate(),
    methods: {
        ...$methodsFormValid,

        newRegister() {
            newRegister();
        }
    }
});
Vue.component('ul-component', {
    props: ['business', "users"],
    template: getInfo(),
    methods:
        {
            removeBusiness(row) {
                console.log(row);
            }
        }
});
// explicit installation required in module environments
Vue.use(VueFire);
const app = new Vue(
    {
        el: '#app-management',

        firebase: {
            business: db.ref(refCurrent)
        },

        data: function () {
            return {
                businessOther: db.ref(refCurrent)
            }
        },
        methods: {
            ...$methodsFormValid,

            removeBusiness(row) {
                console.log(row);
            },

        }
    });

function getBtnCreate() {
    let result = '<li class="m-portlet__nav-item"><a  @click="newRegister()"href="#"  class="m-portlet__nav-link btn btn-primary m-btn m-btn--pill m-btn--air">';
    result += '<span>'
    result += '<i class="la la-plus"></i>'
    result += 'Crear'
    result += '</span>'
    result += '</a></li>';
    return result;
}

function getInfo() {
    let result = '<ul >';
    result += '<li v-for="row in business" class="user"' + '">';
    result += '<span>{{row.title}} </span>';
    result += '<button v-on:click="removeBusiness(row)">X</button>';
    result += '</li>';
    result += '</ul>';

    return result;
}

