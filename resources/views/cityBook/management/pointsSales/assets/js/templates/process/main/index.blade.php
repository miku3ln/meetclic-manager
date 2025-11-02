<script type="text/x-template" id="points-sales-template">
    <div>

        <input id="action-users-listAllRoutes" type="hidden"
               value="{{route('listUsersRoutes',app()->getLocale())}}"/>
        <div id="management-take-part">
            <div v-if="configModalManagementFormEvent.viewAllow">

                <management-form-event-component
                    ref="refManagementFormEvent"
                    :params="configModalManagementFormEvent"

                ></management-form-event-component>
            </div>
        </div>
        <div id="management-take-part-details">
            <div v-if="configModalManagementFormEventDetails.viewAllow">

                <management-form-event-details-component
                    ref="refManagementFormEventDetails"
                    :params="configModalManagementFormEventDetails"

                ></management-form-event-details-component>
            </div>
        </div>
        <b-container class="bv-example-row">
            <div class="content-row-manager-buttons">


                <div v-if="!showManager">
                    <div class="content-manager-buttons-grid ready" v-if="managerMenuConfig.view">
                        <div v-for="(menu, key) in managerMenuConfig.menuCurrent" class="inline-data">
                            <a v-if="menu.isUrl==true"
                               v-bind:href="menu.url+'/managerDashboard'"
                               target="_blank"
                               v-init-tool-tip
                               v-bind:id="'a-menu-'+menu.rowId"
                               class="btn--xs content-manager-buttons-grid__a " data-toggle="tooltip"
                               data-placement="top" v-bind:data-original-title="<?php echo 'menu.title' ?>">
                                <i v-bind:class="<?php echo 'menu.icon' ?>"></i>
                            </a>
                            <a v-else
                               v-init-tool-tip
                               v-bind:id="'a-menu-'+menu.rowId"
                               v-on:click="_managerMenuGrid(key, menu)"
                               class=" btn--xs content-manager-buttons-grid__a " data-toggle="tooltip"
                               data-placement="top" v-bind:data-original-title="<?php echo 'menu.title' ?>">
                                <i v-bind:class="<?php echo 'menu.icon' ?>"></i>
                            </a>
                        </div>


                    </div>
                </div>

            </div>
        </b-container>
        <?php ?>
        <div class="content-manager-grid">

            <div class="custom-scroll-admin-grid table-responsive" v-show="!showManager">
                <div class="search-manager">
                    <div class="row">
                        <div class="col-md-12 search-manager__actions">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="search-manager__needle">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                        <input v-init-grid-filters="{initMethod:_search}" type="text"
                                               placeholder="Buscar ....."
                                               v-model="search.needle"/>
                                    </div>
                                </div>
                                <div class="col-md-4 not-view">
                                    <div class="search-manager__sort header-search-select-item ">
                                        <select name="sort-by" id="sort-by" class="chosen-select">
                                            <option value="-1" id="allSort"
                                                    order="asc">{{__('business.filters.sort.one')}}</option>
                                            <option value="0" id="nameSort"
                                                    order="asc">{{__('business.filters.sort.two')}}</option>
                                            <option value="1" id="emailSort"
                                                    order="asc">{{__('business.filters.sort.three')}}</option>
                                            <option value="2" id="categorySort"
                                                    order="asc">{{__('business.filters.sort.four')}}
                                            </option>
                                            <option value="6" id="subcategorySort" order="asc">
                                                {{__('business.filters.sort.eight')}}
                                            </option>
                                            <option value="3" id="countrySort" order="asc">
                                                {{__('business.filters.sort.five')}}
                                            </option>
                                            <option value="4" id="stateProvinceSort" order="asc">
                                                {{__('business.filters.sort.six')}}
                                            </option>
                                            <option value="5" id="citySort" order="asc">
                                                {{__('business.filters.sort.seven')}}
                                            </option>

                                        </select>
                                    </div>
                                </div>
                            </div>


                        </div>


                    </div>
                </div>
                <table id="points-sales-grid"
                       class=""

                >
                    <thead>
                    <tr>
                        <th data-visible="false" data-column-id="id" data-identifier="true"> ID</th>
                        <th data-column-id="description" data-formatter="description">Descripción</th>

                    </tr>
                    </thead>
                </table>
            </div>
        </div>



    </div>

</script>
