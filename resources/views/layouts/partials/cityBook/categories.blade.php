<div class="gallery-items fl-wrap mr-bot spad categories__items">
    <?php
    $plural=__('frontend.menu.home.categories.button-category').'s';
    $singular=__('frontend.menu.home.categories.button-category');
$urlCurrentSearch=route('search',app()->getLocale());
    ?>
    @foreach ($dataManagerPage['categoriesBusiness'] as $row)
        <div class="gallery-item categories__item">
            <div class="grid-item-holder">
                <div class="listing-item-grid">
                    <div class="bg" data-bg=" {{$row->src}}"></div>
                    <div class="listing-counter"><span>{{$row->count}} </span>   {{($row->count>1)?$plural:($row->count==1?$singular:$plural)}}</div>
                    <div class="listing-item-cat">
                        <h3><a href="{{$urlCurrentSearch.'?category='.$row->id}}"> {{$row->name}}</a></h3>
                        <p> {{$row->description}}</p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

</div>
