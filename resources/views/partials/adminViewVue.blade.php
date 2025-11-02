<div class="content-manager-grid" v-show="!showManager">
    <div class="row">
        <div class="col-md-12">
            <!-- Portlet card -->
            <div class="card">
                <div class="card-body">
                    <div class="card-widgets">
                        <a data-toggle="collapse" href="#cardCollpase1" role="button" aria-expanded="false"
                           aria-controls="cardCollpase1"><i class="mdi mdi-minus"></i></a>
                    </div>
                    <h5 class="card-title mb-0"> {{$title}}</h5>

                    <div id="cardCollpase1" class="collapse pt-3 show">
                        <div class="custom-scroll-admin-grid table-responsive" >

                            <table id="{{$grid_name}}"
                                   class=""

                            >
                                <thead>
                                <tr>
                                    <th data-visible="false" data-column-id="id" data-identifier="true"> ID</th>
                                    <th data-column-id="description" data-formatter="description">Descripción</th>

                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div> <!-- end card-->
        </div><!-- end col -->
    </div>
</div>
