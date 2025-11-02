<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>
@extends('layouts.frontend')
@section('additional-styles')
    <link rel="stylesheet" href="{{asset($resourcePathServer.'frontend/assets/css/web/Customers.css')}}">
@endsection
@section('additional-scripts')
    <script>
        var $currentPage = <?php echo json_encode(isset($dataManagerPage['currentPage']) ? $dataManagerPage['currentPage'] : 'not-defined')?>;
        $(function(){
            initSlick();
        });
    </script>
@endsection
@section('content')

    @include('layouts.frontend.slider',array('dataSliderHtml'=>$dataSliderHtml))

    <!--====================  category grid  ====================-->

    @include('layouts.frontend.categories',array('dataCategoriesHtml'=>$dataCategoriesHtml))

    <!--====================  End of banner grid area  ====================-->

    <!--====================  brand logo slider ====================-->
    @if($pageSectionsConfig['alliedBrands']['allow'])
        @include('layouts.frontend.brand-logo-slider-area',array('dataSlider'=>$dataSliderLogo))
    @endif
    <!--====================  End of brand logo slider  ====================-->

    <!--====================  call to action area ====================-->

    <div class="cta-area cta-bg cta-bg--one">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1">
                    <!--=======  cta content wrapper  =======-->

                    <div class="cta-content-wrapper">
                        <div class="cta-content">
                            <h3 class="title">No puedes encontrar <br> lo que necesitas?</h3>
                            <p class="subtitle">Prueba enviandonos un correo con tu necesidad. <br> Nosotros lo
                                buscaremos <em>por tí.
                                </em> y <em>te lo enviaremos</em>hasta tu puerta.</p>
                            <a href="{{route('contactUs',app()->getLocale())}}" class="theme-button theme-button--cta">PREGUNTANOS
                                AHORA!</a>
                        </div>
                    </div>

                    <!--=======  End of cta content wrapper  =======-->
                </div>
            </div>
        </div>
    </div>

@endsection
