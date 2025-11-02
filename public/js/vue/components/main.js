/*const Validator = SimpleVueValidation.Validator;*/
var required = Validators.required;
var minLength = Validators.minLength;
var minValue = Validators.minValue;
var between = Validators.between;
var email = Validators.email;
/*https://flaviocopes.com/vue-components-communication/*/
// define the tree-item component
//http://simple-vue-validator.magictek.cn/
/*Vue.use(SimpleVueValidation);//https://bootstrap-vue.js.org/docs/reference/validation/*/

Vue.use(Vuelidate);//https://jsfiddle.net/sg2zd9mf/
Vue.use(Vuelidate.default);//https://vuelidate.netlify.com/#sub-without-v-model

if (typeof (VueSelect) != 'undefined') {
    Vue.component("v-select", VueSelect.VueSelect);
}
if (typeof (VueBootstrapDatetimePicker) != 'undefined') {
    $.extend(true, $.fn.datetimepicker.defaults, {
        icons: {
            time: 'far fa-clock',
            date: 'far fa-calendar',
            up: 'fas fa-arrow-up',
            down: 'fas fa-arrow-down',
            previous: 'fas fa-chevron-left',
            next: 'fas fa-chevron-right',
            today: 'fas fa-calendar-check',
            clear: 'far fa-trash-alt',
            close: 'far fa-times-circle'
        }
    });
    Vue.component('date-picker', VueBootstrapDatetimePicker);
}
if (typeof (VueTimepicker) != 'undefined') {
    Vue.use(VueTimepicker);//https://uiv.wxsm.space/getting-started
}
if (typeof (VueRateIt) != 'undefined') {
    /*    Vue.component('star-rating', VueRateIt.StarRating);
        Vue.component('heart-rating', VueRateIt.HeartRating);
        Vue.component('image-rating', VueRateIt.ImageRating);
        Vue.component('fa-rating', VueRateIt.FaRating);*/
}
Vue.component("switch-button", {
    template: [
        '<div class="switch-button-control">\n' +
        '        <div class="switch-button" :class="{ enabled: isEnabled }"\n' +
        '\n' +
        '             @click="toggle" :style="{\'--color\': color}">\n' +
        '            <div class="button"></div>\n' +
        '        </div>\n' +
        '        <div class="switch-button-label">\n' +
        '            <slot></slot>\n' +
        '        </div>\n' +
        '    </div>'

    ].join(''),
    model: {
        prop: "isEnabled",
        event: "toggle"
    },
    props: {
        isEnabled: Boolean,
        color: {
            type: String,
            required: false,
            default: "#4D4D4D"
        }
    },
    methods: {
        ...$methodsFormValid,
        toggle: function () {
            this.$emit("toggle", !this.isEnabled);
        }
    }
});
if (typeof (VueColor) != 'undefined') {
    var Chrome = VueColor.Chrome;
    Vue.component('colorpicker', {
        components: {
            'chrome-picker': Chrome,
        },
        template: `
            <div class="input-group color-picker" ref="colorpicker">
            <input type="text" class="form-control" v-model="colorValue" @focus="showPicker()"
                   @input="updateFromInput"/>
            <span class="input-group-addon color-picker-container">
		<span class="current-color" :style="'background-color: ' + colorValue" @click="togglePicker()"></span>
		<chrome-picker :value="colors" @input="updateFromPicker" v-if="displayPicker"/>
	</span>
            </div>`,
        props: ['color'],
        data() {
            return {
                colors: {
                    hex: '#000000',
                },
                colorValue: '',
                displayPicker: false,
            }
        },
        mounted() {
            this.setColor(this.color || '#000000');
        },
        methods: {
            ...$methodsFormValid,
            setColor(color) {
                this.updateColors(color);
                this.colorValue = color;
            },
            updateColors(color) {
                if (color.slice(0, 1) == '#') {
                    this.colors = {
                        hex: color
                    };
                } else if (color.slice(0, 4) == 'rgba') {
                    var rgba = color.replace(/^rgba?\(|\s+|\)$/g, '').split(','),
                        hex = '#' + ((1 << 24) + (parseInt(rgba[0]) << 16) + (parseInt(rgba[1]) << 8) + parseInt(rgba[2])).toString(16).slice(1);
                    this.colors = {
                        hex: hex,
                        a: rgba[3],
                    }
                }
            },
            showPicker() {
                document.addEventListener('click', this.documentClick);
                this.displayPicker = true;
            },
            hidePicker() {
                document.removeEventListener('click', this.documentClick);
                this.displayPicker = false;
            },
            togglePicker() {
                this.displayPicker ? this.hidePicker() : this.showPicker();
            },
            updateFromInput() {
                this.updateColors(this.colorValue);
            },
            updateFromPicker(color) {
                this.colors = color;
                if (color.rgba.a == 1) {
                    this.colorValue = color.hex;
                } else {
                    this.colorValue = 'rgba(' + color.rgba.r + ', ' + color.rgba.g + ', ' + color.rgba.b + ', ' + color.rgba.a + ')';
                }
            },
            documentClick(e) {
                var el = this.$refs.colorpicker,
                    target = e.target;
                if (el !== target && !el.contains(target)) {
                    this.hidePicker()
                }
            }
        },
        watch: {
            colorValue(val) {
                if (val) {
                    this.updateColors(val);
                    this.$emit('input', val);
                    //document.body.style.background = val;
                }
            }
        },
    });
}
/*http://eonasdan.github.io/bootstrap-datetimepicker/Events/*/
Vue.component('data-time-picker', {
    inheritAttrs: false,
    template:
        [
            '   <div :id="containerId" class="input-group">',
            "       <input  v-on:change='_value'  data-provide=\"datepicker\" " + 'v-bind="$attrs"' + ':data-target="\'#\' + containerId"' + "class='form-control' " + ':id="id" ' + ">",
            '      <div class="input-group-append">',
            '          <button v-on:click="_viewPicker()" class="input-group-text" type="button" :data-target="\'#\' + id"',
            '              data-toggle="datetimepicker">',
            '                 <i class="fa fa-calendar"></i>',
            "         </button>",
            "       </div>",

            "  </div>"

        ].join(''),

    props: {
        "id": {type: String}, "value": {type: String}, "options": {type: Object}, "optionsEvents": {type: Object},
    },

    beforeMount: function () {
        console.log(this.options);
    },
    mounted() {
        var minValue = this.options.hasOwnProperty('minValue') ? this.options.minValue : null;

        var minValueTime = null;
        if (minValue) {
            if (typeof (minValue) == 'string') {//'04/08/2020'
                minValueTime = new Date(minValue);
            } else {
                minValueTime = minValue;
            }
        }


        var value = this.value;
        var valueCurrent = null;
        if (value) {
            if (typeof (value) == 'string') {//'04/08/2020'
                valueCurrent = new Date(value);
            } else {
                valueCurrent = value;
            }
        }

        valueCurrent = valueCurrent ? valueCurrent : (minValueTime ? minValueTime : new Date());
        console.log('hola')
        /* https://bootstrap-datepicker.readthedocs.io/en/latest/options.html*/

        var viewModeData = [
            'decades', 'years', 'months', 'days'
        ];
        if (this.optionsEvents && this.optionsEvents.hasOwnProperty('moment')) {
            this.optionsEventsCurrent = this.optionsEvents;
        }
        /*format
        * https://www.ibm.com/support/knowledgecenter/es/SSHEB3_3.5.0/com.ibm.tap.doc/loc_topics/c_custom_date_formats.html
        * dd/MM/yyyy HH:mm:ss
        * */
        var viewMode = this.options.hasOwnProperty('viewMode') ? this.options.viewMode : 'years';
        var showTodayButton = this.options.hasOwnProperty('showTodayButton') ? this.options.showTodayButton : true;
        const options = {
            icons: {
                time: "mdi mdi-clock ",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down",
                previous: "fas fa-angle-left",
                next: "fas fa-angle-right",
                today: "mdi mdi-fullscreen-exit",
                clear: "fas fa-eraser",
                close: "far fa-window-close",

            },
            viewMode: viewMode,
            showTodayButton: showTodayButton,
            tooltips: {
                today: "Fecha Actual",
                todayHours: 'Hora',
                /*       ,
                        clear: "Clear selection",
                        close: "Close the picker",
                        selectMonth: "Select Month",
                        prevMonth: "Previous Month",
                        nextMonth: "Next Month",
                        selectYear: "Select Year",
                        prevYear: "Previous Year",
                        nextYear: "Next Year",
                        selectDecade: "Select Decade",
                        prevDecade: "Previous Decade",
                        nextDecade: "Next Decade",
                        prevCentury: "Previous Century",
                        nextCentury: "Next Century",
                        pickHour: "Pick Hour",
                        incrementHour: "Increment Hour",
                        decrementHour: "Decrement Hour",
                        pickMinute: "Pick Minute",
                        incrementMinute: "Increment Minute",
                        decrementMinute: "Decrement Minute",
                        pickSecond: "Pick Second",
                        incrementSecond: "Increment Second",
                        decrementSecond: "Decrement Second",
                        togglePeriod: "Toggle Period",*/
                selectTime: "Seleccione la fecha"
            },
            format: this.options.hasOwnProperty('format') ? this.options.format : 'DD/MM/YYYY',// format: 'LT' only hours*/
            locale: this.options.hasOwnProperty('locale') ? this.options.locale : 'es',//https://github.com/moment/moment/tree/master/locale*/
        };

        if (minValueTime) {

            options.minDate = minValueTime;
        }
        if (this.options.hasOwnProperty('maxValue')) {
            var maxValue = this.options.maxValue;
            var maxValueTime;
            if (typeof (maxValue) == 'string') {//'04/08/2020'
                maxValueTime = new Date(maxValue);
            } else {
                maxValueTime = maxValue;
            }
            options.maxDate = maxValueTime;
        }
        if (this.options.hasOwnProperty('disabledValues')) {
            options.disabledValues = this.options.disabledValues;
        }
        if (this.options.hasOwnProperty('icons')) {
            options.disabledValues = this.options.icons;
        }


        options.date = this.valueCurrent;
        var elementSelector = "#" + this.id;
        this.objectElement = $(elementSelector).datetimepicker(options);
        this._initEventCurrent();
        this.setValue(valueCurrent);
        this._eventEmmit(
            {
                type: 'init'
            }
        );
    }
    ,
    data() {
        return {

            modelCurrent: '',
            modelCurrentEvent: '',
            containerId: `${this.id}_picker`,
            objectElement: null,
            optionsEventsCurrent: {
                moment: {
                    'formatOut': 'YYYY-MM-DD hh:mm'
                }
            },

        }
    }
    ,
    methods: {
        ...$methodsFormValid,
        _value(e) {

            this.setValue(e.target.value);
            if (e.target.value == '') {
                this.emmitInitFunction({
                    type: 'show'
                });
            }

        }
        ,
        setValue(value) {
            this.modelCurrent = value;
        }
        ,
        _eventEmmit: function (params) {
            if ('change' == params.type) {
                var valueCurrent = null;
                if (this.modelCurrent != '') {

                    valueCurrent = this.getFormat({
                        value: this.modelCurrent,
                        formatOut: this.optionsEventsCurrent.moment.formatOut
                    });
                }
                if ($(this.objectElement).val() == '' && valueCurrent != '') {

                    this.emmitInitFunction({
                        type: 'date', 'dateSet': new Date(valueCurrent)
                    });

                }
                if (this['optionsEvents']) {

                    this.emmitInitFunction({
                        type: 'dateSetChildren',
                        'dateSet': new Date(valueCurrent),
                        'childrenSelector': this['optionsEvents']['childrenSelector']
                    });
                }
                this.$emit('input', valueCurrent);
            } else if ('init' == params.type) {
                var valueCurrent = null;
                if (this.modelCurrent != '') {

                    valueCurrent = this.getFormat({
                        value: this.modelCurrent,
                        formatOut: this.optionsEventsCurrent.moment.formatOut
                    });
                }
                if ($(this.objectElement).val() == '' && valueCurrent != '') {
                    this.emmitInitFunction({
                        type: 'date', 'dateSet': new Date(valueCurrent)
                    });

                }
                if (this['optionsEvents']) {
                    this.emmitInitFunction({
                        type: 'dateSetChildren',
                        'dateSet': new Date(valueCurrent),
                        'childrenSelector': this['optionsEvents']['childrenSelector']
                    });
                }
                this.$emit('input', valueCurrent);
            }
        }
        ,
        getFormat(params) {
            var value = params['value'];
            var formatOut = params['formatOut'];
            var result = '';
            try {
                result = moment(value).format(formatOut);
            } catch (err) {
                console.log(err);
                result = moment(value).format('YYYY-MM-DD');
            }
            return result;
        }
        ,
        _currentElement: function (params) {
            var e = params['e'];
            var nameEvent = params['nameEvent'];
            if (nameEvent == 'change') {
                var valueCurrent = e.date._d;
                this.setValue(valueCurrent);
                this._eventEmmit(
                    {
                        type: nameEvent
                    }
                );
            } else if (nameEvent == 'error') {
                var valueCurrent = e.date._d;
                this.setValue(valueCurrent);
                this._eventEmmit(
                    {
                        type: 'change'
                    }
                );
            }
        }
        ,
        _viewPicker() {
            this.emmitInitFunction({
                type: 'show'
            });
        }
        ,
        emmitInitFunction: function (params) {
            var type = params['type'];
            var elementSelector = "#" + this.id;
            var objectElement = $(elementSelector);
            if (type == 'show') {
                objectElement.data("DateTimePicker").show();
            } else if (type == 'hide') {

                objectElement.data("DateTimePicker").hide();
            } else if (type == 'disable') {

                objectElement.data("DateTimePicker").disable();
            } else if (type == 'enable') {
                objectElement.data("DateTimePicker").enable();

            } else if (type == 'clear') {
                objectElement.data("DateTimePicker").clear();

            } else if (type == 'maxValue') {
                var dateSetMax = params['dateSetMax']
                objectElement.data("DateTimePicker").maxValue(dateSetMax);

            } else if (type == 'minValue') {
                var dateSetMin = params['dateSetMin']
                objectElement.data("DateTimePicker").minValue(dateSetMin);

            } else if (type == 'date') {
                var dateSet = params['dateSet']
                objectElement.data("DateTimePicker").date(dateSet);

            } else if (type == 'dateSetChildren') {
                var dateSet = params['dateSet']
                var childrenSelector = params['childrenSelector'];
                var elementSelector = childrenSelector;
                var objectElementChildren = $(elementSelector);
                if (objectElementChildren.length) {

                    objectElementChildren.data("DateTimePicker").minDate(dateSet);
                }

            }
        }
        ,
        _initEventCurrent: function () {
            var $this = this;
            this.objectElement.on("dp.change", function (e) {
                $this._currentElement({
                    'nameEvent': 'change', e: e
                })
            }).on("dp.show", function (e) {
                $this._currentElement({
                    'nameEvent': 'show', e: e
                })
            }).on("dp.error", function (e) {
                $this._currentElement({
                    'nameEvent': 'error', e: e
                });
            }).on("dp.update", function (e) {
                $this._currentElement({
                    'nameEvent': 'error', e: e
                })
            });
        }
    }
    ,

});

