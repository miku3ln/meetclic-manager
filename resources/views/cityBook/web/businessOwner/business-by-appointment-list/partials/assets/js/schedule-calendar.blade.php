<script>
    function initModalAppointmentForm(info){
        selectedDate = info.dateStr;
        $("#modalAppointmentCreate")
            .modal("show");
        $("#appointmentDate")
            .val(info.dateStr);
        $("#modalAppointmentCreate")
            .on(
                "show.bs.modal",
                function(){
                    console.log(
                        "Abriendo modal"
                    );
                    console.log(
                        "Fecha seleccionada:",
                        selectedDate
                    );
                    $("#appointmentDate")
                        .val(
                            selectedDate
                        );
                }
            );
        $("#modalAppointmentCreate")
            .on(
                "shown.bs.modal",
                function(){


                    $("#startTime")
                        .focus();

                    $("#btnSaveAppointment").click(function(){


                        let date =
                            $("#appointmentDate").val();


                        let time =
                            $("#startTime").val();



                        let params = {


                            // quemados por ahora
                            business_id:42,


                            appointment_type_id:2,


                            customer_id:33,



                            code:
                                $("#code").val(),



                            title:
                                $("#title").val(),



                            description:
                                $("#description").val(),



                            start_datetime:
                                date+" "+time+":00",



                            status:
                                "PENDING",



                            location:
                                $("#location").val(),



                            notes:
                                $("#notes").val()


                        };



                        console.log(params);
                        saveDataAppointment({data:params});



                    });
                }
            );
        $("#modalAppointmentCreate")
            .on(
                "hidden.bs.modal",
                function(){


                    $("#formAppointment")[0]
                        .reset();


                    selectedDate = null;


                }
            );
    }

    function mapAppointment(info){

        const event = info.event;

        const props = event.extendedProps ?? {};

        const start = moment(event.start);

        const end = event.end ? moment(event.end) : null;
console.log(event);
        return {

            id: event.id,

            title: event.title,
            statusBackground: event.backgroundColor,
            statusBorder: event.borderColor,
            status: props.status ?? "-",

            customer: props.customer_name+" "+ props.customer_last_name,

            responsible: props.responsible_name ?? "Sin responsable asignado",

            start: start.format("DD/MM/YYYY HH:mm"),

            end: end ? end.format("DD/MM/YYYY HH:mm") : "-",

            duration: end
                ? end.diff(start, "minutes") + " minutos"
                : "-",

            code: props.code ?? "-",

            location: props.location ?? "-",

            description: props.description ?? "Sin descripción.",

            notes: props.notes ?? "Sin observaciones."

        };

    }
    function renderAppointmentModal(data){

        $("#appointmentTitle")
            .text(data.title);

        $("#appointmentStatus")
            .text(data.status)
            .css({
                backgroundColor: data.statusBackground,
                borderColor: data.statusBorder,
                color: data.statusText
            });


        $("#appointmentCustomer")
            .text(data.customer);

        $("#appointmentResponsible")
            .text(data.responsible);

        $("#appointmentStart")
            .text(data.start);

        $("#appointmentEnd")
            .text(data.end);

        $("#appointmentDuration")
            .text(data.duration);

        $("#appointmentCode")
            .text(data.code);

        $("#appointmentLocation")
            .text(data.location);

        $("#appointmentDescription")
            .text(data.description);

        $("#appointmentNotes")
            .text(data.notes);

    }
    function showAppointmentDetail(event){
        const data = mapAppointment(event);
        renderAppointmentModal(data);
        $("#modalAppointmentDetail").modal("show");

    }
    var calendar=null;
    function initScheduleCalendar(){
       let calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
           locale: 'es',
           initialView: 'dayGridMonth',
           height: 'auto',
           selectable: true,
           editable: false,
           nowIndicator: true,
           dayMaxEvents: true,
           headerToolbar: {
               left: 'prev,next today',
               center: 'title',
               right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
           },
            dayCellDidMount: function(info) {

                const today = new Date();
                today.setHours(0,0,0,0);

                const cellDate = new Date(info.date);

                if (cellDate < today) {
                    info.el.style.background = '#f5f5f5';
                    info.el.style.cursor = 'not-allowed';
                    info.el.classList.add('fc-day-disabled');
                }
            },
           events: function (fetchInfo, successCallback, failureCallback) {
               let businessId = 42;
               $.ajax({
                   url: "{{route("business-by-appointment-list-data")}}",
                   type: 'GET',
                   data: {
                       businessId: businessId,
                       start: fetchInfo.startStr,
                       end: fetchInfo.endStr
                   },
                   success: function (response) {

                       if (response.success) {
                           successCallback(response.data);
                       } else {
                           failureCallback(response.message);
                       }

                   },
                   error: function (xhr) {
                       failureCallback(xhr.responseText);
                   }
               });

           },
           eventClick: function (info) {
               showAppointmentDetail(info);


           },

           dateClick: function (info) {
               console.log(info);
               const today = new Date();
               today.setHours(0,0,0,0);

               const selected = info.date;
console.log("selected",selected);
               console.log("today",selected);

               if (selected >= today) {
                   modalInfoEventCalendar=info;
                   modalCrudAppointmentModal.show();
               }else {
                   return;
               }

           }

       });
       calendar.render();
   }
</script>
