<input id="action-{{$configPartial["modelNameAction"]}}-saveData" type="hidden"
       value="{{ action("People\PeopleTypeIdentificationController@saveData") }}"/>

<input id="action-{{$configPartial["modelNameAction"]}}-admin" type="hidden"
       value="{{ action("People\PeopleTypeIdentificationController@getAdmin") }}"/>
