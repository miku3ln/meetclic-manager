{{--ACTIONS MODEL--}}
<input id="action-product-measure-type-saveData" type="hidden"
value="{{action("Products\ProductMeasureTypeController@saveData")}}"/>

<input id="action-product-measure-type-getAdmin" type="hidden"
value="{{action("Products\ProductMeasureTypeController@getAdmin")}}"/>



<input id="action-language-product-measure-type-saveData" type="hidden"
       value="{{action("Language\LanguageProductMeasureTypeController@saveData")}}"/>
<input id="action-language-product-measure-type-getAdmin" type="hidden"
       value="{{action("Language\LanguageProductMeasureTypeController@getAdmin")}}"/>
<input id="action-language-product-measure-type-setDelete" type="hidden"
       value="{{action("Language\LanguageProductMeasureTypeController@setDelete")}}"/>

<input id="action-language-getListSelect2" type="hidden"
       value="{{action("Language\LanguageController@getListSelect2")}}"/>
