{{--ACTIONS MODEL--}}
<input id="action-product-category-saveData" type="hidden"
value="{{action("Products\ProductCategoryController@saveData")}}"/>
<input id="action-product-category-getAdmin" type="hidden"
value="{{action("Products\ProductCategoryController@getAdmin")}}"/>

<input id="action-language-product-category-saveData" type="hidden"
       value="{{action("Language\LanguageProductCategoryController@saveData")}}"/>
<input id="action-language-product-category-getAdmin" type="hidden"
       value="{{action("Language\LanguageProductCategoryController@getAdmin")}}"/>
<input id="action-language-product-category-setDelete" type="hidden"
       value="{{action("Language\LanguageProductCategoryController@setDelete")}}"/>

<input id="action-language-getListSelect2" type="hidden"
       value="{{action("Language\LanguageController@getListSelect2")}}"/>
