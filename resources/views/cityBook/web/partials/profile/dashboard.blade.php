@section('script')

    @include( 'cityBook.web.partials.profile.assets.js.account')



@endsection
@section("manager-styles")
    <style>
        .data-money {

            position: absolute;
            width: 61px;
            height: auto;
            text-align: right;
            color: #facc39;
            border-radius: 4%;
        }

        .data-money--up {
            background-color: #4DB7FE;

        }

        .data-money--down {
            background-color: #4DB7FE;

        }
    </style>
@endsection
@include(  'cityBook.web.partials.profile.actions.dashboards')
<div class="profile-edit-container">


    <div class="profile-edit-header fl-wrap" style="margin-top:30px">
        <h4>  {{__('frontend.greeting.hi')}} , <span>{{$dataManagerPage['profileConfig']['data']['user']->name}}</span>
        </h4>
    </div>
    <div class="notification success fl-wrap">
        <p> {{__('frontend.greeting.one')}}  {{__('frontend.referral.activities.six')}} <a href="#">Fitness Center
                Brooklyn</a> {{__('frontend.greeting.two')}}!</p>
        <a class="notification-close" href="#"><i class="fa fa-times"></i></a>
    </div>
    <div class="statistic-container fl-wrap">

        <div class="statistic-item-wrap">
            <div class="statistic-item gradient-bg fl-wrap">
                <i class="fa fa fa fa-star-o"></i>
                <div
                    class="statistic-item-numder">{{$dataManagerPage['profileConfig']['data']['user']['gaming']['bee']}}</div>
                <h5>{{env('namePointsOne') }} </h5>


            </div>
        </div>
        <div class="statistic-item-wrap ">
            <div class="statistic-item gradient-bg fl-wrap">
                <i class="fa fa fa-trophy"></i>
                <div
                    class="statistic-item-numder">{{$dataManagerPage['profileConfig']['data']['user']['gaming']['queen']}}</div>
                <h5>{{env('namePointsTwo') }}  </h5>


            </div>
        </div>
    </div>

    <div class="statistic-container fl-wrap">

        <div class="statistic-item-wrap">
            <div class="statistic-item gradient-bg fl-wrap">
                <i class="fa fa-map-marker"></i>
                <div class="statistic-item-numder">21</div>
                <h5> {{__('frontend.account.dashboard.counters.total-listings')}}</h5>
            </div>
        </div>

        <div class="statistic-item-wrap">
            <div class="statistic-item gradient-bg fl-wrap">
                <i class="fa fa fa-eye"></i>
                <div class="statistic-item-numder">1054</div>
                <h5>{{__('frontend.account.dashboard.counters.total-listings-views')}}</h5>
            </div>
        </div>

        <div class="statistic-item-wrap">
            <div class="statistic-item gradient-bg fl-wrap">
                <i class="fa fa-comments-o"></i>
                <div class="statistic-item-numder">675</div>
                <h5>{{__('frontend.account.dashboard.counters.total-reviews')}}</h5>
            </div>
        </div>

        <div class="statistic-item-wrap">
            <div class="statistic-item gradient-bg fl-wrap">
                <i class="fa fa-heart-o"></i>
                <div class="statistic-item-numder">154</div>
                <h5>{{__('frontend.account.dashboard.counters.total-times-bookmarked')}}</h5>
            </div>
        </div>

    </div>

</div>
<div class="manager-grid">
    <grid-manager-component

        ref="refBusiness"
        :params="configDataBusiness"
        v-on:_actions-emit="_updateParentByChildren($event)"

    ></grid-manager-component>
</div>
