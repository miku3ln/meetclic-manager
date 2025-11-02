<section class="scroll-con-sec hero-section" data-scrollax-parent="true" id="sec1">
    <div class="bg" data-bg="{{ URL::asset($themePath.'images/bg/32.jpg')}}"
         data-scrollax="properties: { translateY: '200px' }"></div>
    <div class="overlay"></div>
    <div class="hero-section-wrap fl-wrap">
        <div class="container">
            <div class="intro-item fl-wrap">
                <h2> {{__('frontend.menu.home.slider.title')}}</h2>
                <h3>{{__('frontend.menu.home.slider.subtitle')}}</h3>
            </div>
            <div class="main-search-input-wrap">
                <div class="main-search-input fl-wrap">
                    <div class="main-search-input-item">
                        <input name="" class="" type="text"
                               placeholder="{{__('frontend.menu.home.filters.keywords')}}" value=""/>
                    </div>
                    <div class="main-search-input-item location" id="autocomplete-container">
                        <input type="text" placeholder="{{__('frontend.menu.home.filters.location')}}"
                               id="autocomplete-input" value=""/>
                        <a href="#"><i class="fa fa-dot-circle-o"></i></a>
                    </div>
                    <div class="main-search-input-item">

                        <select data-placeholder="{{__('frontend.menu.home.filters.category')}}"
                                class="chosen-select">
                            <option val="0">All Categories</option>
                            @foreach ($dataManagerPage['categoriesBusiness'] as $row)
                                <option val="{{$row->id}}">{{$row->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <button class="main-search-button"
                            onclick="window.location.href= '{{route('search',app()->getLocale())}}'">
                        {{__('frontend.menu.home.filters.button')}}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="bubble-bg"></div>
    <div class="header-sec-link">
        <div class="container">
            <a href="#sec2" class="custom-scroll-link">{{__('frontend.menu.home.slider.button')}}</a>
        </div>
    </div>
</section>
