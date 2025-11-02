@if( isset($dataManagerPage['business']['addManagerUser']))
    <div class="box-widget-item fl-wrap">
        <div class="box-widget-item-header">
            <h3>Book a Season Ticket : </h3>
        </div>
        <div class="box-widget opening-hours">
            <div class="box-widget-content">
                <form class="add-comment custom-form">
                    <fieldset>
                        <label><i class="fa fa-user-o"></i></label>
                        <input type="text" placeholder="Your Name *" value=""/>
                        <div class="clearfix"></div>
                        <label><i class="fa fa-envelope-o"></i> </label>
                        <input type="text" placeholder="Email Address*" value=""/>
                        <label><i class="fa fa-phone"></i> </label>
                        <input type="text" placeholder="Phone*" value=""/>
                        <div class="quantity fl-wrap">
                            <span><i class="fa fa-user-plus"></i>Persons : </span>
                            <div class="quantity-item">
                                <input type="button" value="-" class="minus">
                                <input type="text" name="quantity" title="Qty" class="qty" min="1"
                                       max="3" step="1" value="1">
                                <input type="button" value="+" class="plus">
                            </div>
                        </div>
                        <select data-placeholder="Ticket Type" class="chosen-select">
                            <option value="Ticket Type">Ticket Type</option>
                            <option value="Standard Pass">Standard Pass</option>
                            <option value="Silver Pass">Silver Pass</option>
                            <option value="Gold Pass">Gold Pass</option>
                            <option value="Platinum Pass">Platinum Pass</option>
                        </select>
                        <textarea cols="40" rows="3" placeholder="Additional Information:"></textarea>
                    </fieldset>
                    <button class="btn  big-btn  color-bg flat-btn book-btn">Book Now<i
                            class="fa fa-angle-right"></i></button>
                </form>
            </div>
        </div>
    </div>
@endif
