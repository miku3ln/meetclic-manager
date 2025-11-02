<script type="text/x-template" id="search-manager-template">
    <div>
        <div class="container-button-search visible-content">
            <button class="container-button-search__button" v-on:click='_viewMenu()'>
                <span class="search-button__icon"><i
                            :class="getClassButtonOpenManager()"></i></span>
            </button>
        </div>
        <div class="preview-demo"
             :class="getClassContentManagerState()">
            <span class="preview-demo-show"><i class="fa fa-cog"></i></span>
            <div class="preview-demo-inner">

                <div class="component-demo"
                     :class="getClassContentState()"
                >
                    <div class="component-demo__content">
                        <div class="component-demo__app-bar">
                            <div class="component-demo__tab-section">
                                <div class="preview-demo-inner__title">
                                    <h1 class="title_search"><?php echo "{{configDataSearchManager.title}}";?></h1>
                                </div>
                            </div>
                            <!---->
                            <button
                                    v-on:click="_viewConfigSearch()"
                                    class="mdc-icon-button material-icons component-demo__config-button mdc-ripple-upgraded--unbounded mdc-ripple-upgraded"
                                    title="Open configuration panel"
                            >
                                <i class="fa fa-cogs"></i>
                            </button>
                            <!---->
                        </div>
                        <div class="component-demo__stage-content">
                            <div v-show="initManager">

                                <div class="row">
                                    <div class="col-md-12">

                                        <b-form-input

                                                aria-describedby="input-lazy-help"
                                                lazy-formatter

                                                v-on:input="_searchBusiness"
                                                v-model="modelSearch"
                                                v-bind:placeholder="inputSearchConfig.placeholder"
                                                min="4"

                                        ></b-form-input>
                                    </div>
                                </div>
                                <div class="content-business-manager">
                                    <table id="business-grid"

                                    >
                                        <thead>
                                        <tr>
                                            <th data-visible="false" data-column-id="id" data-identifier="true"> ID</th>
                                            <th data-visible="true" data-column-id="business_row_html"
                                                data-formatter="business_row_html"></th>

                                        </tr>
                                        </thead>
                                    </table>
                                </div>

                            </div>
                            <div v-show="!initManager">
                                <div class="loading-text">
                                    <?php echo "{{configManager.loadingText}}"?>
                                </div>
                            </div>

                        </div>
                        <div class="component-demo__config-panel"
                             :class="getClassConfigPanelState()"
                        >
                            <div class="component-demo__panel-header">
                                <span class="component-demo__panel-header-label"><?php echo "{{configDataSearchManager.configPanel.title}} ";?></span>
                                <!---->
                                <button
                                        v-on:click="_viewConfigSearch()"
                                        class="mdc-icon-button material-icons component-demo__panel-header-close mdc-ripple-upgraded--unbounded mdc-ripple-upgraded"
                                        title="Close configuration panel"
                                >
                                    <i class="fa fa-times"></i>
                                </button>
                                <!---->
                            </div>

                            <div class="list-options list-options--filters">

                                <b-form-group v-for="(category,index) in dataCategories" :key="category.id">
                                    <template slot="label">

                                        <b-form-checkbox
                                                class="category--content"
                                                v-model="allSelectedManager[index][category.id].model"
                                                @change="_selectAllCategory(index,category.id)"
                                        >
                                            <?php echo "{{  category.name  }}"?>
                                        </b-form-checkbox>
                                    </template>

                                    <b-form-checkbox
                                            class="subcategory--content"
                                            @change="_selectSubcategory(index,category.id,indexsub,subcategory.value,selectedManager[index][category.id][indexsub][subcategory.value].model)"
                                            v-for="(subcategory,indexsub) in category.subcategories"
                                            v-model="selectedManager[index][category.id][indexsub][subcategory.value].model"

                                    >
                                        <?php echo "{{subcategory.text}}" ?>

                                    </b-form-checkbox>
                                </b-form-group>

                            </div>
                        </div>
                    </div>


                </div>
            </div>

        </div>
    </div>

