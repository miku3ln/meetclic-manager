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

Vue.component("date-time-picker-bs4", {
    model: {prop: "value", event: "input"},

    props: {
        value: {type: String, default: ""},
        label: {type: String, default: "Fecha y hora"},
        required: {type: Boolean, default: true},
        emitOnChange: {type: Boolean, default: true},

        // ✅ límites simples (solo fecha)
        minDate: {type: String, default: ""}, // "YYYY-MM-DD"
        maxDate: {type: String, default: ""}, // "YYYY-MM-DD"

        // ✅ límites completos (fecha+hora) - acepta Date | ISO | timestamp
        minDateTime: {type: [Date, String, Number], default: null},
        maxDateTime: {type: [Date, String, Number], default: null},

        // ✅ atajo: no permitir pasado (min = ahora)
        disablePast: {type: Boolean, default: false}
    },

    data() {
        return {
            datePart: "",
            timePart: "",
            touched: false,
            lastCompleteEmitted: ""
        };
    },

    computed: {
        // ===== helpers para límites datetime =====
        minDT() {
            if (this.disablePast) return new Date();
            if (!this.minDateTime) return null;
            const d = this.minDateTime instanceof Date ? this.minDateTime : new Date(this.minDateTime);
            return isNaN(d.getTime()) ? null : d;
        },
        maxDT() {
            if (!this.maxDateTime) return null;
            const d = this.maxDateTime instanceof Date ? this.maxDateTime : new Date(this.maxDateTime);
            return isNaN(d.getTime()) ? null : d;
        },

        // min/max para el input date
        dateMinAttr() {
            // prioridad: minDT -> minDate
            if (this.minDT) return this.formatDate(this.minDT);
            return this.minDate || "";
        },
        dateMaxAttr() {
            if (this.maxDT) return this.formatDate(this.maxDT);
            return this.maxDate || "";
        },

        // min/max para el input time (depende del día seleccionado)
        timeMinAttr() {
            // Si hay minDT y el usuario eligió el MISMO día => restringir hora
            if (this.minDT && this.datePart === this.formatDate(this.minDT)) {
                return this.formatTime(this.minDT); // "HH:mm"
            }
            return "";
        },
        timeMaxAttr() {
            if (this.maxDT && this.datePart === this.formatDate(this.maxDT)) {
                return this.formatTime(this.maxDT);
            }
            return "";
        },

        pickedDateObj() {
            if (!this.datePart || !this.timePart) return null;
            const d = new Date(`${this.datePart}T${this.timePart}:00`);
            return isNaN(d.getTime()) ? null : d;
        },

        isOutOfRange() {
            if (!this.pickedDateObj) return false;

            // valida vs minDT/maxDT
            if (this.minDT && this.pickedDateObj.getTime() < this.minDT.getTime()) return true;
            if (this.maxDT && this.pickedDateObj.getTime() > this.maxDT.getTime()) return true;

            // valida vs minDate/maxDate (solo fecha)
            if (this.minDate && this.datePart < this.minDate) return true;
            if (this.maxDate && this.datePart > this.maxDate) return true;

            // valida vs time min/max del día (cuando aplica)
            if (this.timeMinAttr && this.timePart < this.timeMinAttr) return true;
            if (this.timeMaxAttr && this.timePart > this.timeMaxAttr) return true;

            return false;
        },

        status() {
            if (!this.required && (!this.datePart && !this.timePart)) return "warning";
            if (!this.datePart || !this.timePart) return "warning";

            if (!this.pickedDateObj) return "error";
            if (this.isOutOfRange) return "error";

            return "success";
        },

        statusMessage() {
            if (this.status === "success") return "OK";
            if (this.status === "error") {
                // mensaje más útil
                if (this.isOutOfRange) return "Fuera de rango permitido";
                return "Formato inválido";
            }
            return "Seleccione fecha y hora";
        },

        isValid() {
            return this.status === "success";
        },

        isoValue() {
            if (!this.isValid || !this.pickedDateObj) return "";
            return this.toIsoWithOffset(this.pickedDateObj);
        },

        badgeClass() {
            if (this.status === "success") return "badge-success";
            if (this.status === "error") return "badge-danger";
            return "badge-warning";
        }
    },

    watch: {
        value: {
            immediate: true,
            handler(v) {
                if (!v) {
                    this.datePart = "";
                    this.timePart = "";
                    this.emitStatus(true);
                    return;
                }
                const d = new Date(v);
                if (isNaN(d.getTime())) {
                    this.emitStatus(true);
                    return;
                }
                this.datePart = this.formatDate(d);
                this.timePart = this.formatTime(d);
                this.emitStatus(true);
            }
        },

        datePart() {
            // si cambia el día, puede cambiar el min/max del time
            this.emitStatus(true);
            if (this.emitOnChange) this.emitIfComplete();
        },

        timePart() {
            this.emitStatus(true);
            if (this.emitOnChange) this.emitIfComplete();
        },

        isoValue(v) {
            this.$emit("input", v);
        }
    },

    methods: {
        emitStatus() {
            this.$emit("status-change", {
                status: this.status,
                message: this.statusMessage,
                isValid: this.isValid,
                iso: this.isoValue || "",
                datePart: this.datePart,
                timePart: this.timePart,

                // ✅ extra data para que el padre sepa el rango
                limits: {
                    minDate: this.dateMinAttr || null,
                    maxDate: this.dateMaxAttr || null,
                    minTime: this.timeMinAttr || null,
                    maxTime: this.timeMaxAttr || null
                }
            });
        },

        emitIfComplete() {
            if (!this.isValid) return;
            if (!this.isoValue) return;

            if (this.lastCompleteEmitted === this.isoValue) return;
            this.lastCompleteEmitted = this.isoValue;

            this.$emit("change-complete", {
                iso: this.isoValue,
                datePart: this.datePart,
                timePart: this.timePart,
                dateObj: this.pickedDateObj,
                status: this.status,
                message: this.statusMessage,
                isValid: this.isValid
            });
        },

        formatDate(d) {
            const y = d.getFullYear();
            const m = String(d.getMonth() + 1).padStart(2, "0");
            const day = String(d.getDate()).padStart(2, "0");
            return `${y}-${m}-${day}`;
        },

        formatTime(d) {
            const hh = String(d.getHours()).padStart(2, "0");
            const mm = String(d.getMinutes()).padStart(2, "0");
            return `${hh}:${mm}`;
        },

        toIsoWithOffset(date) {
            const pad = (n) => String(n).padStart(2, "0");
            const y = date.getFullYear();
            const m = pad(date.getMonth() + 1);
            const d = pad(date.getDate());
            const hh = pad(date.getHours());
            const mm = pad(date.getMinutes());
            const ss = pad(date.getSeconds());

            const offsetMin = -date.getTimezoneOffset();
            const sign = offsetMin >= 0 ? "+" : "-";
            const offH = pad(Math.floor(Math.abs(offsetMin) / 60));
            const offM = pad(Math.abs(offsetMin) % 60);

            return `${y}-${m}-${d}T${hh}:${mm}:${ss}${sign}${offH}:${offM}`;
        }
    },

    template: `
        <div class=" shadow-sm border-0">
        <div class="">
            <label class="font-weight-bold mb-2">{{ label }}</label>

            <div class="form-row">
                <div class="form-group col-md-7">
                    <label class="small text-muted">Fecha</label>
                    <input
                        type="date"
                        class="form-control"
                        :min="dateMinAttr"
                        :max="dateMaxAttr"
                        :class="[
                touched && (!datePart || status==='error') ? 'is-invalid' : '',
                touched && datePart && status==='success' ? 'is-valid' : ''
              ]"
                        v-model="datePart"
                        @blur="touched=true"
                        @input="emitStatus(true)"
                    />
                    <div class="invalid-feedback">
                        {{ status === 'error' ? statusMessage : 'Selecciona una fecha.' }}
                    </div>
                </div>

                <div class="form-group col-md-5">
                    <label class="small text-muted">Hora</label>
                    <input
                        type="time"
                        class="form-control"
                        :min="timeMinAttr"
                        :max="timeMaxAttr"
                        :class="[
                touched && (!timePart || status==='error') ? 'is-invalid' : '',
                touched && timePart && status==='success' ? 'is-valid' : ''
              ]"
                        v-model="timePart"
                        @blur="touched=true"
                        @input="emitStatus(true)"
                    />
                    <div class="invalid-feedback">
                        {{ status === 'error' ? statusMessage : 'Selecciona una hora.' }}
                    </div>
                </div>
            </div>

            <span class="badge badge-pill not-view" :class="badgeClass">
          {{ statusMessage }}
        </span>
        </div>
        </div>
    `
});

