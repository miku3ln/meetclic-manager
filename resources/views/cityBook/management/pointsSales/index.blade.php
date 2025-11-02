@extends('layouts.cityBook')
<?php
$managementNameProcess = $configPartial['moduleCamel'];

?>
@section('content')
    <div id="app-management" class="container">


        <!--section -->
        <section id="sec1">
            <!-- container -->
            <div class="profile-edit-wrap">

                @include('cityBook.web.partials.buttons-manager')

                <div class="row">
                    <div class="col-md-3">
                        <div class="fixed-bar fl-wrap">
                            <div class="user-profile-menu-wrap fl-wrap">
                                @include('cityBook.menu.account')
                            </div>
                        </div>

                    </div>
                    <div id="tab-business" class="col-md-9">

                        @include('cityBook.management.'.$managementNameProcess.'.partials.wizards.index',['managementNameProcess'=>$managementNameProcess])

                    </div>

                </div>

            </div>


        </section>
        <div class="limit-box fl-wrap"></div>
    </div>
    @include(  'cityBook.management.'.$managementNameProcess.'.partials.actions',['managementNameProcess'=>$managementNameProcess])
@endsection
@section('script')
    <script>
        var $frontend = true;
        var $cropObject = null;

    </script>
    <script src="{{ URL::asset($resourcePathServer.'js/frontend/web/Events.js')}}"></script>

    <script src="{{ asset($resourcePathServer.'js/frontend/web/ManagementFormEventPointsSales.js') }}"
            type="text/javascript"></script>
    @include('layouts.partials.managementFormEventPointsSalesDetails',array())
    @include('layouts.partials.managementFormEventPointsSales',array())

    @include( 'cityBook.management.'.$managementNameProcess.'.assets.js.index',['managementNameProcess'=>$managementNameProcess])
