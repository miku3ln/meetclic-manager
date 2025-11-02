@if(isset($configManagementPage['content']['headerHtml'] ))
    {!! $configManagementPage['content']['headerHtml'] !!}
@else
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">

                        @if(isset($menuParentName))
                            <li class="breadcrumb-item"><a href="javascript: void(0);">{{$menuParentName}}</a></li>
                            <li class="breadcrumb-item active">{{$menuName}}</li>
                        @else
                            <li class="breadcrumb-item"><a href="javascript: void(0);">{{env('APP_NAME')}}</a></li>
                            <li class="breadcrumb-item active">{{$menuName}}</li>
                        @endif


                    </ol>
                </div>
                <h4 class="page-title">{{$pageTitle}}</h4>
            </div>
        </div>
    </div>

@endif
