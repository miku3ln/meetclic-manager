<script type='text/x-template' id='discount-by-products-template'>
    <div>

        <div class='content-component'>
            <b-row>
                <b-col  md="6">
                    <div class="head-info">

                        <h1 class="head-info__title"> <?php echo "{{configProcess.inventory.title}}" ?></h1>
                        <span class="head-info__msg"> <?php echo "{{configProcess.inventory.msg}}" ?></span>
                    </div>
                </b-col>
                <b-col  md="6">
                    <div class="row">
                        <div class=" col-md-6 col-sm-12">
                            <card-box :options="gridConfig.optionsCurrentGrid">

                            </card-box>
                        </div>
                    </div>
                </b-col>
            </b-row>

            <b-row>

                <b-col md="12">
                    <div class="content-manager-grid">
                        <div class="custom-scroll-admin-grid table-responsive">
                            <table id="discount-by-products-grid"
                                   class="">
                                <thead>
                                <tr>
                                    <th data-visible="false" data-column-id="id" data-identifier="true"> ID</th>
                                    <th data-column-id="check-list" data-formatter="check-list-manager"></th>
                                    <th data-column-id="description" data-formatter="description">Descripción</th>


                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </b-col>
            </b-row>
        </div>
    </div>
</script>

