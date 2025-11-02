@if(false)
    @if( isset($dataManagerPage['business']['descriptions']))
        <div class="accordion">
            @foreach ($dataManagerPage['business']['descriptions'] as $description)

                <a class="toggle act-accordion" href="#">{{$description->title}}<i
                        class="fa fa-angle-down"></i></a>
                <div class="accordion-inner visible">
                    <p>{{$description->description}}</p>
                </div>
            @endforeach
        </div>
    @endif
@endif
