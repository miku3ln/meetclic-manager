<script type='text/x-template' id='antecedent-by-history-clinic-template'>
    <div>

        <b-form-group :label="labelsConfig.titles.one">
            <b-form-checkbox-group id="checkbox-group-2" v-model="selected" name="flavour-2"  <?php echo '@change="_antecedent"'?>>
                <div class="content-checkbox" v-for="(row,index) in options">
                    <b-form-checkbox  :value="row.value"   >
                        <?php echo '{{row.text}}'?>
                    </b-form-checkbox>
                    <input type="text"  v-model="row.description">
                </div>

            </b-form-checkbox-group>
        </b-form-group>
        <div class="manager-buttons-process">

            <button type="button"
                    :disabled="!validateForm()"
                    class="btn btn-success "
                    v-on:click="_saveModel()">
                <?php echo '{{isNew?labelsConfig.buttons.create:labelsConfig.buttons.update}}'?></button>

        </div>
    </div>
</script>
