<script>
    function renderSummary(data) {
        let config = data;
        let totalSchedules = config.schedules?.length ?? 0;
        let totalDays = [
            ...new Set(
                (config.schedules ?? [])
                    .map(schedule => schedule.day_week)
            )
        ].length;
        let totalResponsibles = [
            ...new Set(
                (config.schedules ?? [])
                    .flatMap(schedule =>
                        schedule.assigned_users?.map(
                            item => item.user_id
                        ) ?? []
                    )
            )
        ].length;
        return `
<div class="schedule-summary card border-0 shadow-sm mb-4">


<div class="card-body">


<div class="schedule-summary__header mb-4">


<h5 class="schedule-summary__title">

<i class="bi bi-gear"></i>

Configuración general

</h5>


<p class="text-muted mb-0">

Parámetros principales de disponibilidad y reservas.

</p>


</div>




<div class="row g-3">



<div class="col-md-3">


<div class="schedule-summary__item">


<span class="schedule-summary__label">

Duración cita

</span>


<strong class="schedule-summary__value">

${config.default_duration_minutes} minutos

</strong>


</div>


</div>




<div class="col-md-3">


<div class="schedule-summary__item">


<span class="schedule-summary__label">

Intervalo agenda

</span>


<strong class="schedule-summary__value">

${config.default_interval_minutes} minutos

</strong>


</div>


</div>





<div class="col-md-3">


<div class="schedule-summary__item">


<span class="schedule-summary__label">

Días configurados

</span>


<strong class="schedule-summary__value">

${totalDays}

días

</strong>


</div>


</div>





<div class="col-md-3">


<div class="schedule-summary__item">


<span class="schedule-summary__label">

Jornadas

</span>


<strong class="schedule-summary__value">

${totalSchedules}

bloques

</strong>


</div>


</div>





<div class="col-md-4">


<div class="schedule-summary__item">


<span class="schedule-summary__label">

Responsables asignados

</span>


<strong class="schedule-summary__value">

${totalResponsibles}

usuarios

</strong>


</div>


</div>





<div class="col-md-4">


<div class="schedule-summary__item">


<span class="schedule-summary__label">

Atención sin responsable

</span>


<strong class="schedule-summary__value">


${

            config.allow_without_responsible

                ?

                'Permitido'

                :

                'No permitido'

        }


</strong>


</div>


</div>





<div class="col-md-4">


<div class="schedule-summary__item">


<span class="schedule-summary__label">

Múltiples citas mismo horario

</span>


<strong class="schedule-summary__value">


${

            config.allow_multiple_appointments_same_time

                ?

                'Permitido'

                :

                'No permitido'

        }


</strong>


</div>


</div>



</div>





<hr class="my-4">



<div class="d-flex align-items-center gap-2">


<i class="bi bi-check-circle text-success"></i>


<span class="small text-muted">

Configuración activa y lista para generar disponibilidad.

</span>


</div>



</div>


</div>


`;

    }

    class ScheduleConfigurationUI {
        constructor(data) {
            this.data = data;

            this.container = $('#scheduleConfiguration');

            this.duration = data.default_duration_minutes;
            this.interval = data.default_interval_minutes;

        }



        generateIntervals(start, end) {
            let result = [];
            let current = this.toMinutes(start);

            let finish = this.toMinutes(end);


            while (current < finish) {


                let next = current + this.interval;


                if (next > finish)
                    break;


                result.push({

                    start: this.formatTime(current),

                    end: this.formatTime(next)

                });


                current = next;


            }


            return result;


        }

        renderIntervals(intervals, schedule) {


            return intervals.map(interval => {


                return `


<div class="schedule-interval">


<div>

<strong>
${interval.start}
-
${interval.end}
</strong>


</div>







<div class="schedule-interval__capacity not-view">


${schedule.assigned_users.length}
pacientes


</div>


</div>


`


            }).join('');


        }
        toMinutes(time){

            if(!time){
                return 0;
            }


            let parts = time.split(':');


            let hours = parseInt(parts[0]);

            let minutes = parseInt(parts[1]);


            return (hours * 60) + minutes;

        }
        formatTime(minutes){


            let hours = Math.floor(minutes / 60);

            let mins = minutes % 60;


            return `${String(hours).padStart(2,'0')}:${String(mins).padStart(2,'0')}`;

        }
        renderWeeklySchedule(){

            let schedules = this.data.schedules ?? [];


            const days = [
                {
                    id:1,
                    name:'Lunes'
                },
                {
                    id:2,
                    name:'Martes'
                },
                {
                    id:3,
                    name:'Miércoles'
                },
                {
                    id:4,
                    name:'Jueves'
                },
                {
                    id:5,
                    name:'Viernes'
                },
                {
                    id:6,
                    name:'Sábado'
                },
                {
                    id:7,
                    name:'Domingo'
                }
            ];



            return `


<div class="schedule-weekly card border-0 shadow-sm mb-4">


<div class="card-body">



<h5 class="schedule-weekly__title mb-1">

Horario semanal

</h5>



<p class="text-muted mb-4">

Disponibilidad configurada por día y jornada.

</p>





<div class="schedule-weekly__list">





${
                days.map(day=>{


                    let daySchedules = schedules.filter(
                        schedule => schedule.day_week === day.id
                    );



                    return `




<div class="schedule-weekly__day
${daySchedules.length
                        ?
                        'schedule-weekly__day--active'
                        :
                        ''
                    }">





<div class="schedule-weekly__day-info">


<div>


<strong>

${day.name}

</strong>



<div class="small text-muted">

${
                        daySchedules.length
                            ?
                            `${daySchedules.length} jornada(s) configurada(s)`
                            :
                            'Sin atención'
                    }

</div>



</div>


</div>








<div class="schedule-weekly__hours row g-3">





${
                        daySchedules.length


                            ?


                            daySchedules.map(schedule=>{


                                let intervals = this.generateIntervals(
                                    schedule.start_time,
                                    schedule.end_time
                                );


                                let capacity =
                                    intervals.length *
                                    schedule.assigned_users.length;





                                return `





<div class="col-md-6">





<div class="schedule-period">







<div class="schedule-period__header">



<div>



<strong>

${schedule.start_time.substring(0,5)}

-

${schedule.end_time.substring(0,5)}

</strong>





<div class="small text-uppercase

${
                                    schedule.period === 'MORNING'
                                        ?
                                        'type-period-morning'
                                        :
                                        'type-period-afternoon'
                                }

">


${schedule.period}


</div>



</div>



</div>








<div class="schedule-period__summary">





<div class="schedule-period__capacity">


<i class="bi bi-people"></i>


${capacity}

pacientes


</div>







<div class="schedule-period__staff-count">


<i class="bi bi-person"></i>


${schedule.assigned_users.length}

personal


</div>




</div>









<div class="schedule-period__users">





${
                                    schedule.assigned_users.map(item=>{


                                        return `


<span class="badge bg-light text-dark">


<i class="bi bi-person"></i>


${item.user.name}



${
                                            item.is_primary
                                                ?
                                                ' ⭐'
                                                :
                                                ''
                                        }



</span>


`;


                                    }).join('')

                                }




</div>









<div class="schedule-period__intervals">






<div class="schedule-interval-table">





<div class="schedule-interval-table__header">


<div>
Horario
</div>



<div>
Capacidad
</div>



</div>








${
                                    this.renderIntervals(
                                        intervals,
                                        schedule
                                    )
                                }







</div>





</div>









</div>







</div>






`;



                            }).join('')



                            :



                            `

<div class="text-muted small">

No disponible

</div>

`

                    }






</div>






</div>





`;



                }).join('')

            }







</div>






</div>



</div>



`;

        }
        render() {

            this.container.html(
                this.build()
            );

            this.events();

        }

        events(){

            let self = this;


            // Cambio de disponibilidad por día
            this.container.on(
                'change',
                '.schedule-weekly__day .form-check-input',
                function(){

                    let day = $(this).data('day');

                    let enabled = $(this).is(':checked');


                    self.updateDayStatus(
                        day,
                        enabled
                    );


                }
            );




            // Agregar nuevo evento especial
            this.container.on(
                'click',
                '.schedule-events__add',
                function(){

                    self.openEventModal();

                }
            );




            // Editar evento
            this.container.on(
                'click',
                '.schedule-events__actions button[data-action="edit"]',
                function(){

                    let id = $(this).data('id');


                    self.editEvent(id);

                }
            );




            // Eliminar evento
            this.container.on(
                'click',
                '.schedule-events__actions button[data-action="delete"]',
                function(){

                    let id = $(this).data('id');


                    self.deleteEvent(id);

                }
            );



            // Cambio de hora inicio
            this.container.on(
                'change',
                '.schedule-config__time-start',
                function(){

                    self.data.start_time = $(this).val();

                }
            );



            // Cambio de hora fin
            this.container.on(
                'change',
                '.schedule-config__time-end',
                function(){

                    self.data.end_time = $(this).val();

                }
            );

        }
        build() {

            return `

<div class="schedule-config">

    ${renderSummary(this.data)}

    ${this.renderWeeklySchedule()}

</div>

`;

        }
    }
function initScheduleConfiguration(){
    let ui = new ScheduleConfigurationUI(
        $appointmentSettings
    );


    ui.render();
}
</script>
