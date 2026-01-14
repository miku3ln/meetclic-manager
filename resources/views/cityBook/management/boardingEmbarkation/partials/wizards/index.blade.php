<b-card no-body>
    <b-tabs pills card >
        <b-tab active @click="_managementProcess(0)">
            <template v-slot:title>
                <i class="fa fa-bar-chart"></i>
                <strong>Reportes</strong>
            </template>
            <div class="manager-current" v-if="managerProcessCurrent.type==0">


                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>📅 Filtrar por Rango de Fechas</strong>
                    </div>

                    <div class="panel-body">
                        <form class="form-inline" @submit.prevent="initReports">

                            <div class="form-group">
                                <label for="startDate">Desde:</label>
                                <input
                                    type="date"
                                    class="form-control"
                                    id="startDate"
                                    v-model="reportConfig.filters.startDate"
                                    :max="reportConfig.limits.maxDate"
                                >
                            </div>

                            <div class="form-group" style="margin-left: 15px;">
                                <label for="endDate">Hasta:</label>
                                <input
                                    type="date"
                                    class="form-control"
                                    id="endDate"
                                    v-model="reportConfig.filters.endDate"
                                    :min="reportConfig.filters.startDate"
                                    :max="reportConfig.limits.maxDate"
                                >
                            </div>

                            <button
                                type="submit"
                                class="btn btn-primary"
                                id="applyFilters"
                                style="margin-left: 15px;"
                                :disabled="!reportConfig.state.canApply"
                                :title="reportConfig.state.message"
                            >
                                Aplicar Filtros
                            </button>

                        </form>

                        <p v-if="reportConfig.state.message" class="help-block" style="margin-top:8px;">
                            <?php echo "{{ reportConfig.state.message }}" ?>
                        </p>
                    </div>
                </div>

                <div class="report-tracking-web">

                    <div class="chart-container">

                        <div id="chart-location"></div>
                    </div>

                    <div class="chart-container">

                        <div id="chart-sources"></div>
                    </div>

                    <div class="chart-container">

                        <div id="chart-daily"></div>
                    </div>

                    <div class="chart-container">

                        <div id="chart-users"></div>
                    </div>

                    <div class="chart-container">

                        <div id="chart-clicks"></div>
                    </div>

                </div>


            </div>
        </b-tab>
        <b-tab @click="_managementProcess(1)">

            <template v-slot:title>
                <span aria-hidden="true" class="fa fa-user-o"></span>
                <strong>Registro</strong>
            </template>
            <div class="manager-current" v-if="managerProcessCurrent.type==1">
                <register-form-component

                    ref="refRegisterForm"
                    :params="configDataRegisterForm"
                    v-on:_actions-emit="_updateParentByChildren($event)"

                ></register-form-component>
            </div>

        </b-tab>
        <b-tab @click="_managementProcess(2)">
            <template v-slot:title>
                <span aria-hidden="true" class="fa fa-calendar-times-o"></span>
                <strong>Registros</strong>
            </template>

            <div class="manager-current" v-if="managerProcessCurrent.type==2">
                <points-sales-component

                    ref="refPointsSales"
                    :params="configDataPointsSales"
                    v-on:_actions-emit="_updateParentByChildren($event)"

                ></points-sales-component>
            </div>

        </b-tab>


    </b-tabs>
</b-card>


