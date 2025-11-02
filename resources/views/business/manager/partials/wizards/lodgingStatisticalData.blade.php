
<lodging-statistical-data-component
        ref="refLodgingStatisticalData"
        :params="managerProcessBusiness.configDataLodgingStatisticalData"
        v-on:_lodgingStatisticalData-emit="_updateParentByChildren($event)"

></lodging-statistical-data-component>
