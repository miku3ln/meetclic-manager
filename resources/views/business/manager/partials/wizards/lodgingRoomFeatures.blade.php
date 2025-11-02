
<lodging-room-features-component

        ref="reLodgingRoomFeatures"
        :params="managerProcessBusiness.configDataLodgingRoomFeatures"
        v-on:_lodgingRoomFeatures-emit="_updateParentByChildren($event)"

></lodging-room-features-component>
