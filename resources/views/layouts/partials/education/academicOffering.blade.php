<!-- Classic Breadcrumbs-->
<section class="section breadcrumb-classic context-dark">
    <div class="container">
        <h1>Proyecto Educativo</h1>
        <div class="offset-top-10 offset-md-top-35">
            <ul class="list-inline list-inline-lg list-inline-dashed p">
                <li><a href="{{ route($rootPage, app()->getLocale()) }}">Home</a></li>
                <li>Proyecto Educativo
                </li>
            </ul>
        </div>
    </div>
</section>
<!-- vertical link Tabs-->
<section class="section section-xl bg-default">
    @if(isset($dataManagerPage['dataAcademicsOfferingHtml']))
        <div class="container">
            <div class="tabs-custom tabs-vertical tabs-line tabs-line-1" id="tabs-7">
                @if ($dataManagerPage['dataAcademicsOfferingHtml'])
                    {!! $dataManagerPage['dataAcademicsOfferingHtml'] !!}
                @endif
            </div>
        </div>

    @endif
</section>
