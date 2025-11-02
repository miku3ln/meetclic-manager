{{--ACTIONS MODEL--}}
<input id="action-allow-processes-threads-saveData" type="hidden"
value="{{action("AllowProcessesThreads\AllowProcessesThreadsController@saveData")}}"/>

<input id="action-allow-processes-threads-getAdmin" type="hidden"
value="{{action("AllowProcessesThreads\AllowProcessesThreadsController@getAdmin")}}"/>

{{--
ROUTES SET CONFIG routes
--}}
{{--
Route::post("allowProcessesThreads/save","AllowProcessesThreads\AllowProcessesThreadsController@saveData");

Route::post("allowProcessesThreads/admin","AllowProcessesThreads\AllowProcessesThreadsController@getAdmin");

Route::get("allowProcessesThreads/listSelect2","AllowProcessesThreads\AllowProcessesThreadsController@getListSelect2");

Route::get("allowProcessesThreads/manager","AllowProcessesThreads\AllowProcessesThreadsController@getManager");
--}}

