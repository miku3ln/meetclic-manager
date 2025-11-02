<!-- Log In & Verify & Successfull Modal -->
<div class="modal fade" id="login" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-white border-0 overflow-hidden rounded-4">
            <div class="modal-body p-0">
                <div class="row g-0">
                    <div class="col-lg-4 d-none d-lg-block">
                        <div
                            class="p-4 d-flex bg-warning-subtle align-items-center flex-column text-center gap-4 justify-content-center h-100">
                            <img src="{{ $logoSrc}}" alt=""
                                 class="img-fluid mb-auto px-4">
                            <div>
                                <h5 class="fw-bold">Welcome to Eatpura</h5>
                                <p class="m-0">Download the app get free food &amp; <span
                                        class="fw-bold text-success">$50</span> off on your first order.</p>
                            </div>
                            <a href="#" class="btn btn-sm w-100 btn-warning mt-auto rounded-pill">Download
                                App</a>
                        </div>
                    </div>
                    <div class="col-lg-8 p-4">
                        <button type="button" class="btn-close float-end shadow-none" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        <div class="mb-4 pe-5">
                            <h6 class="fw-bold text-danger mb-1">Phone Number Verification</h6>
                        </div>
                        <form>
                            <div class="text-start">
                                <p class="lh-base pb-2 text-muted fs-6 mb-1">Enter your phone number to
                                    Login/Sign
                                    up</p>
                                <div class="input-group bg-white shadow-sm rounded-3 border py-2 mb-4">
                                    <a href="#"
                                       class="input-group-text bg-transparent border-0 rounded-0 text-black px-3"><i
                                            class="lni lni-mobile me-1"></i> +91</a>
                                    <input type="number"
                                           class="form-control bg-transparent border-0 rounded-0 ps-0"
                                           placeholder="Type your number" value="">
                                </div>
                                <a href="#" class="btn btn-danger fw-bold py-3 px-4 w-100 rounded-4 shadow"
                                   data-bs-target="#verify" data-bs-toggle="modal">Next</a>
                                <div class="mt-3">
                                    <p class="text-muted mb-1">By continuing, you agree to our</p>
                                    <span class="small">
                                    <a href="#" class="text-decoration-underline me-2">Terms of service</a>
                                    <a href="#" class="text-decoration-underline ">Privacy Policy</a>
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Verify -->
<div class="modal fade" id="verify" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-white border-0 overflow-hidden rounded-4">
            <div class="modal-body p-0">
                <div class="row g-0">
                    <div class="col-lg-4 d-none d-lg-block">
                        <div
                            class="p-4 d-flex bg-warning-subtle align-items-center flex-column text-center gap-4 justify-content-center h-100">
                            <img src="{{ $logoSrc}}" alt=""
                                 class="img-fluid mb-auto px-4">
                            <div>
                                <h5 class="fw-bold">Welcome to Eatpura</h5>
                                <p class="m-0">Download the app get free food &amp; <span
                                        class="fw-bold text-success">$50</span> off on your first order.</p>
                            </div>
                            <a href="#" class="btn btn-sm w-100 btn-warning mt-auto rounded-pill">Download
                                App</a>
                        </div>
                    </div>
                    <div class="col-lg-8 p-4">
                        <div class="mb-4">
                            <h6 class="fw-bold d-flex align-items-center text-danger mb-1"><a class="me-3"
                                                                                              href="#"
                                                                                              data-bs-target="#login"
                                                                                              data-bs-toggle="modal"><i
                                        class="lni lni-arrow-left fs-5 d-flex"></i></a> Phone Number
                                Verification
                            </h6>
                        </div>
                        <form>
                            <div class="text-start">
                                <p class="lh-base pb-2 text-muted fs-6 mb-1">Enter 4 digit code sent to your
                                    phone<br>+91-+91 1234 567890</p>
                                <div class="row mb-4">
                                    <div class="col-3">
                                        <input type="text"
                                               class="form-control text-center bg-white shadow-sm rounded-3 border py-2 fs-4"
                                               value="5" maxlength="1">
                                    </div>
                                    <div class="col-3">
                                        <input type="text"
                                               class="form-control text-center bg-white shadow-sm rounded-3 border py-2 fs-4"
                                               value="2" maxlength="1">
                                    </div>
                                    <div class="col-3">
                                        <input type="text"
                                               class="form-control text-center bg-white shadow-sm rounded-3 border py-2 fs-4"
                                               value="8" maxlength="1">
                                    </div>
                                    <div class="col-3">
                                        <input type="text"
                                               class="form-control text-center bg-white shadow-sm rounded-3 border py-2 fs-4"
                                               value="1" maxlength="1">
                                    </div>
                                </div>
                                <a href="#" class="btn btn-danger fw-bold py-3 px-4 w-100 rounded-4 shadow"
                                   data-bs-toggle="modal" data-bs-target="#successfull">Next</a>
                                <div class="mt-3">
                                    <span class="small d-flex justify-content-between">
                                    <a href="#" class="text-decoration-underline me-2">Resend Code</a>
                                    <small class="text-muted">Resend Code (in <b id="timer">60</b> secs)</small>
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Success full login Modal-->
<div class="modal fade" id="successfull" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-white border-0 overflow-hidden rounded-4">
            <div class="modal-body border-0 rounded-3 text-center p-5">
                <img src="{{ URL::asset($themePath.'')}}/img/successfull.png" alt="" class="img-fluid w-25">
                <p class="fw-bold text-danger mb-0 mt-4">Welcome to Eatpura</p>
                <h5 class="text-success mb-3 mt-1">Your Login is Successfull</h5>
                <p class="mb-4">Download the app get free food &amp; <span
                        class="fw-bold text-success">$50</span>
                    off on your first order.</p>
                <a href="listing.html" class="btn fw-bold py-2 px-4 btn-danger mt-auto rounded-pill">Shop
                    Now</a>
            </div>
        </div>
    </div>
