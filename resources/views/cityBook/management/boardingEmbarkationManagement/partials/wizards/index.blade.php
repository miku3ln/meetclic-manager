<div class="administration-data">
    <div class="row">
        <div class="col-md-12">
            <div class="row" id="actions-process" v-if="[-1].includes(configDataRegisterForm.view_type)">
                <div class="col-md-6">
                    <button @click="createRegisterForm()" class="btn btn-success" v-form-text="'actions.create'">
                    </button>
                    <button @click="reportsForm()" class="btn btn-warning"   >
                        <span v-form-text="'titles.report'"></span>
                        <i class="fa fa-bar-chart"></i>

                    </button>
                </div>
            </div>

            <div class="manager-process" v-if="[3].includes(configDataRegisterForm.view_type)">
                <register-form-responsible-component
                    ref="refRegisterFormResponsible"
                    :params="configDataRegisterForm"
                    v-on:_actions-emit="_updateParentByChildren($event)"

                ></register-form-responsible-component>

            </div>
            <div class="manager-process" v-if="[0,1].includes(configDataRegisterForm.view_type)">
                <register-form-component
                    ref="refRegisterForm"
                    :params="configDataRegisterForm"
                    v-on:_actions-emit="_updateParentByChildren($event)"

                ></register-form-component>

            </div>
            <div class="manager-process" v-if="[2].includes(configDataRegisterForm.view_type)">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>📅 Filtros</strong>
                    </div>

                    <div class="panel-body">
                        <form >
                            <div class="row">
                                <div class="col-md-12">
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

                                                        <div class="mc-ticket-card-view__meta"
                                                             v-if="managerCurrentBusiness.allowView">
                                                            <div class="row">
                                                                <div class="col-xs-6 col-sm-12">
                                                                    <div class="mc-ticket-card-view__item">
                                                                    <span
                                                                        class="mc-ticket-card-view__item-label">FECHA:</span>
                                                                        <span
                                                                            class="mc-ticket-card-view__item-value"><?php echo "{{managerCurrentBusiness.time.date}}" ?></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-6 col-sm-12">
                                                                    <div class="mc-ticket-card-view__item">
                                                                    <span
                                                                        class="mc-ticket-card-view__item-label">HORA:</span>
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
                                </div>
                            </div>
                           <div class="row">
                               <div class="col-md-3">
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


                               </div>
                               <div class="col-md-3">
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
                               </div>

                           </div>



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



                <div class="embark-actions" role="group" aria-label="Acciones de embarque">

                    <button type="button"
                            class="btn btn-success"
                            :disabled="!reportConfig.state.canApply"
                            v-on:click="initReports()"

                    >
                        <i class="fa fa fa-bar-chart embark-actions__icon" aria-hidden="true"></i>
                        <span class="embark-actions__text" v-form-text="'actions.generate'"></span>
                    </button>
                    <button type="button"
                            class="embark-actions__btn btn btn-warning"
                            v-on:click="onReturnMain()"
                    >
                        <i class="fa fa-arrow-left embark-actions__icon" aria-hidden="true"></i>
                        <span class="embark-actions__text"  v-form-text="'actions.back'"></span>
                    </button>


                </div>
            </div>
            <grid-registers-component v-if="[-1].includes(configDataRegisterForm.view_type)"
                                      ref="refPointsSales"
                                      :params="configDataRegisterForm"
                                      v-on:_actions-emit="_updateParentByChildren($event)"

            ></grid-registers-component>
        </div>
    </div>
</div>



