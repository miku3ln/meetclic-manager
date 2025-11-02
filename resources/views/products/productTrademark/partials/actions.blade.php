{{--ACTIONS MODEL--}}
<input id="action-product-trademark-saveData" type="hidden"
value="{{action("Products\ProductTrademarkController@saveData")}}"/>
<input id="action-product-trademark-getAdmin" type="hidden"
value="{{action("Products\ProductTrademarkController@getAdmin")}}"/>


<input id="action-language-product-trademark-saveData" type="hidden"
       value="{{action("Language\LanguageProductTrademarkController@saveData")}}"/>
<input id="action-language-product-trademark-getAdmin" type="hidden"
       value="{{action("Language\LanguageProductTrademarkController@getAdmin")}}"/>
<input id="action-language-product-trademark-setDelete" type="hidden"
       value="{{action("Language\LanguageProductTrademarkController@setDelete")}}"/>

<input id="action-language-getListSelect2" type="hidden"
       value="{{action("Language\LanguageController@getListSelect2")}}"/>
