
@if( isset($dataManagerPage['menuAccountManagementUser']['data']['menu']  )&& count($dataManagerPage['menuAccountManagementUser']['data']['menu']['one'])>0)
    <div class="user-profile-menu ">
        <h3>{{__('frontend.account.menu.title.one')}}</h3>
        <ul>
            @foreach($dataManagerPage['menuAccountManagementUser']['data']['menu']['one'] as $key =>$row)

                <li><a href="{{$row['link']}}"
                       class="{{$row['active']?'user-profile-act':'' }} ">
                        <i class="{{$row['icon']}}"></i>{{$row['text']}}</a>
                </li>

            @endforeach
        </ul>
    </div>
@endif
@if( isset($dataManagerPage['menuAccountManagementUser']['data']['menu']  )&& count($dataManagerPage['menuAccountManagementUser']['data']['menu']['two'])>0)
    <div class="user-profile-menu">
        <h3>{{__('frontend.account.menu.title.two')}}</h3>
        <ul>
            @foreach($dataManagerPage['menuAccountManagementUser']['data']['menu']['two'] as $key =>$row)
                <li><a href="{{$row['link']}}"
                       class="{{$row['active']?'user-profile-act':'' }} ">
                        <i class="{{$row['icon']}}"></i>{{$row['text']}}</a>
                </li>

            @endforeach
        </ul>
    </div>
@endif
@if( isset($dataManagerPage['menuAccountManagementUser']['data']['menu']  )&& count($dataManagerPage['menuAccountManagementUser']['data']['menu']['three'])>0)

    <div class="user-profile-menu">
        <h3>{{__('frontend.account.menu.title.three')}}</h3>
        <ul>
            @foreach($dataManagerPage['menuAccountManagementUser']['data']['menu']['three'] as $key =>$row)
                <li><a href="{{$row['link']}}"
                       class="{{$row['active']?'user-profile-act':'' }} ">
                        <i class="{{$row['icon']}}"></i>{{$row['text']}}</a>
                </li>
            @endforeach
        </ul>
    </div>
@endif
