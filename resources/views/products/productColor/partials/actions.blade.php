{{--ACTIONS MODEL--}}
<input id="action-product-color-saveData" type="hidden"
value="{{action("Products\ProductColorController@saveData")}}"/>

<input id="action-product-color-getAdmin" type="hidden"
value="{{action("Products\ProductColorController@getAdmin")}}"/>

<input id="action-language-product-color-saveData" type="hidden"
       value="{{action("Language\LanguageProductColorController@saveData")}}"/>
<input id="action-language-product-color-getAdmin" type="hidden"
       value="{{action("Language\LanguageProductColorController@getAdmin")}}"/>
<input id="action-language-product-color-setDelete" type="hidden"
       value="{{action("Language\LanguageProductColorController@setDelete")}}"/>

<input id="action-language-getListSelect2" type="hidden"
       value="{{action("Language\LanguageController@getListSelect2")}}"/>
