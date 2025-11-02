<div class="list-single-main-item fl-wrap">
    <div class="list-single-main-item-title fl-wrap">
        <h3>{{$dataManagerPage['business']['aboutUs']['title']}}</h3>
    </div>
    <div class="about__description" >
        {!! $dataManagerPage['business']['aboutUs']['description'] !!}
    </div>

    @if($dataManagerPage['business']['contactUs']->web !='')
        <a target="_blank" href="{{$dataManagerPage['business']['contactUs']->web}}"
           class="btn transparent-btn float-btn">Visit Website <i
                class="fa fa-angle-right"></i></a>

    @endif

    <span class="fw-separator"></span>
    @if( isset($dataManagerPage['business']['amenities']))
        <div class="list-single-main-item-title fl-wrap">
            <h3>{{__('business.variants.one.title')}}</h3>
        </div>
        <div class="listing-features fl-wrap">
            <ul>
                @foreach ($dataManagerPage['business']['amenities'] as $row)

                    <li><i class="{{$row->source}}"></i> {{$row->text}}</li>

                @endforeach

            </ul>
        </div>
    @endif
    @if( isset($dataManagerPage['business']['tags']))
        <span class="fw-separator"></span>

        <div class="list-single-main-item-title fl-wrap">
            <h3>Tags</h3>
        </div>
        <div class="list-single-tags tags-stylwrap">
            <a href="#">Lunch</a>
            <a href="#">Friendly service</a>
            <a href="#">Wine</a>
            <a href="#">Sandwich</a>
            <a href="#">Food</a>
            <a href="#">Cocktails</a>
        </div>
    @endif


</div>

