$(function () {
    zoomInit();

});


var appInit = new Vue(
    {
        el: '#app-management',
        directives: {},
        created: function () {
            this.initEventsShare();
            var $scope = this;
            this.$root.$on("_carouselEvents", function (emitValue) {
                $scope._managerTypes(emitValue);
            });
        },
        mounted: function () {
            appThisComponent = this;
            var $this = this;
            $(document).ready(function () {
            });
        },
        data: function () {
            var result = {
                overriddenNetworks: {
                    "custom": {
                        "type": "popup"
                    },
                },
                dataNetworkShare: {
                    title: $eventDetails.hasOwnProperty('events') ? $eventDetails['events']['name'] + '-' + parseFloat($eventDetails['events']['sale_price']) : 'Not Description.',
                    description: $eventDetails.hasOwnProperty('events') ? $eventDetails['events']['description'] : 'Not Description.',
                    quote: "Comparte,Gana muchos premios con meetclic.",
                    hashtags: "meetclic,eventss,migu3ln",
                    'twitter-user': "vuejs",
                    method: 'share',
                    href: $eventDetails.hasOwnProperty('events') ? $eventDetails.url : 'meetclic.com',
                },
                loadPage: false,
                configModalManagementFormEvent: {
                    viewAllow: false
                }

            };

            return result;
        },
        methods: {
            ...$methodsFormValid,
            initEventsShare: function () {
                $.ajaxSetup({cache: true});
                $.getScript('https://connect.facebook.net/en_US/sdk.js', function () {
                    FB.init({
                        appId: '642760929635985',
                        version: 'v2.7' // or v2.1, v2.2, v2.3, ...
                    });

                    /*    FB.getLoginStatus(this.updateStatusCallback);*/
                });
            },
            updateStatusCallback: updateStatusCallback,
            initManagement: function () {
                console.log('init');
            },
            openShare: function () {
                console.log('open');
            },
            closeShare: function () {
                console.log('closeShare')

            },
            changeShare: function () {
                console.log('changeShare')

            }, _shareInformation: function (type) {
                var paramsShare = this.dataNetworkShare;
                var textManager = 'El Evento fue compartido con exito.';
                var position = 'bottom-left';
                if (type == 0) {

                    FB.ui(
                        paramsShare,
                        // callback
                        function (response) {
                            if (response && !response.error_message) {
                                $.NotificationApp.send({
                                    heading: "Informacion !",
                                    text: textManager,
                                    position: position,
                                    loaderBg: '#53BF82',
                                    icon: 'success',
                                    hideAfter: 5000
                                });
                            } else {
                                textManager = 'No se agrego o se cancelo al compartir.!';
                                $.NotificationApp.send({
                                    heading: "Informacion !",
                                    text: textManager,
                                    position: position,
                                    loaderBg: '#bf6219',
                                    icon: 'warning',
                                    hideAfter: 5000
                                });
                            }
                        }
                    );
                } else {
                    alert('Proximamente En otras redes sociales.')
                }
            }, _managerTypes: function (emitValues) {
                if (emitValues.type == "resetComponent") {
                    this.configModalManagementFormEvent.viewAllow = false


                }
            },  _managementTakePart: function () {


                var dataEvent =$eventDetails['data'];
                dataEvent['categories']=$eventDetails['categories'];
                dataEvent['distances']=$eventDetails['distances'];
                dataEvent['kits']=$eventDetails['kits'];
                dataEvent['teams']=$eventDetails['teams'];
                this.configModalManagementFormEvent.data = dataEvent;
                this.configModalManagementFormEvent.viewAllow = true;

            },
        }
    })
;
appInit.initManagement();

function updateStatusCallback() {
    console.log(this);
}