Vue.component('card-box', {
    inheritAttrs: false,
    template:
        [
            '<div class="card-box">',
            '    <h4 class="mt-0 font-16 card-box__title"><span class="card-box__title-span badge " :class="getTitleClass()">{{getTitle()}}</span></h4>',
            '     <div  v-if="managerCustom()">',
            '       <p  class="text-muted mb-0 card-box__traffic-light"   v-for="(p, keyP) in options.card.data">',
            '          {{p.title}} ',
            '            <span class="float-right card-box__value-traffic-light" >',
            '              <i class="card-box__i"  :class="getValueTrafficLightClass(p)">',
            '              </i>      ',
            '              {{p.value}}      ',
            '           </span>',
            '      </p>',
            '     </div>',
            '     <p  v-else class="text-muted mb-0 card-box__traffic-light"   v-for="(p, keyP) in card.data">',
            '          {{p.title}} ',
            '            <span class="float-right card-box__value-traffic-light">',
            '              <i class="card-box__i" :class="getValueTrafficLightClass(p)">',
            '              </i>      ',
            '              {{p.value}}      ',
            '           </span>',
            '     </p>',
            '</div>'

        ].join(''),

    props: {
        "options": {type: Object}, "optionsEvents": {type: Object},
    },

    beforeMount: function () {
        console.log(this.options);
    },
    mounted() {
        var valueCurrent = '';
        this._initEventCurrent();
        this.setValue(valueCurrent);
        this._eventEmmit(
            {
                type: 'init'
            }
        );
    }
    ,
    data() {
        return {

            optionsEventsCurrent: {},
            card: {
                'type': 'success',
                'title': 'Title not manager',
                'data': [
                    {
                        title: '# Total',
                        type: 'success',
                        'icon-class': 'fa fa-caret-up',
                        'value': '$ 50',

                    }

                ],

            }
        }
    }
    ,
    methods: {
        ...$methodsFormValid,
        managerCustom() {
            var result = this.options.hasOwnProperty('card') ? (this.options.card.hasOwnProperty('data') ? (this.options.card.data.length > 0) : false) : false;
            return result;
        },
        getValueTrafficLightClass: function (row) {
            var result = new Object;
            var valueType = row.type;
            var nameClass = '';
            if (valueType == 'success') {
                nameClass = 'text-success';
            } else if (valueType == 'warning') {
                nameClass = 'text-warning';
            } else if (valueType == 'info') {
                nameClass = 'text-info';
            }
            nameClass = row['icon-class'] + ' ' + nameClass;
            result[nameClass] = true;
            return result;
        },
        getTitleClass: function () {
            var result = new Object;
            var allowData = this.options.hasOwnProperty('card') ? (this.options.card.hasOwnProperty('type') ? true : false) : false;
            var valueType = '';
            var nameClass = '';
            if (allowData) {

                valueType = this.options['card']['type'];

            } else {
                valueType = 'success';
            }
            if (valueType == 'success') {
                nameClass = 'badge-success';
            } else if (valueType == 'warning') {
                nameClass = 'badge-warning';
            } else if (valueType == 'info') {
                nameClass = 'badge-info';
            }
            result[nameClass] = true;
            return result;
        },
        getTitle: function () {
            var allowData = this.options.hasOwnProperty('card') ? (this.options.card.hasOwnProperty('title') ? true : false) : false;
            var result = '';
            if (allowData) {

                result = this.options['card']['title'];

            } else {
                result = this.card['title'];
            }

            return result;
        },
        _value(e) {
            this.setValue(e.target.value);

        }, setValue(value) {
            this.modelCurrent = value;
        }, _eventEmmit: function (params) {
            var valueCurrent = this.modelCurrent;
            if ('change' == params.type) {

                this.$emit('input', valueCurrent);
            } else if ('init' == params.type) {

                this.$emit('input', valueCurrent);
            }
        },
        _currentElement: function (params) {

        },
        emmitInitFunction: function (params) {
        }
        ,
        _initEventCurrent: function () {

        }
    }
    ,

});


