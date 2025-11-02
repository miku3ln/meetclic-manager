<div class="share-container  isShare">
    <a v-for="network in networkShares"
       v-on:click="_shareType(network)"
       v-if='network.allow'
       v-bind:class="'pop pop--share '+network.icon"

    >
    </a>

</div>
