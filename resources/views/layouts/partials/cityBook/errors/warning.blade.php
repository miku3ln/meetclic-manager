

<section class="parallax-section" data-scrollax-parent="true" id="sec1">
    <div class="bg par-elem " data-bg="{{ URL::asset($themePath.'images/bg/29.jpg')}}" data-scrollax="properties: { translateY: '30%' }"></div>
    <div class="overlay"></div>
    <div class="bubble-bg"></div>
    <div class="container">
        <div class="error-wrap">
            <h2>{{$title}}</h2>
            <p>{{$description}}</p>
            <div class="clearfix"></div>

            <form action="{{route('search',app()->getLocale())}}">
                <input name="se" id="se" type="text" class="search" placeholder="Search.." value="Search...">
                <button class="search-submit" id="submit_btn"><i class="fa fa-search transition"></i></button>
            </form>
            <div class="clearfix"></div>
            <p>Or</p>
            <a href="{{route('search',app()->getLocale())}}" class="btn  big-btn  color-bg flat-btn">Back to Home Page<i
                    class="fa fa-angle-right"></i></a>


        </div>
    </div>
</section>
@if(!Auth::check())
    @include('layouts.partials.cityBook.join')
@endif
