
<lodging-room-levels-component

        ref="reLodgingRoomLevels"
        :params="managerProcessBusiness.configDataLodgingRoomLevels"
        v-on:_lodgingRoomLevels-emit="_updateParentByChildren($event)"

></lodging-room-levels-component>
