<div class="fl-wrap list-single-header-column">
                                        <span class="viewed-counter not-view">
                                            <i class="fa fa-eye"></i>
                                            Viewed - 156
                                        </span>
    <a class="custom-scroll-link not-view" href="#reviews"><i
            class="fa fa-hand-o-right"></i>
        Add Review
    </a>
    <div class="share-holder hid-share">
        <div class="showshare"><span>Compartir</span><i class="fa fa-share"></i>
        </div>
        <div class="share-container  isShare">
            <a v-if="network.allow" v-for="network in networkShares"
               v-on:click="_shareType(network)"
               v-bind:class="'pop pop--share share-icon '+network.icon">
            </a>
        </div>
    </div>
</div>