</script>

<script type="text/x-template" id="search-manager-business-template">
    <div>
        <div class="container-button-search visible-content">
            <button class="container-button-search__button" v-on:click='_viewMenu()'>
                <span class="search-button__icon"><i
                            :class="getClassButtonOpenManager()"></i></span>
            </button>
        </div>
        <div class="preview-demo"
             :class="getClassContentManagerState()">
            <span class="preview-demo-show"><i class="fa fa-cog"></i></span>
            <div class="preview-demo-inner">

                <div class="component-demo"
                     :class="getClassContentState()"
                >
                    <div class="component-demo__content">
                        <div class="component-demo__app-bar">
                            <div class="component-demo__tab-section">
                                <div class="preview-demo-inner__title">
                                    <h1 class="title_search"><?php echo "{{configDataSearchManager.title}}";?></h1>
                                </div>
                            </div>
                            <!---->
                            <button
                                    v-on:click="_viewConfigSearch()"
                                    class="mdc-icon-button material-icons component-demo__config-button mdc-ripple-upgraded--unbounded mdc-ripple-upgraded"
                                    title="Open configuration panel"
                            >
                                <i class="fa fa-cogs"></i>
                            </button>
                            <!---->
                        </div>
                        <div class="component-demo__stage-content">
                            <div v-show="initManager">

                                <div class="row">
                                    <div class="col-md-6">

                                        <b-form-input

                                                aria-describedby="input-lazy-help"
                                                lazy-formatter

                                                v-on:input="_searchBusiness"
                                                v-model="modelSearch"
                                                v-bind:placeholder="inputSearchConfig.placeholder"
                                                min="4"

                                        ></b-form-input>
                                    </div>
                                </div>
                                <div class="content-business-manager">
                                    <table id="business-grid"

                                    >
                                        <thead>
                                        <tr>
                                            <th data-visible="false" data-column-id="id" data-identifier="true"> ID</th>
                                            <th data-visible="true" data-column-id="business_row_html"
                                                data-formatter="business_row_html"></th>

                                        </tr>
                                        </thead>
                                    </table>
                                </div>

                            </div>
                            <div v-show="!initManager">
                                <div class="loading-text">
                                    <?php echo "{{configManager.loadingText}}"?>
                                </div>
                            </div>

                        </div>
                        <div class="component-demo__config-panel"
                             :class="getClassConfigPanelState()"
                        >
                            <div class="component-demo__panel-header">
                                <span class="component-demo__panel-header-label"><?php echo "{{configDataSearchManager.configPanel.title}} ";?></span>
                                <!---->
                                <button
                                        v-on:click="_viewConfigSearch()"
                                        class="mdc-icon-button material-icons component-demo__panel-header-close mdc-ripple-upgraded--unbounded mdc-ripple-upgraded"
                                        title="Close configuration panel"
                                >
                                    <i class="fa fa-times"></i>
                                </button>
                                <!---->
                            </div>

                            <div class="list-options list-options--filters">

                                <b-form-group v-for="(category,index) in dataCategories" :key="category.id">
                                    <template slot="label">

                                        <b-form-checkbox
                                                v-model="allSelectedManager[index][category.id].model"
                                                @change="_selectAllCategory(index,category.id)"
                                        >
                                            <?php echo "{{  category.name  }}"?>
                                        </b-form-checkbox>
                                    </template>

                                    <b-form-checkbox

                                            @change="_selectSubcategory(index,category.id,indexsub,subcategory.value,selectedManager[index][category.id][indexsub][subcategory.value].model)"
                                            v-for="(subcategory,indexsub) in category.subcategories"
                                            v-model="selectedManager[index][category.id][indexsub][subcategory.value].model"

                                    >
                                        <?php echo "{{subcategory.text}}" ?>

                                    </b-form-checkbox>
                                </b-form-group>

                            </div>
                        </div>
                    </div>


                </div>
            </div>

        </div>
    </div>

</script>
