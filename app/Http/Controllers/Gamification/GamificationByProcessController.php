<?php

namespace App\Http\Controllers\Gamification;

use App\Http\Controllers\MyBaseController;
use App\Models\GamificationByProcess;
use App\Modules\PointSales\Repositories\ProductRepository;
use App\Modules\PointSales\Services\ProductSalesService;
use App\Modules\PointSales\Services\StockDiscountService;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class GamificationByProcessController extends MyBaseController
{
    public function __construct(ProductSalesService $service, ProductRepository $repo)
    {
        $this->service = $service;
        $this->serviceProduct = $repo;


    }

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new GamificationByProcess();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function getAdminGamificationFrontend()
    {
        $dataPost = Request::all();
        $model = new GamificationByProcess();
        $result = $model->getAdminGamificationFrontend($dataPost);

        return Response::json(
            $result
        );
    }

    public function getAdminGamificationFrontendHome()
    {
        $dataPost = Request::all();
        $model = new GamificationByProcess();
        $result = $model->getAdminGamificationFrontendHome($dataPost);

        return Response::json(
            $result
        );
    }

    public function getAdminShopPageByBusiness()
    {
        $dataPost = Request::all();
        $dataPost["filters"]["type"] = "SHOP";
        $result = $this->service->getProductsShopPage($dataPost);
        $rows = collect($result['rows']);
        /*
        |--------------------------------------------------------------------------
        | GET PRODUCT IDS
        |--------------------------------------------------------------------------
        */

        $productIds = $rows
            ->pluck('id')
            ->toArray();

        /*
        |--------------------------------------------------------------------------
        | GET ALL RECIPES IN ONE QUERY
        |--------------------------------------------------------------------------
        */

        $recipes = $this->serviceProduct
            ->getRecipesByProducts($productIds);

        /*
        |--------------------------------------------------------------------------
        | GROUP RECIPES
        |--------------------------------------------------------------------------
        */

        $recipesGrouped = collect($recipes)
            ->groupBy('parent_product_id');

        /*
        |--------------------------------------------------------------------------
        | ATTACH RECIPES
        |--------------------------------------------------------------------------
        */

        $rows = $rows->map(function ($product) use ($recipesGrouped) {
            $product['recipe'] = $recipesGrouped
                ->get($product['id'])
                ?->values()
                ?? collect();

            return $product;
        });

        $result['rows'] = $rows;

        return Response::json($result);
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new GamificationByProcess();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }


    public function getListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  GamificationByProcess();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }
}
