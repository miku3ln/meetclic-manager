<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>
@section('content')
    @include('partials.admin_view',[
    'title'=>'Administración de '.$name_manager."s",
    'icon'=>'<i class="'.$icon_manager.'"></i>',
    'id_table'=>$model_entity.'_table',
    'action_buttons'=>[
        [
        'label'=>'Crear',
        'icon'=>'<i class="la la-plus"></i>',
        'handler_js'=>'newRegister()',
        'color'=>'btn-primary'
        ],
      ]
    ])
    @include('partials.modal',[
    'title'=>'Crear '.$name_manager,
    'id'=>'modal',
    'action_buttons'=>[
        [
        'type'=>'submit',
        'form'=>$model_entity.'_form',
        'id'=>'btn_save',
        'label'=>'Guardar',
        'color'=>'btn-primary'
        ],
     ]
    ])

    @foreach ($actions as $key => $action)
        <input id="{{$key}}"  type="hidden" value="{{action($action)}}"  />
    @endforeach

@endsection
@section('additional-scripts')
    <script  type="text/javascript">
        var model_entity="{{$model_entity}}";
        var name_manager="{{$name_manager}}";
    </script>
    <script src="{{ asset($resourcePathServer.'js/'.$model_entity.'/index.js') }}" type="text/javascript"></script>
@endsection
