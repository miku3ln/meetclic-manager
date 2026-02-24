<!--BUSINESS-->
<input id="action-management-admin" type="hidden"
       value="{{ route("getDictionaryData") }}"/>

<input id="action-management-save" type="hidden"
       value="{{ route("saveWord")}}"/>
<input id="action-management-dictionaryPronunciationUpload" type="hidden"
       value="{{ route("dictionaryPronunciationUpload") }}"/>
<input id="action-management-dictionaryPronunciationDelete" type="hidden"
       value="{{ route("dictionaryPronunciationDelete",'-1') }}"/>
<input id="action-management-grammaticalClassList" type="hidden"
       value="{{ route("grammaticalClassList") }}"/>

<input id="action-management-responsibles-admin" type="hidden"
       value="{{ route("maritimeVesselsResposiblesAdmin") }}"/>
<input id="action-management-responsibles-save" type="hidden"
       value="{{ route("saveMaritimeVesselResponsiblesApi")}}"/>
this.params.data