</div>
<!-- My Cart Offcanvas -->
<div class="offcanvas offcanvas-end my-cart-width" tabindex="-1" id="mycart">
    <div class="offcanvas-header px-4 py-3">
        <h5 class="offcanvas-title fw-bold"><?php echo "{{cartManager.title}}" ?></h5>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
        <div class="bg-light px-4 py-3">
            <h6 class="fw-bold mb-1 not-view">Delivery in 10 minutes</h6>
            <p class="text-muted m-0"> <?php echo "{{dataManagerProductsShopCart.data.length}}" ?> <?php echo "{{cartManager.result.one}}" ?> </p>
        </div>
        <!-- 1st product -->
        <div v-if="dataManagerProductsShopCart.data.length>0" class="px-4 py-3"
             v-for="(product, index) in dataManagerProductsShopCart.data" :key="product.id">
            <div class="row">
                <div class="col-3">
                    <img :src="getUrlResource(product['source'])" alt=""
                         class="img-fluid border rounded-4">
                </div>
                <div class="col-9">
                    <h6 class="fw-bold mb-1"><?php echo "{{product.name}}({{ product.code }})" ?></h6>
                    <p class="text-muted"><?php echo "{{product.description}}" ?></p>
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="fw-bold m-0">
                            <del class="text-muted small fw-normal not-view">$55</del>
                            <br>$<?php echo "{{product.sale_price}}" ?>
                        </h6>
                        <div class="input-group border rounded overflow-hidden value">
                            <input type="button"
                                   @click="onManagerProductByModalCart({type:3,row:product })"
                                   value="-"
                                   class="button-minus btn btn-light btn-sm border-end col"
                                   data-field="quantity">
                            <input type="number"
                                   v-model="product.count"
                                   name="quantity"
                                   :id="'quantity_amountSale_' + product.id"
                                   :name="'quantity_amountSale_' + product.id + ''"
                                   class="quantity-field form-control form-control-sm col text-center shadow-none border-0">
                            <input type="button"
                                   @click="onManagerProductByModalCart({type:4,row:product })"
                                   value="+"
                                   class="button-plus btn btn-light btn-sm border-start col"
                                   data-field="quantity">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="dataManagerProductsShopCart.data.length==0" class="px-4 py-3">
            <h1><?php echo "{{cartManager.empty}}" ?></h1>
        </div>

    </div>
    <div class="offcanvas-footer p-4" v-if="dataManagerProductsShopCart.data.length>0">
        <a href="#"
           class="btn btn-danger fw-bold d-flex align-items-center justify-content-between py-3 px-4 w-100 rounded-4 shadow"
           data-bs-toggle="offcanvas" data-bs-target="#myaddress"
           aria-controls="myaddress"> <?php echo "{{dataManagerProductsShopCart.data.length}}" ?> <?php echo "{{cartManager.result.one}}" ?> &#183;
            <?php echo "{{cartManager.result.two}}" ?><?php echo "{{dataManagerProductsShopCart.result.total}}" ?>
            <span class="text-uppercase"><?php echo "{{cartManager.toDo}}" ?><i class="icofont-double-right ms-1"></i></span>
        </a>
    </div>
