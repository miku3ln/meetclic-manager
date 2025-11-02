@if( isset($dataManagerPage['business']['scheduling']))

    <div class="box-widget-item fl-wrap">
        <div class="box-widget-item-header">
            <h3>{{__('frontend.business-details.working')}} : </h3>
        </div>
        <div class="box-widget opening-hours">
            <div class="box-widget-content">
                <span
                    class="current-status {{$dataManagerPage['business']['information']->statusOpen?'current-status--open':'current-status--close'}}">
                    <i class="fa fa-clock-o"></i>
    {{__('frontend.business-details.now')}} {{$dataManagerPage['business']['information']->statusOpen?__('frontend.actions.opened') :__('frontend.actions.closed')}}
                </span>
                <ul>
                    <?php

                    $allDay = __('frontend.business-details.all-day');
                    ?>
                    @foreach ($dataManagerPage['business']['scheduling'] as $schedule)
                        <li class="{{$schedule->currentClass}}">
                            @if($schedule->type==0)
                                <span class="opening-hours-day">{{$schedule->text}} </span>
                                <span class="opening-hours-time">{{$allDay}}

                            </span>
                            @else

                                <span class="opening-hours-day">{{$schedule->text}} </span>

                                <ul class="opening-hours-time__ul">

                                    @foreach ($schedule->breakdown as $breakdown)
                                        <li class="opening-hours-time__li">
                                            <span>{{$breakdown['start_time']['modelBreakdown']}}</span> a <span>{{$breakdown['end_time']['modelBreakdown']}}</span>

                                        </li>
                                    @endforeach

                                </ul>


                            @endif
                        </li>

                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif
