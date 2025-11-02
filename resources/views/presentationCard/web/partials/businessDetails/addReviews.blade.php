<div class="list-single-main-item fl-wrap" id="reviews">
    <div class="list-single-main-item-title fl-wrap">
        <h3>{{__('frontend.business-details.reviews.title')}}</h3>
    </div>

    <div id="add-review" class="add-review-box">
        <div class="leave-rating-wrap">
            <span class="leave-rating-title">{{__('frontend.business-details.reviews.field1')}}: </span>
            <div class="leave-rating">
                <input type="radio" name="rating" id="rating-1" value="1"/>
                <label for="rating-1" class="fa fa-star-o"></label>
                <input type="radio" name="rating" id="rating-2" value="2"/>
                <label for="rating-2" class="fa fa-star-o"></label>
                <input type="radio" name="rating" id="rating-3" value="3"/>
                <label for="rating-3" class="fa fa-star-o"></label>
                <input type="radio" name="rating" id="rating-4" value="4"/>
                <label for="rating-4" class="fa fa-star-o"></label>
                <input type="radio" name="rating" id="rating-5" value="5"/>
                <label for="rating-5" class="fa fa-star-o"></label>
            </div>
        </div>

        <form class="add-comment custom-form">
            <fieldset>
                <div class="row">
                    <div class="col-md-6">
                        <label><i class="fa fa-user-o"></i></label>
                        <input type="text" placeholder="{{__('frontend.business-details.reviews.field2')}}*" value=""/>
                    </div>
                    <div class="col-md-6">
                        <label><i class="fa fa-envelope-o"></i> </label>
                        <input type="text" placeholder="{{__('frontend.business-details.reviews.field3')}}*" value=""/>
                    </div>
                </div>
                <textarea cols="40" rows="3"
                          placeholder="{{__('frontend.business-details.reviews.field4')}}:"></textarea>
            </fieldset>
            <button type="button"
                    class="btn  big-btn btn--custom">{{__('frontend.business-details.reviews.button')}} <i
                    class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
        </form>
    </div>

</div>
