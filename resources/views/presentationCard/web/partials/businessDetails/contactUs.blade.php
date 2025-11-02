@if( isset($dataManagerPage['business']['contactUs']))

    <div class="box-widget-item fl-wrap">
        <div class="box-widget-item-header">
            <h3>{{__('frontend.business-details.contact-us')}}: </h3>
        </div>
        <div class="box-widget">
            <div class="map-container">
                <div id="singleMap"
                     data-latitude="{{$dataManagerPage['business']['contactUs']->location['lat']}}"
                     data-longitude="{{$dataManagerPage['business']['contactUs']->location['lng']}}"
                     data-mapTitle="{{$dataManagerPage['business']['information']->title}}"></div>
            </div>
            <div class="box-widget-content">
                <div class="list-author-widget-contacts list-item-widget-contacts">
                    <ul>
                        <li><span><i class="fa fa-map-marker"></i> {{__('frontend.business-details.contact-us.address')}} :</span> <a
                                >{{$dataManagerPage['business']['contactUs']->address}}</a>
                        </li>
                        <li><span><i class="fa fa-phone"></i> {{__('frontend.business-details.contact-us.phone')}} :</span> <a
                                href="tel:+{{$dataManagerPage['business']['contactUs']->phone}}">+{{$dataManagerPage['business']['contactUs']->phone}}</a>
                        </li>
                        <li><span><i class="fa fa-envelope-o"></i> {{__('frontend.business-details.contact-us.mail')}} :</span> <a
                                href="mailto:{{$dataManagerPage['business']['contactUs']->email}}">{{$dataManagerPage['business']['contactUs']->email}}</a>
                        </li>
                        @if($dataManagerPage['business']['contactUs']->web !='')
                            <li><span><i class="fa fa-globe"></i> {{__('frontend.business-details.contact-us.web')}} :</span> <a
                                    href="#">{{$dataManagerPage['business']['contactUs']->web}}</a>
                            </li>
                        @endif
                    </ul>
                </div>

                @if(isset($dataManagerPage['business']['contactUs']->networkSocial) &&  count($dataManagerPage['business']['contactUs']->networkSocial)>0)
                    <div class="list-widget-social">
                        <ul>
                            <li><a href="#" target="_blank"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#" target="_blank"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#" target="_blank"><i class="fa fa-vk"></i></a></li>
                            <li><a href="#" target="_blank"><i class="fa fa-whatsapp"></i></a></li>
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif
