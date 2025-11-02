@if(isset($typeJoin))
    @if($typeJoin==1)

        <section class="color-bg color-bg--join-home" id="join-home">
            <div class="shapes-bg-big"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="images-collage fl-wrap">
                            <div class="images-collage-title">meetclic<span> <i class="fa fa-forumbee"></i> </span>   </div>
                            <div class="images-collage-main images-collage-item"><img
                                    src="{{ URL::asset($themePath.'images/avatar/1.jpg')}}"
                                ></div>
                            <div class="images-collage-other images-collage-item" data-position-left="23"
                                 data-position-top="10" data-zindex="2"><img
                                    src="{{ URL::asset($themePath.'images/avatar/2.jpg')}}" alt=""></div>
                            <div class="images-collage-other images-collage-item" data-position-left="62"
                                 data-position-top="54" data-zindex="5"><img
                                    src="{{ URL::asset($themePath.'images/avatar/4.jpg')}}" alt=""></div>
                            <div class="images-collage-other images-collage-item anim-col" data-position-left="18"
                                 data-position-top="70" data-zindex="11"><img
                                    src="{{ URL::asset($themePath.'images/avatar/6.jpg')}}" alt="">
                            </div>
                            <div class="images-collage-other images-collage-item" data-position-left="37"
                                 data-position-top="90" data-zindex="1"><img
                                    src="{{ URL::asset($themePath.'images/avatar/5.jpg')}}" alt=""></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="color-bg-text">
                            <h3 class="join-title join-title--home">{{__('frontend.menu.home.join.title')}}</h3>
                            <p>{{__('frontend.menu.home.join.description')}}</p>
                            <a href="{{route('register',app()->getLocale())}}" class="color-bg-link ">{{__('frontend.menu.home.join.button')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @elseif($typeJoin==2)

        <section class="gradient-bg">
            <div class="cirle-bg">
                <div class="bg" data-bg="{{ URL::asset($themePath.'images/bg/circle.png')}}"></div>
            </div>
            <div class="container">
                <div class="join-wrap fl-wrap">
                    <div class="row">
                        <div class="col-md-8">
                            <h3>{{__('frontend.menu.home.join.title')}}</h3>
                            <p>{{__('frontend.menu.home.join.description')}}</p>
                        </div>
                        <div class="col-md-4">
                            <a href="{{route('register',app()->getLocale())}}"
                                                 class="color-bg-link"
                            >{{__('frontend.menu.home.join.button')}} <i
                                    class="fa fa-sign-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@else
    <section class="gradient-bg">
        <div class="cirle-bg">
            <div class="bg" data-bg="{{ URL::asset($themePath.'images/bg/circle.png')}}"></div>
        </div>
        <div class="container">
            <div class="join-wrap fl-wrap">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="join-title join-title--search">{{__('frontend.menu.home.join.title')}}</h3>
                        <p>{{__('frontend.menu.home.join.description')}}</p>
                    </div>
                    <div class="col-md-4">
                        <a href="{{route('register',app()->getLocale())}}"
                                             class="color-bg-link">{{__('frontend.menu.home.join.button')}}<i
                                class="fa fa-sign-in"></i></a></div>
                </div>
            </div>
        </div>
    </section>
@endif
