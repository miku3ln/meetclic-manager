<!-- Classic Breadcrumbs-->
<section class="section breadcrumb-classic context-dark">
    <div class="container">
        <h1>Perfil</h1>
        <div class="offset-top-10 offset-md-top-35">
            <ul class="list-inline list-inline-lg list-inline-dashed p">
                <li><a href="{{ route($rootPage, app()->getLocale()) }}">Home</a></li>
                <li>Perfil
                </li>
            </ul>
        </div>
    </div>
</section>
<section class="section section-xl bg-default">
    <div class="container">
        <div class="row row-30 justify-content-sm-center">
            @if ($dataManagerPage['dataProfileHtml'])
                {!! $dataManagerPage['dataProfileHtml'] !!}
            @endif
        </div>
    </div>
</section>
