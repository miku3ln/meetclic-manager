
<script type="text/x-template" id="management-form-event-template">
    <div>
        <b-modal
            hide-footer
            id="modal-management-form-event"
            ref="refManagementFormEventModal"
            size="xl"
        <?php echo '@show="_showModal"' ?>
            <?php echo '@hidden="_hideModal"' ?>


        >
            <template slot="modal-title">
                <label v-html="labelsConfig.title"></label>
            </template>

            <b-container class="container-manager-buttons">

                <div class="content-row-manager-buttons">
                    <button

                        type="button"
                        class="btn  btn-danger"
                        v-on:click="_hideModal()">
                        <?php  echo "{{labelsConfig.buttons.return}}" ?>
                    </button>

                </div>
            </b-container>
            <div class="d-block ">
                <b-form id="ManagementFormEvent" v-on:submit.prevent="_submitForm">
                    <b-row>
                        <h1 class="title-event">        <?php  echo "{{labelsConfig.event}}" ?></h1>


                    </b-row>


                    <div class="preview-management" >
                        <div class="content-row">
                            <label class="preview-management-lbl "><span class="preview-management__title" v-html='getLabelForm("team_id")' ></span>
                                : <?php echo '{{modelView.team}}' ?> </label>
                        </div>
                        <div class="content-row">
                            <label class="preview-management-lbl "><span class="preview-management__title" v-html='getLabelForm("distance_id")' ></span>
                                : <?php echo '{{modelView.distance}}' ?> </label>
                        </div>

                        <div v-for="(p, index) in  modelView.people" class="preview-management__people">
                            <div class="content-row">
                                <span class="preview-management__title"><?php echo '{{p.one.label}}' ?></span>
                                <span><?php echo '{{p.one.value}}' ?></span>
                            </div>
                            <div class="content-row">
                                <span class="preview-management__title"><?php echo '{{p.eight.label}}' ?></span>
                                <span><?php echo '{{p.eight.value}}' ?></span>
                            </div>
                            <div class="content-row">
                                <span class="preview-management__title"><?php echo '{{p.nine.label}}' ?></span>
                                <span v-html="p.nine.value"></span>
                            </div>
                        </div>

                    </div>
                </b-form>


            </div>


        </b-modal>


    </div>

</script>
