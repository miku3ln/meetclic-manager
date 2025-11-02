
let appThis = null;
/*https://codepen.io/laylajune/pen/OXzBWg*/
let appInit = new Vue(
        {
            el: '#app-management',
            directives: {
                "_upload-resource": {
                    inserted: function (el, binding, vnode, vm, arg) {
                        let paramsInput = binding.value;
                        paramsInput._initEventsUpload({
                            objSelector: el
                        });

                    }
                },

            },
            created: function () {
                let vmCurrent = this;
                console.log("created");

            },
            mounted: function () {
                console.log("mounted");
                $("#app-management").show();

            },
            data: {
               information:{title:"Listing One"},
                buttons:{
                   one:{
                       title:"Hola soy Button"
                   }
                }
            },
            methods: {
                ...$methodsFormValid,

                onManagerInfo: function () {
                    console.log("mounted");

                }



            }
        })
;

