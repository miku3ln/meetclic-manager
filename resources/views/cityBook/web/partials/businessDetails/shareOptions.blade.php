<div class="share-holder hid-share">
    <div class="showshare" option-open="{{__('frontend.actions.share')}}"
         option-close="{{__('frontend.actions.close')}}">
        <span>{{__('frontend.actions.share')}} </span><i class="fa fa-share"></i>
    </div>
    @include('cityBook.web.partials.businessDetails.shareSocialNetworks')
</div>
<span class="viewed-counter"><i class="fa fa-eye"></i>  {{$counterViews}} - {{(__('frontend.actions.viewed').($counterViews>1||$counterViews==0?'s':''))}} </span>
@if(env('allowProcessSuggestions'))
<a class="custom-scroll-link" href="#reviews"><i class="fa fa-hand-o-right"></i>
    {{__('frontend.actions.add').' '.__('frontend.actions.review')}} </a>
@endif
