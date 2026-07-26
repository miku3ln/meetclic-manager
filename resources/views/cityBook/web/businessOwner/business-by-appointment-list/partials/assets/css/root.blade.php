<style id="appointment-view">
    .appointment-detail__grid{

        display:grid;

        grid-template-columns:repeat(2,1fr);

        gap:16px;

        margin-bottom:20px;

    }

    .appointment-detail__card{

        border:1px solid #dee2e6;

        border-radius:10px;

        padding:14px;

        background:#fff;

    }

    .appointment-detail__label{

        font-size:.80rem;

        color:#6c757d;

        margin-bottom:6px;

        text-transform:uppercase;

        letter-spacing:.5px;

    }

    .appointment-detail__value{

        font-size:1rem;

        font-weight:600;

    }

    .appointment-detail__section{

        margin-top:20px;

    }

    .appointment-detail__text{

        border:1px solid #dee2e6;

        border-radius:8px;

        padding:12px;

        background:#fafafa;

        min-height:70px;

    }
    .appointment-detail__card--full{

        grid-column:1 / -1;

    }

    .appointment-detail__header{

        align-items:flex-start;

    }

    .appointment-detail__title{

        margin-bottom:.5rem;

        font-weight:700;

    }

    .appointment-detail__status{

        font-size:.80rem;

    }
</style>
<style id="time-custom">
    /* ==========================================================================
   Appointment Time Picker
   ========================================================================== */

    .appointment-time-picker{

        display:flex;

        flex-wrap:wrap;

        gap:.5rem;

        align-items:flex-start;

    }


    /* ==========================================================================
       Grupo (mañana / tarde)
       ========================================================================== */

    .appointment-time-picker__group{

        width:100%;

        margin-bottom:1rem;

    }


    .appointment-time-picker__group-title{

        font-size:.85rem;

        font-weight:600;

        color:#6c757d;

        margin-bottom:.5rem;

    }


    /* ==========================================================================
       Contenedor de horas
       ========================================================================== */

    .appointment-time-picker__slots{

        display:flex;

        flex-wrap:wrap;

        gap:.5rem;

    }


    /* ==========================================================================
       Hora
       ========================================================================== */

    .appointment-time-picker__slot{

        min-width:75px;

        height:42px;

        border:1px solid #dee2e6;

        background:#ffffff;

        color:#495057;

        border-radius:.5rem;

        cursor:pointer;

        transition:all .20s ease;

        display:flex;

        align-items:center;

        justify-content:center;

        font-size:.90rem;

        font-weight:500;

        user-select:none;

    }


    /* Hover */

    .appointment-time-picker__slot:hover{

        border-color:#0d6efd;

        color:#0d6efd;

        background:#f8fbff;

    }


    /* Seleccionado */

    .appointment-time-picker__slot.active{

        background:#0d6efd;

        color:#ffffff;

        border-color:#0d6efd;

    }


    /* Ocupado */

    .appointment-time-picker__slot.busy{

        background:#fff3cd;

        color:#856404;

        border-color:#ffe69c;

    }


    /* Deshabilitado */

    .appointment-time-picker__slot.disabled{

        opacity:.45;

        cursor:not-allowed;

        pointer-events:none;

    }


    /* Disponible */

    .appointment-time-picker__slot.available{

        border-color:#198754;

        color:#198754;

    }


    /* ==========================================================================
       Sin horarios
       ========================================================================== */

    .appointment-time-picker__empty{

        width:100%;

        padding:2rem;

        border:1px dashed #ced4da;

        border-radius:.5rem;

        color:#6c757d;

        text-align:center;

    }


    /* ==========================================================================
       Responsive
       ========================================================================== */

    @media (max-width:576px){

        .appointment-time-picker__slot{

            flex:1 1 calc(33.333% - .5rem);

            min-width:0;

        }

    }
