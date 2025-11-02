@if( isset($dataManagerPage['business']['employer']))

    <div class="box-widget-item fl-wrap">
        <div class="box-widget-item-header">
            <h3>More from this employer : </h3>
        </div>
        <div class="box-widget widget-posts">
            <div class="box-widget-content">
                <ul>
                    <li class="clearfix">
                        <a href="#" class="widget-posts-img"><img
                                src="{{ URL::asset($themePath.'images/all/1.jpg')}}" alt=""></a>
                        <div class="widget-posts-descr">
                            <a href="#" title="">Cafe "Lollipop"</a>
                            <span class="widget-posts-date"><i
                                    class="fa fa-calendar-check-o"></i> 21 Mar 2017 </span>
                        </div>
                    </li>
                    <li class="clearfix">
                        <a href="#" class="widget-posts-img"><img
                                src="{{ URL::asset($themePath.'images/all/2.jpg')}}" alt=""></a>
                        <div class="widget-posts-descr">
                            <a href="#" title=""> Apartment in the Center</a>
                            <span class="widget-posts-date"><i
                                    class="fa fa-calendar-check-o"></i> 7 Mar 2017 </span>
                        </div>
                    </li>
                    <li class="clearfix">
                        <a href="#" class="widget-posts-img"><img
                                src="{{ URL::asset($themePath.'images/all/3.jpg')}}" alt=""></a>
                        <div class="widget-posts-descr">
                            <a href="#" title="">Event in City Mol</a>
                            <span class="widget-posts-date"><i
                                    class="fa fa-calendar-check-o"></i> 7 Mar 2017 </span>
                        </div>
                    </li>
                </ul>
                <a class="widget-posts-link" href="#">See All Listing<span><i
                            class="fa fa-angle-right"></i></span></a>
            </div>
        </div>
    </div>
@endif
