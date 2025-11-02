<script type="text/x-template" id="schedules-template">
    <div>
        <div v-if="configparams.schedules.length>0">
            <div v-for="(schedule, index)  in configparams.schedules">

                <div v-if="schedule">
                    <b-container class="bv-example-row">
                        <b-row>

                            <b-col lg="4" md="4" sm="12">
                                <b-input-group>
                                    <label
                                        for="" class="label--schedule"><?php echo "{{ schedule.text  }}" ?></label>
                                    <b-form-checkbox
                                        switch v-model="schedule.modelDay"
                                        v-bind:name="schedule.name"
                                        @change="_daySchedule(schedule.modelDay,index)"
                                    >
                                        <?php echo "{{schedule.modelDay?'Abierto':'Cerrado'}}" ?>
                                    </b-form-checkbox>

                                </b-input-group>


                            </b-col>
                            <b-col lg="8" md="8" sm="12" v-if="schedule.modelDay">
                                <b-form-checkbox
                                    switch v-model="schedule.configTypeSchedule.type"
                                    @change="_typeSchedule(schedule.configTypeSchedule.type,index)"

                                >
                                    <?php echo "{{ !schedule.configTypeSchedule.type?'24 Horas':'Horarios'}}" ?>


                                </b-form-checkbox>
                            </b-col>

                        </b-row>
                        <b-row v-if="schedule.configTypeSchedule.type">
                            <b-col lg="9" md="9" sm="12">


                                <div v-for="(scheduleDay, keyScheduleDay) in schedule.configTypeSchedule.data">
                                    <div v-if="scheduleDay">


                                        <b-row>
                                            <b-col lg="6">
                                                <b-input-group prepend="Apertura">

                                                    <b-form-input

                                                        v-model="scheduleDay.start_time.modelBreakdown"
                                                        type="time"
                                                        aria-label="Apertura"
                                                        min="0:00"
                                                        max="23:00"/>
                                                </b-input-group>

                                                <b-form-invalid-feedback
                                                    :state="validationElement('schedule',scheduleDay.start_time,index,keyScheduleDay,'start_time')">
                                                    <?php echo "{{scheduleDay.start_time.msj}}" ?>
                                                </b-form-invalid-feedback>
                                                <b-form-valid-feedback
                                                    :state="validationElement('schedule',scheduleDay.start_time,index,keyScheduleDay,'start_time')">
                                                    <?php echo "{{scheduleDay.start_time.msj}}" ?>
                                                </b-form-valid-feedback>
                                            </b-col>
                                            <b-col lg="6">
                                                <b-input-group prepend="Cierre">
                                                    <b-form-input

                                                        v-model="scheduleDay.end_time.modelBreakdown"
                                                        type="time"
                                                        aria-label="Hora de Apertura"
                                                        min="0:00" max="23:00"

                                                    />
                                                </b-input-group>

                                                <b-form-invalid-feedback
                                                    :state="validationElement('schedule',scheduleDay.end_time,index,keyScheduleDay,'end_time')">
                                                    <?php echo "{{scheduleDay.start_time.msj}}" ?>
                                                </b-form-invalid-feedback>
                                                <b-form-valid-feedback
                                                    :state="validationElement('schedule',scheduleDay.end_time,index,keyScheduleDay,'end_time')">
                                                    <?php echo "{{scheduleDay.start_time.msj}}" ?>
                                                </b-form-valid-feedback>
                                            </b-col>

                                            <button
                                                type="button"
                                                v-on:click="_removeSchedule(index,keyScheduleDay)"
                                                aria-label="Close"
                                                class="close remove--schedule-day"
                                                v-if="keyScheduleDay">×
                                            </button>
                                        </b-row>
                                    </div>
                                </div>


                            </b-col>

                            <b-col lg="3" md="3" sm="12">

                                <button type="button"
                                        class="btn btn-primary" v-on:click="_addSchedule(index)">
                                    Agregar Horario
                                </button>
                            </b-col>
                        </b-row>
                    </b-container>
                </div>
            </div>
            <button id="manager-schedule" type="button"
                    :disabled="!validateForm()"
                    class="btn btn-success" v-on:click="_saveSchedules()">
                Guardar
            </button>
        </div>
        <div v-else>
            <h1> No existe Horarios Configurados.</h1>
        </div>


    </div>

</script>
