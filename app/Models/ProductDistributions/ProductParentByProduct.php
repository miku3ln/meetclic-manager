<?php

namespace App\Models\ProductDistributions;

use App\Models\BusinessByDiscounts;
use App\Models\BusinessByProduct;
use App\Models\Exception;
use App\Models\ModelManager;
use App\Models\Multimedia;
use App\Models\ProductByColor;
use App\Models\ProductByDetails;
use App\Models\ProductByMultimedia;
use App\Models\ProductBySizes;
use App\Models\ProductDetailsShippingFee;
use App\Models\ProductInventory;
use App\Models\Products\Product;
use App\Models\Products\ProductByPackage;
use Auth;
use Illuminate\Support\Facades\DB;

//Variants


class ProductParentByProduct extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const VIEW_ONLINE = 1;

    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'product_parent_by_product';

    protected $fillable = array(
        'id',//*
        'product_parent_id',//*
        'product_id',//*


    );
    protected $attributesData = [
        ['column' => 'product_parent_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'product_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],


    ];
    public $timestamps = false;

    protected $field_main = 'name';


    public static function getRulesModel()
    {
        $rules = [
            "product_parent_id" => "required|numeric",
            "product_id" => "required|numeric",
        ];
        return $rules;
    }


    /*MANAGER MAINS*/

    public function getAdminData($params)
    {
        $sort = 'DESC';
        $field = 'id';

        $tableProducts = 'product';
        $query = DB::table($tableProducts);
        $business_id = $params['filters']['business_id'];
        $product_parent_id = $params['filters']['product_parent_id'];
        if (isset($params['sort'])) {

            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            if ($field == 'code_name') {
                $field = 'name';
            }
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $sale_prices_manager = 'ROUND(product_inventory.sale_price,2) sale_not_tax ,ROUND((product_inventory.sale_price+(product_inventory.sale_price*tax.percentage/100)),2) sale_price';

        $selectString = "$tableProducts.id,$tableProducts.view_online,$tableProducts.code,$tableProducts.name,$tableProducts.state,product_trademark.value as product_trademark,
product_trademark.id as product_trademark_id,
product_category.value as product_category,
product_category.id as product_category_id,
product_subcategory.value as product_subcategory,
product_subcategory.id as product_subcategory_id,
$tableProducts.source,$tableProducts.description,$tableProducts.code_provider,$tableProducts.code_product,$tableProducts.has_tax,$tableProducts.is_service,$tableProducts.user_id,product_measure_type.value as product_measure_type,
product_measure_type.id as product_measure_type_id
,$sale_prices_manager,product_inventory.id product_inventory_id,ROUND(product_inventory.quantity_units,2) quantity_units
,product_details_shipping_fee.id product_details_shipping_fee_id,product_details_shipping_fee.height,product_details_shipping_fee.length,product_details_shipping_fee.width,product_details_shipping_fee.weight
,tax.value tax_value,tax.percentage tax_percentage,tax.id  tax_id,
business_by_products.id business_by_products_id,product_parent_by_product.id product_parent_by_product_id,product_trademark.id product_trademark_id,product_by_details.id product_by_details_id
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business_by_products', 'product.id', '=', 'business_by_products.products_id');
        $query->join('product_by_details', 'product.id', '=', 'product_by_details.product_id');

        $query->join('product_parent_by_product', 'product.id', '=', 'product_parent_by_product.product_id');
        $query->join('product_trademark', 'product_trademark.id', '=', $tableProducts . '.product_trademark_id');
        $query->leftJoin('product_details_shipping_fee', 'product_details_shipping_fee.product_id', '=', $tableProducts . '.id');
        $query->join('product_category', 'product_category.id', '=', $tableProducts . '.product_category_id');
        $query->join('product_subcategory', 'product_subcategory.id', '=', $tableProducts . '.product_subcategory_id');
        $query->join('product_measure_type', 'product_measure_type.id', '=', $tableProducts . '.product_measure_type_id');
        $query->join('product_inventory', 'product_inventory.product_id', '=', $tableProducts . '.id');
        $query->join('tax', 'tax.id', '=', 'product_inventory.tax_id');

        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where($tableProducts . '.code', 'like', '%' . $likeSet . '%');
            $query->orWhere($tableProducts . '.name', 'like', '%' . $likeSet . '%');
            $query->orWhere('product_inventory.note', 'like', '%' . $likeSet . '%');
            $query->orWhere("product_trademark.value", 'like', '%' . $likeSet . '%');
            $query->orWhere("product_category.value", 'like', '%' . $likeSet . '%');
            $query->orWhere("product_subcategory.value", 'like', '%' . $likeSet . '%');
            $query->orWhere($tableProducts . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere("product_measure_type.value", 'like', '%' . $likeSet . '%');

        }

        $query->where('business_by_products.business_id', '=', $business_id);
        $query->where('product_parent_by_product.product_parent_id', '=', $product_parent_id);

        $is_service = 0;
        $query->where('product.is_service', '=', $is_service);
        $recordsTotal = $query->get()->count();
        $pages = 1;
        $total = $recordsTotal; // total items in array
// sort
        $query->orderBy($field, $sort);
// Pagination: $perpage 0; get all data
        if ($perpage > 0) {
            $pages = ceil($total / $perpage); // calculate total pages
            $page = max($page, 1); // get 1 page when $_REQUEST['page'] <= 0
            $page = min($page, $pages); // get last page when $_REQUEST['page'] > $totalPages
            $offset = ($page - 1) * $perpage;
            if ($offset < 0) {
                $offset = 0;
            }
            $query->offset((int)$offset);
            $query->limit((int)$perpage);
        }
        $current_page = isset($params['current']) ? (int)$params['current'] : 0;
        $data = $query->get()->toArray();

        $result['total'] = $total;
        $result['rows'] = $data;
        $result['current'] = $current_page;
        $limit = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $result['rowCount'] = $limit;

        return $result;
    }

    public function getProductShopAdminData($params)
    {
        $sort = 'DESC';
        $field = 'id';

        $tableProducts = 'product';
        $query = DB::table($tableProducts);
        $business_id = $params['filters']['business_id'];
        $category_id = isset($params['filters']['category_id'])?$params['filters']['category_id']:null;
        $sub_category_id = isset($params['filters']['sub_category_id'])?$params['filters']['sub_category_id']:null;

        // $product_parent_id = $params['filters']['product_parent_id'];
        if (isset($params['sort'])) {

            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            if ($field == 'code_name') {
                $field = 'name';
            }
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 1;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $sale_prices_manager = 'ROUND(product_inventory.sale_price,2) sale_not_tax ,ROUND((product_inventory.sale_price+(product_inventory.sale_price*tax.percentage/100)),2) sale_price';

        $selectString = "$tableProducts.id,$tableProducts.view_online,$tableProducts.code,$tableProducts.name,$tableProducts.state,product_trademark.value as product_trademark,
product_trademark.id as product_trademark_id,
product_category.value as product_category,
product_category.id as product_category_id,
product_subcategory.value as product_subcategory,
product_subcategory.id as product_subcategory_id,
$tableProducts.source,$tableProducts.description,$tableProducts.code_provider,$tableProducts.code_product,$tableProducts.has_tax,$tableProducts.is_service,$tableProducts.user_id,product_measure_type.value as product_measure_type,
product_measure_type.id as product_measure_type_id
,$sale_prices_manager,product_inventory.id product_inventory_id,ROUND(product_inventory.quantity_units,2) quantity_units
,product_details_shipping_fee.id product_details_shipping_fee_id,product_details_shipping_fee.height,product_details_shipping_fee.length,product_details_shipping_fee.width,product_details_shipping_fee.weight
,tax.value tax_value,tax.percentage tax_percentage,tax.id  tax_id,
business_by_products.id business_by_products_id,product_parent_by_product.id product_parent_by_product_id,product_trademark.id product_trademark_id,product_by_details.id product_by_details_id
,product_parent_by_product.product_parent_id";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business_by_products', 'product.id', '=', 'business_by_products.products_id');
        $query->join('product_by_details', 'product.id', '=', 'product_by_details.product_id');

        $query->join('product_parent_by_product', 'product.id', '=', 'product_parent_by_product.product_id');
        $query->join('product_trademark', 'product_trademark.id', '=', $tableProducts . '.product_trademark_id');
        $query->leftJoin('product_details_shipping_fee', 'product_details_shipping_fee.product_id', '=', $tableProducts . '.id');
        $query->join('product_category', 'product_category.id', '=', $tableProducts . '.product_category_id');
        $query->join('product_subcategory', 'product_subcategory.id', '=', $tableProducts . '.product_subcategory_id');
        $query->join('product_measure_type', 'product_measure_type.id', '=', $tableProducts . '.product_measure_type_id');
        $query->join('product_inventory', 'product_inventory.product_id', '=', $tableProducts . '.id');
        $query->join('tax', 'tax.id', '=', 'product_inventory.tax_id');
        if ($category_id != "" && $category_id != null) {

            $query->where('product_category.id', '=', $category_id);

        }
        if ($sub_category_id != "" && $sub_category_id != null) {

            $query->where('product_subcategory.id', '=', $sub_category_id);

        }

        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where($tableProducts . '.code', 'like', '%' . $likeSet . '%');
            $query->orWhere($tableProducts . '.name', 'like', '%' . $likeSet . '%');
            $query->orWhere('product_inventory.note', 'like', '%' . $likeSet . '%');
            $query->orWhere("product_trademark.value", 'like', '%' . $likeSet . '%');
            $query->orWhere("product_category.value", 'like', '%' . $likeSet . '%');
            $query->orWhere("product_subcategory.value", 'like', '%' . $likeSet . '%');
            $query->orWhere($tableProducts . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere("product_measure_type.value", 'like', '%' . $likeSet . '%');

        }

        $query->where('business_by_products.business_id', '=', $business_id);
        //      $query->where('product_parent_by_product.product_parent_id', '=', $product_parent_id);

        $is_service = 0;
        $query->where('product.is_service', '=', $is_service);
        $recordsTotal = $query->get()->count();
        $pages = 1;
        $total = $recordsTotal; // total items in array
// sort
        $query->orderBy($field, $sort);
// Pagination: $perpage 0; get all data
        if ($perpage > 0) {
            $pages = ceil($total / $perpage); // calculate total pages
            $page = max($page, 1); // get 1 page when $_REQUEST['page'] <= 0
            $page = min($page, $pages); // get last page when $_REQUEST['page'] > $totalPages
            $offset = ($page - 1) * $perpage;
            if ($offset < 0) {
                $offset = 0;
            }
            $query->offset((int)$offset);
            $query->limit((int)$perpage);
        }
        $current_page = isset($params['current']) ? (int)$params['current'] : 0;
        $data = $query->get()->toArray();

        $result['total'] = $total;
        $result['rows'] = $data;
        $result['current'] = $current_page;
        $limit = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $result['rowCount'] = $limit;

        return $result;
    }
    public function getProductShopRecentAdminData($params)
    {
        $sort = 'DESC';
        $field = 'id';

        $tableProducts = 'product';
        $query = DB::table($tableProducts);
        $business_id = $params['filters']['business_id'];
        $category_id = isset($params['filters']['category_id'])?$params['filters']['category_id']:null;
        $sub_category_id = isset($params['filters']['sub_category_id'])?$params['filters']['sub_category_id']:null;

        // $product_parent_id = $params['filters']['product_parent_id'];
        if (isset($params['sort'])) {

            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            if ($field == 'code_name') {
                $field = 'name';
            }
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 1;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $sale_prices_manager = 'ROUND(product_inventory.sale_price,2) sale_not_tax ,ROUND((product_inventory.sale_price+(product_inventory.sale_price*tax.percentage/100)),2) sale_price';

        $selectString = "$tableProducts.id,$tableProducts.view_online,$tableProducts.code,$tableProducts.name,$tableProducts.state,product_trademark.value as product_trademark,
product_trademark.id as product_trademark_id,
product_category.value as product_category,
product_category.id as product_category_id,
product_subcategory.value as product_subcategory,
product_subcategory.id as product_subcategory_id,
$tableProducts.source,$tableProducts.description,$tableProducts.code_provider,$tableProducts.code_product,$tableProducts.has_tax,$tableProducts.is_service,$tableProducts.user_id,product_measure_type.value as product_measure_type,
product_measure_type.id as product_measure_type_id
,$sale_prices_manager,product_inventory.id product_inventory_id,ROUND(product_inventory.quantity_units,2) quantity_units
,product_details_shipping_fee.id product_details_shipping_fee_id,product_details_shipping_fee.height,product_details_shipping_fee.length,product_details_shipping_fee.width,product_details_shipping_fee.weight
,tax.value tax_value,tax.percentage tax_percentage,tax.id  tax_id,
business_by_products.id business_by_products_id,product_parent_by_product.id product_parent_by_product_id,product_trademark.id product_trademark_id,product_by_details.id product_by_details_id
,product_parent_by_product.product_parent_id";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business_by_products', 'product.id', '=', 'business_by_products.products_id');
        $query->join('product_by_details', 'product.id', '=', 'product_by_details.product_id');

        $query->join('product_parent_by_product', 'product.id', '=', 'product_parent_by_product.product_id');
        $query->join('product_trademark', 'product_trademark.id', '=', $tableProducts . '.product_trademark_id');
        $query->leftJoin('product_details_shipping_fee', 'product_details_shipping_fee.product_id', '=', $tableProducts . '.id');
        $query->join('product_category', 'product_category.id', '=', $tableProducts . '.product_category_id');
        $query->join('product_subcategory', 'product_subcategory.id', '=', $tableProducts . '.product_subcategory_id');
        $query->join('product_measure_type', 'product_measure_type.id', '=', $tableProducts . '.product_measure_type_id');
        $query->join('product_inventory', 'product_inventory.product_id', '=', $tableProducts . '.id');
        $query->join('tax', 'tax.id', '=', 'product_inventory.tax_id');
        if ($category_id != "" && $category_id != null) {

            $query->where('product_category.id', '=', $category_id);

        }
        if ($sub_category_id != "" && $sub_category_id != null) {

            $query->where('product_subcategory.id', '=', $sub_category_id);

        }

        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where($tableProducts . '.code', 'like', '%' . $likeSet . '%');
            $query->orWhere($tableProducts . '.name', 'like', '%' . $likeSet . '%');
            $query->orWhere('product_inventory.note', 'like', '%' . $likeSet . '%');
            $query->orWhere("product_trademark.value", 'like', '%' . $likeSet . '%');
            $query->orWhere("product_category.value", 'like', '%' . $likeSet . '%');
            $query->orWhere("product_subcategory.value", 'like', '%' . $likeSet . '%');
            $query->orWhere($tableProducts . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere("product_measure_type.value", 'like', '%' . $likeSet . '%');

        }

        $query->where('business_by_products.business_id', '=', $business_id);
        //      $query->where('product_parent_by_product.product_parent_id', '=', $product_parent_id);

        $is_service = 0;
        $query->where('product.is_service', '=', $is_service);
        $recordsTotal = $query->get()->count();
        $pages = 1;
        $total = $recordsTotal; // total items in array
// sort
        $query->orderBy($field, $sort);
// Pagination: $perpage 0; get all data
        if ($perpage > 0) {
            $pages = ceil($total / $perpage); // calculate total pages
            $page = max($page, 1); // get 1 page when $_REQUEST['page'] <= 0
            $page = min($page, $pages); // get last page when $_REQUEST['page'] > $totalPages
            $offset = ($page - 1) * $perpage;
            if ($offset < 0) {
                $offset = 0;
            }
            $query->offset((int)$offset);
            $query->limit((int)$perpage);
        }
        $current_page = isset($params['current']) ? (int)$params['current'] : 0;
        $data = $query->get()->toArray();

        $result['total'] = $total;
        $result['rows'] = $data;
        $result['current'] = $current_page;
        $limit = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $result['rowCount'] = $limit;

        return $result;
    }
    public function getAdmin($params)
    {
        $result = $this->getAdminData($params);

        $modelMeta = new ProductByMetaData();

        $modelColor = new ProductByColor();
        $modelSize = new ProductBySizes();
        $modelMultimedia = new ProductByMultimedia();
        $modelPackage = new ProductByPackage();

        foreach ($result['rows'] as $key => $row) {
            if (is_array($row)) {
                $row = (object)$row;
            }
            $dataRow = $row;
            $product_id = $row->id;

            $images = $modelMultimedia->getDataProduct(['filters' => ['product_id' => $product_id]]);
            $colors = $modelColor->getColorsProduct([
                'filters' => [
                    'product_id' => $product_id
                ]
            ]);
            $packages = $modelPackage->getPackagesProduct([
                'filters' => [
                    'product_id' => $product_id
                ]
            ]);
            $sizes = $modelSize->getSizesProduct([
                'filters' => [
                    'product_id' => $product_id
                ]
            ]);
            $setPush = $dataRow;
            $dataPrices = $modelMeta->getDataByProductParent(['filters' => ['product_id' => $row->id]]);
            $setPush->product_by_meta_data = $dataPrices;
            $setPush->colors = $colors;
            $setPush->sizes = $sizes;
            $setPush->images = $images;
            $setPush->packages = $packages;


            $result['rows'][$key] = $setPush;


        }
        return $result;

    }

    public function getProductShopAdmin($params)
    {
        $result = $this->getProductShopAdminData($params);

        $modelMeta = new ProductByMetaData();
        $modelProductParent = new ProductParent();

        $modelColor = new ProductByColor();
        $modelSize = new ProductBySizes();
        $modelMultimedia = new ProductByMultimedia();
        $modelPackage = new ProductByPackage();

        foreach ($result['rows'] as $key => $row) {
            if (is_array($row)) {
                $row = (object)$row;
            }
            $business_id = $params['filters']['business_id'];
            $id = $row->product_parent_id;
            $parentData = $modelProductParent->getAdminProductParent(
                [
                    "filters" => [
                        "business_id" => $business_id,
                        "id" => $id,

                    ]
                ]
            );
            $dataRow = $row;
            $product_id = $row->id;

            $images = $modelMultimedia->getDataProduct(['filters' => ['product_id' => $product_id]]);
            $colors = $modelColor->getColorsProduct([
                'filters' => [
                    'product_id' => $product_id
                ]
            ]);
            $packages = $modelPackage->getPackagesProduct([
                'filters' => [
                    'product_id' => $product_id
                ]
            ]);
            $sizes = $modelSize->getSizesProduct([
                'filters' => [
                    'product_id' => $product_id
                ]
            ]);
            $setPush = $dataRow;
            $dataPrices = $modelMeta->getDataByProductParent(['filters' => ['product_id' => $row->id]]);
            $setPush->product_by_meta_data = $dataPrices;
            $setPush->colors = $colors;
            $setPush->sizes = $sizes;
            $setPush->images = $images;
            $setPush->packages = $packages;
            $setPush->source = '';
            $setPush->parentData = $parentData;
            $sale_price = 0;

            foreach ($parentData->product_parent_by_prices_data as $keyPrice => $rowPrice) {
                if ($rowPrice->priority == 1) {
                    $sale_price = number_format($rowPrice->price, 2);
                    break;
                }
            }


            $setPush->sale_price = $sale_price;

            if (count($images) > 0) {
                $setPush->source = $images[0]->source;
            }

            $result['rows'][$key] = $setPush;


        }
        return $result;

    }
    public function getProductShopRecentAdmin($params)
    {
        $result = $this->getProductShopRecentAdminData($params);

        $modelMeta = new ProductByMetaData();
        $modelProductParent = new ProductParent();

        $modelColor = new ProductByColor();
        $modelSize = new ProductBySizes();
        $modelMultimedia = new ProductByMultimedia();
        $modelPackage = new ProductByPackage();

        foreach ($result['rows'] as $key => $row) {
            if (is_array($row)) {
                $row = (object)$row;
            }
            $business_id = $params['filters']['business_id'];
            $id = $row->product_parent_id;
            $parentData = $modelProductParent->getAdminProductParent(
                [
                    "filters" => [
                        "business_id" => $business_id,
                        "id" => $id,

                    ]
                ]
            );
            $dataRow = $row;
            $product_id = $row->id;

            $images = $modelMultimedia->getDataProduct(['filters' => ['product_id' => $product_id]]);
            $colors = $modelColor->getColorsProduct([
                'filters' => [
                    'product_id' => $product_id
                ]
            ]);
            $packages = $modelPackage->getPackagesProduct([
                'filters' => [
                    'product_id' => $product_id
                ]
            ]);
            $sizes = $modelSize->getSizesProduct([
                'filters' => [
                    'product_id' => $product_id
                ]
            ]);
            $setPush = $dataRow;
            $dataPrices = $modelMeta->getDataByProductParent(['filters' => ['product_id' => $row->id]]);
            $setPush->product_by_meta_data = $dataPrices;
            $setPush->colors = $colors;
            $setPush->sizes = $sizes;
            $setPush->images = $images;
            $setPush->packages = $packages;
            $setPush->source = '';
            $setPush->parentData = $parentData;
            $sale_price = 0;

            foreach ($parentData->product_parent_by_prices_data as $keyPrice => $rowPrice) {
                if ($rowPrice->priority == 1) {
                    $sale_price = number_format($rowPrice->price, 2);
                    break;
                }
            }


            $setPush->sale_price = $sale_price;

            if (count($images) > 0) {
                $setPush->source = $images[0]->source;
            }

            $result['rows'][$key] = $setPush;


        }
        return $result;

    }


    public function getProduct($params)
    {
        $user = Auth::user();
        $user_id = null;
        $allowUser = false;
        if ($user) {
            $allowUser = true;
            $user_id = $user->id;
        }
        $sale_prices_manager = 'ROUND(product_inventory.sale_price,2) sale_not_tax ,ROUND((product_inventory.sale_price+(product_inventory.sale_price*tax.percentage/100)),2) sale_price';
        $selectBusiness = 'business.id business_id, business.title business_title,business.email business_email';
        $selectString = "$this->table.id,$this->table.code,$this->table.name,$this->table.state,product_trademark.value as product_trademark,
product_trademark.id as product_trademark_id,
product_category.value as product_category,
product_category.id as product_category_id,
product_subcategory.value as product_subcategory,
product_subcategory.id as product_subcategory_id,
$this->table.source,$this->table.description,$this->table.code_provider,$this->table.code_product,$this->table.has_tax,$this->table.is_service,$this->table.user_id,product_measure_type.value as product_measure_type,
product_measure_type.id as product_measure_type_id
,product_inventory.id product_inventory_id,$sale_prices_manager
,business_by_discount.id business_by_discount_id,business_by_discount.code business_by_discount_code,business_by_discount.name business_by_discount_name,business_by_discount.value business_by_discount_value
,tax.value tax_value,tax.percentage tax_percentage
," . $selectBusiness;
        if ($allowUser) {

            $selectString = "$this->table.id,$this->table.code,$this->table.name,$this->table.state,product_trademark.value as product_trademark,
product_trademark.id as product_trademark_id,
product_category.value as product_category,
product_category.id as product_category_id,
product_subcategory.value as product_subcategory,
product_subcategory.id as product_subcategory_id,
$this->table.source,$this->table.description,$this->table.code_provider,$this->table.code_product,$this->table.has_tax,$this->table.is_service,$this->table.user_id,product_measure_type.value as product_measure_type,
product_measure_type.id as product_measure_type_id
,template_wish_list_by_user.product_id product_id_whishlist
,product_inventory.id product_inventory_id,$sale_prices_manager
,business_by_discount.id business_by_discount_id,business_by_discount.code business_by_discount_code,business_by_discount.name business_by_discount_name,business_by_discount.value business_by_discount_value
,tax.value tax_value,tax.percentage tax_percentage," . $selectBusiness;
        }
        $product_id = $params['filters']['product_id'];
        $language = isset($params['filters']['language']) ? ($params['filters']['language'] == 'es' ? null : $params['filters']['language']) : null;

        $relationLanguage = 'language_product';
        $relationLanguageId = 'product_id';
        $entityLanguage = $this->table;

        if ($language) {
            $selectString .= ',' . $relationLanguage . '.name name_lang,' . $relationLanguage . '.description description_lang
           ';
        }
        $select = DB::raw($selectString);
        $query = DB::table($this->table);
        $query->select($select);
        $query->join('business_by_products', 'business_by_products.products_id', '=', $this->table . '.id');
        $query->join('business', 'business_by_products.business_id', '=', 'business.id');

        $type = BusinessByDiscounts::TYPE_PERCENTAGE;
        $type_apply = BusinessByDiscounts::TYPE_APPLY_PRODUCTS;
        $has_limit = BusinessByDiscounts::HAS_LIMIT_NOT;
        $has_limit_end = BusinessByDiscounts::HAS_LIMIT_END_NOT;
        $limit_init = null;
        $limit_end = null;
        $minimum_requirements = 0;
        $apply_amount_min_products = 0;
        $amount_min_use = 0;
        $type_add_customers = 0;
        $business_id = isset($params['filters']['business_id']) ? $params['filters']['business_id'] : null;

        $query->leftJoin('discount_by_products', function ($query)
        use (
            $type,
            $type_apply,
            $has_limit,
            $has_limit_end,
            $limit_init,
            $limit_end,
            $minimum_requirements,
            $apply_amount_min_products,
            $amount_min_use,
            $type_add_customers,
            $business_id
        ) {
            $query->on('discount_by_products.product_id', '=', 'business_by_products.products_id')
                ->join('business_by_discount', 'discount_by_products.business_by_discount_id', '=', 'business_by_discount.id')
                ->where('business_by_discount.state', '=', 'ACTIVE')
                ->where('business_by_discount.type', '=', $type)
                ->where('business_by_discount.type_apply', '=', $type_apply)
                ->where('business_by_discount.has_limit', '=', $has_limit)
                ->where('business_by_discount.minimum_requirements', '=', $minimum_requirements)
                ->where('business_by_discount.apply_amount_min_products', '=', $apply_amount_min_products)
                ->where('business_by_discount.amount_min_use', '=', $amount_min_use)
                ->where('business_by_discount.business_id', '=', $business_id)
                ->where('business_by_discount.type_add_customers', '=', $type_add_customers);

        });

        $query->join('product_trademark', 'product_trademark.id', '=', $this->table . '.product_trademark_id');
        $query->join('product_category', 'product_category.id', '=', $this->table . '.product_category_id');
        $query->join('product_subcategory', 'product_subcategory.id', '=', $this->table . '.product_subcategory_id');
        $query->join('product_measure_type', 'product_measure_type.id', '=', $this->table . '.product_measure_type_id');
        $query->join('product_inventory', 'product_inventory.product_id', '=', $this->table . '.id');

        $query->join('tax', 'tax.id', '=', 'product_inventory.tax_id');

        if ($language) {
            $state = 'ACTIVE';
            $query->leftJoin($relationLanguage, function ($query) use ($language, $state, $relationLanguage, $entityLanguage, $relationLanguageId) {
                $query->on($entityLanguage . '.id', '=', $relationLanguage . '.' . $relationLanguageId);
                $query->join('language', $relationLanguage . '.language_id', '=', 'language.id');
                $query->where($entityLanguage . '.state', '=', $state);
                $query->where('language.initials', '=', $language);
            });

        }
        if ($user_id) {

            $query->leftJoin('template_wish_list_by_user', function ($join) use ($user_id) {
                $join->on('template_wish_list_by_user.product_id', '=', 'product.id')
                    ->where('template_wish_list_by_user.user_id', '=', $user_id);

            });
            /* $table, $first, $operator = null, $second = null, $type = 'inner', $where = false*/
        }
        $query->where($this->table . '.id', '=', $product_id);

        $data = $query->first();

        return $data;
    }

}
