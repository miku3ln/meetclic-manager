<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\MyBaseController;
use App\Models\BusinessByProduct;
use App\Models\Products\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class ProductController extends MyBaseController
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->layout->content = View::make('product.index', [

        ]);
    }

    public function getListProducts()
    {
        $data = Request::all();
        $query = Product::query();
        $recordsTotal = $query->get()->count();
        $datatable = !empty($data['datatable']) ? $data['datatable'] : [];
        $datatable = array_merge(['pagination' => [], 'sort' => [], 'query' => []], $datatable);
        $sort = !empty($datatable['sort']['sort']) ? $datatable['sort']['sort'] : 'asc';
        $field = !empty($datatable['sort']['field']) ? $datatable['sort']['field'] : 'name';
        $page = !empty($datatable['pagination']['page']) ? (int)$datatable['pagination']['page'] : 1;
        $perpage = !empty($datatable['pagination']['perpage']) ? (int)$datatable['pagination']['perpage'] : -1;

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
        $data = $query->get()->toArray();
        $meta = [
            'page' => $page,
            'pages' => $pages,
            'perpage' => $perpage,
            'total' => $total,
        ];
        $sort = [
            'sort' => $sort,
            'field' => $field,
        ];
        $result = array(
            'meta' => $meta + $sort,
            'data' => $data
        );
        return Response::json(
            $result
        );
    }

    public function getAdminBusiness()
    {
        $data = Request::all();

        $query = Product::query();
        $recordsTotal = $query->get()->count();
        $datatable = !empty($data['datatable']) ? $data['datatable'] : [];
        $datatable = array_merge(['pagination' => [], 'sort' => [], 'query' => []], $datatable);
        $sort = !empty($datatable['sort']['sort']) ? $datatable['sort']['sort'] : 'asc';
        $field = !empty($datatable['sort']['field']) ? $datatable['sort']['field'] : 'name';
        $page = !empty($datatable['pagination']['page']) ? (int)$datatable['pagination']['page'] : 1;
        $perpage = !empty($datatable['pagination']['perpage']) ? (int)$datatable['pagination']['perpage'] : -1;

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
        $data = $query->get()->toArray();
        $meta = [
            'page' => $page,
            'pages' => $pages,
            'perpage' => $perpage,
            'total' => $total,
        ];
        $sort = [
            'sort' => $sort,
            'field' => $field,
        ];
        $result = array(
            'meta' => $meta + $sort,
            'data' => $data
        );

        return Response::json(
            $result
        );
    }


    public function getFormProduct($id = null)
    {
        $method = 'POST';
        $images = collect([]);
        $product = isset($id) ? Product::find($id) : new Product();
        if ($id && $id != 'null') {
            $images = $product->images()->get();
        }
        $view = View::make('product.loads._form', [
            'method' => $method,
            'product' => $product,
            'images' => $images,
        ])->render();
        return Response::json(array(
            'html' => $view
        ));
    }

    public function postSave()
    {
        try {
            $controllerImage = new ImageController();
            DB::beginTransaction();
            $data = Request::all();
            if ($data['product_id'] == '') { //Create
                $product = new Product();
                $product->status = 'ACTIVE';
            } else { //Update
                $product = Product::find($data['product_id']);
                if (isset($data['status']))
                    $product->status = $data['status'];
            }
            $product->name = trim($data['name']);
            $product->category_id = $data['category_id'];
            $product->description = $data['description'];
            if ($product->save()) {
                if (isset($data['files'])) {

                    $files_data = $data['files'];
                    foreach ($files_data as $file) {
                        $data = [
                            'product_id' => $product->id,
                            'image' => $file
                        ];
                        $controllerImage->postSaveImage($data);
                    }
                }
                DB::commit();
                return Response::json(true);
            }
            return Response::json(true);
        } catch (Exception $e) {
            DB::rollback();
            return Response::json(false);
        }
    }

    public function postIsNameUnique()
    {
        $validation = Validator::make(Request::all(), ['name' => 'unique:products,name,' . Request::input('id') . ',id']);
        return Response::json($validation->passes() ? true : false);
    }

    public function getAdminProductsBusiness()
    {
        $dataPost = Request::all();
        $model = new Product;
        $result = $model->getProductsBusiness($dataPost);
        return Response::json(
            $result
        );
    }


    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new Product();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new Product();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }

    public function saveDataInputOutput()
    {

        $attributesPost = Request::all();
        $model = new Product();
        $result = $model->saveDataInputOutput(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }

    public function getListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  Product();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }

//CODE ECCOMERCE-001
    public function getAdminFrontend($language="es")
    {
        $dataPost = Request::all();
        $model = new Product();

        $data = $model->getAdminFrontend($dataPost);
        $result=Response::json(
            $data
        );

        return $result;
    }

    public function getAdminOutletsFrontend()
    {
        $dataPost = Request::all();
        $model = new Product();
        $result = $model->getAdminOutletsFrontend($dataPost);

        return Response::json(
            $result
        );
    }

    public function getAdminBalancesFrontend()
    {
        $dataPost = Request::all();
        $model = new Product();
        $result = $model->getAdminBalancesFrontend($dataPost);

        return Response::json(
            $result
        );
    }

    public function getBusinessProductsListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  Product();
        $result = $model->getBusinessProductsListSelect2($attributesPost);
        return Response::json($result);
    }

    public function getBusinessProductsServicesListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  Product();
        $result = $model->getBusinessProductsServicesListSelect2($attributesPost);
        return Response::json($result);
    }

    public function getBusinessServicesListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  Product();
        $result = $model->getBusinessServicesListSelect2($attributesPost);
        return Response::json($result);
    }

    public function saveDataService()
    {

        $attributesPost = Request::all();
        $model = new Product();
        $result = $model->saveDataService(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }

    public function getAdminService()
    {
        $dataPost = Request::all();
        $model = new Product();
        $result = $model->getAdminService($dataPost);

        return Response::json(
            $result
        );
    }

    public function getProductService()
    {

        $attributesPost = Request::all();
        $model = new  Product();
        $isService = $attributesPost['filters']['isService'];
        $result = [];
        if ($isService) {
            $result = $model->getServices($attributesPost);
        }
        return Response::json($result);
    }

    public function getEventsProductService()
    {

        $attributesPost = Request::all();
        $model = new  Product();

        $result = [];

        $result = $model->getProductsServices($attributesPost);

        return Response::json($result);
    }
    public function getListProductServices()
    {

        $attributesPost = Request::all();
        $model = new  BusinessByProduct();
        $result = $model->getListProductServices($attributesPost);
        return Response::json($result);
    }
}
