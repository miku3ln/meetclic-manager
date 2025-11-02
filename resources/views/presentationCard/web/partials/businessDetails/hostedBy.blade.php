@if(false)
    <div class="box-widget-item fl-wrap">
        <div class="box-widget-item-header">
            <h3>Hosted by : </h3>
        </div>
        <div class="box-widget list-author-widget">
            <div class="list-author-widget-header shapes-bg-small  color-bg fl-wrap">
                                <span class="list-author-widget-link"><a
                                        href="{{$dataManagerPage['business']['information']->user->url}}">{{$dataManagerPage['business']['information']->user->user_name}}</a></span>
                <img src="{{$dataManagerPage['business']['information']->user->source}}" alt="">
            </div>
            <div class="box-widget-content">
                <div class="list-author-widget-text">
                    <div class="list-author-widget-contacts">
                        <ul>
                            @if(isset($dataManagerPage['business']['information']->user->phone))
                                <li><span><i class="fa fa-phone"></i> Phone :</span> <a
                                        href="#">+{{$dataManagerPage['business']['information']->user->phone}}</a>
                                </li>
                            @endif
                            <li><span><i class="fa fa-envelope-o"></i> Mail :</span> <a
                                    href="#">{{$dataManagerPage['business']['information']->user->email}}</a>
                            </li>
                            @if(isset($dataManagerPage['business']['information']->user->web))

                                <li><span><i class="fa fa-globe"></i> Website :</span> <a
                                        href="#">{{$dataManagerPage['business']['information']->user->web}}</a>
                                </li>
                            @endif

                        </ul>
                    </div>
                    <a href="{{$dataManagerPage['business']['information']->user->url}}" class="btn transparent-btn">View
                        Profile <i
                            class="fa fa-eye"></i></a>
                </div>
            </div>
        </div>
    </div>
@endif
