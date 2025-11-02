<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
?>


@extends('layouts.frontend')
@section('additional-styles')
    <link rel="stylesheet" href="{{asset($resourcePathServer.'frontend/assets/css/web/Customers.css')}}">

    @include('partials.plugins.resourcesCss',['toast'=>true])
    <style>
        .page-content-wrapper--our-stores {
            margin-bottom: 4%;
        }
        .theme-button.theme-button--our-stores {
            background-color: #E74E1C;
            text-transform: uppercase;
        }
        .theme-button.theme-button--our-stores:hover {
            background-color: #001B2A;
        }
        .page-content-wrapper__address {
            text-transform: uppercase;
            color: #001B2A;
            font-weight: 800;
        }
        .page-content-wrapper__title{
         color: #E74E1C;

        }
        .content-information {
            padding-top: 10%;

        }
    </style>
@endsection
@section('script-bootgrid-init')


@endsection

@section('additional-scripts')



@endsection
@section('content')

    <div class="breadcrumb-area section-space--breadcrumb section-space--manager-sisdep">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <!--=======  breadcrumb wrapper  =======-->

                    <div class="breadcrumb-wrapper">
                        <h2 class="page-title">{{$dataManagerPage['header']['title'] }}</h2>
                        <ul class="breadcrumb-list">
                            {!! $dataManagerPage['header']['breadCrumb']['inactive'] !!}

                            <li class="active"> {{$dataManagerPage['header']['breadCrumb']['active']}}</li>
                        </ul>
                    </div>

                    <!--=======  End of breadcrumb wrapper  =======-->
                </div>
            </div>
        </div>
    </div>
    <div class="page-content-wrapper page-content-wrapper--our-stores">

        <div class="container">
            @php
                $leftInit=false;
$leftHtml='';
$rightHtml='';

            @endphp
            @foreach($ourStoresData as $key =>$row )
                <div class="row">
                    @php
                        $lat=   $row['position']['lat'];
                        $lng=   $row['position']['lng'];

                               $href='https://maps.google.com/maps?q='.$lat.'%2C'.$lng.'&amp;z=17&amp;hl=en';
                                   $leftHtml='<img class="img-responsive" src="'.$row['source'].'">';
                                    $rightHtml='<div class="content-information"><h1 class="page-content-wrapper__title">'.$row['title'].' </h1>';
           $rightHtml.='<p class="page-content-wrapper__address">'.$row['address'].' </p>';
           $rightHtml.='<a class="theme-button theme-button--our-stores" href="'.$href.'" target="_blank">'.$row['button'].' </a> </div>';

                    @endphp

                    <div class="col-md-6 col-sm-12 text-center">
                        {!! $leftInit==false?$leftHtml:$rightHtml !!}
                    </div>

                    <div class="col-md-6 col-sm-12 text-center">

                        {!! $leftInit==false?$rightHtml:$leftHtml!!}

                    </div>
                    @if(!$leftInit)
                        @php
                            $leftInit=true;
                        @endphp
                    @else
                        @php
                            $leftInit=false;
                        @endphp

                    @endif
                </div>
            @endforeach

        </div>


    </div>

@endsection
