

<script type="text/x-template" id="grid-registers-template">
    <div>

        <input id="action-users-listAllRoutes" type="hidden"
               value="{{route('listUsersRoutes',app()->getLocale())}}"/>

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

                <table id="grid-registers-grid"
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