</div>
<div class="offcanvas offcanvas-end my-cart-width" tabindex="-1" id="myaddress">
    <div class="offcanvas-header px-4 py-3">
        <h5 class="offcanvas-title fw-bold" id="myaddressLabel"><?php echo "{{addressManager.title}}" ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
        <div class="bg-light">
            <a href="#"
               class="link-dark py-3 px-4 osahan-location text-decoration-none d-flex align-items-center gap-3 text-start flex-shrink-0"
               data-bs-toggle="modal" data-bs-target="#addaddress">
                <i class="lni lni-circle-plus text-danger fs-4"></i>
                <div class="lh-sm">
                    <h6 class="fw-bold mb-0"><?php echo "{{addressManager.addNew}}" ?></h6>
                    <small class="text-muted mb-0 align-bottom small">Ludhiana, Punjab, India</small>
                </div>
            </a>
        </div>
        <div class="py-3 px-4">
            <p class="text-muted m-0"><?php echo "{{addressManager.subTitle}}" ?></p>
        </div>
        <div class="px-4 py-2 bg-light">
            <div
                class="form-check osahan-radio-box-action osahan-radio-box w-100 bg-white border p-3 my-3 rounded-4">
                <input class="form-check-input" type="radio" name="aaflexRadioDefault" id="aaflexRadioDefault1">
                <label class="form-check-label" for="aaflexRadioDefault1"></label>
                <div class="osahan-radio-box-inner">
                    <div class="d-flex align-items-center justify-content-between bg-white">
                        <div class="w-75">
                            <div class="d-flex align-items-center gap-3 osahan-mb-1">
                                <i class="lni lni-home text-muted fs-5"></i>
                                <div class="pe-4 overflow-hidden">
                                    <h6 class="fw-bold mb-1">Mr David - <span class="fw-light small">Home</span>
                                    </h6>
                                    <p class="text-muted text-truncate mb-0 small">H.No. 2834 Street, 784
                                        Sector,
                                        Ludhiana, Punjab</p>
                                </div>
                            </div>
                        </div>
                        <div class="ms-auto gap-2 mt-auto text-center small">
                            <a href="#" class="small d-flex align-items-center gap-1" data-bs-toggle="modal"
                               data-bs-target="#addaddress"><i class="lni lni-pencil-alt d-flex"></i>Edit</a>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="form-check osahan-radio-box-action osahan-radio-box w-100 bg-white border p-3 my-3 rounded-4">
                <input class="form-check-input" type="radio" name="aaflexRadioDefault" id="aaflexRadioDefault2"
                       checked>
                <label class="form-check-label" for="aaflexRadioDefault2"></label>
                <div class="osahan-radio-box-inner">
                    <div class="d-flex align-items-center justify-content-between bg-white">
                        <div class="w-75">
                            <div class="d-flex align-items-center gap-3 osahan-mb-1">
                                <i class="lni lni-briefcase text-muted fs-5"></i>
                                <div class="pe-4 overflow-hidden">
                                    <h6 class="fw-bold mb-1">Black Smith - <span
                                            class="fw-light small">Office</span></h6>
                                    <p class="text-muted text-truncate mb-0 small">9878, 784 Sector, Ludhiana,
                                        Punjab</p>
                                </div>
                            </div>
                        </div>
                        <div class="ms-auto gap-2 mt-auto text-center small">
                            <a href="#" class="small d-flex align-items-center gap-1" data-bs-toggle="modal"
                               data-bs-target="#addaddress"><i class="lni lni-pencil-alt d-flex"></i>Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer p-4">
        <a href="#" class="btn btn-danger fw-bold py-3 px-4 w-100 rounded-4 shadow" data-bs-toggle="offcanvas"
           data-bs-target="#mycardwithaddress" aria-controls="mycardwithaddress"><?php echo "{{addressManager.toDo}}" ?></a>
    </div>
