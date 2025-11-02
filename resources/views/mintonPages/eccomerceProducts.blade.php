<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
$assetsTemplate='templates/minton/';

?>

@extends('layouts.masterMinton')

@section('css')

    <link href="{{ asset($resourcePathServer.$assetsTemplate."assets/libs/dropzone/min/dropzone.min.css")}}" rel="stylesheet"
          type="text/css"/>

    <link href="{{ asset($resourcePathServer.$assetsTemplate."assets/libs/quill/quill.core.css")}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset($resourcePathServer.$assetsTemplate."assets/libs/quill/quill.snow.css")}}" rel="stylesheet"
          type="text/css"/>

    <link href="{{ asset($resourcePathServer.$assetsTemplate."assets/css/icons.min.css")}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset($resourcePathServer.$assetsTemplate."assets/css/all-manager.css")}}" rel="stylesheet"
          type="text/css"/>


@endsection
@section('breadcrumb')
    @include('partials.breadcrumb',[
      'pageTitle'=>'Eccomerce Products',
           'menuName'=>'Inicio',

      ])
@endsection
@section('content')
    <div id="app-management">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <div id="addproduct-nav-pills-wizard" class="twitter-bs-wizard form-wizard-header">
                            <ul class="twitter-bs-wizard-nav mb-2">
                                <li class="nav-item">
                                    <a href="#general-info" class="nav-link" data-bs-toggle="tab"
                                       data-toggle="tab">
                                        <span class="number">01</span>
                                        <span class="d-none d-sm-inline">General</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#product-img" class="nav-link" data-bs-toggle="tab"
                                       data-toggle="tab">
                                        <span class="number">02</span>
                                        <span class="d-none d-sm-inline">Product Images</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="#metadata" class="nav-link" data-bs-toggle="tab" data-toggle="tab">
                                        <span class="number">03</span>
                                        <span class="d-none d-sm-inline">Meta Data</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content twitter-bs-wizard-tab-content">
                                <div class="tab-pane" id="general-info">
                                    <h4 class="header-title">General Information</h4>
                                    <p class="sub-header">Fill all information below</p>

                                    <div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="product-name" class="form-label">Product Name
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" id="product-name" class="form-control"
                                                           placeholder="e.g : Apple iMac">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="product-reference" class="form-label">Reference
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" id="product-reference"
                                                           class="form-control" placeholder="e.g : Apple iMac">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="product-description" class="form-label">Product
                                                Description <span class="text-danger">*</span></label>
                                            <div id="snow-editor" style="height: 200px;"></div>
                                            <!-- end Snow-editor-->
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="product-summary" class="form-label">Product
                                                        Summary</label>
                                                    <textarea class="form-control" id="product-summary" rows="5"
                                                              placeholder="Please enter summary"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="product-category" class="form-label">Categories
                                                        <span class="text-danger">*</span></label>
                                                    <select class="form-control select2" id="product-category">
                                                        <option>Select</option>
                                                        <optgroup label="Shopping">
                                                            <option value="SH1">Shopping 1</option>
                                                            <option value="SH2">Shopping 2</option>
                                                            <option value="SH3">Shopping 3</option>
                                                            <option value="SH4">Shopping 4</option>
                                                        </optgroup>
                                                        <optgroup label="CRM">
                                                            <option value="CRM1">Crm 1</option>
                                                            <option value="CRM2">Crm 2</option>
                                                            <option value="CRM3">Crm 3</option>
                                                            <option value="CRM4">Crm 4</option>
                                                        </optgroup>
                                                        <optgroup label="eCommerce">
                                                            <option value="E1">eCommerce 1</option>
                                                            <option value="E2">eCommerce 2</option>
                                                            <option value="E3">eCommerce 3</option>
                                                            <option value="E4">eCommerce 4</option>
                                                        </optgroup>

                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="product-price" class="form-label">Price <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="product-price"
                                                           placeholder="Enter amount">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="mb-2">Status <span
                                                    class="text-danger">*</span></label>
                                            <br/>
                                            <div class="radio form-check-inline">
                                                <input type="radio" id="inlineRadio1" value="option1"
                                                       name="radioInline" checked="">
                                                <label for="inlineRadio1"> Online </label>
                                            </div>
                                            <div class="radio form-check-inline">
                                                <input type="radio" id="inlineRadio2" value="option2"
                                                       name="radioInline">
                                                <label for="inlineRadio2"> Offline </label>
                                            </div>
                                            <div class="radio form-check-inline">
                                                <input type="radio" id="inlineRadio3" value="option3"
                                                       name="radioInline">
                                                <label for="inlineRadio3"> Draft </label>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="form-label">Comment</label>
                                            <textarea class="form-control" rows="3"
                                                      placeholder="Please enter comment"></textarea>
                                        </div>
                                    </div>

                                    <ul class="pager wizard mb-0 list-inline text-end mt-3">
                                        <li class="next list-inline-item">
                                            <button type="button" class="btn btn-success">Add More Info <i
                                                    class="mdi mdi-arrow-right ms-1"></i></button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-pane" id="product-img">
                                    <h4 class="header-title">Product Images</h4>
                                    <p class="sub-header">Upload product image</p>

                                    <form action="/" method="post" class="dropzone" id="myAwesomeDropzone"
                                          data-plugin="dropzone" data-previews-container="#file-previews"
                                          data-upload-preview-template="#uploadPreviewTemplate">
                                        <div class="fallback">
                                            <input name="file" type="file" multiple/>
                                        </div>

                                        <div class="dz-message needsclick">
                                            <div class="mb-3">
                                                <i class="h1 text-muted ri-upload-cloud-2-line"></i>
                                            </div>
                                            <h3>Drop files here or click to upload.</h3>
                                            <span class="text-muted font-13">(This is just a demo dropzone. Selected files are
                                                                <strong>not</strong> actually uploaded.)</span>
                                        </div>
                                    </form>

                                    <!-- Preview -->
                                    <div class="dropzone-previews mt-3" id="file-previews"></div>

                                    <ul class="pager wizard mb-0 list-inline text-end mt-3">
                                        <li class="previous list-inline-item">
                                            <button type="button" class="btn btn-secondary"><i
                                                    class="mdi mdi-arrow-left"></i> Back to General
                                            </button>
                                        </li>
                                        <li class="next list-inline-item">
                                            <button type="button" class="btn btn-success">Add Meta Data <i
                                                    class="mdi mdi-arrow-right ms-1"></i></button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-pane" id="metadata">
                                    <h4 class="header-title">Meta Data</h4>
                                    <p class="sub-header">Fill all information below</p>

                                    <form>
                                        <div class="mb-3">
                                            <label for="product-meta-title" class="form-label">Meta
                                                title</label>
                                            <input type="text" class="form-control" id="product-meta-title"
                                                   placeholder="Enter title">
                                        </div>

                                        <div class="mb-3">
                                            <label for="product-meta-keywords" class="form-label">Meta
                                                Keywords</label>
                                            <input type="text" class="form-control" id="product-meta-keywords"
                                                   placeholder="Enter keywords">
                                        </div>

                                        <div>
                                            <label for="product-meta-description" class="form-label">Meta
                                                Description </label>
                                            <textarea class="form-control" rows="5"
                                                      id="product-meta-description"
                                                      placeholder="Please enter description"></textarea>
                                        </div>
                                    </form>

                                    <ul class="pager wizard mb-0 list-inline text-end mt-3">
                                        <li class="previous list-inline-item">
                                            <button type="button" class="btn btn-secondary"><i
                                                    class="mdi mdi-arrow-left"></i> Edit Information
                                            </button>
                                        </li>
                                        <li class="list-inline-item">
                                            <button type="submit" class="btn btn-success">Publish Product <i
                                                    class="mdi mdi-arrow-right ms-1"></i></button>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <a href="ecommerce-product-create.html" class="btn btn-danger mb-2"><i
                                        class="mdi mdi-plus-circle me-1"></i> Add Products</a>
                            </div>
                            <div class="col-sm-6">
                                <div class="float-sm-end">

                                    <button type="button" class="btn btn-success mb-2 mb-sm-0"><i
                                            class="mdi mdi-cog"></i></button>

                                </div>
                            </div><!-- end col-->
                        </div>
                        <!-- end row -->

                        <div class="table-responsive">
                            <table class="table table-centered w-100 dt-responsive nowrap"
                                   id="products-datatable"
                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="table-light">
                                <tr>
                                    <th class="all" style="width: 20px;">
                                        <div class="form-check font-16 mb-0">
                                            <input class="form-check-input" type="checkbox"
                                                   id="productlistCheck">
                                            <label class="form-check-label"
                                                   for="productlistCheck">&nbsp;</label>
                                        </div>
                                    </th>
                                    <th class="all">Product</th>
                                    <th>Rating</th>
                                    <th>Category</th>
                                    <th>Added Date</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th style="width: 85px;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="form-check font-16 mb-0">
                                            <input class="form-check-input" type="checkbox"
                                                   id="productlistCheck1">
                                            <label class="form-check-label"
                                                   for="productlistCheck1">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td id="image-current">
                                        <img src="{{ asset($resourcePathServer.$assetsTemplate) }}/assets/images/products/product-1.png" alt="contact-img"
                                             title="contact-img" class="rounded me-3" height="48"/>

                                        <h5 class="m-0 d-inline-block align-middle"><a href="#"
                                                                                       class="text-dark">Blue
                                                color T-shirt</a></h5>
                                    </td>
                                    <td>
                                        <span class="badge bg-success"><i class="mdi mdi-star"></i> 4.9</span>
                                    </td>
                                    <td>
                                        T-shirt
                                    </td>
                                    <td>
                                        09 Mar, 2020
                                    </td>
                                    <td>
                                        <div>
                                            $ 32
                                        </div>
                                    </td>

                                    <td>
                                        112
                                    </td>
                                    <td>
                                        <span class="badge badge-soft-success">Active</span>
                                    </td>

                                    <td>
                                        <ul class="list-inline table-action m-0">
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-eye"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-square-edit-outline"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-delete"></i></a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check font-16 mb-0">
                                            <input class="form-check-input" type="checkbox"
                                                   id="productlistCheck2">
                                            <label class="form-check-label"
                                                   for="productlistCheck2">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>
                                        <img src="{{ asset($resourcePathServer.$assetsTemplate) }}/assets/images/products/product-2.png" alt="contact-img"
                                             title="contact-img" class="rounded me-3" height="48"/>

                                        <h5 class="m-0 d-inline-block align-middle"><a href="#"
                                                                                       class="text-dark">Half
                                                sleeve maroon T-shirt</a></h5>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning"><i class="mdi mdi-star"></i> 3.1</span>
                                    </td>
                                    <td>
                                        T-shirt
                                    </td>
                                    <td>
                                        05 Mar, 2020
                                    </td>
                                    <td>
                                        <div>
                                            $ 33
                                        </div>
                                    </td>

                                    <td>
                                        60
                                    </td>
                                    <td>
                                        <span class="badge badge-soft-success">Active</span>
                                    </td>

                                    <td>
                                        <ul class="list-inline table-action m-0">
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-eye"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-square-edit-outline"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-delete"></i></a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check font-16 mb-0">
                                            <input class="form-check-input" type="checkbox"
                                                   id="productlistCheck3">
                                            <label class="form-check-label"
                                                   for="productlistCheck3">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>
                                        <img src="{{ asset($resourcePathServer.$assetsTemplate) }}/assets/images/products/product-3.png" alt="contact-img"
                                             title="contact-img" class="rounded me-3" height="48"/>

                                        <h5 class="m-0 d-inline-block align-middle"><a href="#"
                                                                                       class="text-dark">Cream
                                                color T-shirt</a></h5>
                                    </td>
                                    <td>
                                        <span class="badge bg-success"><i class="mdi mdi-star"></i> 4.3</span>
                                    </td>
                                    <td>
                                        T-shirt
                                    </td>
                                    <td>
                                        02 Mar, 2020
                                    </td>
                                    <td>
                                        <div>
                                            $ 33
                                        </div>
                                    </td>

                                    <td>
                                        58
                                    </td>
                                    <td>
                                        <span class="badge badge-soft-danger">Deactive</span>
                                    </td>

                                    <td>
                                        <ul class="list-inline table-action m-0">
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-eye"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-square-edit-outline"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-delete"></i></a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check font-16 mb-0">
                                            <input class="form-check-input" type="checkbox"
                                                   id="productlistCheck4">
                                            <label class="form-check-label"
                                                   for="productlistCheck4">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>
                                        <img src="{{ asset($resourcePathServer.$assetsTemplate) }}/assets/images/products/product-4.png" alt="contact-img"
                                             title="contact-img" class="rounded me-3" height="48"/>

                                        <h5 class="m-0 d-inline-block align-middle"><a href="#"
                                                                                       class="text-dark">Blue
                                                color T-shirt</a></h5>
                                    </td>
                                    <td>
                                        <span class="badge bg-success"><i class="mdi mdi-star"></i> 4.9</span>
                                    </td>
                                    <td>
                                        T-shirt
                                    </td>
                                    <td>
                                        27 Feb, 2020
                                    </td>
                                    <td>
                                        <div>
                                            $ 34
                                        </div>
                                    </td>

                                    <td>
                                        98
                                    </td>
                                    <td>
                                        <span class="badge badge-soft-success">Active</span>
                                    </td>

                                    <td>
                                        <ul class="list-inline table-action m-0">
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-eye"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-square-edit-outline"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-delete"></i></a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check font-16 mb-0">
                                            <input class="form-check-input" type="checkbox"
                                                   id="productlistCheck5">
                                            <label class="form-check-label"
                                                   for="productlistCheck5">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>
                                        <img src="{{ asset($resourcePathServer.$assetsTemplate) }}/assets/images/products/product-5.png" alt="contact-img"
                                             title="contact-img" class="rounded me-3" height="48"/>

                                        <h5 class="m-0 d-inline-block align-middle"><a href="#"
                                                                                       class="text-dark">Half
                                                sleeve T-shirt</a></h5>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger"><i class="mdi mdi-star"></i> 2.5</span>
                                    </td>
                                    <td>
                                        T-shirt
                                    </td>
                                    <td>
                                        23 Feb, 2020
                                    </td>
                                    <td>
                                        <div>
                                            $ 35
                                        </div>
                                    </td>

                                    <td>
                                        85
                                    </td>
                                    <td>
                                        <span class="badge badge-soft-danger">Deactive</span>
                                    </td>

                                    <td>
                                        <ul class="list-inline table-action m-0">
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-eye"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-square-edit-outline"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-delete"></i></a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check font-16 mb-0">
                                            <input class="form-check-input" type="checkbox"
                                                   id="productlistCheck6">
                                            <label class="form-check-label"
                                                   for="productlistCheck6">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>
                                        <img src="{{ asset($resourcePathServer.$assetsTemplate) }}/assets/images/products/product-6.png" alt="contact-img"
                                             title="contact-img" class="rounded me-3" height="48"/>

                                        <h5 class="m-0 d-inline-block align-middle"><a href="#"
                                                                                       class="text-dark">Blue
                                                Hoodie for men</a></h5>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning"><i class="mdi mdi-star"></i> 3.4</span>
                                    </td>
                                    <td>
                                        T-shirt
                                    </td>
                                    <td>
                                        21 Feb, 2020
                                    </td>
                                    <td>
                                        <div>
                                            $ 36
                                        </div>
                                    </td>

                                    <td>
                                        88
                                    </td>
                                    <td>
                                        <span class="badge badge-soft-success">Active</span>
                                    </td>

                                    <td>
                                        <ul class="list-inline table-action m-0">
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-eye"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-square-edit-outline"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-delete"></i></a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check font-16 mb-0">
                                            <input class="form-check-input" type="checkbox"
                                                   id="productlistCheck7">
                                            <label class="form-check-label"
                                                   for="productlistCheck7">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>
                                        <img src="{{ asset($resourcePathServer.$assetsTemplate) }}/assets/images/products/product-7.png" alt="contact-img"
                                             title="contact-img" class="rounded me-3" height="48"/>

                                        <h5 class="m-0 d-inline-block align-middle"><a href="#"
                                                                                       class="text-dark">Vneck
                                                green T-shirt</a></h5>
                                    </td>
                                    <td>
                                        <span class="badge bg-success"><i class="mdi mdi-star"></i> 4.5</span>
                                    </td>
                                    <td>
                                        T-shirt
                                    </td>
                                    <td>
                                        19 Feb, 2020
                                    </td>
                                    <td>
                                        <div>
                                            $ 37
                                        </div>
                                    </td>

                                    <td>
                                        82
                                    </td>
                                    <td>
                                        <span class="badge badge-soft-success">Active</span>
                                    </td>

                                    <td>
                                        <ul class="list-inline table-action m-0">
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-eye"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-square-edit-outline"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-delete"></i></a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check font-16 mb-0">
                                            <input class="form-check-input" type="checkbox"
                                                   id="productlistCheck8">
                                            <label class="form-check-label"
                                                   for="productlistCheck8">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>
                                        <img src="{{ asset($resourcePathServer.$assetsTemplate) }}/assets/images/products/product-8.png" alt="contact-img"
                                             title="contact-img" class="rounded me-3" height="48"/>

                                        <h5 class="m-0 d-inline-block align-middle"><a href="#"
                                                                                       class="text-dark">Full
                                                sleeve Pink T-shirt</a></h5>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger"><i class="mdi mdi-star"></i> 2.4</span>
                                    </td>
                                    <td>
                                        T-shirt
                                    </td>
                                    <td>
                                        15 Feb, 2020
                                    </td>
                                    <td>
                                        <div>
                                            $ 38
                                        </div>
                                    </td>

                                    <td>
                                        54
                                    </td>
                                    <td>
                                        <span class="badge badge-soft-success">Active</span>
                                    </td>

                                    <td>
                                        <ul class="list-inline table-action m-0">
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-eye"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-square-edit-outline"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-delete"></i></a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check font-16 mb-0">
                                            <input class="form-check-input" type="checkbox"
                                                   id="productlistCheck9">
                                            <label class="form-check-label"
                                                   for="productlistCheck9">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>
                                        <img src="{{ asset($resourcePathServer.$assetsTemplate) }}/assets/images/products/product-1.png" alt="contact-img"
                                             title="contact-img" class="rounded me-3" height="48"/>

                                        <h5 class="m-0 d-inline-block align-middle"><a href="#"
                                                                                       class="text-dark">Blue
                                                color T-shirt</a></h5>
                                    </td>
                                    <td>
                                        <span class="badge bg-success"><i class="mdi mdi-star"></i> 4.3</span>
                                    </td>
                                    <td>
                                        T-shirt
                                    </td>
                                    <td>
                                        15 Feb, 2020
                                    </td>
                                    <td>
                                        <div>
                                            $ 38
                                        </div>
                                    </td>

                                    <td>
                                        60
                                    </td>
                                    <td>
                                        <span class="badge badge-soft-success">Active</span>
                                    </td>

                                    <td>
                                        <ul class="list-inline table-action m-0">
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-eye"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-square-edit-outline"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-delete"></i></a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check font-16 mb-0">
                                            <input class="form-check-input" type="checkbox"
                                                   id="productlistCheck10">
                                            <label class="form-check-label"
                                                   for="productlistCheck10">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>
                                        <img src="{{ asset($resourcePathServer.$assetsTemplate) }}/assets/images/products/product-2.png" alt="contact-img"
                                             title="contact-img" class="rounded me-3" height="48"/>

                                        <h5 class="m-0 d-inline-block align-middle"><a href="#"
                                                                                       class="text-dark">Half
                                                sleeve maroon T-shirt</a></h5>
                                    </td>
                                    <td>
                                        <span class="badge bg-success"><i class="mdi mdi-star"></i> 4.0</span>
                                    </td>
                                    <td>
                                        T-shirt
                                    </td>
                                    <td>
                                        13 Feb, 2020
                                    </td>
                                    <td>
                                        <div>
                                            $ 45
                                        </div>
                                    </td>

                                    <td>
                                        32
                                    </td>
                                    <td>
                                        <span class="badge badge-soft-danger">Deactive</span>
                                    </td>

                                    <td>
                                        <ul class="list-inline table-action m-0">
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-eye"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-square-edit-outline"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-delete"></i></a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check font-16 mb-0">
                                            <input class="form-check-input" type="checkbox"
                                                   id="productlistCheck11">
                                            <label class="form-check-label"
                                                   for="productlistCheck11">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>
                                        <img src="{{ asset($resourcePathServer.$assetsTemplate) }}/assets/images/products/product-3.png" alt="contact-img"
                                             title="contact-img" class="rounded me-3" height="48"/>

                                        <h5 class="m-0 d-inline-block align-middle"><a href="#"
                                                                                       class="text-dark">Cream
                                                color T-shirt</a></h5>
                                    </td>
                                    <td>
                                        <span class="badge bg-success"><i class="mdi mdi-star"></i> 4.2</span>
                                    </td>
                                    <td>
                                        T-shirt
                                    </td>
                                    <td>
                                        12 Feb, 2020
                                    </td>
                                    <td>
                                        <div>
                                            $ 46
                                        </div>
                                    </td>

                                    <td>
                                        64
                                    </td>
                                    <td>
                                        <span class="badge badge-soft-success">Active</span>
                                    </td>

                                    <td>
                                        <ul class="list-inline table-action m-0">
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-eye"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-square-edit-outline"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-delete"></i></a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check font-16 mb-0">
                                            <input class="form-check-input" type="checkbox"
                                                   id="productlistCheck112">
                                            <label class="form-check-label"
                                                   for="productlistCheck112">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>
                                        <img src="{{ asset($resourcePathServer.$assetsTemplate) }}/assets/images/products/product-4.png" alt="contact-img"
                                             title="contact-img" class="rounded me-3" height="48"/>

                                        <h5 class="m-0 d-inline-block align-middle"><a href="#"
                                                                                       class="text-dark">Blue
                                                color T-shirt</a></h5>
                                    </td>
                                    <td>
                                        <span class="badge bg-success"><i class="mdi mdi-star"></i> 4.0</span>
                                    </td>
                                    <td>
                                        T-shirt
                                    </td>
                                    <td>
                                        08 Feb, 2020
                                    </td>
                                    <td>
                                        <div>
                                            $ 47
                                        </div>
                                    </td>

                                    <td>
                                        74
                                    </td>
                                    <td>
                                        <span class="badge badge-soft-danger">Deactive</span>
                                    </td>

                                    <td>
                                        <ul class="list-inline table-action m-0">
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-eye"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-square-edit-outline"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="action-icon"> <i
                                                        class="mdi mdi-delete"></i></a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-none" id="uploadPreviewTemplate">
            <div class="card mt-1 mb-0 shadow-none border">
                <div class="p-2">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <img data-dz-thumbnail src="#" class="avatar-sm rounded bg-light" alt="">
                        </div>
                        <div class="col ps-0">
                            <a href="javascript:void(0);" class="text-muted fw-bold" data-dz-name></a>
                            <p class="mb-0" data-dz-size></p>
                        </div>
                        <div class="col-auto">
                            <!-- Button -->
                            <a href="" class="btn btn-link btn-lg text-muted" data-dz-remove>
                                <i class="fe-x"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset($resourcePathServer.$assetsTemplate.'assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js')}}"></script>
    <script src="{{ asset($resourcePathServer.$assetsTemplate.'assets/libs/quill/quill.min.js')}}"></script>

    <script src="{{ asset($resourcePathServer.$assetsTemplate.'assets/libs/dropzone/min/dropzone.min.js')}}"></script>
    <script src="{{ asset($resourcePathServer.$assetsTemplate.'assets/js/pages/form-fileuploads.init.js')}}"></script>
    <script src="{{ asset($resourcePathServer.$assetsTemplate.'assets/js/pages/add-product.init.js')}}"></script>



@endsection

@section('script-bottom')

@endsection
