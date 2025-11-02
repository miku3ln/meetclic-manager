<input id="action_peopleNationality_save" type="hidden"
       value="{{ action("People\PeopleNationalityController@saveData") }}"/>

<input id="action_peopleNationality_admin" type="hidden"
       value="{{ action("People\PeopleNationalityController@getAdmin") }}"/>
<input id="action_peopleNationality_listS2Countries" type="hidden"
       value="{{ action("Geography\CountryController@getListS2Countries") }}"/>