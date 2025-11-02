<gallery-component
        :items="itemsGallery"
        ref="childGallery"
        :params="managerProcessBusiness.configGallery"
        v-on:_data-components-children="_updateParentByChildren($event)"
></gallery-component>
