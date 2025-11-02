<points-sales-component

        ref="refPointsSales"
        :params="configDataPointsSales"
        v-on:_actions-emit="_updateParentByChildren($event)"

></points-sales-component>
