 <!-- Classic Breadcrumbs-->
 <section class="section breadcrumb-classic context-dark">
     <div class="container">
         <h1>Noticia</h1>
         <div class="offset-top-10 offset-md-top-35">
             <ul class="list-inline list-inline-lg list-inline-dashed p">
                 <li><a href="{{ route($rootPage, app()->getLocale()) }}">Home</a></li>
                 <li>Noticia
                 </li>
             </ul>
         </div>
     </div>
 </section>


 @if (isset($dataManagerPage['dataNewHtml']))
 {!! $dataManagerPage['dataNewHtml'] !!}
@endif
