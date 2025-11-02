<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
?>

@extends('layouts.cityBook')
@section('additional-styles')
    <style>

        h1.title {
            float: left;
            width: 100%;
            text-align: center;
            color: #4db7fe;
            font-size: 34px;
            font-weight: 700;
        }

        .main-header {
            display: none;
        }

        .main-footer {
            display: none;

        }

        .responsive {
            width: 100%;
            height: auto;
        }

        #wrapper {

            padding-top: 0 !important;
        }

        .manager-invitation__title-user {
            color: #232020;

            top: 5%;
            left: 20%;
            font-weight: bold;
            font-size: 50px;
        }

        .manager-invitation__title-user span {

        }
        .manager-invitation__link-location{
            font-size: 25px;
            color: #232020;
            font-weight: bold;

        }
    </style>
@endsection
@section('additional-scripts')
    <script src="{{ asset($resourcePathServer.'plugins/codec-barras/jquery-barcode-last.min.js')}}"
            type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'plugins/pdfmaker/2021/pdfmake.min.js')}}"
            type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'plugins/pdfmaker/2021/vfs_fonts.js')}}"
            type="text/javascript"></script>
    <script>
        var $dataManagerPage = <?php echo json_encode($dataManagerPage['information']); ?>;

        $(function () {

            $('.header-search').show();
            var customerCurrent = $dataManagerPage['customer'];
            viewCodec({'codigo': customerCurrent.identification_document, element: $('.manager-invitation__document')});
        })

        function viewCodec(params) {
            $params = {element: params.element, codigo: params.codigo, type: "code128"};
            createCodec($params);
        }

        function createCodec($params) {
            $params.element.html("");
            $params.element.barcode($params.codigo, $params.type, {barWidth: 3, barHeight: 80,output:"bmp"});
        }

    </script>
@endsection
@section('content')
    <div id="app-management">
<!--        <div class="manager-invitation-pdf">
            <iframe  id="iframe-pdf" class="preview-pane" type="application/pdf" width="100%"
                    height="650" frameborder="0"></iframe>
        </div>-->
        <div class="manager-invitation">
            <img src="{{$dataManagerPage['information']['resources']['header']}}" alt="" class="responsive"
                 id="header-img">
        </div>
        <div class="row">
            <div class="col-md-6">
                <a  class="manager-invitation__link-location" target="_blank" href="{{$dataManagerPage['information']['location']}}">Lugar del Evento</a>
            </div>

        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="manager-invitation__title-user">
                    <h1>INVITADO:
                        <span>{{$dataManagerPage['information']['customer']->name.' - '.$dataManagerPage['information']['customer']->last_name}}</span>
                    </h1>
                </div>
            </div>
            <div class="col-md-6">
                <div class="manager-invitation__document">

                </div>
                <div class="manager-invitation__information-not-print">
                    Minga por el planeta Otavalo ECOLOGIGO No Imprimas el pase.
                </div>
            </div>

        </div>


    </div>
@endsection


