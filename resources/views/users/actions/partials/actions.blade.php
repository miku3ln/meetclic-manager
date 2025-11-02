<input id="action_actions_save" type="hidden"
       value="{{ action("Users\ActionsController@saveData") }}"/>

<input id="action_actions_admin" type="hidden"
       value="{{ action("Users\ActionsController@getAdmin") }}"/>
<input id="action_actions_listActionsParent" type="hidden"
       value="{{ action("Users\ActionsController@getListActionsParent") }}"/>