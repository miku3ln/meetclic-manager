

<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>

<!--====================  hero slider area ====================-->

<div class="hero-slider-area section-space">
    <!-- START REVOLUTION SLIDER 5.4.7 fullscreen mode -->
    <div id="rev_slider_25_1" class="rev_slider fullscreenbanner" style="display:none;" data-version="5.4.7">
        <ul>
        @if($dataSliderHtml=='')

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
                    <img src="{{ URL::asset($resourcePathServer.'frontend/assets/img/revimages/homepage04-slide1.jpg')}}" alt=""
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
                    <img src="{{ URL::asset($resourcePathServer.'frontend/assets/img/revimages/homepage04-slide3.jpg')}}" alt=""
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
            @else
                {{$dataSliderHtml}}

            @endif
        </ul>
        <div class="tp-bannertimer tp-bottom" style="visibility: hidden !important;"></div>
    </div>
</div>

<!--====================  End of hero slider area  ====================-->