</style>
<style>
    .fc-day-disabled {
        opacity: .6;
    }

    .fc-day-disabled:hover {
        background: #f5f5f5 !important;
    }

    .type-period-morning {
        color: #FF9800;
    }
    .type-period-afternoon {
        color: #de0929;
    }
    .schedule-config__item {

        display: flex;
        flex-direction: column;
        padding: 1rem;
        border-radius: .5rem;
        background: #f8f9fa;

    }


    .schedule-toggle {

        display: flex;
        justify-content: space-between;
        align-items: center;

    }


    .schedule-users {

        background: #f8f9fa;

    }


    .schedule-user {

        border-left: 4px solid #4c4cff;

    }
    /* ===============================
HORARIO SEMANAL
================================ */

    .schedule-weekly {
        border-radius: 16px;
        overflow: hidden;
    }


    .schedule-weekly__title {
        font-weight: 700;
        color: #2c2c2c;
    }



    /* ===============================
       DIA
    ================================ */

    .schedule-weekly__list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }


    .schedule-weekly__day {

        background: #ffffff;
        border: 1px solid #e9ecef;
        border-radius: 14px;
        padding: 1.25rem;

        transition: all .25s ease;

    }


    .schedule-weekly__day--active {

        border-left: 4px solid #4c4cff;

    }



    .schedule-weekly__day-info {

        display:flex;
        justify-content:space-between;
        align-items:center;

        margin-bottom:1rem;

    }



    .schedule-weekly__day-info strong {

        font-size:1.1rem;
        color:#2c2c2c;

    }



    /* ===============================
       JORNADA
    ================================ */


    .schedule-weekly__hours {



    }



    .schedule-period {

        background:#f8f9ff;

        border:1px solid #e5e5ff;

        border-radius:12px;

        padding:1rem;

    }



    .schedule-period__header {

        display:flex;

        justify-content:space-between;

        align-items:center;

        margin-bottom:.75rem;

    }



    .schedule-period__header strong {

        font-size:1rem;

        color:#4c4cff;

    }



    .schedule-period__header .text-uppercase {

        font-size:.75rem;

        font-weight:600;

        letter-spacing:.05em;

    }



    /* ===============================
       RESUMEN CAPACIDAD
    ================================ */


    .schedule-period__summary {

        display:flex;

        gap:1rem;

        margin-bottom:1rem;

    }



    .schedule-period__capacity,
    .schedule-period__staff-count {


        display:flex;

        align-items:center;

        gap:.4rem;

        background:white;

        padding:.45rem .75rem;

        border-radius:8px;

        font-size:.85rem;

        color:#555;

        border:1px solid #eee;

    }



    /* ===============================
       PERSONAL
    ================================ */


    .schedule-period__users {


        display:flex;

        flex-wrap:wrap;

        gap:.5rem;

        margin-bottom:1rem;

    }



    .schedule-period__users .badge {


        padding:.55rem .75rem;

        border-radius:20px;

        font-weight:500;

        border:1px solid #ddd;

    }





    /* ===============================
       TABLA INTERVALOS
    ================================ */


    .schedule-period__intervals {

        margin-top:1rem;

    }



    .schedule-interval-table {

        width:100%;

        border-radius:12px;

        overflow:hidden;

        border:1px solid #e5e5e5;

        background:white;

    }



    .schedule-interval-table__header {


        display:grid;

        grid-template-columns:
    160px 1fr 120px;


        padding:.75rem 1rem;

        background:#2c2c2c;

        color:white;

        font-size:.85rem;

        font-weight:600;

    }





    /* ===============================
       FILAS INTERVALOS
    ================================ */


    .schedule-interval__row {


        display:grid;

        grid-template-columns:
    160px 1fr 120px;


        align-items:center;


        padding:.75rem 1rem;


        border-bottom:1px solid #eee;


        transition:.2s ease;

    }



    .schedule-interval__row:last-child {

        border-bottom:none;

    }



    .schedule-interval__row:hover {


        background:#f8f8ff;

    }





    .schedule-interval__time {


        font-weight:600;

        color:#4c4cff;


    }



    .schedule-interval__users {


        display:flex;

        flex-wrap:wrap;

        gap:.4rem;

    }



    .schedule-interval__users span {


        background:#f1f1ff;

        color:#333;

        padding:.35rem .6rem;

        border-radius:15px;

        font-size:.8rem;

    }



    .schedule-interval__capacity {


        text-align:center;

        font-weight:600;

        color:#2c2c2c;

    }



    /* ===============================
       RESPONSIVE
    ================================ */


    @media(max-width:768px){


        .schedule-period__summary {

            flex-direction:column;

        }



        .schedule-interval-table__header {

            display:none;

        }



        .schedule-interval__row {


            display:flex;

            flex-direction:column;

            align-items:flex-start;

            gap:.5rem;


        }



        .schedule-interval__capacity {


            text-align:left;

        }



    }
</style>
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
@include('cityBook.web.businessOwner.business-by-appointment-list.partials.assets.css.nav-bar')
