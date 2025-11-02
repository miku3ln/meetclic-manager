$(function () {
    initManagementEvents({
        type: "home"
    });


});
var emptyManagerImage = 'https://image.shutterstock.com/image-vector/picture-vector-icon-no-image-260nw-1350441335.jpg';
var appThisComponent = null;
var appInit = new Vue(
    {
        el: '#management-take-part',
        created: function () {
            var $scope = this;
            this.$root.$on("_carouselEvents", function (emitValue) {
                $scope._managerTypes(emitValue);
            });
        },
        mounted: function () {
            var $scope = this;
            $(function () {
                $('.management-take-part').on('click', function () {
                    var rowManagerList = $(this).attr('id').split('-');
                    $scope._managementTakePart({
                        id: rowManagerList[2],

                    });
                });
            });
        },

        data: function () {
            var result = {
                loadPage: false,
                configModalManagementFormEvent: {
                    viewAllow: false
                }
            };

            return result;
        },
        methods: {
            ...$methodsFormValid,
            _managementTakePart: function (params) {

                var idManager = params['id'];
                var selectorData = ('#row-' + idManager);
                var dataEvent = $(selectorData).attr('data');
                dataEvent = JSON.parse(dataEvent);
                this.configModalManagementFormEvent.data = dataEvent;
                this.configModalManagementFormEvent.viewAllow = true;

            },
            _managerTypes: function (emitValues) {
                if (emitValues.type == "resetComponent") {
                    this.configModalManagementFormEvent.viewAllow = false


                }
            },
        },

    })
;


