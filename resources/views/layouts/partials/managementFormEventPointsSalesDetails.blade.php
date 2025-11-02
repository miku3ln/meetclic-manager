<script type="text/x-template" id="management-form-event-details-template">
    <div>
        <b-modal
            hide-footer
            id="modal-management-form-event-details"
            ref="refManagementFormEventDetailsModal"
            size="xl"
        <?php echo '@show="_showModal"' ?>
            <?php echo '@hidden="_hideModal"' ?>

            <?php echo '@ok="_saveModal"' ?>
        >
            <template slot="modal-title">
                <label v-html="labelsConfig.title"></label>
            </template>

            <div class="d-block ">
                <b-form id="ManagementFormEventDetails" v-on:submit.prevent="_submitForm">
                    <b-row>
                        <h1 class="title-event" v-html="labelsConfig.event"></h1>


                    </b-row>

                </b-form>


            </div>

        </b-modal>


    </div>

</script>
