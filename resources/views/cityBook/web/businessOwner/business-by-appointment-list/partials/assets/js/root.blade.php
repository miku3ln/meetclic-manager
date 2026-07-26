<script src="https://cdn.jsdelivr.net/npm/moment@2.30.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js"></script>

@include('cityBook.web.businessOwner.business-by-appointment-list.partials.assets.js.schedule-configuration.schedule-configuration')
@include('cityBook.web.businessOwner.business-by-appointment-list.partials.assets.js.schedule-calendar')
@include('cityBook.web.businessOwner.business-by-appointment-list.partials.assets.js.appointments.appointments-manager')
@include('cityBook.web.businessOwner.business-by-appointment-list.partials.assets.js.appointments.crud-appointment')
<script>
    class Navbar {


        constructor() {

            this.init();

        }


        init() {

            this.events();

        }


        events() {


            $('#btnSidebarMobile')
                .on('click', () => {


                    $('#navbarMobile')
                        .toggleClass('active');
                });


            $('.navbar-app__link')
                .on('click', function () {


                    let route = $(this)
                        .data('route');


                    console.log(
                        "Ir a:",
                        route
                    );


                });


            $('#btnNotification')
                .on('click', () => {


                    console.log(
                        "Mostrar notificaciones"
                    );


                });


            $('#btnUserMenu')
                .on('click', () => {


                    console.log(
                        "Abrir usuario"
                    );


                });


        }


    }
</script>
<script>
    var $managerData = <?php echo json_encode($managerData) ?>;
    var BUSINESS_ID = null;
    var $appointmentSettings = <?php echo json_encode($managerData['appointmentSettings']) ?>;
    $(function () {
        new Navbar();
        BUSINESS_ID = $appointmentSettings.business_id;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN':
                    $('meta[name="csrf-token"]').attr('content')
            }
        });

        initScheduleCalendar();
        //initScheduleConfiguration();
        initModalCrudAppointment();
    });

</script>
