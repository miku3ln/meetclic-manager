{{--ACTIONS MODEL--}}
<input id="action-product-subcategory-saveData" type="hidden"
value="{{action("Products\ProductSubcategoryController@saveData")}}"/>
<input id="action-product-subcategory-getAdmin" type="hidden"
value="{{action("Products\ProductSubcategoryController@getAdmin")}}"/>
<input id="action-language-product-subcategory-saveData" type="hidden"
       value="{{action("Language\LanguageProductSubcategoryController@saveData")}}"/>
<input id="action-language-product-subcategory-getAdmin" type="hidden"
       value="{{action("Language\LanguageProductSubcategoryController@getAdmin")}}"/>
<input id="action-language-product-subcategory-setDelete" type="hidden"
       value="{{action("Language\LanguageProductSubcategoryController@setDelete")}}"/>

<input id="action-language-getListSelect2" type="hidden"
       value="{{action("Language\LanguageController@getListSelect2")}}"/>
<input id="action-product-category-getListSelect2" type="hidden"
       value="{{action("Products\ProductCategoryController@getListSelect2")}}"/>
