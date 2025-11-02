<div class="content-manager-grid">
    <div class="grid-manager-filters">


        <div class="row">
            <div class=" col-md-4 col-sm-12">
                <div class="form-group">
                    <label for="status">Estado Mantenimiento</label>
                    <select ng-model="filtersGrid.status" name='status' class="form-control"
                            ng-change="_filtersGrid()"
                    >
                        <?php echo '<option ng-repeat="x in statusDataFiltersGrid" value="{{x.id}}">{{x.text}}</option>'; ?>
                    </select>
                </div>
            </div>

        </div>
        <form>
            <div class="row" ng-if="filtersGrid.status=='ALL'">
                <div class=" col-md-3 col-sm-12">
                    <div class="card-box">
                        <h4 class="mt-0 font-16"><span
                                class="badge badge-warning"><?php echo '{{filtersDataResults["IN OBSERVATION"].text}}'?></span>
                        </h4>
                        <p class="text-muted mb-0"># Registros
                            <span class="float-right">
                            <i class="fa fa-caret-up text-success mr-1"></i>
                            <?php echo '{{filtersDataResults["IN OBSERVATION"].registers}}'?>
                        </span>
                        </p>
                        <p class="text-muted mb-0">Impuestos $
                            <span class="float-right">
                            <i class="fa fa-caret-down text-danger mr-1"></i>
                            <?php echo '{{filtersDataResults["IN OBSERVATION"].value_taxes}}'?>
                        </span>
                        </p>
                        <p class="text-muted mb-0">Total $
                            <span class="float-right">
                            <i class="fa fa-caret-up text-success mr-1"></i>
                            <?php echo '{{filtersDataResults["IN OBSERVATION"].total}}'?>
                        </span>
                        </p>
                    </div>
                </div>
                <div class=" col-md-3 col-sm-12">

                    <div class="card-box">

                        <h4 class="mt-0 font-16"><span
                                class="badge badge-info"><?php echo '{{filtersDataResults["INITIATED"].text}}'?></span>
                        </h4>
                        <p class="text-muted mb-0"># Registros
                            <span class="float-right">
                            <i class="fa fa-caret-up text-success mr-1"></i>
                            <?php echo '{{filtersDataResults["INITIATED"].registers}}'?>
                        </span>
                        </p>
                        <p class="text-muted mb-0">Impuestos $
                            <span class="float-right">
                            <i class="fa fa-caret-down text-danger mr-1"></i>
                            <?php echo '{{filtersDataResults["INITIATED"].value_taxes}}'?>
                        </span>
                        </p>
                        <p class="text-muted mb-0">Total $
                            <span class="float-right">
                            <i class="fa fa-caret-up text-success mr-1"></i>
                            <?php echo '{{filtersDataResults["INITIATED"].total}}'?>
                        </span>
                        </p>
                    </div>
                </div>
                <div class=" col-md-3 col-sm-12">

                    <div class="card-box">

                        <h4 class="mt-0 font-16"><span
                                class="badge badge-success"><?php echo '{{filtersDataResults["FINISHED"].text}}'?></span>
                        </h4>
                        <p class="text-muted mb-0"># Registros
                            <span class="float-right">
                            <i class="fa fa-caret-up text-success mr-1"></i>
                            <?php echo '{{filtersDataResults["FINISHED"].registers}}'?>
                        </span>
                        </p>
                        <p class="text-muted mb-0">Impuestos $
                            <span class="float-right">
                            <i class="fa fa-caret-down text-danger mr-1"></i>
                            <?php echo '{{filtersDataResults["FINISHED"].value_taxes}}'?>
                        </span>
                        </p>
                        <p class="text-muted mb-0">Total $
                            <span class="float-right">
                            <i class="fa fa-caret-up text-success mr-1"></i>
                            <?php echo '{{filtersDataResults["FINISHED"].total}}'?>
                        </span>
                        </p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card-box">

                        <h4 class="mt-0 font-16"><span
                                class="badge badge-danger"><?php echo '{{filtersDataResults["CANCELLED"].text}}'?></span>
                        </h4>
                        <p class="text-muted mb-0"># Registros
                            <span class="float-right">
                            <i class="fa fa-caret-up text-success mr-1"></i>
                            <?php echo '{{filtersDataResults["CANCELLED"].registers}}'?>
                        </span>
                        </p>
                        <p class="text-muted mb-0">Impuestos $
                            <span class="float-right">
                            <i class="fa fa-caret-down text-danger mr-1"></i>
                            <?php echo '{{filtersDataResults["CANCELLED"].value_taxes}}'?>
                        </span>
                        </p>
                        <p class="text-muted mb-0">Total $
                            <span class="float-right">
                            <i class="fa fa-caret-up text-success mr-1"></i>
                            <?php echo '{{filtersDataResults["CANCELLED"].total}}'?>
                        </span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class=" col-md-3 col-sm-12" ng-if="filtersGrid.status=='IN OBSERVATION'">
                    <div class="card-box">
                        <h4 class="mt-0 font-16"><span
                                class="badge badge-warning"><?php echo '{{filtersDataResults["IN OBSERVATION"].text}}'?></span>
                        </h4>
                        <p class="text-muted mb-0"># Registros
                            <span class="float-right">
                            <i class="fa fa-caret-up text-success mr-1"></i>
                            <?php echo '{{filtersDataResults["IN OBSERVATION"].registers}}'?>
                        </span>
                        </p>
                        <p class="text-muted mb-0">Impuestos $
                            <span class="float-right">
                            <i class="fa fa-caret-down text-danger mr-1"></i>
                            <?php echo '{{filtersDataResults["IN OBSERVATION"].value_taxes}}'?>
                        </span>
                        </p>
                        <p class="text-muted mb-0">Total $
                            <span class="float-right">
                            <i class="fa fa-caret-up text-success mr-1"></i>
                            <?php echo '{{filtersDataResults["IN OBSERVATION"].total}}'?>
                        </span>
                        </p>
                    </div>
                </div>
                <div class=" col-md-3 col-sm-12" ng-if="filtersGrid.status=='INITIATED'">

                    <div class="card-box">

                        <h4 class="mt-0 font-16"><span
                                class="badge badge-info"><?php echo '{{filtersDataResults["INITIATED"].text}}'?></span>
                        </h4>
                        <p class="text-muted mb-0"># Registros
                            <span class="float-right">
                            <i class="fa fa-caret-up text-success mr-1"></i>
                            <?php echo '{{filtersDataResults["INITIATED"].registers}}'?>
                        </span>
                        </p>
                        <p class="text-muted mb-0">Impuestos $
                            <span class="float-right">
                            <i class="fa fa-caret-down text-danger mr-1"></i>
                            <?php echo '{{filtersDataResults["INITIATED"].value_taxes}}'?>
                        </span>
                        </p>
                        <p class="text-muted mb-0">Total $
                            <span class="float-right">
                            <i class="fa fa-caret-up text-success mr-1"></i>
                            <?php echo '{{filtersDataResults["INITIATED"].total}}'?>
                        </span>
                        </p>
                    </div>
                </div>
                <div class=" col-md-3 col-sm-12" ng-if="filtersGrid.status=='FINISHED'">

                    <div class="card-box">

                        <h4 class="mt-0 font-16"><span
                                class="badge badge-success"><?php echo '{{filtersDataResults["FINISHED"].text}}'?></span>
                        </h4>
                        <p class="text-muted mb-0"># Registros
                            <span class="float-right">
                            <i class="fa fa-caret-up text-success mr-1"></i>
                            <?php echo '{{filtersDataResults["FINISHED"].registers}}'?>
                        </span>
                        </p>
                        <p class="text-muted mb-0">Impuestos $
                            <span class="float-right">
                            <i class="fa fa-caret-down text-danger mr-1"></i>
                            <?php echo '{{filtersDataResults["FINISHED"].value_taxes}}'?>
                        </span>
                        </p>
                        <p class="text-muted mb-0">Total $
                            <span class="float-right">
                            <i class="fa fa-caret-up text-success mr-1"></i>
                            <?php echo '{{filtersDataResults["FINISHED"].total}}'?>
                        </span>
                        </p>
                    </div>
                </div>

                <div class=" col-md-3 col-sm-12" ng-if="filtersGrid.status=='CANCELLED'">
                    <div class="card-box">

                        <h4 class="mt-0 font-16"><span
                                class="badge badge-danger"><?php echo '{{filtersDataResults["CANCELLED"].text}}'?></span>
                        </h4>
                        <p class="text-muted mb-0"># Registros
                            <span class="float-right">
                            <i class="fa fa-caret-up text-success mr-1"></i>
                            <?php echo '{{filtersDataResults["CANCELLED"].registers}}'?>
                        </span>
                        </p>
                        <p class="text-muted mb-0">Impuestos $
                            <span class="float-right">
                            <i class="fa fa-caret-down text-danger mr-1"></i>
                            <?php echo '{{filtersDataResults["CANCELLED"].value_taxes}}'?>
                        </span>
                        </p>
                        <p class="text-muted mb-0">Total $
                            <span class="float-right">
                            <i class="fa fa-caret-up text-success mr-1"></i>
                            <?php echo '{{filtersDataResults["CANCELLED"].total}}'?>
                        </span>
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="custom-scroll-admin-grid table-responsive">
        <table id="repair-grid"
               class=""
               init-grid-current
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
