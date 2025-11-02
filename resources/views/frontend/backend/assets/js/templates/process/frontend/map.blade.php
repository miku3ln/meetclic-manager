
<script type='text/x-template' id='map-template'>
    <div>

        <b-row>
            <b-col md="12">
                <div class="floating-panel-manager-manager-routes">
                    <input id="search-map-current"
                           class="floating-panel-manager__search"
                           type="textbox"
                           value="Ecuador"
                           v-focus-select
                    >

                </div>
                <div v-init-map-current="{this:this}" id="myMapCurrent" style="height:400px; width:100%;"
                >
                    <div class="manager-buttons" v-if="viewManagerSave">
                        <b-button @click="_saveOptionsMap" size="sm" variant="primary">Guardar</b-button>

                    </div>
                </div>
            </b-col>
        </b-row>

        <textarea id="mapData" style="width:100%; height:300px;
display:none;">
            {
            "zoom":7,"tilt":0,"mapTypeId":"hybrid","center":{"lat":20.487486793750797,"lng":74.22363281640626},
            "overlays":
            [
            {"type":"polygon","title":"","content":"","fillColor":"#000000","fillOpacity":0.3,"strokeColor":"#000000","strokeOpacity":0.9,"strokeWeight":3,"paths":[[{"lat":"21.329035778926478","lng":"73.46008301171878"},{"lat":"21.40065516914794","lng":"78.30505371484378"},{"lat":"20.106233605369603","lng":"77.37121582421878"},{"lat":"20.14749530904506","lng":"72.65808105859378"}]]}
,{"type":"marker","title":"hol","content":"holatc","label":"hol","position":{"lat":20.487486793750797,"lng": 74.22363281640627}}
            ]
            }
        </textarea>
        <textarea id="kmlString" style="width:100%; height:500px" class="not-view"></textarea>

    </div>
</script>

