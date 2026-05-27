@if(isset($dataManagerPage['business']['counters']) && isset($dataManagerPage['type']))

    @php

        $counterConfigs = [

            1 => [
                'class' => 'gradient-bg',
                'items' => [
                    [
                        'icon' => 'fa fa-building',
                        'number' => 45,
                        'label' => __('frontend.business-details.counter.five')
                    ],
                    [
                        'icon' => 'fa fa-male',
                        'number' => 2557,
                        'label' => __('frontend.business-details.counter.six')
                    ],
                    [
                        'icon' => 'fa fa-cutlery',
                        'number' => 5,
                        'label' => __('frontend.business-details.counter.seven')
                    ],
                ]
            ],

            2 => [
                'class' => 'gradient-bg gradient-bg--counters-profile-business',
                'items' => [
                    [
                        'icon' => 'fa fa-male',
                        'number' => $dataManagerPage['business']['counters']['weekVisit']['count'] ?? 0,
                        'label' => __('frontend.business-details.counter.one')
                    ],
                    [
                        'icon' => 'fa fa-hand-peace-o',
                        'number' => $dataManagerPage['business']['counters']['customersSatisfied']['count'] ?? 0,
                        'label' => __('frontend.business-details.counter.two')
                    ],
                    [
                        'icon' => 'fa fa-trophy',
                        'number' => $dataManagerPage['business']['counters']['awards']['count'] ?? 0,
                        'label' => __('frontend.business-details.counter.three')
                    ],
                ]
            ],

            4 => [
                'class' => 'gradient-bg',
                'items' => [
                    [
                        'icon' => 'fa fa-male',
                        'number' => 154,
                        'label' => __('frontend.business-details.counter.one')
                    ],
                    [
                        'icon' => 'fa fa-hand-peace-o',
                        'number' => 12168,
                        'label' => __('frontend.business-details.counter.six')
                    ],
                    [
                        'icon' => 'fa fa-trophy',
                        'number' => 72,
                        'label' => __('frontend.business-details.counter.three')
                    ],
                ]
            ],

        ];

        $currentCounter = $counterConfigs[$dataManagerPage['type']] ?? null;

    @endphp

    @if($currentCounter)

        <div class="list-single-facts fl-wrap {{$currentCounter['class']}}"
             type-counter="{{$dataManagerPage['type']}}">

            @foreach($currentCounter['items'] as $item)

                <div class="inline-facts-wrap">
                    <div class="inline-facts">

                        <i class="{{$item['icon']}}"></i>

                        <div class="milestone-counter">
                            <div class="stats animaper">
                                <div class="num"
                                     data-content="0"
                                     data-num="{{$item['number']}}">
                                    0
                                </div>
                            </div>
                        </div>

                        <h6>{{$item['label']}}</h6>

                    </div>
                </div>

            @endforeach

        </div>

    @endif

@endif
