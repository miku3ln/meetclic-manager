@if (isset($vue))

@else

    <div class="row">
        <div class="col-md-12">


        <!-- Portlet card -->
            <div class="card">
                <div class="card-body">
                    <div class="card-widgets">

                        <a data-toggle="collapse" href="#cardCollpase1" role="button" aria-expanded="false"
                           aria-controls="cardCollpase1"><i class="mdi mdi-minus"></i></a>

                    </div>
                    <h5 class="card-title mb-0">{{$title}}</h5>

                    <div id="cardCollpase1" class="collapse pt-3 show">
                        @if($action_buttons && is_array($action_buttons))
                        @endif

                        @if(isset($form_id))
                            {!! Form::open(array('id' => $form_id,'class' => 'm-form m-form--state m-form--fit m-form--label-align-right form-horizontal', 'method' => (isset($method)?$method:'POST'))) !!}
                        @endif
                        <div id="{{$id_table? $id_table: ''}}" class="datatable  create-now"></div>
                        @if(isset($form_id))
                            {!! Form::close() !!}
                        @endif
                    </div>
                </div>
            </div> <!-- end card-->
        </div><!-- end col -->
    </div>


@endif
