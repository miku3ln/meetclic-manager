<form id="business-by-schedule-form" class="m-form m-form--state m-form--fit m-form--label-align-right form-horizontal">
    @csrf
    @method('PUT')
    <schedules-component
        :configparams="managerProcessBusiness.configDataSchedules"
    ></schedules-component>

</form>
