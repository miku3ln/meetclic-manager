<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\MyBaseController;
use App\Models\PriceByZone;
use App\Models\Products\Product;
use App\Models\Zone;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class PriceByZoneController extends MyBaseController
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->layout->content = View::make('priceByZone.index', [
        ]);
    }


    public function getListPrices()
    {
        $data = Request::all();
        $query = Product::query()->select(['products.id', 'products.name'])->where(['status' => Product::STATUS_ACTIVE]);
        $queryZones = Zone::query()->select(['zones.id', 'zones.name'])->where(['status' => Zone::STATUS_ACTIVE])->orderBy('zones.name');
        $queryPricesByZone = PriceByZone::query();
        $recordsTotal = $query->get()->count();
        $datatable = !empty($data['datatable']) ? $data['datatable'] : [];
        $datatable = array_merge(['pagination' => [], 'sort' => [], 'query' => []], $datatable);

        //TODO: implement functionality to search
        // search filter by keywords
        //        $filter = isset($datatable['query']['generalSearch']) && is_string($datatable['query']['generalSearch']) ? $datatable['query']['generalSearch'] : '';
        //        if (!empty($filter)) {
        //            $data = array_filter($data, function ($a) use ($filter) {
        //                return (boolean)preg_grep("/$filter/i", (array)$a);
        //            });
        //            unset($datatable['query']['generalSearch']);
        //        }
        //
        //// filter by field query
        //        $query = isset($datatable['query']) && is_array($datatable['query']) ? $datatable['query'] : null;
        //        if (is_array($query)) {
        //            $query = array_filter($query);
        //            foreach ($query as $key => $val) {
        //                $data = list_filter($data, [$key => $val]);
        //            }
        //        }

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
        $products = $query->get()->toArray();
        if (isset($datatable['query']['city_id'])) {
            $queryZones->where(['city_id' => $datatable['query']['city_id']]);
        }
        $zones = $queryZones->get()->toArray();
        $pricesByZone = $queryPricesByZone->whereIn('zone_id', array_column($zones, 'id'))->get()->toArray();
        foreach ($products as $key => $product) {
            foreach ($zones as $zone) {
                foreach ($pricesByZone as $price) {
                    if ($price['zone_id'] == $zone['id'] && $price['product_id'] == $product['id']) {
                        $products[$key][$zone['id']] = $price['price'];
                    }
                }
            }
        }
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
            'data' => $products
        );
        return Response::json(
            $result
        );
    }

    public function postSave()
    {
        try {
            DB::beginTransaction();
            $data = Request::all();
            if (isset($data['price']) && is_array($data['price'])) {
                foreach ($data['price'] as $product_id => $prices) {
                    $product = Product::findOrFail($product_id);
                    if (is_array($prices) && count($prices) > 0) {
                        $prices_detail = [];
                        foreach ($prices as $zone_id => $price) {
                            if ($price) {
                                $prices_detail[$zone_id] = ['price' => $price];
                            } else {
                                $product->prices()->detach($zone_id);
                            }
                        }
                        $product->prices()->syncWithoutDetaching($prices_detail);
                    }
                }
                DB::commit();
                return Response::json(['success' => true]);
            } else {
                return Response::json(['success' => false]);
            }
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            return Response::json(['success' => false]);
        } catch (Exception $e) {
            DB::rollback();
            return Response::json(['success' => false]);
        }
    }
}
