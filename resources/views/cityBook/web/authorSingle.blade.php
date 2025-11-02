@extends('layouts.cityBook')
<?php
//CMS-TEMPLATE-AUTHOR-SINGLE-ALL
$urlRoute = route('businessDetails', app()->getLocale());
$allowContact = false;
if (count($dataManagerPage['authorSingleData']['data']['InformationSocialNetwork']) > 0) {
    $allowContact = true;
}
if ($dataManagerPage['authorSingleData']['data']['InformationAddress']!=null){
    $allowContact = true;
}

?>
@section('additional-styles')
    <style>
        .color-bg--profile {
            background: #FACC39 !important;
        }

        .breadcrumbs--profile {
            font-size: 15px;
        }

        .card-popup-rainingvis i {
            font-size: 19px;
            color: #fff !important;
        }

        .listing-rating--profile i {

            color: #FACC39 !important;
        }

        .section-title__title {
            color: #445EF2 !important;
            font-weight: 600 !important;
        }

        .header-sec-link--profile {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            z-index: 20;
        }

        .header-sec-link--profile a {
            background: #445EF2;
            color: #fff;
            box-shadow: 0px 0px 0px 4px rgba(255, 255, 255, 0.2);
            display: inline-table;
            padding: 6px 40px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
            font-weight: 700;
            color: #fff;
            text-transform: uppercase;
            font-size: 12px;
            box-shadow: 0px 0px 0px 4px rgba(255, 255, 255, 0.2);

        }

        .header-sec-link--profile a:hover {
            background: #FACC39;
            color: #fff;

        }


        .btn.transparent-btn {
            border-color: #FACC39;
            background: #FACC39;
            color: #fff;

        }

        .btn.transparent-btn:hover {
            border-color: #445EF2;
            background: #445EF2;
            color: #fff !important;

        }

        .custom-form--profile {
            float: left;
            width: 100%;
            position: relative;
        }

        .custom-form--profile label i {
            color: #445EF2 !important;
        }

        .custom-form--profile textarea, .custom-form--profile input[type="text"], .custom-form--profile input[type=email], .custom-form--profile input[type=password], .custom-form--profile input[type=button] {
            float: left;
            border: 1px solid #eee;
            background: #f9f9f9;
            width: 100%;
            padding: 15px 20px 15px 55px;
            border-radius: 6px;
            color: #666;
            font-size: 13px;
            -webkit-appearance: none;
        }

        .custom-form--profile input {
            margin-bottom: 20px;
        }

        .custom-form--profile textarea, .custom-form--profile input[type="text"], .custom-form--profile input[type=email], .custom-form--profile input[type=password], .custom-form--profile input[type=button] {
            border: 1px solid #eee;
            background: #f9f9f9;
            color: #666;
        }

        .custom-form--profile label i {
            padding-right: 12px;
            font-size: 14px;
            position: absolute;
            top: 16px;
            left: 20px;
        }

        .custom-form--profile label {
            color: #666;
        }

        .custom-form--profile label {
            float: left;
            position: relative;
            width: 100%;
            text-align: left;
            font-weight: 500;
            color: #666;
        }

        .custom-form--profile textarea {
            height: 200px;
            resize: none;
            padding: 25px 20px;
            -webkit-appearance: none;
        }

        .custom-form--profile button {
            float: left;
            outline: none;
            border: none;
            cursor: pointer;
            margin-top: 30px;
            background: none;
            -webkit-appearance: none;
        }

        .custom-form--profile button {
            background: #FACC39 !important;
            color: #fff !important;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet"/>

@endsection
@section('additional-scripts')
    <script type="text/javascript" src="{{URL::asset($resourcePathServer.'plugins/instagram/instagram.js')}}"></script>

    <script>
        $(function () {

            $('.show-search-button').show();
        })
    </script>
    <script type="text/javascript" src="{{URL::asset($resourcePathServer.'libs/vue/pagination/index.js')}}"></script>
    <script>
        var $paramsRequest = <?php echo json_encode($paramsRequest) ?>;
        var $dataManagerPage =<?php echo json_encode($dataManagerPage) ?>;
    </script>
    <script>
        function ratingInit(elementSelector) {
            var cr2 = $(elementSelector);
            cr2.each(function (cr) {
                var starcount2 = $(this).attr("data-starrating2");
                $("<i class='fa fa-star'></i>").duplicate(starcount2).prependTo(this);
            });
        }

        ratingInit('.listing-rating--profile');
        Vue.component('paginate', VuejsPaginate);
        var $currentApp;
        const app = new Vue(
            {
                directives: {
                    'init-listing-items': {
                        inserted: function (el, binding, vnode, vm, arg) {
                            var paramsInput = binding.value;
                            var initMethod = paramsInput['initMethod'];
                            initMethod({
                                elementInit: el,
                                params: paramsInput
                            });
                        }
                    },


                },
                el: '#app-management',
                created: function () {
                    $currentApp = this;
                    var $scope = this;
                    var dataManagerUser = $dataManagerPage.authorSingleData['information'];
                    console.log(dataManagerUser);
                    this.informationShare = dataManagerUser;
                    $(function () {
                        $scope.initManagement();
                    });
                },
                data: function () {
                    return {
                        managerLoading: {
                            map: {
                                view: true
                            },
                            data: {
                                view: true
                            },
                            page: {
                                view: true
                            }
                        },
                        businessData: [],
                        configGridAdmin: {
                            html: '',
                            isEmpty: false,
                            msj: {
                                empty: '<h1>No existe Datos</h1>',
                            }
                        },
                        configPagination: {
                            items: [],
                            itemActive: 0,
                            totalData: 0,
                            rowCountPerPage: 0,
                            currentPage: 0,
                            html: '',
                            view: {
                                init: 0,
                                to: 0,

                            }
                        },
                        model: {
                            attributes: {
                                'keywords': null,
                                'address-google': null,
                                'country': null,
                                'category': null,
                                'distance': 0,
                                'check': false,
                                currentPage: 0
                            }
                        },
                        networkShares: [{
                            type: 0,
                            icon: 'share-icon share-icon-facebook',
                            allow: true
                        },
                            {
                                type: 1,
                                icon: 'share-icon share-icon-twitter',
                                allow: false
                            },
                            {
                                type: 2,
                                icon: 'share-icon share-icon-googleplus',
                                allow: false
                            },
                            {
                                type: 3,
                                icon: 'share-icon fa fa-whatsapp',
                                allow: true
                            },
                        ],
                        currentPage: $dataManagerPage.currentPage,
                        'informationShare': {},
                    };
                },
                methods: {

                    ...$shareManager,
                    onListenElementsForm: onListenElementsForm,
                    initManagement: function () {
                        initApisSocialNetworks();
                    },
                    _element: function (e) {
                        console.log(e);
                    },


                }
            })
        ;

    </script>

@endsection

@section('content')
    <div id="app-management">
        @if($dataManagerPage['authorSingleData']['success']==false)
            <div class="empty" style="height: 715px;">
                No existe autor!
            </div>
        @else

            <section class="parallax-section small-par color-bg color-bg--profile list-single-section">
                <div class="shapes-bg-big"></div>


                <div class="container">
                    <div class="section-title center-align">
                        <div class="section-title center-align">
                            <div class="breadcrumbs fl-wrap breadcrumbs--profile">
                                <a href="{{route('homePage',app()->getLocale())}}">{{__('frontend.menu.home')}}</a>
                                <span>{{__('labels.twelve')}}</span></div>
                            <h2 class="section-title__title">
                                <span>{{__('labels.thirteen')}} :{{$dataManagerPage['authorSingleData']['successProfile']==false?$dataManagerPage['authorSingleData']['data']['user']['name']:($dataManagerPage['authorSingleData']['data']['Profile']->first_name.' '.$dataManagerPage['authorSingleData']['data']['Profile']->last_name)}}</span>
                            </h2>
                            <div class="user-profile-avatar"><img
                                        src="{{ URL::asset($dataManagerPage['authorSingleData']['data']['user']['urlAvatar'])}}"
                                        alt=""></div>
                            <div class="user-profile-rating clearfix">
                                <div class="listing-rating card-popup-rainingvis" data-starrating2="5">
                                    <span class="not-view">(37 {{__('frontend.account.menu.reviews')}} )</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" header-sec-link--profile">

                        <div class="container"><a href="#sec1" class="custom-scroll-link">{{__('labels.fourteen')}} </a>
                        </div>
                    </div>

                </div>
                <div class="list-single-header absolute-header fl-wrap">
                    <div class="container container--manager-information">
                        <div class="list-single-header-item">
                            <div class="row">
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-8">
                                    @include('cityBook.web.partials.share-data',[])
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
            <!-- section end -->
            <!--section -->
            <section class="gray-bg" id="sec1">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            @if($dataManagerPage['authorSingleData']['successProfile'])

                                @if($dataManagerPage['authorSingleData']['data']['UsersByAboutUs']!=null)
                                    <div class="list-single-main-item fl-wrap">
                                        <div class="list-single-main-item-title fl-wrap">
                                            <h3>{{__('labels.fifteen')}}
                                                <span> {{$dataManagerPage['authorSingleData']['successProfile']==false?$dataManagerPage['authorSingleData']['data']['user']['name']:($dataManagerPage['authorSingleData']['data']['Profile']->first_name.' '.$dataManagerPage['authorSingleData']['data']['Profile']->last_name)}}</span>
                                            </h3>
                                        </div>
                                        <div class="list-single-main-item__about-us">
                                            {{
        $dataManagerPage['authorSingleData']['data']['UsersByAboutUs']->description
    }}
                                        </div>
                                        @if($dataManagerPage['authorSingleData']['data']['UsersByAboutUs']->web !='null')
                                            <a href="{{$dataManagerPage['authorSingleData']['data']['UsersByAboutUs']->web}}"
                                               class="btn transparent-btn float-btn">{{__('labels.sixteen')}} <i
                                                        class="fa fa-angle-right"></i></a>
                                        @endif


                                    </div>
                                @endif
                            @endif
                            @if(env('allowProcessAuthorListing'))
                                <div class="listsearch-header fl-wrap">
                                    <h3>{{__('labels.seventeen')}}{{' '}}{{$dataManagerPage['authorSingleData']['successProfile']==false?$dataManagerPage['authorSingleData']['data']['user']['name']:($dataManagerPage['authorSingleData']['data']['Profile']->first_name.' '.$dataManagerPage['authorSingleData']['data']['Profile']->last_name)}}</h3>
                                    <div class="listing-view-layout">
                                        <ul>
                                            <li><a class="grid active" href="#"><i class="fa fa-th-large"></i></a></li>
                                            <li><a class="list" href="#"><i class="fa fa-list-ul"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- list-main-wrap-->

                                <div class="list-main-wrap fl-wrap card-listing ">
                                    <!-- listing-item -->
                                    <div class="listing-item">
                                        <article class="geodir-category-listing fl-wrap">
                                            <div class="geodir-category-img">
                                                <img src="{{ URL::asset($themePath.'images/all/8.jpg')}}" alt="">
                                                <div class="overlay"></div>
                                                <div class="list-post-counter"><span>4</span><i class="fa fa-heart"></i>
                                                </div>
                                            </div>
                                            <div class="geodir-category-content fl-wrap">
                                                <a class="listing-geodir-category" href="listing.html">Restourants</a>
                                                <div class="listing-avatar"><a href="author-single.html"><img
                                                                src="{{ URL::asset($themePath.'images/avatar/5.jpg')}}"
                                                                alt=""></a>
                                                    <span
                                                            class="avatar-tooltip">Added By  <strong>Lisa Smith</strong></span>
                                                </div>
                                                <h3><a href="{{$urlCurrent=$urlRoute.'/'.(1)}}">Luxury Restourant</a>
                                                </h3>
                                                <p>Sed interdum metus at nisi tempor laoreet. Integer gravida orci a
                                                    justo
                                                    sodales, sed lobortis est placerat.</p>
                                                <div class="geodir-category-options fl-wrap">
                                                    <div
                                                            class="listing-rating listing-rating--profile"
                                                            data-starrating2="5">
                                                        <span>(7 reviews)</span>
                                                    </div>
                                                    <div class="geodir-category-location"><a href="#"><i
                                                                    class="fa fa-map-marker" aria-hidden="true"></i>
                                                            27th
                                                            Brooklyn
                                                            New York, NY 10065</a></div>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                    <!-- listing-item end-->
                                    <!-- listing-item -->
                                    <div class="listing-item">
                                        <article class="geodir-category-listing fl-wrap">
                                            <div class="geodir-category-img">
                                                <img src="{{ URL::asset($themePath.'images/all/1.jpg')}}" alt="">
                                                <div class="overlay"></div>
                                                <div class="list-post-counter"><span>15</span><i
                                                            class="fa fa-heart"></i>
                                                </div>
                                            </div>
                                            <div class="geodir-category-content fl-wrap">
                                                <a class="listing-geodir-category" href="listing.html">Event</a>
                                                <div class="listing-avatar"><a href="author-single.html"><img
                                                                src="{{ URL::asset($themePath.'images/avatar/2.jpg')}}"
                                                                alt=""></a>
                                                    <span
                                                            class="avatar-tooltip">Added By  <strong>Mark Rose</strong></span>
                                                </div>
                                                <h3><a href="{{$urlCurrent=$urlRoute.'/'.(2)}}">Event In City Mol</a>
                                                </h3>
                                                <p>Morbi suscipit erat in diam bibendum rucard-popup-rainingvistrum in
                                                    nisl.
                                                    Aliquam et purus
                                                    ante.</p>
                                                <div class="geodir-category-options fl-wrap">
                                                    <div
                                                            class="listing-rating  listing-rating--profile"
                                                            data-starrating2="4">
                                                        <span>(17 reviews)</span>
                                                    </div>
                                                    <div class="geodir-category-location"><a href="#"><i
                                                                    class="fa fa-map-marker" aria-hidden="true"></i>
                                                            27th
                                                            Brooklyn
                                                            New York, NY 10065</a></div>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                    <!-- listing-item end-->
                                    <div class="clearfix"></div>
                                    <!-- listing-item -->
                                    <div class="listing-item">
                                        <article class="geodir-category-listing fl-wrap">
                                            <div class="geodir-category-img">
                                                <img src="{{ URL::asset($themePath.'images/all/4.jpg')}}" alt="">
                                                <div class="overlay"></div>
                                                <div class="list-post-counter"><span>553</span><i
                                                            class="fa fa-heart"></i>
                                                </div>
                                            </div>
                                            <div class="geodir-category-content fl-wrap">
                                                <a class="listing-geodir-category" href="listing.html">Restourants</a>
                                                <div class="listing-avatar"><a href="author-single.html"><img
                                                                src="{{ URL::asset($themePath.'images/avatar/3.jpg')}}"
                                                                alt=""></a>
                                                    <span
                                                            class="avatar-tooltip">Added By  <strong>Adam Koncy</strong></span>
                                                </div>
                                                <h3><a href="{{$urlCurrent=$urlRoute.'/'.(3)}}">Luxury Restourant</a>
                                                </h3>
                                                <p>Sed non neque elit. Sed ut imperdie.</p>
                                                <div class="geodir-category-options fl-wrap">
                                                    <div class="listing-rating listing-rating--profile"
                                                         data-starrating2="5">
                                                        <span>(7 reviews)</span>
                                                    </div>
                                                    <div class="geodir-category-location"><a href="#"><i
                                                                    class="fa fa-map-marker" aria-hidden="true"></i>
                                                            27th
                                                            Brooklyn
                                                            New York, NY 10065</a></div>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                    <!-- listing-item end-->
                                    <!-- listing-item -->
                                    <div class="listing-item">
                                        <article class="geodir-category-listing fl-wrap">
                                            <div class="geodir-category-img">
                                                <img src="{{ URL::asset($themePath.'images/all/20.jpg')}}" alt="">
                                                <div class="overlay"></div>
                                                <div class="list-post-counter"><span>47</span><i
                                                            class="fa fa-heart"></i>
                                                </div>
                                            </div>
                                            <div class="geodir-category-content fl-wrap">
                                                <a class="listing-geodir-category" href="listing.html">Fitness</a>
                                                <div class="listing-avatar"><a href="author-single.html"><img
                                                                src="{{ URL::asset($themePath.'images/avatar/4.jpg')}}"
                                                                alt=""></a>
                                                    <span
                                                            class="avatar-tooltip">Added By  <strong>Alisa Noory</strong></span>
                                                </div>
                                                <h3><a href="{{$urlCurrent=$urlRoute.'/'.(1)}}">Gym in the Center</a>
                                                </h3>
                                                <p>Mauris in erat justo. Nullam ac urna eu. </p>
                                                <div class="geodir-category-options fl-wrap">
                                                    <div class="listing-rating listing-rating--profile"
                                                         data-starrating2="5">
                                                        <span>(23 reviews)</span>
                                                    </div>
                                                    <div class="geodir-category-location"><a href="#"><i
                                                                    class="fa fa-map-marker" aria-hidden="true"></i>
                                                            27th
                                                            Brooklyn
                                                            New York, NY 10065</a></div>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                    <!-- listing-item end-->
                                    <div class="clearfix"></div>
                                    <!-- listing-item -->
                                    <div class="listing-item">
                                        <article class="geodir-category-listing fl-wrap">
                                            <div class="geodir-category-img">
                                                <img src="{{ URL::asset($themePath.'images/all/5.jpg')}}" alt="">
                                                <div class="overlay"></div>
                                                <div class="list-post-counter"><span>3</span><i class="fa fa-heart"></i>
                                                </div>
                                            </div>
                                            <div class="geodir-category-content fl-wrap">
                                                <a class="listing-geodir-category" href="listing.html">Shops</a>
                                                <div class="listing-avatar"><a href="author-single.html"><img
                                                                src="{{ URL::asset($themePath.'images/avatar/1.jpg')}}"
                                                                alt=""></a>
                                                    <span
                                                            class="avatar-tooltip">Added By  <strong>Nasty Wood</strong></span>
                                                </div>
                                                <h3><a href="{{$urlCurrent=$urlRoute.'/'.(1)}}">Shop in Boutique
                                                        Zone</a>
                                                </h3>
                                                <p>Morbiaccumsan ipsum velit tincidunt . </p>
                                                <div class="geodir-category-options fl-wrap">
                                                    <div class="listing-rating  listing-rating--profile"
                                                         data-starrating2="4">
                                                        <span>(6 reviews)</span>
                                                    </div>
                                                    <div class="geodir-category-location"><a href="#"><i
                                                                    class="fa fa-map-marker" aria-hidden="true"></i>
                                                            27th
                                                            Brooklyn
                                                            New York, NY 10065</a></div>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                    <!-- listing-item end-->
                                    <!-- listing-item -->
                                    <div class="listing-item">
                                        <article class="geodir-category-listing fl-wrap">
                                            <div class="geodir-category-img">
                                                <img src="{{ URL::asset($themePath.'images/all/23.jpg')}}" alt="">
                                                <div class="overlay"></div>
                                                <div class="list-post-counter"><span>35</span><i
                                                            class="fa fa-heart"></i>
                                                </div>
                                            </div>
                                            <div class="geodir-category-content fl-wrap">
                                                <a class="listing-geodir-category" href="listing.html">Hotels</a>
                                                <div class="listing-avatar"><a href="author-single.html"><img
                                                                src="{{ URL::asset($themePath.'images/avatar/6.jpg')}}"
                                                                alt=""></a>
                                                    <span
                                                            class="avatar-tooltip">Added By  <strong>Kliff Antony</strong></span>
                                                </div>
                                                <h3><a href="{{$urlCurrent=$urlRoute.'/'.(1)}}">Luxary Hotel</a></h3>
                                                <p>Lorem ipsum gravida nibh vel velit.</p>
                                                <div class="geodir-category-options fl-wrap">
                                                    <div class="listing-rating listing-rating--profile"
                                                         data-starrating2="5">
                                                        <span>(11 reviews)</span>
                                                    </div>
                                                    <div class="geodir-category-location"><a href="#"><i
                                                                    class="fa fa-map-marker" aria-hidden="true"></i>
                                                            27th
                                                            Brooklyn
                                                            New York, NY 10065</a></div>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                    <!-- listing-item end-->
                                    <!-- pagination-->
                                    <div class="pagination">
                                        <a href="#" class="prevposts-link"><i class="fa fa-caret-left"></i></a>
                                        <a href="#" class="current-page">1</a>
                                        <a href="#">2</a>
                                        <a href="#">3</a>
                                        <a href="#" class="nextposts-link"><i class="fa fa-caret-right"></i></a>
                                    </div>
                                </div>
                            @endif
                            <!-- list-main-wrap end-->
                        </div>
                        <!--box-widget-wrap -->
                        <div class="col-md-4">
                            <div class="fl-wrap">
                                <!--box-widget-item -->
                                @if($allowContact)
                                    <div class="box-widget-item fl-wrap">
                                        <div class="box-widget-item-header">
                                            <h3>{{__('labels.eighteen')}}: </h3>
                                        </div>
                                        <div class="box-widget">
                                            <div class="box-widget-content">
                                                <div class="list-author-widget-contacts list-item-widget-contacts">
                                                    <ul>
                                                        @if(($dataManagerPage['authorSingleData']['data']['InformationAddress'])!=null)
                                                            <li>
                                                                <span><i class="fa fa-map-marker"></i> {{__('labels.twenty-four')}} :</span>
                                                                <a>
                                                                    {{
        $dataManagerPage['authorSingleData']['data']['InformationAddress']->street_one.','.$dataManagerPage['authorSingleData']['data']['InformationAddress']->street_two
        }}
                                                                </a>
                                                            </li>
                                                        @endif
                                                        @if($dataManagerPage['authorSingleData']['data']['Profile'])
                                                            <li><span><i class="fa fa-phone"></i>  {{__('labels.twenty-five')}} :</span>
                                                                <a
                                                                        href="tel://{{$dataManagerPage['authorSingleData']['data']['Profile']->phone_code.''.$dataManagerPage['authorSingleData']['data']['InformationPhone']->information_phone}}">+
                                                                    {{
        $dataManagerPage['authorSingleData']['data']['Profile']->phone_code.''.$dataManagerPage['authorSingleData']['data']['InformationPhone']->information_phone
        }}


                                                                </a>
                                                            </li>
                                                            <li><span><i class="fa fa-envelope-o"></i>  {{__('labels.twenty-six')}} :</span>
                                                                <a
                                                                        href="mailto://{{$dataManagerPage['authorSingleData']['data']['Profile']->email}}">{{$dataManagerPage['authorSingleData']['data']['Profile']->email}}</a>
                                                            </li>
                                                        @endif
                                                        @if(($dataManagerPage['authorSingleData']['data']['UsersByAboutUs'])!=null && $dataManagerPage['authorSingleData']['data']['UsersByAboutUs']->web !='null')
                                                            <li><span><i class="fa fa-globe"></i>  {{__('labels.twenty-seven')}} :</span>
                                                                <a
                                                                        href="{{$dataManagerPage['authorSingleData']['data']['UsersByAboutUs']->web}}">

                                                                    {{
        $dataManagerPage['authorSingleData']['data']['UsersByAboutUs']->web
        }}


                                                                </a>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                                @if(count($dataManagerPage['authorSingleData']['data']['InformationSocialNetwork'])>0)

                                                    <div class="list-widget-social">
                                                        <ul>
                                                            @foreach($dataManagerPage['authorSingleData']['data']['InformationSocialNetwork'] as $key =>$value)
                                                                <li><a href="{{$value->information_social_network}}"
                                                                       target="_blank"><i
                                                                                class="{{$value->social_network_icon}}"></i></a>
                                                                </li>

                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <!--box-widget-item end -->
                                <!--box-widget-item -->
                                @if(env('allowProcessAuthorContactUs'))
                                    <div class="box-widget-item fl-wrap">
                                        <div class="box-widget-item-header">
                                            <h3> {{__('labels.nineteen')}} : </h3>
                                        </div>
                                        <div class="box-widget">
                                            <div class="box-widget-content">
                                                <form id="add-comment" class="add-comment custom-form--profile">
                                                    <fieldset>
                                                        <label><i class="fa fa-user-o"></i></label>
                                                        <input type="text" placeholder="{{__('labels.twenty')}}*"
                                                               value=""/>
                                                        <div class="clearfix"></div>
                                                        <label><i class="fa fa-envelope-o"></i> </label>
                                                        <input type="text" placeholder="{{__('labels.twenty-one')}}*"
                                                               value=""/>
                                                        <textarea cols="40" rows="3"
                                                                  placeholder="{{__('labels.twenty-two')}}"></textarea>
                                                    </fieldset>
                                                    <button
                                                            class="btn  big-btn  color-bg flat-btn">{{__('labels.twenty-three')}}
                                                        <i
                                                                class="fa fa-angle-right"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <!--box-widget-item end -->
                            </div>
                        </div>
                        <!--box-widget-wrap end-->
                    </div>
                </div>
            </section>
            <!-- section end -->
            <div class="limit-box fl-wrap"></div>
            <!--section -->
        @endif
        <!--section -->
            <div class="instagram"></div>
        @if(!Auth::check())
            @include('layouts.partials.cityBook.join')
        @endif
    </div>
@endsection