Vue.component('menu-admin-grid', {
    inheritAttrs: false,
    template:
        [
            '<div class="inline-data">',
            '<div v-for="(menu, key) in managerMenuConfig.menuCurrent" class="inline-data">',
            '   <a',
            '       v-if="menu.isUrl"',
            '        v-init-tool-tip',
            '        v-bind:id="\'a-menu-\'+menu.rowId"',
            '         v-bind:href="menu.url+menu.rowId"',
            '         class="btn--xs content-manager-buttons-grid__a "',
            '         data-toggle="tooltip"',
            '         data-placement="top"',
            '          v-bind:data-original-title="menu.title">',
            '       <i v-bind:class="menu.icon"></i>',
            '   </a>',
            '   <a',
            '       v-else ',
            '        v-init-tool-tip',
            '        v-bind:id="\'a-menu-\'+menu.rowId"',
            '         v-on:click="_managerMenuGrid(key, menu)"',
            '         class="btn--xs content-manager-buttons-grid__a "',
            '         data-toggle="tooltip"',
            '         data-placement="top"',
            '          v-bind:data-original-title="menu.title">',
            '       <i v-bind:class="menu.icon"></i>',
            '   </a>',

            '</div>',
            '</div>',

        ].join(''),

    props: {
        "options": {type: Object}, "managerMenuConfig": {type: Object}, 'eventCurrent': {type: Object},
    },

    beforeMount: function () {
        console.log(this.options);
    },
    mounted() {
        var valueCurrent = '';
        this._initEventCurrent();
        this.setValue(valueCurrent);
        this._eventEmmit(
            {
                type: 'init'
            }
        );
    }
    ,
    data() {
        return {

            optionsEventsCurrent: {},

        }
    }
    ,
    methods: {
        ...$methodsFormValid,
        _eventEmmit: function (params) {

            if ('change' == params.type) {
                this.$emit('input', params);
            } else if ('click' == params.type) {

                this.$emit('input', params.data);
            }
        },
        _managerMenuGrid: typeof (_managerMenuGrid) == "undefined" ? function () {
        } : _managerMenuGrid,
        _initEventCurrent: function () {

        },
        setValue: function (value) {

        },
        _managerRowGrid: function (params) {
            this._eventEmmit(
                {
                    'type': 'click',
                    data: params


                }
            );
        }
    }

});

