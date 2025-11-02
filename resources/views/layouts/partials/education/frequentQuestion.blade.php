 <!-- Classic Breadcrumbs-->
 <section class="section breadcrumb-classic context-dark">
     <div class="container">
         <h1>Preguntas Frecuentes</h1>
         <div class="offset-top-10 offset-md-top-35">
             <ul class="list-inline list-inline-lg list-inline-dashed p">
                 <li><a href="{{ route($rootPage, app()->getLocale()) }}">Home</a></li>
                 <li>Preguntas Frecuentes
                 </li>
             </ul>
         </div>
     </div>
 </section>
 <!-- vertical link Tabs-->
 <section class="section section-lg bg-default">
 @if(isset($dataManagerPage['dataFrequentQuestionHtml']))
     <div class="container">
         <div class="card-group-custom card-group-corporate" id="accordion1" role="tablist"
              aria-multiselectable="false">
             @if ($dataManagerPage['dataFrequentQuestionHtml'])
                 {!! $dataManagerPage['dataFrequentQuestionHtml'] !!}
             @endif
         </div>
     </div>

@endif
 </section>
