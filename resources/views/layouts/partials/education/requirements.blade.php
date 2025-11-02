<!-- Classic Breadcrumbs-->
<section class="section breadcrumb-classic context-dark">
    <div class="container">
        <h1>Requisitos</h1>
        <div class="offset-top-10 offset-md-top-35">
            <ul class="list-inline list-inline-lg list-inline-dashed p">
                <li><a href="{{ route($rootPage, app()->getLocale()) }}">Home</a></li>
                <li>Requisitos
                </li>
            </ul>
        </div>
    </div>
</section>
<!-- vertical link Tabs-->
<section class="section section-grid-demonstration section-xl bg-default">

    @if(isset($dataManagerPage['dataRequirementsHtml']))
        <div class="container">

            @if ($dataManagerPage['dataRequirementsHtml'])
                {!! $dataManagerPage['dataRequirementsHtml'] !!}
            @endif

        </div>

    @endif
</section>
