<script>

    /**
     * ============================================================================
     * AppointmentTimePicker
     * ----------------------------------------------------------------------------
     * Componente para seleccionar horarios de citas.
     *
     * Dependencias:
     * - jQuery
     *
     * Autor:
     * ----------------------------------------------------------------------------
     */

    class AppointmentTimePicker {

        /**
         * Constructor
         */
        constructor(options = {}) {

            this.options = $.extend(true, {

                element: null,

                settings: null,

                date: null,

                value: null,

                disabled: false,

                name: "start_time",

                required: false

            }, options);

            /**
             * Estado interno
             */
            this.state = {

                day: null,

                schedule: null,

                periods: [],

                slots: [],

                selected: this.options.value

            };

            /**
             * Cache DOM
             */
            this.dom = {

                container: null,

                hidden: null

            };

            /**
             * Eventos propios
             */
            this.events = {};

            this.init();

        }

        /**
         * Inicializar componente
         */
        init() {

            this.cacheDom();

            this.create();

            this.calculate();

            this.render();

            this.createHiddenInput();

            this.bind();

        }

        /**
         * Cachear DOM
         */
        cacheDom() {

            this.dom.container = $(this.options.element);

        }

        /**
         * Crear estructura
         */
        create() {


            this.dom.container.empty();


            this.dom.container.addClass(
                "appointment-time-picker"
            );





        }
        createHiddenInput(){


            let required = this.options.required
                ? "required"
                : "";


            let html = `

        <input

            type="hidden"

            id="${this.options.name}"

            name="${this.options.name}"

            class="${required}"

            value="${this.state.selected || ""}"

        >

    `;


            this.dom.container.prepend(html);


            this.dom.hidden =
                this.dom.container.find(
                    "#" + this.options.name
                );


        }
        /**
         * Registrar eventos internos
         */
        bind() {

            const self = this;

            this.dom.container.on(

                "click",

                ".appointment-time-picker__slot",

                function () {

                    if ($(this).hasClass("disabled")) {

                        return;

                    }

                    self.select($(this).data("value"));

                }

            );

        }
        generateSlots(start,end,interval){


            start = start.substring(0,5);

            end = end.substring(0,5);



            let slots=[];


            let current=this.toMinutes(start);


            let finish=this.toMinutes(end);



            while(current < finish){


                slots.push(

                    this.toTime(current)

                );


                current += interval;


            }


            return slots;


        }
        /**
         * Calcular información
         */
        calculate() {

            /**
             * Obtener día actual
             */
            this.state.day = this.options.date.getDay();


            const schedules = this.options.settings.schedules || [];


            /**
             * Obtener todos los horarios del día
             */
            const daySchedules = schedules.filter(item => {

                return Number(item.day_week) === Number(this.state.day);

            });


            if(daySchedules.length === 0){

                this.state.periods = [];
                this.state.slots = [];

                return;

            }


            this.state.schedule = daySchedules;


            this.state.periods = daySchedules;


            this.state.slots = [];


            /**
             * Intervalo configurado
             */
            const interval =
                this.options.settings.default_interval_minutes || 60;



            daySchedules.forEach(period => {


                const hours = this.generateSlots(

                    period.start_time,

                    period.end_time,

                    period.interval_minutes || interval

                );


                this.state.slots.push({

                    id: period.id,

                    period: period.period,

                    title:
                        this.formatPeriod(period.period)
                        +
                        " "
                        +
                        period.start_time.substring(0,5)
                        +
                        " - "
                        +
                        period.end_time.substring(0,5),


                    hours: hours

                });


            });


        }
        formatPeriod(period){


            const periods={

                MORNING:"Mañana",

                AFTERNOON:"Tarde",

                EVENING:"Noche"

            };


            return periods[period] || period;


        }
        toTime(minutes){

            let h=Math.floor(minutes/60);

            let m=minutes%60;

            return String(h).padStart(2,"0")+

                ":"+

                String(m).padStart(2,"0");

        }
        toMinutes(time){

            let parts=time.split(":");

            return Number(parts[0])*60+

                Number(parts[1]);

        }
        /**
         * Renderizar
         */
        render(){


            /**
             * Guardar hidden antes de limpiar
             */
            let hidden = null;


            if(this.dom.hidden){

                hidden = this.dom.hidden.detach();

            }



            this.dom.container.empty();



            if(this.state.slots.length === 0){


                this.dom.container.html(

                    `
            <div class="appointment-time-picker__empty">
                No existen horarios disponibles.
            </div>
            `

                );


                if(hidden){

                    this.dom.container.prepend(hidden);

                }


                return;

            }



            this.state.slots.forEach(group=>{


                let html = `


        <div class="appointment-time-picker__group">


            <div class="appointment-time-picker__group-title">

                ${group.title}

            </div>



            <div class="appointment-time-picker__slots">


        `;



                group.hours.forEach(hour=>{


                    const active =
                        hour === this.state.selected
                            ? "active"
                            : "";



                    html += `


                <div

                    class="
                    appointment-time-picker__slot
                    ${active}
                    "

                    data-value="${hour}"

                >

                    ${hour}

                </div>


            `;


                });



                html += `


            </div>


        </div>


        `;



                this.dom.container.append(html);



            });



            /**
             * Volver a colocar hidden
             */
            if(hidden){

                this.dom.container.prepend(hidden);

            }


        }
        /**
         * Seleccionar hora
         */
        select(value){


            this.state.selected=value;


            this.dom.container

                .find(".appointment-time-picker__slot")

                .removeClass("active");



            this.dom.container

                .find('[data-value="'+value+'"]')

                .addClass("active");



            if(this.dom.hidden){

                this.dom.hidden.val(value);

            }


            this.emit("change",value);


        }

        /**
         * Obtener valor
         */
        getValue() {

            return this.state.selected;

        }

        /**
         * Asignar valor
         */
        setValue(value) {

            this.select(value);

        }

        /**
         * Cambiar fecha
         */
        setDate(date) {

            this.options.date = date;

            this.refresh();

        }

        /**
         * Cambiar configuración
         */
        setSettings(settings) {

            this.options.settings = settings;

            this.refresh();

        }

        /**
         * Refrescar
         */
        refresh() {

            this.calculate();

            this.render();

            this.emit("refresh", this.state);

        }

        /**
         * Destruir componente
         */
        destroy() {

            this.dom.container.off();

            this.dom.container.empty();

            this.events = {};

        }

        /**
         * Registrar eventos
         */
        on(event, callback) {

            if (!this.events[event]) {

                this.events[event] = [];

            }

            this.events[event].push(callback);

            return this;

        }

        /**
         * Remover evento
         */
        off(event) {

            if (this.events[event]) {

                delete this.events[event];

            }

            return this;

        }

        /**
         * Disparar evento
         */
        emit(event, data = null) {

            if (!this.events[event]) {

                return;

            }

            this.events[event].forEach(function (callback) {

                callback(data);

            });

        }

    }

    var modalCrudAppointmentModal = null;
    var modalAppointmentCreateName = "modalAppointmentCreate";
    var modalInfoEventCalendar = null;
    var btnSaveAppointmentName = "btnSaveAppointment";
    var formAppointmentName = "formAppointment";

    var formAppointment = null;
    var managerCustomerName = "managerCustomer";
    var appointmentTypeName = "appointmentType";


    function isValidateFormCrudAppointment() {
        let valid = true;
        formAppointment.querySelectorAll(".required").forEach(function (el) {
            if ($.trim(el.value) === "") {

                valid = false;


            }

        });

        return {
            isValid: valid
        };

    }

    function initEventFormAppointment() {
        formAppointment.addEventListener('change', function (e) {
            if (
                e.target.matches('input, select, textarea')
            ) {
                validateCrudAppointment();
            }

        });
    }

    function validateFormCrudAppointment() {
        let valid = true;
        var managerValid = isValidateFormCrudAppointment();
        if (managerValid.isValid) {
            formAppointment.querySelectorAll(".required").forEach(function (el) {
                if ($.trim(el.value) === "") {

                    valid = false;
                    el.classList.add("is-invalid");

                } else {

                    el.classList.remove("is-invalid");

                }

            });
        }


        return {
            isValid: managerValid.isValid
        };

    }

    function validateCrudAppointment() {

        var resultValid = validateFormCrudAppointment();
        var valid = resultValid.isValid;
        setManagerButtonSaveAppointment(valid);


    }

    function setManagerButtonSaveAppointment(allow) {
        $("#" + btnSaveAppointmentName)
            .prop("disabled", !allow);
    }

    function saveDataAppointment(params) {
        $.ajax({
            url: "{{route("business-by-appointment-save")}}",
            type: 'POST',
            data: params.data,
            success: function (response) {
                var type = "warning";
                if (response.success) {
                    type = "success";
                }
                showToast(response.message, type);
            },
            error: function (xhr) {
                var type = "warning";
                showToast(response.message, type);
            }
        });
    }

    function initModalCrudAppointment() {
        modalCrudAppointmentModal = new bootstrap.Modal(
            document.getElementById(modalAppointmentCreateName),
            {
                backdrop: "static",
                keyboard: false
            }
        );
        formAppointment = document.getElementById(formAppointmentName);
        var modalId = modalAppointmentCreateName;
        modalCrudAppointmentModal = new bootstrap.Modal(
            document.getElementById(modalId),
            {
                backdrop: "static",
                keyboard: false
            }
        );
        $("#" + modalId).on("shown.bs.modal", function () {
            resetCrudAppointment();
            initElementsInvoiceManagerModal();
            var managerValid = isValidateFormCrudAppointment();
            setManagerButtonSaveAppointment(managerValid.isValid);
        });

        $("#" + modalId).on("hidden.bs.modal", function () {
            resetCrudAppointment();
        });

    }

    function resetCrudAppointment() {
        $('#' + formAppointmentName)[0].reset();
        $("#" + managerCustomerName)
            .val(null)
            .trigger("change");
        $("#" + appointmentTypeName)
            .val(null)
            .trigger("change");
    }

    function getDataInfoCalendar() {

        var types = [
            "dayGridMonth",
            "timeGridWeek",
            "timeGridDay",

        ];
        const dateStr =
            modalInfoEventCalendar.date.getFullYear() + '-' +
            String(modalInfoEventCalendar.date.getMonth() + 1).padStart(2, '0') + '-' +
            String(modalInfoEventCalendar.date.getDate()).padStart(2, '0');
        const [year, month, day] = dateStr.split('-');
        var customerDate=day+"/"+month+"/"+year
        return {
            customerDate:customerDate,
            view: modalInfoEventCalendar.view.type,
            dateStr: dateStr,
            year: year, month: month, day: day

        }
    }

    function initElementsInvoiceManagerModal() {

        initEventFormAppointment();
        var title = "Nueva Cita";
        var managerInfoCalendar = getDataInfoCalendar();
        var selectorTitleModal="#"+modalAppointmentCreateName+" .modal-title";
        $(selectorTitleModal).text("");
        title = "Nueva Cita: " + managerInfoCalendar.customerDate;
        $(selectorTitleModal).text(title);
        const dateCurrent = new Date(
            "2028-07-26T08:07:00"
        );


        const timePicker = new AppointmentTimePicker({

            element:"#startTime",
            settings:$appointmentSettings,
            date:dateCurrent,
            value:null,
            name:"start_time",
            required:true

        });
        timePicker.on("change", function(time){
            validateCrudAppointment();


        });
        $("#" + btnSaveAppointmentName)
            .off("click")
            .on("click", function () {
                var hourSelect = $("#start_time").val() + ":00";
                var start_datetime = managerInfoCalendar.dateStr;
                var saveData = {
                    business_id: BUSINESS_ID,
                    appointment_type_id: $('#' + appointmentTypeName).val(),
                    customer_id: $('#' + managerCustomerName).val(),
                    code: $("#code").val(),
                    title: $("#title").val(),
                    description: $("#description").val(),
                    start_datetime: start_datetime + ' ' + hourSelect,
                    status: 'PENDING',
                    location: $("#location").val(),
                    notes: $("#notes").val()

                };
                saveDataAppointment({data: saveData});
            });
        if ($("#" + managerCustomerName).hasClass("select2-hidden-accessible")) {

            $("#" + managerCustomerName).select2("destroy");

        }
        $('#' + managerCustomerName).select2({
            dropdownParent: $('#' + modalAppointmentCreateName),
            // theme: 'bootstrap-5', // opcional si usas el tema
            width: '100%',
            placeholder: 'Buscar cliente...',
            allowClear: true,
            ajax: {

                url: '{{ route('getListCustomer') }}',

                dataType: 'json',

                delay: 300,

                data: function (params) {

                    return {
                        filters: {
                            search_value: params.term || '',
                            business_id: BUSINESS_ID
                        }

                    };

                },

                processResults: function (response) {

                    return {
                        results: $.map(response, function (item) {

                            return item;

                        })
                    };

                },

                cache: true

            }

        }).on("select2:select", function (e) {

            validateCrudAppointment();
        }).on('select2:clear', function () {
            validateCrudAppointment();
        });
        if ($("#" + appointmentTypeName).hasClass("select2-hidden-accessible")) {

            $("#" + appointmentTypeName).select2("destroy");

        }
        $('#' + appointmentTypeName).select2({

            dropdownParent: $('#' + modalAppointmentCreateName),

            width: '100%',

            placeholder: 'Seleccione tipo de cita...',

            allowClear: true,


            data: $.map($managerData.appointmentTypes, function (item) {

                return {

                    id: item.id,

                    text: item.title,

                    description: item.description,

                    background_color: item.background_color,

                    text_color: item.text_color

                };

            }),



            /**
             * Render opción desplegable
             */
            templateResult: function(data) {


                if (!data.id) {

                    return data.text;

                }


                return $(`

            <div class="d-flex align-items-center gap-2">


                <span
                    class="badge"
                    style="
                        background-color:${data.background_color};
                        color:${data.text_color};
                    "
                >
                    ${data.text}
                </span>


                <small class="text-muted">
                    ${data.description ?? ''}
                </small>


            </div>

        `);


            },


            /**
             * Render seleccionado
             */
            templateSelection: function(data) {


                if (!data.id) {

                    return data.text;

                }


                return $(`

            <span
                class="badge"
                style="
                    background-color:${data.background_color};
                    color:${data.text_color};
                "
            >

                ${data.text}

            </span>

        `);


            }


        })
            .on("select2:select", function (e) {

                validateCrudAppointment();

            })
            .on('select2:clear', function () {

                validateCrudAppointment();

            });

        $("#startTime").on("change", function () {

            const value = $(this).val();

            if (!availableTimes.includes(value)) {

                alert("La hora seleccionada no está disponible.");

                $(this).val(""); // o volver al último valor válido
                $(this).trigger("change");

                return;
            }

            console.log("Hora válida:", value);

        });
    }

</script>
