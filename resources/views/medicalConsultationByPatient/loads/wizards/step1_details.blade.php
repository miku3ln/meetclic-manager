<div class="m-portlet m-portlet--bordered m-portlet--rounded m-portlet--unair m-portlet--head-sm">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon">
                            <i class="flaticon-profile-1"></i>
                        </span>
                <h3 class="m-portlet__head-text">
                    Información Personal
                </h3>
            </div>
        </div>
    </div>
    <div class="m-portlet__body">
        <form class="m-form m-form--fit m-form--label-align-right">
            <div class="m-portlet__body">
                <div class="m-scrollable" data-scrollable="true" data-max-height="200" data-scrollbar-shown="true">
                    <div style="padding-left: 15px; padding-right: 15px;">
                        <div>
                            <table class="table">
                                <thead>
                                <tr style="color: white; background-color: #8781d2;">
                                    <th colspan="4">
                                        <h3>{!! $patient->name !!}</h3>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th scope="row">
                                        Teléfono :
                                    </th>
                                    <td>
                                        {!! $patient->phone ? $patient->phone : 'Sin asignar' !!}
                                    </td>
                                    <th scope="row">
                                        Celular :
                                    </th>
                                    <td>
                                        {!! $patient->movil ? $patient->movil : 'Sin asignar' !!}
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        Fecha Nacimiento :
                                    </th>
                                    <td>
                                        {!! $patient->birthday_date ? $patient->birthday_date : 'Sin asignar'  !!}
                                    </td>
                                    <th scope="row">
                                        Género :
                                    </th>
                                    <td>
                                        {!! $patient->gender ? $patient->gender : 'Sin asignar' !!}

                                    </td>

                                </tr>

                                <tr>
                                    <th scope="row">
                                        Email :
                                    </th>
                                    <td colspan="3">
                                        {!! $patient->email ? $patient->email : 'Sin asignar' !!}
                                    </td>

                                </tr>
                                <tr>
                                    <th scope="row">
                                        Dirección :
                                    </th>
                                    <td colspan="3">
                                        {!! $patient->address ? $patient->address : 'Sin asignar' !!}
                                    </td>

                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>



