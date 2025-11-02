<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';

$typeSliderManager = isset($typeSliderManager) ? $typeSliderManager : 'index-5';

$classParent = "";
$idSlider = '';
$classSlider = '';
if ($typeSliderManager == 'index-5') {
    $classParent = "section-space";
    $idSlider = 'rev_slider_25_1';
    $classSlider = 'fullscreenbanner';
} else if ($typeSliderManager == 'index-6') {
    $classParent = "";
    $idSlider = 'rev_slider_25_1';
    $classSlider = 'fullwidthabanner';
}


?>

<!--====================  hero slider area ====================-->

<div class="hero-slider-area {{$classParent}}" id="app-carouse-events">
    <!-- START REVOLUTION SLIDER 5.4.7 fullscreen mode -->
    <div id="{{$idSlider}}" class="rev_slider {{$classSlider}} " style="display:none;" data-version="5.4.7">
        <ul>
        @if($dataSliderHtml=='')
            @if($typeSliderManager=='index-6')
                <!-- SLIDE  -->
                    <li data-index="rs-65"
                        data-transition="slideoververtical,slideoverhorizontal,slideoverleft,slideoverright,slideoverdown,parallaxvertical,parallaxhorizontal,parallaxtobottom,parallaxtotop,parallaxtoleft"
                        data-slotamount="default,default,default,default,default,default,default,default,default,default"
                        data-hideafterloop="0" data-hideslideonmobile="off"
                        data-easein="default,default,default,default,default,default,default,default,default,default"
                        data-easeout="default,default,default,default,default,default,default,default,default,default"
                        data-masterspeed="1000,default,default,default,default,default,default,default,default,default"
                        data-thumb="" data-delay="7010" data-rotate="0,0,0,0,0,0,0,0,0,0" data-saveperformance="off"
                        data-title="Slide" data-param1="" data-param2="" data-param3="" data-param4="" data-param5=""
                        data-param6="" data-param7="" data-param8="" data-param9="" data-param10="" data-description="">
                        <!-- MAIN IMAGE -->
                        <img src="{{ URL::asset($resourcePathServer.'frontend/assets/img/revimages/transparent.png')}}"
                             data-bgcolor='#eeeeee'
                             style='background:#eeeeee' alt="" data-bgposition="center center" data-bgfit="cover"
                             data-bgrepeat="no-repeat" class="rev-slidebg" data-no-retina>
                        <!-- LAYERS -->

                        <!-- LAYER NR. 1 -->
                        <div class="tp-caption   tp-resizeme" id="slide-65-layer-1"
                             data-x="['left','left','left','left']" data-hoffset="['249','150','-153','-186']"
                             data-y="['top','top','top','top']" data-voffset="['33','33','43','32']"
                             data-width="['none','none','503','804']" data-height="none" data-whitespace="nowrap"
                             data-type="text" data-responsive_offset="on"
                             data-frames='[{"delay":520,"speed":2340,"frame":"0","from":"z:0;rX:0;rY:0;rZ:0;sX:0.9;sY:0.9;skX:0;skY:0;opacity:0;","to":"o:1;","ease":"Power2.easeOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Back.easeIn"}]'
                             data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
                             data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
                             style="z-index: 5; white-space: nowrap; font-size: 20px; line-height: 22px; font-weight: 400; color: #ffffff; letter-spacing: 0px;font-family:Open Sans;">
                            <img
                                src="{{ URL::asset($resourcePathServer.'frontend/assets/img/revimages/homepage06-slide1-obj1.png')}}"
                                alt=""></div>

                        <!-- LAYER NR. 2 -->
                        <div class="tp-caption   tp-resizeme" id="slide-65-layer-2"
                             data-x="['center','center','center','center']" data-hoffset="['0','0','0','-6']"
                             data-y="['top','top','top','top']" data-voffset="['558','544','546','509']"
                             data-width="none" data-height="none" data-whitespace="nowrap" data-type="text"
                             data-responsive_offset="on"
                             data-frames='[{"delay":520,"speed":1380,"sfxcolor":"#eeeeee","sfx_effect":"blockfromleft","frame":"0","from":"z:0;","to":"o:1;","ease":"Power4.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power4.easeInOut"}]'
                             data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
                             data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
                             style="z-index: 6; white-space: nowrap; font-size: 18px; line-height: 24px; font-weight: 700; color: #f8b200; letter-spacing: 2px;font-family:Source Sans Pro;">
                            CHAIR COLLECTION
                        </div>

                        <!-- LAYER NR. 3 -->
                        <div class="tp-caption   tp-resizeme" id="slide-65-layer-3"
                             data-x="['center','center','center','center']" data-hoffset="['1','0','0','1']"
                             data-y="['top','top','top','top']" data-voffset="['591','581','584','534']"
                             data-fontsize="['48','48','48','35']" data-lineheight="['77','77','77','50']"
                             data-width="none" data-height="none" data-whitespace="nowrap" data-type="text"
                             data-responsive_offset="on"
                             data-frames='[{"delay":520,"speed":1380,"sfxcolor":"#eeeeee","sfx_effect":"blockfromright","frame":"0","from":"z:0;","to":"o:1;","ease":"Power4.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power4.easeInOut"}]'
                             data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
                             data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
                             style="z-index: 7; white-space: nowrap; font-size: 48px; line-height: 77px; font-weight: 600; color: #000000; letter-spacing: 0px;font-family:Source Sans Pro;">
                            Graceful & Unique Style
                        </div>

                        <!-- LAYER NR. 4 -->
                        <a class="tp-caption Robin-Button-Hover-2 rev-btn " href="shop-left-sidebar.html" target="_self"
                           id="slide-65-layer-4" data-x="['center','center','center','center']"
                           data-hoffset="['0','0','0','-7']" data-y="['top','top','top','top']"
                           data-voffset="['680','682','682','600']" data-width="none" data-height="none"
                           data-whitespace="nowrap" data-type="button" data-actions='' data-responsive_offset="on"
                           data-responsive="off"
                           data-frames='[{"delay":960,"speed":950,"frame":"0","from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","to":"o:1;","ease":"Power2.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"nothing"},{"frame":"hover","speed":"400","ease":"Power4.easeInOut","to":"o:1;rX:0;rY:0;rZ:0;z:0;","style":"c:rgb(248,178,0);bg:rgba(34,34,34,0);bc:rgb(248,178,0);"}]'
                           data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[12,12,12,12]"
                           data-paddingright="[25,25,25,25]" data-paddingbottom="[12,12,12,12]"
                           data-paddingleft="[25,25,25,25]"
                           style="z-index: 8; white-space: nowrap; font-size: 16px; line-height: 21px; font-weight: 700; color: rgba(255,255,255,1);font-family:Source Sans Pro;background-color:rgba(247,177,19,0.75);border-color:rgba(248,178,0,0);border-style:solid;border-width:2px 2px 2px 2px;border-radius:5px 5px 5px 5px;outline:none;box-shadow:none;box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;cursor:pointer;text-decoration: none;">SHOP
                            NOW!
                        </a>

                        <!-- LAYER NR. 5 -->
                        <div class="tp-caption   tp-resizeme" id="slide-65-layer-5"
                             data-x="['left','left','left','left']" data-hoffset="['1100','996','523','681']"
                             data-y="['top','top','top','top']" data-voffset="['118','83','98','106']" data-width="none"
                             data-height="none" data-whitespace="nowrap" data-type="text" data-responsive_offset="on"
                             data-frames='[{"delay":1970,"speed":900,"frame":"0","from":"x:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'
                             data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
                             data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
                             style="z-index: 9; white-space: nowrap; font-size: 20px; line-height: 22px; font-weight: 400; color: #ffffff; letter-spacing: 0px;font-family:Open Sans;">
                            <img
                                src="{{ URL::asset($resourcePathServer.'frontend/img/revimages/homepage06-slide1-obj2.png' )}}"
                                alt=""></div>

                        <!-- LAYER NR. 6 -->
                        <a class="tp-caption   tp-resizeme" href="shop-left-sidebar.html" target="_self"
                           id="slide-65-layer-7" data-x="['left','left','left','left']"
                           data-hoffset="['1173','1072','598','776']" data-y="['top','top','top','top']"
                           data-voffset="['444','415','434','441']" data-width="none" data-height="none"
                           data-whitespace="nowrap" data-type="text" data-actions='' data-responsive_offset="on"
                           data-frames='[{"delay":1930,"speed":2000,"frame":"0","from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","to":"o:1;","ease":"Power4.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power2.easeInOut"},{"frame":"hover","speed":"500","ease":"Power3.easeOut","to":"o:1;rX:0;rY:0;rZ:0;z:0;","style":"c:rgb(0,0,0);br:0px 0px 0px 0px;"}]'
                           data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
                           data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
                           style="z-index: 10; white-space: nowrap; font-size: 16px; line-height: 21px; font-weight: 700; color: #f8b200; letter-spacing: 0px;font-family:Source Sans Pro;cursor:pointer;text-decoration: none;">READ
                            MORE </a>
                    </li>
                    <!-- SLIDE  -->
                    <li data-index="rs-66"
                        data-transition="slotslide-vertical,slotslide-horizontal,slotfade-vertical,slotfade-horizontal,parallaxtoright,parallaxtoleft,parallaxtotop,parallaxtobottom,parallaxhorizontal,parallaxvertical"
                        data-slotamount="default,default,default,default,default,default,default,default,default,default"
                        data-hideafterloop="0" data-hideslideonmobile="off"
                        data-easein="default,default,default,default,default,default,default,default,default,default"
                        data-easeout="default,default,default,default,default,default,default,default,default,default"
                        data-masterspeed="1000,default,default,default,default,default,default,default,default,default"
                        data-thumb="" data-delay="7000" data-rotate="0,0,0,0,0,0,0,0,0,0" data-saveperformance="off"
                        data-title="Slide" data-param1="" data-param2="" data-param3="" data-param4="" data-param5=""
                        data-param6="" data-param7="" data-param8="" data-param9="" data-param10="" data-description="">
                        <!-- MAIN IMAGE -->
                        <img src="{{ URL::asset($resourcePathServer.'frontend/assets/img/revimages/transparent.png ')}}"
                             data-bgcolor='#eeeeee'
                             style='background:#eeeeee' alt="" data-bgposition="center center" data-bgfit="cover"
                             data-bgrepeat="no-repeat" class="rev-slidebg" data-no-retina>
                        <!-- LAYERS -->

                        <!-- LAYER NR. 7 -->
                        <div class="tp-caption   tp-resizeme" id="slide-66-layer-1"
                             data-x="['center','center','center','center']" data-hoffset="['0','0','-165','135']"
                             data-y="['top','top','top','top']" data-voffset="['59','33','49','1']"
                             data-width="['none','none','503','804']" data-height="none" data-whitespace="nowrap"
                             data-type="text" data-responsive_offset="on"
                             data-frames='[{"delay":540,"speed":2340,"frame":"0","from":"z:0;rX:0;rY:0;rZ:0;sX:0.9;sY:0.9;skX:0;skY:0;opacity:0;","to":"o:1;","ease":"Power2.easeOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Back.easeIn"}]'
                             data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
                             data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
                             style="z-index: 5; white-space: nowrap; font-size: 20px; line-height: 22px; font-weight: 400; color: #ffffff; letter-spacing: 0px;font-family:Open Sans;">
                            <img
                                src="{{ URL::asset($resourcePathServer.'frontend/assets/img/revimages/homepage06-slide2-obj1.png' )}}"
                                alt=""></div>

                        <!-- LAYER NR. 8 -->
                        <div class="tp-caption   tp-resizeme" id="slide-66-layer-2"
                             data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']"
                             data-y="['top','top','top','top']" data-voffset="['558','544','599','495']"
                             data-width="none" data-height="none" data-whitespace="nowrap" data-type="text"
                             data-responsive_offset="on"
                             data-frames='[{"delay":520,"speed":1430,"sfxcolor":"#eeeeee","sfx_effect":"blockfromleft","frame":"0","from":"z:0;","to":"o:1;","ease":"Power4.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power4.easeInOut"}]'
                             data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
                             data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
                             style="z-index: 6; white-space: nowrap; font-size: 18px; line-height: 24px; font-weight: 700; color: #f8b200; letter-spacing: 2px;font-family:Source Sans Pro;">
                            COLORED COLLECTION
                        </div>

                        <!-- LAYER NR. 9 -->
                        <div class="tp-caption   tp-resizeme" id="slide-66-layer-3"
                             data-x="['center','center','center','center']" data-hoffset="['0','0','0','5']"
                             data-y="['top','top','top','top']" data-voffset="['586','581','657','528']"
                             data-fontsize="['48','48','48','35']" data-lineheight="['77','77','77','50']"
                             data-width="none" data-height="none" data-whitespace="nowrap" data-type="text"
                             data-responsive_offset="on"
                             data-frames='[{"delay":520,"speed":1450,"sfxcolor":"#eeeeee","sfx_effect":"blockfromright","frame":"0","from":"z:0;","to":"o:1;","ease":"Power4.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power4.easeInOut"}]'
                             data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
                             data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
                             style="z-index: 7; white-space: nowrap; font-size: 48px; line-height: 77px; font-weight: 600; color: #000000; letter-spacing: 0px;font-family:Source Sans Pro;">
                            Beautiful Lounge Chair
                        </div>

                        <!-- LAYER NR. 10 -->
                        <a class="tp-caption Robin-Button-Hover-2 rev-btn " href="shop-left-sidebar.html" target="_self"
                           id="slide-66-layer-4" data-x="['center','center','center','center']"
                           data-hoffset="['0','0','0','-1']" data-y="['top','top','top','top']"
                           data-voffset="['684','682','774','599']" data-width="none" data-height="none"
                           data-whitespace="nowrap" data-type="button" data-actions='' data-responsive_offset="on"
                           data-responsive="off"
                           data-frames='[{"delay":990,"speed":980,"frame":"0","from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","mask":"x:0px;y:[100%];s:inherit;e:inherit;","to":"o:1;","ease":"Power2.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"nothing"},{"frame":"hover","speed":"400","ease":"Power4.easeInOut","to":"o:1;rX:0;rY:0;rZ:0;z:0;","style":"c:rgb(248,178,0);bg:rgba(34,34,34,0);bc:rgb(248,178,0);"}]'
                           data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[12,12,12,12]"
                           data-paddingright="[25,25,25,25]" data-paddingbottom="[12,12,12,12]"
                           data-paddingleft="[25,25,25,25]"
                           style="z-index: 8; white-space: nowrap; font-size: 16px; line-height: 21px; font-weight: 700; color: rgba(255,255,255,1);font-family:Source Sans Pro;background-color:rgba(247,177,19,0.75);border-color:rgba(248,178,0,0);border-style:solid;border-width:2px 2px 2px 2px;border-radius:5px 5px 5px 5px;outline:none;box-shadow:none;box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;cursor:pointer;text-decoration: none;">SHOP
                            NOW!
                        </a>

                        <!-- LAYER NR. 11 -->
                        <div class="tp-caption   tp-resizeme" id="slide-66-layer-5"
                             data-x="['left','left','left','left']" data-hoffset="['1094','900','514','-342']"
                             data-y="['top','top','top','top']" data-voffset="['98','80','91','70']" data-width="none"
                             data-height="none" data-whitespace="nowrap" data-type="text" data-responsive_offset="on"
                             data-frames='[{"delay":1980,"speed":900,"frame":"0","from":"x:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'
                             data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
                             data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
                             style="z-index: 9; white-space: nowrap; font-size: 20px; line-height: 22px; font-weight: 400; color: #ffffff; letter-spacing: 0px;font-family:Open Sans;">
                            <img
                                src="{{ URL::asset($resourcePathServer.'frontend/ assets/img/revimages/homepage06-slide2-obj2.png' )}}"
                                alt=""></div>

                        <!-- LAYER NR. 12 -->
                        <a class="tp-caption   tp-resizeme" href="shop-left-sidebar.html" target="_self"
                           id="slide-66-layer-7" data-x="['left','left','left','left']"
                           data-hoffset="['1169','977','587','-272']" data-y="['top','top','top','top']"
                           data-voffset="['422','410','415','401']" data-width="none" data-height="none"
                           data-whitespace="nowrap" data-type="text" data-actions='' data-responsive_offset="on"
                           data-frames='[{"delay":2000,"speed":2000,"frame":"0","from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","to":"o:1;","ease":"Power4.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power2.easeInOut"},{"frame":"hover","speed":"500","ease":"Power3.easeOut","to":"o:1;rX:0;rY:0;rZ:0;z:0;","style":"c:rgb(0,0,0);br:0px 0px 0px 0px;"}]'
                           data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
                           data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
                           style="z-index: 10; white-space: nowrap; font-size: 16px; line-height: 21px; font-weight: 700; color: #f8b200; letter-spacing: 0px;font-family:Source Sans Pro;cursor:pointer;text-decoration: none;">READ
                            MORE </a>
                    </li>
                    <!-- SLIDE  -->
                    <li data-index="rs-67"
                        data-transition="zoomin,zoomout,scaledownfrombottom,scaledownfromtop,scaledownfromleft,scaledownfromright,turnoff-vertical,3dcurtain-horizontal,3dcurtain-vertical"
                        data-slotamount="default,default,default,default,default,default,default,default,default"
                        data-hideafterloop="0" data-hideslideonmobile="off"
                        data-easein="default,default,default,default,default,default,default,default,default"
                        data-easeout="default,default,default,default,default,default,default,default,default"
                        data-masterspeed="1000,default,default,default,default,default,default,default,default"
                        data-thumb="" data-delay="7000" data-rotate="0,0,0,0,0,0,0,0,0" data-saveperformance="off"
                        data-title="Slide" data-param1="" data-param2="" data-param3="" data-param4="" data-param5=""
                        data-param6="" data-param7="" data-param8="" data-param9="" data-param10="" data-description="">
                        <!-- MAIN IMAGE -->
                        <img
                            src="{{ URL::asset($resourcePathServer.'frontend/ assets/img/revimages/transparent.png' )}}"
                            data-bgcolor='#eeeeee'
                            style='background:#eeeeee' alt="" data-bgposition="center center" data-bgfit="cover"
                            data-bgrepeat="no-repeat" class="rev-slidebg" data-no-retina>
                        <!-- LAYERS -->

                        <!-- LAYER NR. 13 -->
                        <div class="tp-caption   tp-resizeme" id="slide-67-layer-1"
                             data-x="['center','center','center','center']" data-hoffset="['0','0','-163','103']"
                             data-y="['top','top','top','top']" data-voffset="['59','33','124','-5']"
                             data-width="['none','none','503','804']" data-height="none" data-whitespace="nowrap"
                             data-type="text" data-responsive_offset="on"
                             data-frames='[{"delay":520,"speed":2340,"frame":"0","from":"z:0;rX:0;rY:0;rZ:0;sX:0.9;sY:0.9;skX:0;skY:0;opacity:0;","to":"o:1;","ease":"Power2.easeOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Back.easeIn"}]'
                             data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
                             data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
                             style="z-index: 5; white-space: nowrap; font-size: 20px; line-height: 22px; font-weight: 400; color: #ffffff; letter-spacing: 0px;font-family:Open Sans;">
                            <img
                                src="{{ URL::asset($resourcePathServer.'frontend/assets/img/revimages/homepage06-slide3-obj1.png ' )}}"
                                alt=""></div>

                        <!-- LAYER NR. 14 -->
                        <div class="tp-caption   tp-resizeme" id="slide-67-layer-2"
                             data-x="['center','center','center','center']" data-hoffset="['4','0','0','0']"
                             data-y="['top','top','top','top']" data-voffset="['560','544','629','495']"
                             data-width="none" data-height="none" data-whitespace="nowrap" data-type="text"
                             data-responsive_offset="on"
                             data-frames='[{"delay":520,"speed":1390,"sfxcolor":"#eeeeee","sfx_effect":"blockfromleft","frame":"0","from":"z:0;","to":"o:1;","ease":"Power4.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power4.easeInOut"}]'
                             data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
                             data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
                             style="z-index: 6; white-space: nowrap; font-size: 18px; line-height: 24px; font-weight: 700; color: #f8b200; letter-spacing: 2px;font-family:Source Sans Pro;">
                            WINTER COLLECTION
                        </div>

                        <!-- LAYER NR. 15 -->
                        <div class="tp-caption   tp-resizeme" id="slide-67-layer-3"
                             data-x="['center','center','center','center']" data-hoffset="['0','0','0','5']"
                             data-y="['top','top','top','top']" data-voffset="['583','581','682','528']"
                             data-fontsize="['48','48','48','35']" data-lineheight="['77','77','77','50']"
                             data-width="none" data-height="none" data-whitespace="nowrap" data-type="text"
                             data-responsive_offset="on"
                             data-frames='[{"delay":520,"speed":1410,"sfxcolor":"#eeeeee","sfx_effect":"blockfromright","frame":"0","from":"z:0;","to":"o:1;","ease":"Power4.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power4.easeInOut"}]'
                             data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
                             data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
                             style="z-index: 7; white-space: nowrap; font-size: 48px; line-height: 77px; font-weight: 600; color: #000000; letter-spacing: 0px;font-family:Source Sans Pro;">
                            Comfortable & Modern
                        </div>

                        <!-- LAYER NR. 16 -->
                        <a class="tp-caption Robin-Button-Hover-2 rev-btn " href="shop-left-sidebar.html" target="_self"
                           id="slide-67-layer-4" data-x="['center','center','center','center']"
                           data-hoffset="['0','0','0','-1']" data-y="['top','top','top','top']"
                           data-voffset="['683','682','801','599']" data-width="none" data-height="none"
                           data-whitespace="nowrap" data-type="button" data-actions='' data-responsive_offset="on"
                           data-responsive="off"
                           data-frames='[{"delay":950,"speed":980,"frame":"0","from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","mask":"x:0px;y:[100%];s:inherit;e:inherit;","to":"o:1;","ease":"Power2.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"nothing"},{"frame":"hover","speed":"400","ease":"Power4.easeInOut","to":"o:1;rX:0;rY:0;rZ:0;z:0;","style":"c:rgb(248,178,0);bg:rgba(34,34,34,0);bc:rgb(248,178,0);"}]'
                           data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[12,12,12,12]"
                           data-paddingright="[25,25,25,25]" data-paddingbottom="[12,12,12,12]"
                           data-paddingleft="[25,25,25,25]"
                           style="z-index: 8; white-space: nowrap; font-size: 16px; line-height: 21px; font-weight: 700; color: rgba(255,255,255,1); font-family:Source Sans Pro;background-color:rgba(247,177,19,0.75);border-color:rgba(248,178,0,0);border-style:solid;border-width:2px 2px 2px 2px;border-radius:5px 5px 5px 5px;outline:none;box-shadow:none;box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;cursor:pointer;text-decoration: none;">SHOP
                            NOW!
                        </a>

                        <!-- LAYER NR. 17 -->
                        <div class="tp-caption   tp-resizeme" id="slide-67-layer-5"
                             data-x="['left','left','left','left']" data-hoffset="['1093','900','522','-342']"
                             data-y="['top','top','top','top']" data-voffset="['98','80','180','70']" data-width="none"
                             data-height="none" data-whitespace="nowrap" data-type="text" data-responsive_offset="on"
                             data-frames='[{"delay":1920,"speed":900,"frame":"0","from":"x:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'
                             data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
                             data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
                             style="z-index: 9; white-space: nowrap; font-size: 20px; line-height: 22px; font-weight: 400; color: #ffffff; letter-spacing: 0px;font-family:Open Sans;">
                            <img
                                src="{{ URL::asset($resourcePathServer.'frontend/assets/img/revimages/homepage06-slide3-obj2.png ' )}}"
                                alt=""></div>

                        <!-- LAYER NR. 18 -->
                        <a class="tp-caption   tp-resizeme" href="shop-left-sidebar.html" target="_self"
                           id="slide-67-layer-7" data-x="['left','left','left','left']"
                           data-hoffset="['1169','977','600','-272']" data-y="['top','top','top','top']"
                           data-voffset="['423','410','504','401']" data-width="none" data-height="none"
                           data-whitespace="nowrap" data-type="text" data-actions='' data-responsive_offset="on"
                           data-frames='[{"delay":1930,"speed":2000,"frame":"0","from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","to":"o:1;","ease":"Power4.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power2.easeInOut"},{"frame":"hover","speed":"500","ease":"Power3.easeOut","to":"o:1;rX:0;rY:0;rZ:0;z:0;","style":"c:rgb(0,0,0);br:0px 0px 0px 0px;"}]'
                           data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
                           data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
                           style="z-index: 10; white-space: nowrap; font-size: 16px; line-height: 21px; font-weight: 700; color: #f8b200; letter-spacing: 0px;font-family:Source Sans Pro;cursor:pointer;text-decoration: none;">READ
                            MORE </a>
                    </li>
            @elseif($typeSliderManager=='index-5')
                <!-- SLIDE  -->
                    <li data-index="rs-59"
                        data-transition="slideoverdown,slidingoverlayvertical,cube-horizontal,3dcurtain-vertical"
                        data-slotamount="default,default,default,default" data-hideafterloop="0"
                        data-hideslideonmobile="off"
                        data-easein="default,default,default,default" data-easeout="default,default,default,default"
                        data-masterspeed="1010,default,default,default" data-thumb="" data-delay="7010"
                        data-rotate="0,0,0,0"
                        data-saveperformance="off" data-title="Slide" data-param1="" data-param2="" data-param3=""
                        data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9=""
                        data-param10="" data-description="">
                        <!-- MAIN IMAGE -->
                        <img
                            src="{{ URL::asset($resourcePathServer.'frontend/assets/img/revimages/homepage04-slide1.jpg')}}"
                            alt=""
                            width="1920"
                            height="1080"
                            data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat"
                            class="rev-slidebg"
                            data-no-retina>
                        <!-- LAYERS -->

                        <!-- LAYER NR. 1 -->
                        <div class="tp-caption   tp-resizeme" id="slide-59-layer-3"
                             data-x="['center','center','center','center']" data-hoffset="['0','3','5','0']"
                             data-y="['top','top','top','top']" data-voffset="['230','260','339','228']" data-width="none"
                             data-height="none" data-whitespace="nowrap" data-type="text" data-responsive_offset="on"
                             data-frames='[{"delay":610,"speed":1500,"frame":"0","from":"x:[-175%];y:0px;z:0;rX:0;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:1;","mask":"x:[100%];y:0;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'
                             data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
                             data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
                             style="z-index: 5; white-space: nowrap; font-size: 22px; line-height: 35px; font-weight: 700; color: rgba(0,0,0,0.4); letter-spacing: 1px;font-family:Source Sans Pro;">
                            BLACK AND WHITE
                        </div>

                        <!-- LAYER NR. 2 -->
                        <div class="tp-caption   tp-resizeme" id="slide-59-layer-5"
                             data-x="['center','center','center','center']" data-hoffset="['1','1','10','-3']"
                             data-y="['top','middle','middle','middle']" data-voffset="['279','0','-22','-25']"
                             data-fontsize="['90','90','90','60']" data-lineheight="['110','100','100','70']"
                             data-width="none"
                             data-height="none" data-whitespace="nowrap" data-type="text" data-responsive_offset="on"
                             data-frames='[{"delay":610,"split":"chars","splitdelay":0.05,"speed":1850,"split_direction":"forward","frame":"0","from":"y:[-100%];z:0;rZ:35deg;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power4.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power2.easeInOut"}]'
                             data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
                             data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
                             style="z-index: 6; white-space: nowrap; font-size: 90px; line-height: 110px; font-weight: 600; color: #000000; letter-spacing: -2px;font-family:Source Sans Pro;">
                            Trendy & Modern
                        </div>

                        <!-- LAYER NR. 3 -->
                        <a class="tp-caption Robin-Button-New rev-btn " href="shop-left-sidebar.html" target="_self"
                           id="slide-59-layer-7" data-x="['center','center','center','center']"
                           data-hoffset="['0','0','4','0']"
                           data-y="['top','middle','top','top']" data-voffset="['425','143','548','407']" data-width="none"
                           data-height="none" data-whitespace="nowrap" data-type="button" data-actions=''
                           data-responsive_offset="on" data-responsive="off"
                           data-frames='[{"delay":1650,"speed":1040,"frame":"0","from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","to":"o:1;","ease":"Power4.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"nothing"},{"frame":"hover","speed":"300","ease":"Power0.easeInOut","to":"o:1;rX:0;rY:0;rZ:0;z:0;","style":"c:rgb(255,255,255);bg:rgb(34,34,34);bc:rgb(0,0,0);"}]'
                           data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[12,12,12,12]"
                           data-paddingright="[25,25,25,25]" data-paddingbottom="[12,12,12,12]"
                           data-paddingleft="[25,25,25,25]"
                           style="z-index: 7; white-space: nowrap; font-size: 16px; line-height: 21px; font-weight: 700; color: #000000; font-family:Source Sans Pro;background-color:rgba(247,177,19,0);border-color:rgba(0,0,0,1);border-style:solid;border-width:2px 2px 2px 2px;border-radius:5px 5px 5px 5px;outline:none;box-shadow:none;box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;cursor:pointer;text-decoration: none;">SHOP
                            NOW!
                        </a>
                    </li>
                    <!-- SLIDE  -->
                    <li data-index="rs-60"
                        data-transition="parallaxtoright,parallaxtoleft,parallaxtotop,parallaxtobottom,parallaxhorizontal,slidingoverlaydown,slidingoverlayleft,slidingoverlayright,slidingoverlayhorizontal"
                        data-slotamount="default,default,default,default,default,default,default,default,default"
                        data-hideafterloop="0" data-hideslideonmobile="off"
                        data-easein="default,default,default,default,default,default,default,default,default"
                        data-easeout="default,default,default,default,default,default,default,default,default"
                        data-masterspeed="1000,default,default,default,default,default,default,default,default"
                        data-thumb=""
                        data-delay="7000" data-rotate="0,0,0,0,0,0,0,0,0" data-saveperformance="off" data-title="Slide"
                        data-param1="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6=""
                        data-param7=""
                        data-param8="" data-param9="" data-param10="" data-description="">
                        <!-- MAIN IMAGE -->
                        <img src="{{ URL::asset($resourcePathServer.'frontend/assets/img/revimages/homepage04-slide2.jpg')}}
                            " alt="" width="1920" height="1080"
                             data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat"
                             class="rev-slidebg"
                             data-no-retina>
                        <!-- LAYERS -->

                        <!-- LAYER NR. 4 -->
                        <div class="tp-caption   tp-resizeme" id="slide-60-layer-9"
                             data-x="['center','center','center','center']" data-hoffset="['0','0','0','1']"
                             data-y="['top','top','top','top']" data-voffset="['231','239','373','230']"
                             data-color="['rgba(0,0,0,0.4)','rgba(0,0,0,0.4)','rgba(17,17,17,0.4)','rgba(17,17,17,0.4)']"
                             data-width="none" data-height="none" data-whitespace="nowrap" data-type="text"
                             data-responsive_offset="on"
                             data-frames='[{"delay":720,"speed":1960,"frame":"0","from":"z:0;rX:0;rY:0;rZ:0;sX:0.8;sY:0.8;skX:0;skY:0;opacity:0;","to":"o:1;","ease":"Power4.easeOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"nothing"}]'
                             data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
                             data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
                             style="z-index: 5; white-space: nowrap; font-size: 22px; line-height: 22px; font-weight: 700; color: rgba(0,0,0,0.4); letter-spacing: 0px;font-family:Source Sans Pro;">
                            ROBIN LIVING ROOM
                        </div>

                        <!-- LAYER NR. 5 -->
                        <div class="tp-caption   tp-resizeme" id="slide-60-layer-5"
                             data-x="['center','center','center','center']" data-hoffset="['-3','4','12','6']"
                             data-y="['top','top','top','top']" data-voffset="['277','299','413','277']"
                             data-fontsize="['90','90','90','60']" data-lineheight="['120','120','120','80']"
                             data-fontweight="['600','600','600','700']" data-width="['671','none','659','430']"
                             data-height="['122','none','122','81']" data-whitespace="nowrap" data-type="text"
                             data-responsive_offset="on"
                             data-frames='[{"delay":510,"speed":1940,"frame":"0","from":"z:0;rX:0deg;rY:0;rZ:0;sX:2;sY:2;skX:0;skY:0;opacity:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power2.easeOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Back.easeIn"}]'
                             data-textAlign="['center','inherit','center','center']" data-paddingtop="[0,0,0,0]"
                             data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
                             style="z-index: 6; min-width: 671px; max-width: 671px; max-width: 122px; max-width: 122px; white-space: nowrap; font-size: 90px; line-height: 120px; font-weight: 600; color: #000000; letter-spacing: -2px;font-family:Source Sans Pro;">
                            Timeless Styling
                        </div>

                        <!-- LAYER NR. 6 -->
                        <a class="tp-caption Robin-Button-New rev-btn " href="shop-left-sidebar.html" target="_self"
                           id="slide-60-layer-7" data-x="['center','center','center','center']"
                           data-hoffset="['0','0','0','0']"
                           data-y="['top','middle','top','top']" data-voffset="['438','97','552','394']" data-width="none"
                           data-height="none" data-whitespace="nowrap" data-type="button" data-actions=''
                           data-responsive_offset="on" data-responsive="off"
                           data-frames='[{"delay":770,"speed":1060,"frame":"0","from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","to":"o:1;","ease":"Power4.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power2.easeInOut"},{"frame":"hover","speed":"400","ease":"Power4.easeInOut","to":"o:1;rX:0;rY:0;rZ:0;z:0;","style":"c:rgb(255,255,255);bg:rgb(34,34,34);bc:rgb(0,0,0);"}]'
                           data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[12,12,12,12]"
                           data-paddingright="[25,25,25,25]" data-paddingbottom="[12,12,12,12]"
                           data-paddingleft="[25,25,25,25]"
                           style="z-index: 7; white-space: nowrap; font-size: 16px; line-height: 21px; font-weight: 700; color: #000000; font-family:Source Sans Pro;background-color:rgba(247,177,19,0);border-color:rgba(0,0,0,1);border-style:solid;border-width:2px 2px 2px 2px;border-radius:5px 5px 5px 5px;outline:none;box-shadow:none;box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;cursor:pointer;text-decoration: none;">SHOP
                            NOW!
                        </a>
                    </li>
                    <!-- SLIDE  -->
                    <li data-index="rs-61"
                        data-transition="slidingoverlayhorizontal,fadetoleftfadefromright,fadetotopfadefrombottom,fadetorightfadefromleft,fadetobottomfadefromtop,curtain-2,curtain-1,curtain-3"
                        data-slotamount="default,default,default,default,default,default,default,default"
                        data-hideafterloop="0"
                        data-hideslideonmobile="off"
                        data-easein="default,default,default,default,default,default,default,default"
                        data-easeout="default,default,default,default,default,default,default,default"
                        data-masterspeed="1000,default,default,default,default,default,default,default" data-thumb=""
                        data-delay="6990" data-rotate="0,0,0,0,0,0,0,0" data-saveperformance="off" data-title="Slide"
                        data-param1="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6=""
                        data-param7=""
                        data-param8="" data-param9="" data-param10="" data-description="">
                        <!-- MAIN IMAGE -->
                        <img
                            src="{{ URL::asset($resourcePathServer.'frontend/assets/img/revimages/homepage04-slide3.jpg')}}"
                            alt=""
                            width="1920"
                            height="1080"
                            data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat"
                            class="rev-slidebg"
                            data-no-retina>
                        <!-- LAYERS -->

                        <!-- LAYER NR. 7 -->
                        <div class="tp-caption   tp-resizeme" id="slide-61-layer-9"
                             data-x="['left','center','center','left']"
                             data-hoffset="['198','-393','-253','31']" data-y="['top','top','top','top']"
                             data-voffset="['276','260','416','268']" data-width="none" data-height="none"
                             data-whitespace="nowrap" data-type="text" data-responsive_offset="on"
                             data-frames='[{"delay":1000,"speed":2000,"frame":"0","from":"y:-50px;opacity:0;","to":"o:1;","ease":"Power4.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power2.easeInOut"}]'
                             data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
                             data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
                             style="z-index: 5; white-space: nowrap; font-size: 22px; line-height: 22px; font-weight: 700; color: rgba(17,17,17,0.4); letter-spacing: 0px;font-family:Source Sans Pro;">
                            ROBIN SOFA
                        </div>

                        <!-- LAYER NR. 8 -->
                        <div class="tp-caption   tp-resizeme" id="slide-61-layer-5"
                             data-x="['left','center','center','left']"
                             data-hoffset="['195','-181','-81','30']" data-y="['top','top','top','top']"
                             data-voffset="['329','314','470','316']" data-fontsize="['90','90','80','50']"
                             data-lineheight="['110','110','95','60']" data-width="['none','none','none','314']"
                             data-height="['none','none','none','61']" data-whitespace="nowrap" data-type="text"
                             data-responsive_offset="on"
                             data-frames='[{"delay":480,"split":"chars","splitdelay":0.05,"speed":2700,"split_direction":"forward","frame":"0","from":"x:[105%];z:0;rX:45deg;rY:0deg;rZ:90deg;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power4.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'
                             data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
                             data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
                             style="z-index: 6; white-space: nowrap; font-size: 90px; line-height: 110px; font-weight: 600; color: #000000; letter-spacing: -2px;font-family:Source Sans Pro;">
                            Greening Style
                        </div>

                        <!-- LAYER NR. 9 -->
                        <a class="tp-caption Robin-Button-New rev-btn custom-position custom-position--one"
                           href="shop-left-sidebar.html" target="_self" id="slide-61-layer-7"
                           data-x="['left','center','center','left']" data-hoffset="['192','-385','-245','32']"
                           data-y="['top','middle','top','top']" data-voffset="['476','95','604','408']" data-width="none"
                           data-height="none" data-whitespace="nowrap" data-type="button" data-actions=''
                           data-responsive_offset="on" data-responsive="off"
                           data-frames='[{"delay":1530,"speed":960,"frame":"0","from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","to":"o:1;","ease":"Power4.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"nothing"},{"frame":"hover","speed":"300","ease":"Linear.easeNone","to":"o:1;rX:0;rY:0;rZ:0;z:0;","style":"c:rgb(255,255,255);bg:rgb(34,34,34);bc:rgb(0,0,0);"}]'
                           data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[12,12,12,12]"
                           data-paddingright="[25,25,25,25]" data-paddingbottom="[12,12,12,12]"
                           data-paddingleft="[25,25,25,25]"
                           style="z-index: 7; white-space: nowrap; font-size: 16px; line-height: 21px; font-weight: 700; color: #000000; font-family:Source Sans Pro;background-color:rgba(247,177,19,0);border-color:rgba(0,0,0,1);border-style:solid;border-width:2px 2px 2px 2px;border-radius:5px 5px 5px 5px;outline:none;box-shadow:none;box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;cursor:pointer;text-decoration: none;">SHOP
                            NOW!
                        </a>
                    </li>
            @endif

            @else
                {{$dataSliderHtml}}
            @endif
        </ul>
        <div class="tp-bannertimer tp-bottom" style="visibility: hidden !important;"></div>
    </div>
</div>

<!--====================  End of hero slider area  ====================-->
