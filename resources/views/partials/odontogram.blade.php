<div class="content-render-odontogram hide-element">

    <div id="content-render-data-odontogram-superior">

    </div>
    <div id="content-render-data-odontogram-inferior">
    </div>
    @if(empty($odontogramConfiguration))
        <h1>Leyendas no configuradas</h1>

    @endif
    @if(!empty($odontogramConfiguration))
        <div class="content-legend">

            @foreach($odontogramConfiguration as $legend)
                <div class="content-legend__item">
                    <span class="content-legend__item-bullet" style="background-color:{{$legend->color}}; "></span>
                    <span class="content-legend__item-text">{{$legend->name}}</span>
                </div>
            @endforeach
        </div>
    @endif
</div>