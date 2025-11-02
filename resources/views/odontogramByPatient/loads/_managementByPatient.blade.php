<div class="col-lg-12">
    <div class="m-portlet m-portlet--accent m-portlet--head-solid-bg m-portlet--head-sm"
         m-portlet="true" id="m_portlet_{{$id_table}}">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
						<span class="m-portlet__head-icon">
							<i class="{{$configPortlet["icon"]}}"></i>
						</span>
                    <h3 class="m-portlet__head-text">
                        {{$configPortlet["title"]}}
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <a  data-toggle="tooltip" data-placement="top" title="Collapse" href="#" m-portlet-tool="toggle"
                           class="m-portlet__nav-link m-portlet__nav-link--icon"
                           aria-describedby="tooltip_ges3mb4ofe"><i class="la la-angle-down"></i></a>
                        <div class="m-tooltip m-tooltip--portlet tooltip bs-tooltip-top" role="tooltip"
                             id="tooltip_ges3mb4ofe" aria-hidden="true" x-placement="top"
                             style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(261px, -32px, 0px); display: none;">
                            <div class="tooltip-arrow arrow" style="left: 44px;"></div>
                            <div class="tooltip-inner">Collapse</div>
                        </div>
                    </li>

                    <li class="m-portlet__nav-item">
                        <a  data-toggle="tooltip" data-placement="top" title="Fullscreen" href="#" m-portlet-tool="fullscreen"
                           class="m-portlet__nav-link m-portlet__nav-link--icon"
                           aria-describedby="tooltip_cr4rw063iy"><i class="la la-expand"></i></a>
                        <div class="m-tooltip m-tooltip--portlet tooltip bs-tooltip-top" role="tooltip"
                             id="tooltip_cr4rw063iy" aria-hidden="true" x-placement="top"
                             style="position: absolute; transform: translate3d(321px, -33px, 0px); top: 0px; left: 0px; will-change: transform; display: none;">
                            <div class="tooltip-arrow arrow" style="left: 48px;"></div>
                            <div class="tooltip-inner">Fullscreen</div>
                        </div>
                    </li>
                    <li class="m-portlet__nav-item">
                        <a  data-toggle="tooltip" data-placement="top" title="Agregar Odontograma" href="#" m-portlet-tool="add-register"
                           class="m-portlet__nav-link m-portlet__nav-link--icon"
                           aria-describedby="tooltip_cr4rw063iy"><i class="fa fa-plus-square"></i></a>
                        <div class="m-tooltip m-tooltip--portlet tooltip bs-tooltip-top" role="tooltip"
                             id="tooltip_cr4rw063iy" aria-hidden="true" x-placement="top"
                             style="position: absolute; transform: translate3d(321px, -33px, 0px); top: 0px; left: 0px; will-change: transform; display: none;">
                            <div class="tooltip-arrow arrow" style="left: 48px;"></div>
                            <div class="tooltip-inner">Agregar</div>
                        </div>
                    </li>
                    <li class="m-portlet__nav-item m-portlet__nav-item-update-{{$id_table}} hide-element">
                        <a  data-toggle="tooltip" data-placement="top" title="Editar Odontograma" href="#" m-portlet-tool="update-register"
                           class="m-portlet__nav-link m-portlet__nav-link--icon"
                           aria-describedby="tooltip_cr4rw063iy"><i class="la la-pencil"></i></a>
                        <div class="m-tooltip m-tooltip--portlet tooltip bs-tooltip-top" role="tooltip"
                             id="tooltip_cr4rw063iy" aria-hidden="true" x-placement="top"
                             style="position: absolute; transform: translate3d(321px, -33px, 0px); top: 0px; left: 0px; will-change: transform; display: none;">
                            <div class="tooltip-arrow arrow" style="left: 48px;"></div>
                            <div class="tooltip-inner">Editar</div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body" m-hidden-height="344" style="">
            <div class="content__render-odontogram-loader hide-element">
                <img src="{{ asset(( env('APP_IS_SERVER') ? "public/" : ''). "images/clinic-dental/dentalink-loading.png") }}" class="image-animation">
            </div>
            <div class="conten__render-management">


                <div class="m-datatable m-datatable--default m-datatable--brand m-datatable--loaded m-datatable--scroll">
                    <table id="grid-{{$id_table? $id_table: ''}}"
                           class="">
                        <thead class="m-datatable__head">
                        <tr class="m-datatable__row">
                            <th data-column-id="id" data-identifier="true" data-type="numeric" data-visible="false">ID
                            </th>
                            <th data-column-id="description" data-formatter="description" >
                                Descripcion
                            </th>

                            <th data-column-id="date" data-formatter="date">Fecha</th>
                            <th data-column-id="status" data-formatter="status" data-order="asc">Estado</th>
                        </tr>
                        </thead>
                    </table>
                </div>

                <div id="{{$id_table? $id_table: ''}}" class="datatable"></div>

                @include('partials.odontogram',$odontogramConfiguration)
            </div>
            {{--</div>--}}
        </div>

    </div>
</div>
