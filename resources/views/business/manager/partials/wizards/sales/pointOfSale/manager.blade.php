@include( $partials . '.wizards.sales.pointOfSale.assets.js',['configPartial'=>$configPartial])
@include( $partials . '.wizards.sales.pointOfSale.assets.css',['configPartial'=>$configPartial])

<div id="content-all" class="class-content-all all-manager--invoice" eventshotkey>
    <div class="class-content-all">

        @if($configPartial['resultProcess']['success'])
            @include( $partials . '.wizards.sales.pointOfSale.step1',['configPartial'=>$configPartial])
            @include( $partials . '.wizards.sales.pointOfSale.step2',['configPartial'=>$configPartial])

        @else
            @if($configPartial['resultProcess']['managerError']['typeCode']=='001' || $configPartial['resultProcess']['managerError']['typeCode']=='002')
                {!! $configPartial['resultProcess']['managerError']['params']['description'] !!}

            @elseif($configPartial['resultProcess']['managerError']['typeCode']=='003')

            @elseif($configPartial['resultProcess']['managerError']['typeCode']=='004')

            @endif

        @endif

    </div>
</div>


