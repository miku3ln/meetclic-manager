<div class="mc-ticket-card-view">
    <div class="mc-ticket-card-view__inner">
        <div class="row mc-ticket-card-view__header">
            <!-- Logo -->
            <div class="col-xs-3 col-md-3 col-12 mc-ticket-card-view__logo-col">
                <div class="mc-ticket-card-view__logo">
                    <img
                        v-if="managerCurrentBusiness.allowView"
                        class="mc-ticket-card-view__logo-img"
                        v-bind:src="getSourceMaritime()"
                        alt="Logo"
                    />
                </div>
            </div>

            <!-- Title + Meta -->
            <div class="col-xs-9 col-md-9 col-12 mc-ticket-card-view__title-col">
                <div class="mc-ticket-card-view__title-wrap">
                    <div class="mc-ticket-card-view__maritime-name">

                        <select
                            class="form-control m-select2"
                            v-init-s2-manager="{  _initS2Manager:_managerS2Products }"
                        ></select>

                    </div>

                    <div class="mc-ticket-card-view__meta" v-if="managerCurrentBusiness.allowView">
                        <div class="row">
                            <div class="col-xs-6 col-sm-12">
                                <div class="mc-ticket-card-view__item">
                                    <span class="mc-ticket-card-view__item-label">FECHA:</span>
                                    <span
                                        class="mc-ticket-card-view__item-value"><?php echo "{{managerCurrentBusiness.time.date}}" ?></span>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-12">
                                <div class="mc-ticket-card-view__item">
                                    <span class="mc-ticket-card-view__item-label">HORA:</span>
                                    <span
                                        class="mc-ticket-card-view__item-value"><?php echo "{{managerCurrentBusiness.time.hour}}" ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-12">
                                <div class="mc-ticket-card-view__item">
                                    <span class="mc-ticket-card-view__item-label">RESPONSABLE:</span>
                                    <span
                                        class="mc-ticket-card-view__item-value"><?php echo "{{managerCurrentBusiness.responsible.fullName}}" ?></span>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-12">
                                <div class="mc-ticket-card-view__item">
                                    <span class="mc-ticket-card-view__item-label">IDENTIFICACIÓN:</span>
                                    <span
                                        class="mc-ticket-card-view__item-value"><?php echo "{{managerCurrentBusiness.responsible.document}}" ?></span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<b-card no-body v-if="managerCurrentBusiness.allowView">
    <b-tabs pills card>
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


