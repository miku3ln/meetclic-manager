@if(isset($dataManagerPage['business']['counters']))

    @if(isset($dataManagerPage['type']))
        @if($dataManagerPage['type']==2)
            <div class="list-single-facts fl-wrap gradient-bg gradient-bg--counters-profile-business">
                <!-- inline-facts -->
                <div class="inline-facts-wrap">
                    <div class="inline-facts">
                        <i class="fa fa-male"></i>
                        <div class="milestone-counter">
                            <div class="stats animaper">
                                <div class="num" data-content="0" data-num="{{$dataManagerPage['business']['counters']['weekVisit']['count']}}">0</div>
                            </div>
                        </div>
                        <h6>{{__('frontend.business-details.counter.one')}}</h6>
                    </div>
                </div>
                <!-- inline-facts end -->
                <!-- inline-facts  -->
                <div class="inline-facts-wrap">
                    <div class="inline-facts">
                        <i class="fa fa-hand-peace-o"></i>
                        <div class="milestone-counter">
                            <div class="stats animaper">
                                <div class="num" data-content="0" data-num="{{$dataManagerPage['business']['counters']['customersSatisfied']['count']}}">0</div>
                            </div>
                        </div>
                        <h6>{{__('frontend.business-details.counter.two')}}</h6>
                    </div>
                </div>
                <!-- inline-facts end -->
                <!-- inline-facts  -->
                <div class="inline-facts-wrap">
                    <div class="inline-facts">
                        <i class="fa fa-trophy"></i>
                        <div class="milestone-counter">
                            <div class="stats animaper">
                                <div class="num" data-content="0" data-num="{{$dataManagerPage['business']['counters']['awards']['count']}}">0</div>
                            </div>
                        </div>
                        <h6>{{__('frontend.business-details.counter.three')}}</h6>
                    </div>
                </div>
                <!-- inline-facts end -->
            </div>
        @elseif($dataManagerPage['type']==1)
            <div class="list-single-facts fl-wrap gradient-bg">
                <!-- inline-facts -->
                <div class="inline-facts-wrap">
                    <div class="inline-facts">
                        <i class="fa fa-business-details"></i>
                        <div class="milestone-counter">
                            <div class="stats animaper">
                                <div class="num" data-content="0" data-num="45">0</div>
                            </div>
                        </div>
                        <h6>{{__('frontend.business-details.counter.five')}}</h6>
                    </div>
                </div>
                <!-- inline-facts end -->
                <!-- inline-facts  -->
                <div class="inline-facts-wrap">
                    <div class="inline-facts">
                        <i class="fa fa-male"></i>
                        <div class="milestone-counter">
                            <div class="stats animaper">
                                <div class="num" data-content="0" data-num="2557">0</div>
                            </div>
                        </div>
                        <h6>{{__('frontend.business-details.counter.six')}}</h6>
                    </div>
                </div>
                <!-- inline-facts end -->
                <!-- inline-facts  -->
                <div class="inline-facts-wrap">
                    <div class="inline-facts">
                        <i class="fa fa-cutlery"></i>
                        <div class="milestone-counter">
                            <div class="stats animaper">
                                <div class="num" data-content="0" data-num="5">0</div>
                            </div>
                        </div>
                        <h6>{{__('frontend.business-details.counter.seven')}}</h6>
                    </div>
                </div>

            </div>
        @elseif($dataManagerPage['type']==3)

        @elseif($dataManagerPage['type']==4)
            <div class="list-single-facts fl-wrap gradient-bg">
                <!-- inline-facts -->
                <div class="inline-facts-wrap">
                    <div class="inline-facts">
                        <i class="fa fa-male"></i>
                        <div class="milestone-counter">
                            <div class="stats animaper">
                                <div class="num" data-content="0" data-num="154">0</div>
                            </div>
                        </div>
                        <h6>{{__('frontend.business-details.counter.one')}}</h6>
                    </div>
                </div>
                <!-- inline-facts end -->
                <!-- inline-facts  -->
                <div class="inline-facts-wrap">
                    <div class="inline-facts">
                        <i class="fa fa-hand-peace-o"></i>
                        <div class="milestone-counter">
                            <div class="stats animaper">
                                <div class="num" data-content="0" data-num="12168">0</div>
                            </div>
                        </div>
                        <h6>{{__('frontend.business-details.counter.six')}}</h6>
                    </div>
                </div>
                <!-- inline-facts end -->
                <!-- inline-facts  -->
                <div class="inline-facts-wrap">
                    <div class="inline-facts">
                        <i class="fa fa-trophy"></i>
                        <div class="milestone-counter">
                            <div class="stats animaper">
                                <div class="num" data-content="0" data-num="72">0</div>
                            </div>
                        </div>
                        <h6>{{__('frontend.business-details.counter.three')}}</h6>
                    </div>
                </div>
                <!-- inline-facts end -->
            </div>

        @endif
    @endif
@endif
