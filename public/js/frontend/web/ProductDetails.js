$(function () {
    initEventWhishList();
    initEventsCurrent();
  /*  initManagerItem();*/
    zoomInit();
    initQty();
    initSlick();
});

function initEventsCurrent() {
    $('.color-manager').on('click', function () {
        var elementColor = $(this).find('a.active');
        if (elementColor.length == 0) {
            $('.color-manager').find('a.active').removeClass('active');
            $(this).find('a').addClass('active');
        } else {

        }

    });
}

/*Vue.use(SocialSharing);
Vue.component('social-sharing', SocialSharing);*/
var appInit = new Vue(
    {
        el: '#app-management',
        directives: {},
        created: function () {
            $.ajaxSetup({cache: true});
            $.getScript('https://connect.facebook.net/en_US/sdk.js', function () {
                FB.init({
                    appId: '642760929635985',
                    version: 'v2.7' // or v2.1, v2.2, v2.3, ...
                });
                $('#loginbutton,#feedbutton').removeAttr('disabled');
                /*    FB.getLoginStatus(this.updateStatusCallback);*/
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
                    title: $productDetails.hasOwnProperty('product') ? $productDetails['product']['name'] + '-' + parseFloat($productDetails['product']['sale_price']) : 'Not Description.',
                    description: $productDetails.hasOwnProperty('product') ? $productDetails['product']['description'] : 'Not Description.',
                    quote: "Comparte,Gana muchos premios con meetclic.",
                    hashtags: "meetclic,products,migu3ln",
                    'twitter-user': "vuejs",
                    method: 'share',
                    href: $productDetails.hasOwnProperty('product') ? $productDetails.url : 'meetclic.com',
                }

            };

            return result;
        },
        methods: {
            ...$methodsFormValid,
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
                var textManager = 'El producto fue compartido con exito.';
                var position='bottom-left';
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
            }
        }
    })
;
appInit.initManagement();

function updateStatusCallback() {
    console.log(this);
}