@endsection
@section('additional-styles')
    @include('cityBook.management.'.$managementNameProcess.'.assets.css.index',['managementNameProcess'=>$managementNameProcess])

    <style>
        .management {
            height: 450px;
            overflow-y: scroll;
            overflow-x: hidden;
        }

        .btn.btn-success {
            background-color: #445ef2;
            border-color: #445ef2;
        }

        span.data-value {

            color: #FACC39 !important;
            border-radius: 50%;
            font-size: 19px;

        }

        div#container-data canvas {
            width: 100% !important;
            height: 100% !important;
        }


        /*-----INFORMATION-----*/
        .map-information {
            height: 350px;
        }

        .modal-mask {
            position: fixed;
            z-index: 9998;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, .5);
            display: table;
            transition: opacity .3s ease;
        }

        .modal-wrapper {
            display: table-cell;
            vertical-align: middle;
        }

        .modal-container {
            width: 98%;
            margin: 0px auto;
            padding: 20px 30px;
            background-color: #fff;
            border-radius: 2px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
            transition: all .3s ease;
            font-family: Helvetica, Arial, sans-serif;
        }

        .modal-header h3 {
            margin-top: 0;
            color: #42b983;
        }

        .modal-body {
            margin: 20px 0;
        }

        .modal-default-button {
            float: right;
        }

        /*
         * The following styles are auto-applied to elements with
         * transition="modal" when their visibility is toggled
         * by Vue.js.
         *
         * You can easily play with the modal transition by editing
         * these styles.
         */

        .modal-enter {
            opacity: 0;
        }

        .modal-leave-active {
            opacity: 0;
        }

        .modal-enter .modal-container,
        .modal-leave-active .modal-container {
            -webkit-transform: scale(1.1);
            transform: scale(1.1);
        }

        .not-view {
            display: none;
        }

        /*
        -------MANAGER-----*/
        label.label--schedule {
            width: 38%;
        }

        .remove--schedule-day {
            position: absolute;
            /* top: 66px; */
            right: 0px;
        }

        #btn-add-url_img {
            width: 100%;
            height: 49px;
            margin-top: 0px;
        }

        .content-box-image__preview {
            width: 100%;
            height: 170px;
        }


        #btn-add-url_src {
            width: 100%;
            height: 49px;
        }

        /*
        ------panorama------*/
        #btn-add-url_panorama {
            width: 100%;
            height: 49px;
        }

        /*
        ----s2--*/


        .d-center {
            display: flex;
            align-items: center;
        }

        .selected img {
            width: auto;
            margin-right: 0.5rem;
        }

        .v-select .dropdown li {
            border-bottom: 1px solid rgba(112, 128, 144, 0.1);
        }

        .v-select .dropdown li:last-child {
            border-bottom: none;
        }

        .v-select .dropdown li a {
            padding: 10px 20px;
            width: 100%;
            font-size: 1.25em;
            color: #3c3c3c;
        }

        .v-select .dropdown-menu .active > a {
            color: #fff;
        }

        /*
        ---panorama--*/
        img.content-description__image {
            width: 150px;
            height: auto;
        }

        .content-description__title {
            color: #5867dd;
            font-weight: 600;
        }

        /*
        ----Loding---*/
        .manager-add-guests {
            height: 334px;
            overflow-y: scroll;
            margin-top: 2%;
        }

        .btn--delete {
            color: #fff;
            background-color: #f4516c;
            border-color: #f4516c;
        }

        .title-information {
            color: #716aca;
            text-align: center;
            font-style: italic;
            font-weight: 700;
            padding-top: 2%;
            padding-bottom: 2%;
            text-decoration: underline;
        }

        .map-guests {
            height: 350px;
        }

        .floating-panel-manager {
            position: absolute;
            top: 10px;
            left: 25%;
            z-index: 5;
            background-color: #fff;
            padding: 5px;
            border: 1px solid #999;
            text-align: center;
            font-family: 'Roboto', 'sans-serif';
            line-height: 30px;
            padding-left: 10px;
        }

        .fade.alert {
            z-index: 150000 !important;
        }

        .alert-error {
            background-color: #f2dede;
            border-color: #ebccd1;
            color: #a94442;
        }


        .toggle {
            position: relative;
        }

        .toggle *, .toggle *:before, .toggle *:after {
            box-sizing: border-box;
        }

        .toggle input[type="checkbox"] {
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
        }

        .toggle input[type="checkbox"][disabled] ~ label {
            pointer-events: none;
        }

        .toggle input[type="checkbox"][disabled] ~ label .toggle__switch {
            opacity: 0.4;
        }

        .toggle label {
            position: relative;
        }

        .toggle label .toggle__switch {
            position: relative;
            display: inline-block;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.1);
        }

        .toggle label .toggle__switch:after {
            content: "";
            position: absolute;
            display: inline-block;
            height: 2.125rem;
            width: 2.125rem;
            z-index: 5;
            background: white;
            transform: translate3d(0, 0, 0);
        }

        .toggle input[type="checkbox"][disabled] ~ label {
            color: rgba(187, 187, 187, 0.5);
        }

        .toggle input[type="checkbox"]:focus ~ label .toggle__switch, .toggle input[type="checkbox"]:hover ~ label .toggle__switch {
            background-color: #bbb;
        }

        .toggle input[type="checkbox"]:checked ~ label .toggle__switch {
            background-color: #51c28f;
        }

        .toggle input[type="checkbox"]:checked:focus ~ label .toggle__switch, .toggle input[type="checkbox"]:checked:hover ~ label .toggle__switch {
            background-color: #41B883;
        }

        .toggle label .toggle__switch {
            transition: background-color 0.3s cubic-bezier(0, 1, 0.5, 1);
            background: #c8c8c8;
        }

        .toggle label .toggle__switch:after {
            transition: transform 0.3s cubic-bezier(0, 1, 0.5, 1);
        }

        .toggle input[type="checkbox"]:focus ~ label .toggle__switch:after, .toggle input[type="checkbox"]:hover ~ label .toggle__switch:after {
            box-shadow: 0 3px 3px rgba(0, 0, 0, 0.3);
        }

        .toggle input[type="checkbox"]:checked ~ label .toggle__switch:after {
            transform: translate3d(36px, 0, 0);
        }

        .toggle__switch .toggle input[type="checkbox"]:checked:focus ~ label:after, .toggle__switch .toggle input[type="checkbox"]:checked:hover ~ label:after {
            box-shadow: 0 3px 3px rgba(0, 0, 0, 0.3);
        }

        .toggle label {
            position: relative;
            margin-bottom: 1rem;
        }

        .toggle label .toggle__switch {
            height: 24px;
            width: 60px;
            border-radius: 100px;
        }

        .toggle label .toggle__switch:after {
            content: "";
            top: 3px;
            left: 3px;
            border-radius: 50px;
            width: 18px;
            height: 18px;
            z-index: 5;
        }

        .toggle label .toggle__switch:hover:after {
            box-shadow: 0 3px 3px rgba(0, 0, 0, 0.3);
        }

        /* Smartphones (portrait and landscape) ----------- */
        @media only screen and (min-device-width: 320px) and (max-device-width: 480px) {
            .col-auto {
                width: 100%;
            }
        }

        /* Smartphones (landscape) ----------- */
        @media only screen and (min-width: 321px) {

        }

        /* iPads (portrait and landscape) ----------- */
        @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {

        }

        .content-form {
            margin-top: 3%;
        }

        /*
        ----MANAGER BUTTONS--*/

        .content-badge-information-type-guest {
            font-size: 20px;
            margin-top: 2%;
        }

        .content-description {
            padding-top: 1%;
            padding-bottom: 1%;
        }

        .content-manager-grid {
            margin-top: 4%;
        }

        button#btn-manager {
            margin-top: 28px;
        }

        .content-row-manager-reports {
            z-index: 15;
            position: fixed;
            display: inline-block;
            top: 7%;
        }

        .loading-results-data {
            text-align: center;
            position: absolute;
            color: #fff;
            z-index: 9;
            background: #5c4084;
            padding: 8px 18px;
            border-radius: 5px;
            left: calc(50% - 45px);
            top: calc(50% - 18px);
        }

        .container-infinite {
            padding: 40px 80px 15px 80px;
            background-color: #fff;
            border-radius: 8px;

        }

        .list-group {
            overflow: auto;
            height: 50vh;
            border: 2px solid #dce4ec;
            border-radius: 5px;
        }


        .content-description__value.free {
            background: #0b8b0f;
            text-align: center;
            color: #fff !important;

        }

        .content-description__value.occupied {
            background: #c11111;
            text-align: center;
            color: #fff !important;

        }

        .content-description__value.cleaning {
            background: #f15f11;
            text-align: center;
            color: #fff !important;

        }

        .btn--xs {
            cursor: pointer;
            padding: 0.5%;
            font-size: 19px;
        }

        .content-row-manager-buttons {
            text-align: right;
            width: auto;
        }
    </style>
@endsection
