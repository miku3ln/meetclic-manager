<input id="action-events-trails-type-of-categories-saveData" type="hidden"
       value="{{action("EventsTrails\EventsTrailsTypeOfCategoriesController@saveData")}}"/>

<input id="action-events-trails-type-of-categories-getAdmin" type="hidden"
       value="{{action("EventsTrails\EventsTrailsTypeOfCategoriesController@getAdmin")}}"/>




<input id="action-events-trails-distances-saveData" type="hidden"
       value="{{action("EventsTrails\EventsTrailsDistancesController@saveData")}}"/>
<input id="action-events-trails-distances-getAdmin" type="hidden"
       value="{{action("EventsTrails\EventsTrailsDistancesController@getAdmin")}}"/>
<input id="action-events-trails-type-teams-getListSelect2" type="hidden"
       value="{{action("EventsTrails\EventsTrailsTypeTeamsController@getListSelect2")}}"/>

<input id="action-events-trails-type-teams-saveData" type="hidden"
       value="{{action("EventsTrails\EventsTrailsTypeTeamsController@saveData")}}"/>
<input id="action-events-trails-type-teams-getAdmin" type="hidden"
       value="{{action("EventsTrails\EventsTrailsTypeTeamsController@getAdmin")}}"/>


<input id="action-people-gender-getListSelect2" type="hidden"
       value="{{action("People\PeopleGenderController@getListSelect2")}}"/>

<input id="action-events-trails-by-kit-saveData" type="hidden"
       value="{{action("EventsTrails\EventsTrailsByKitController@saveData")}}"/>
<input id="action-events-trails-by-kit-getAdmin" type="hidden"
       value="{{action("EventsTrails\EventsTrailsByKitController@getAdmin")}}"/>
<input id="action-events-trails-by-kit-getListSelect2PiecesClothes" type="hidden"
       value="{{action("EventsTrails\EventsTrailsByKitController@getListSelect2PiecesClothes")}}"/>

<input id="action-events-trails-registration-points-saveData" type="hidden"
       value="{{action("EventsTrails\EventsTrailsRegistrationPointsController@saveData")}}"/>
<input id="action-events-trails-registration-points-getAdmin" type="hidden"
       value="{{action("EventsTrails\EventsTrailsRegistrationPointsController@getAdmin")}}"/>
<input id="action-business-getManagementBusinessEvents" type="hidden"
       value="{{action("Business\BusinessController@getManagementBusinessEvents")}}"/>
<input id="action-events-trails-registration-points-deletePointSale" type="hidden"
       value="{{route("deletePointSale")}}"/>

<input id="action-management-getDataPaymentsManagement" type="hidden"
       value="{{ route("getDataPaymentsManagementEvent")}}"/>


<input id="action-events-trails-by-profile-saveData" type="hidden"
       value="{{action("EventsTrails\EventsTrailsByProfileController@saveData")}}"/>
<input id="action-events-trails-by-profile-getAdmin" type="hidden"
       value="{{action("EventsTrails\EventsTrailsByProfileController@getAdmin")}}"/>
<input id="action-roles-listAll" type="hidden"
       value="{{ action("Users\RoleController@getListAll") }}"/>
<input id="action-users-equalsUserPassword" type="hidden"
       value="{{ action("Users\UserController@equalsUserPassword") }}"/>
<input id="action-users-uniqueUserEmail" type="hidden"
       value="{{ action("Users\UserController@uniqueUserEmail") }}"/>
<input id="action-users-uniqueUserName" type="hidden"
       value="{{ action("Users\UserController@uniqueUserName") }}"/>


<input id="action-product-getEventsProductService" type="hidden"
       value="{{action("Products\ProductController@getEventsProductService")}}"/>
