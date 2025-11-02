{!! Form::model($product, array('id' => 'product_form','class' => 'm-form m-form--state m-form--fit
m-form--label-align-right form-horizontal', 'method' => $method,'files'=>true, 'enctype' => 'multipart/form-data')) !!}
<div class="m-portlet__body">
    {!! Form::hidden('product_id', $product->id,['id'=>'product_id']) !!}
    <div class=" form-group m-form__group row">
        {!! Form::label('name','* Nombre:', array('class' => 'col-form-label')) !!}
        {!! Form::text('name', $product->name, array('class' => 'form-control m-input', 'autocomplete' =>
        'off', 'placeholder' => 'ej. Domestico', 'maxlength' => '64')) !!}
    </div>
    <div class=" form-group m-form__group row" id="wrapper_category">
        {!! Form::label('category_id','* Categoria:', array('class' => 'col-form-label ')) !!}
        @if($product->category_id)
            <input id="selected_category" type="hidden" value="{{ $product->category_id }}"/>
        @endif
        {!! Form::select('category_id',array(), $product->category_id, array( 'class' => 'form-control m-select2')) !!}
    </div>
    <div class="form-group m-form__group row">
        {!! Form::label('name',' Descripcion:', array('class' => 'col-form-label ')) !!}
        {!! Form::textarea('description', $product->description, array('class' => 'form-control m-input', 'autocomplete' =>
        'off', 'placeholder' => 'ej. Domestico', 'maxlength' => '64')) !!}
    </div>
    @if ($product->id)
        <div class="form-group m-form__group row">
            {!! Form::label('status','* Estado:', array('class' => 'col-form-label')) !!}
            {!! Form::select('status', array( 'ACTIVE' => 'Activo', 'INACTIVE' => 'Inactivo'),$product->status,array('class' => 'form-control m-input') ) !!}
        </div>
    @endif
    <div class="form-group m-form__group row">
        <div class="col-md-12">
            <div class="m-dropzone dropzone m-dropzone--primary"
                 id="mydropzone"
                 data-accepte-files=".png"
                 data-required="true"
                 data-entityId="img_products"
                 data-auto-process-queue={!! $product->id?1:0 !!}>
                <div class="m-dropzone__msg dz-message needsclick">
                    <h3 class="m-dropzone__msg-title">Suelta tus imágenes aquí o haz clic para cargar</h3>
                    <span class="m-dropzone__msg-desc"></span>
                </div>
                @if($product->id)
                    @foreach($images as $image)
                        <div id="{{$image->id}}" class="dz-preview dz-image-preview">
                            <div class="dz-image">
                                <img data-dz-thumbnail="" alt="{{$image->filename}}"
                                     src="{{$image->url}}?h=120">
                            </div>
                            <div class="dz-details">
                                <div class="dz-filename">
                                    <span data-dz-name="">{{$image->filename}}</span>
                                </div>
                            </div>
                            <div class="dz-success-mark"></div>
                            <a class=" btn red btn-sm btn-block"
                               onclick="deleteImage({{$image->id}})"
                               href="javascript:undefined;"
                               data-dz-remove="">Eliminar</a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>


</div>

{!! Form::close() !!}