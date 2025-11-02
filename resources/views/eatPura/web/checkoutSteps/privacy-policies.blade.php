<div class="single-method">
    <input type="checkbox"
           @change="_setValueForm('accept_terms', $v.model.attributes.accept_terms.$model)"
           id="accept_terms"
           v-model.trim="$v.model.attributes.accept_terms.$model">
    <label for="accept_terms">{{__('conditions.title')}}</label>
    <a class="view-link" v-on:click="_viewPolicies()"><?php echo '{{labelPolicies()}}' ?></a>
    <div data-method="accept_terms" class="view-accept-terms">
        @if(isset($dataManagerPage['policies']))
            {!! $dataManagerPage['policies']['onlyPolicies'] !!}
        @else
            {{__('messages.empty')}}
        @endif
    </div>
</div>
