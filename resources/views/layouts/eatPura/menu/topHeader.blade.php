<?php
$managerBusinessMenu = [];
if ($isUser) {
    $modelFrontendManager = new  \App\Models\FrontendManagerData;
    $menuItemsTwo = $modelFrontendManager->getItemsManagerFrontend();

    if ($profileConfig['data']['isAdmin']) {
        // $managerBusinessMenu =$modelFrontendManager->getArrayByData(['haystack'=>$menuItemsTwo]);
    } else {
        $keyAction = 'business';
        $roles = $profileConfig['data']['rolesObject'];
        $actionAllowConfigBusiness = $modelFrontendManager->getAllowAction([
            'roles' => $roles,
            'needle' => $keyAction,
            'keyCompare' => 'link',
        ]);

        if ($actionAllowConfigBusiness) {
            $businessManager = $menuItemsTwo[$keyAction];
            $result[] = $businessManager;
        }
    }
}


?>
<nav class="navbar navbar-expand-lg navbar-light navbar-default bg-white osahan-second-nav py-0 shadow-sm">
    <div class="container px-0 px-xl-3">
        <div class="offcanvas offcanvas-start p-4 p-lg-0" id="navbar-default">
            <div class="d-flex justify-content-between align-items-center mb-2 d-block d-lg-none">
                <a class="navbar-brand m-0 d-lg-block flex-shrink-0" href="{{$urlManagerPage}}">
                    <img src="{{ $logoSrc}}" alt=""
                         class="img-fluid logo-img">
                </a>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
            </div>
            <div class="d-block d-lg-none">
                <form action="#">
                    <div
                        class="input-group bg-white top-search-bar border rounded-pill align-items-center py-1 ps-2">
                        <input type="text" class="form-control bg-transparent border-0 rounded-0"
                               placeholder="{{__('frontend.web.eatPura.frontend.menu.two')}}"
                               aria-label="{{__('frontend.web.eatPura.frontend.menu.two')}}">
                        <a href="#" class="btn btn-danger rounded-pill me-1"><i
                                class="icofont-search me-1"></i> {{__('frontend.web.eatPura.frontend.menu.two')}}
                        </a>
                    </div>
                </form>
                <div class="mt-3 mb-4 not-view">


                    <a href="#"
                       class="link-dark osahan-location text-decoration-none d-flex align-items-center gap-2 text-start flex-shrink-0 w-100"
                       data-bs-toggle="offcanvas" data-bs-target="#location"
                       aria-controls="location">
                        <i class="lni lni-map-marker text-danger fs-5"></i>

                        @if(isset($dataManagerPage['dataPage']['information']))
                            <div class="lh-sm">
                                <p class="fw-normal mb-0 small">{{$dataManagerPage['dataPage']['information']['name']}}</p>
                                <p class="text-muted m-0 text-truncate d-inline-block mb-0 align-bottom">
                                    {{$dataManagerPage['dataPage']['information']['address']['primary'].','.$dataManagerPage['dataPage']['information']['address']['secondary']}}
                                </p>
                            </div>

                        @endif

                        <i class="lni lni-chevron-down ms-auto"></i>
                    </a>
                </div>
            </div>
            <div class="d-block d-lg-none h-100" data-simplebar="">
                <ul class="navbar-nav ">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            {{__('frontend.web.eatPura.frontend.menu.fifteen')}}
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item"
                                   href="{{$urlManagerPage}}">{{__('frontend.web.eatPura.frontend.menu.one')}}</a>


                            </li>
                            @foreach ($managerBusinessMenu as $key => $value)
                                <li id="manager-business-{{$key}}">
                                    <a class="dropdown-item"
                                       href="{{$value["link"]}}">{{$value["text"]}}</a>
                                </li>
                            @endforeach

                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            Productos
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item"
                                   href="{{   route('searchProductBusiness')}}">Busqueda</a>


                            </li>
                            <li>
                                <a class="dropdown-item"
                                   href="{{   route('managementProductsBusiness')}}">Gestión</a>


                            </li>

                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            {{__('frontend.web.eatPura.frontend.menu.four')}}
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item"
                                   href="{{$urlShopPage}}">{{__('frontend.web.eatPura.frontend.menu.four')}}</a>
                            </li>

                        </ul>
                    </li>

                    @if(isset($dataManagerPage['categoriesByProducts']))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" role="button"
                               data-bs-toggle="dropdown"
                               aria-expanded="false">
                                {{__('frontend.web.eatPura.frontend.menu.three')}}
                            </a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-submenu ">

                                    @foreach ($dataManagerPage['categoriesByProducts'] as $row)
                                        <a class="dropdown-item dropdown-list-group-item dropdown-toggle"
                                           href="#" manager-category-a-id="{{$row->id}}">
                                            {{$row->value}}
                                        </a>
                                        <ul class="dropdown-menu">
                                            @foreach ($row->sub_categories as $rowSubCategory)
                                                <li manager-sub-category-li-id="{{$rowSubCategory['id']}}">
                                                    <a manager-sub-category-a-id="{{$rowSubCategory['id']}}"
                                                       class="dropdown-item"
                                                       @click="onFilterSubCategoryMenu({data:'{{ json_encode($rowSubCategory) }}',type:2})">
                                                        {{$rowSubCategory['value']}}
                                                    </a>
                                                </li>

                                            @endforeach

                                        </ul>
                                    @endforeach


                                </li>

                            </ul>
                        </li>
                    @endif

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            {{__('frontend.web.eatPura.frontend.menu.five')}}
                        </a>
                        <ul class="dropdown-menu">
                            @if(!$isUser)
                                <li><a class="dropdown-item"
                                       href="{{route('login',app()->getLocale())}}">
                                        {{__('frontend.web.eatPura.frontend.menu.eleven')}}
                                    </a>
                                </li>
                                <li><a class="dropdown-item"
                                       href="{{route('register',app()->getLocale())}}">
                                        {{__('frontend.web.eatPura.frontend.menu.ten')}}
                                    </a>
                                </li>

                            @else

                                <li><a class="dropdown-item"
                                       href=" {{route('userAccount', app()->getLocale())}}">
                                        {{__('frontend.web.eatPura.frontend.menu.fourth')}}</a>
                                </li>

                            @endif
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