Vue.component("frequency-limit-type-bs4", {
    model: {prop: "value", event: "input"},

    props: {
        // v-model (string) -> 'NONE' | 'ONCE' | ...
        value: {type: String, default: ""},

        label: {type: String, default: "Límite de frecuencia"},

        // ✅ array de opciones { value, text }
        options: {
            type: Array,
            default: () => ([
                //  {value: "NONE", text: "Sin límite"},
                {value: "ONCE", text: "Una vez"},
                {value: "DAILY", text: "Diario"},
                {value: "WEEKLY", text: "Semanal"},
                {value: "MONTHLY", text: "Mensual"},
                {value: "TOTAL_LIMIT", text: "Límite total (cantidad)"}
            ])
        },

        // ✅ 'vertical' | 'horizontal'
        layout: {type: String, default: "vertical"},

        required: {type: Boolean, default: true},

        // nombre del group radio (por si tienes varios componentes)
        name: {type: String, default: "frequency_limit_type"},

        // auto emitir complete cuando ya es válido
        emitOnChange: {type: Boolean, default: true}
    },

    data() {
        return {
            localValue: "",
            touched: false,
            lastComplete: ""
        };
    },

    computed: {
        status() {
            if (!this.required) return "success";
            if (!this.localValue) return "warning";
            return "success";
        },

        isValid() {
            return this.status === "success";
        },

        statusMessage() {
            if (this.isValid) return "OK";
            return "Seleccione una opción";
        },

        badgeClass() {
            return this.isValid ? "badge-success" : "badge-warning";
        },

        isHorizontal() {
            return (this.layout || "").toLowerCase() === "horizontal";
        }
    },

    watch: {
        value: {
            immediate: true,
            handler(v) {
                this.localValue = v || "";
                this.emitStatus(); // siempre notifica estado actual
            }
        },

        localValue() {
            this.touched = true;

            // v-model
            this.$emit("input", this.localValue);

            // status-change siempre en cambios mínimos
            this.emitStatus();

            // change-complete solo si ya está válido
            if (this.emitOnChange) this.emitCompleteIfOk();
        }
    },

    methods: {
        emitStatus() {
            const selected = this.options.find(o => o.value === this.localValue) || null;

            this.$emit("status-change", {
                status: this.status,                 // warning | success
                isValid: this.isValid,
                message: this.statusMessage,
                selectedValue: this.localValue,      // value seleccionado
                selectedText: selected ? selected.text : null,
                selectedOption: selected,            // {value,text} o null
                layout: this.layout,                 // vertical | horizontal
                options: this.options                // array completo
            });
        },

        emitCompleteIfOk() {
            if (!this.isValid) return;

            // evita emitir repetido si no cambió
            if (this.lastComplete === this.localValue) return;
            this.lastComplete = this.localValue;

            const selected = this.options.find(o => o.value === this.localValue) || null;

            this.$emit("change-complete", {
                status: this.status,
                isValid: this.isValid,
                message: this.statusMessage,
                selectedValue: this.localValue,
                selectedText: selected ? selected.text : null,
                selectedOption: selected,
                layout: this.layout,
                options: this.options
            });
        }
    },

    template: `
        <div class=" shadow-sm border-0">
        <div class="">
            <label class="font-weight-bold mb-2">{{ label }}</label>

            <div class="d-flex flex-wrap" :class="isHorizontal ? 'align-items-center' : 'flex-column'">
                <div
                    v-for="(opt, idx) in options"
                    :key="opt.value"
                    class="custom-control custom-radio"
                    :class="isHorizontal ? 'custom-control-inline mr-3 mb-2' : 'mb-2'"
                >
                    <input
                        class="custom-control-input"
                        type="radio"
                        :id="name + '_' + idx"
                        :name="name"
                        :value="opt.value"
                        v-model="localValue"
                    />
                    <label class="custom-control-label" :for="name + '_' + idx">
                        {{ opt.text }}
                    </label>
                </div>
            </div>

            <span class="badge badge-pill not-view" :class="badgeClass">
          {{ statusMessage }}
        </span>
        </div>
        </div>
    `
});


