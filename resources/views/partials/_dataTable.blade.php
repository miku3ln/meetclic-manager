<div class="m-portlet m-portlet--bordered m-portlet--rounded m-portlet--unair m-portlet--head-sm ">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <span class="m-portlet__head-icon">
                    <i class="{{$icon? $icon: ''}}"></i>
                </span>
                <h3 class="m-portlet__head-text">
                    {{ $title ? $title: ''}}
                </h3>
            </div>
        </div>
    </div>
    <div class="m-portlet__body">
        <div class="m-scrollable" data-scrollable="true" data-max-height="300" data-scrollbar-shown="true">

            <div class="m-content">
                {{--<div id="{{$id? $id: ''}}" class="m_datatable"></div>--}}
                <table class="table table-striped table-bordered" id="{{ isset($id) ? $id : 'dataTable' }}">
                    <thead>
                    <tr>
                        @foreach($columns as $column)
                            <th>{{$column['name']}}</th>
                        @endforeach
                        {{--<th class="check"><input name="select_all" value="1" type="checkbox"></th>--}}
                    </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div>
</div>





