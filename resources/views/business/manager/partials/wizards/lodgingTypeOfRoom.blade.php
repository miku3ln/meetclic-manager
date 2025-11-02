
<lodging-type-of-room-component

        ref="reLodgingTypeOfRoom"
        :params="managerProcessBusiness.configDataLodgingTypeOfRoom"
        v-on:_lodgingTypeOfRoom-emit="_updateParentByChildren($event)"

></lodging-type-of-room-component>