</div>
<div class="offcanvas offcanvas-end my-cart-width" tabindex="-1" id="mycardwithaddress"
>
    <div class="offcanvas-header px-4 py-3">
        <h5 class="offcanvas-title fw-bold"><?php echo "{{cartManagerAddress.title}}" ?></h5>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
        <div class="bg-light px-4 py-3">
            <h6 class="fw-bold mb-1 not-view">Delivery in 10 minutes</h6>
            <p class="text-muted m-0"><?php echo "{{dataManagerProductsShopCart.data.length}}" ?> <?php echo "{{cartManagerAddress.result.one}}" ?></p>
        </div>
        <div v-if="dataManagerProductsShopCart.data.length>0" class="px-4 py-3"
             v-for="(product, index) in dataManagerProductsShopCart.data" :key="product.id">
            <div class="row">
                <div class="col-3">
                    <img :src="getUrlResource(product['source'])" alt=""
                         class="img-fluid border rounded-4">
                </div>
                <div class="col-9">
                    <h6 class="fw-bold mb-1"><?php echo "{{product.name}}({{ product.code }})" ?></h6>
                    <p class="text-muted"><?php echo "{{product.description}}" ?></p>
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="fw-bold m-0">
                            <del class="text-muted small fw-normal not-view">$55</del>
                            <br>$<?php echo "{{product.sale_price}}" ?>
                        </h6>
                        <div class="input-group border rounded overflow-hidden value">
                            <input type="button"
                                   @click="onManagerProductByModalCart({type:3,row:product })"
                                   value="-"
                                   class="button-minus btn btn-light btn-sm border-end col"
                                   data-field="quantity">
                            <input type="number"
                                   v-model="product.count"
                                   name="quantity"
                                   :id="'quantity_amountSale_' + product.id"
                                   :name="'quantity_amountSale_' + product.id + ''"
                                   class="quantity-field form-control form-control-sm col text-center shadow-none border-0">
                            <input type="button"
                                   @click="onManagerProductByModalCart({type:4,row:product })"
                                   value="+"
                                   class="button-plus btn btn-light btn-sm border-start col"
                                   data-field="quantity">
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="p-4 bg-light">
            <div class="d-flex align-items-center justify-content-between mb-1 not-view">
                <p class="text-muted m-0">MRP</p>
                <p class="m-0">$<?php echo "{{dataManagerProductsShopCart.result.total}}" ?></p>
            </div>
            <div class="d-flex align-items-center justify-content-between mb-1 not-view">
                <p class="text-muted m-0">Product Discount</p>
                <p class="m-0">$20.00</p>
            </div>
            <div class="d-flex align-items-center justify-content-between mb-3 not-view">
                <p class="text-muted m-0">Delivery Charges</p>
                <p class="text-info m-0">$60.00</p>
            </div>
            <div class="d-flex align-items-center justify-content-between">
                <h6 class="fw-bold m-0"><?php echo "{{cartManagerAddress.result.four}}" ?></h6>
                <p class="fw-bold text-danger m-0">
                    $<?php echo "{{dataManagerProductsShopCart.result.total}}" ?></p>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer border-top p-4">
        <div class="d-flex align-items-center gap-3 pb-3">
            <i class="lni lni-home fs-4"></i>
            <div>
                <h6 class="fw-bold mb-1">Delivering to home</h6>
                <p class="text-muted small m-0">1st Block 1st Cross, Punjab</p>
            </div>
            <a href="#" data-bs-toggle="offcanvas" data-bs-target="#myaddress" aria-controls="myaddress"
               class="ms-auto"> <?php echo "{{cartManagerAddress.result.three}}" ?></a>
        </div>
        <a href="{{route('checkoutPage', app()->getLocale())}}"
           class="btn btn-danger fw-bold d-flex align-items-center justify-content-between py-3 px-4 w-100 rounded-4 shadow">

            <?php echo "{{dataManagerProductsShopCart.data.length}}" ?>
            <?php echo "{{cartManagerAddress.result.one}}" ?> &#183;  <?php echo "{{cartManagerAddress.result.two}}" ?><?php echo "{{dataManagerProductsShopCart.result.total}}" ?> <span>
                <?php echo "{{cartManagerAddress.toDo}}" ?>

                <i
                    class="icofont-double-right ms-1"></i></span>
        </a>
    </div>
</div>
