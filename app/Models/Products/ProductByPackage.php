<?php

namespace App\Models\Products;

use App\Models\Exception;
use App\Models\ModelManager;

use Illuminate\Support\Facades\DB;
use Auth;



class ProductByPackage extends ModelManager
{

    protected $table = 'product_by_package';
    protected $fillable = array('product_id', 'product_parent_by_package_params_id');
    protected $attributesData = [

    ];
    public $timestamps = false;
    protected $field_main = 'product_id';

    public static function getRulesModel()
    {
        $rules = ["product_id" => "required|numeric",
            "product_parent_by_package_params_id" => "required|numeric"
        ];
        return $rules;
    }


    /*MANAGER MAINS*/

    public function getAdmin($params)
    {
        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "product.code as product,
product.id as product_id,
product_parent_by_package_params.name as product_parent_by_package_params,
product_parent_by_package_params.id as product_parent_by_package_params_id
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('product', 'product.id', '=', $this->table . '.product_id');
        $query->join('product_parent_by_package_params', 'product_parent_by_package_params.id', '=', $this->table . '.product_parent_by_package_params_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->orWhere("product.code", 'like', '%' . $likeSet . '%');
            $query->orWhere("product_parent_by_package_params.name", 'like', '%' . $likeSet . '%');;

        }

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

    public function getPackagesProduct($params)
    {

        $product_id = $params['filters']['product_id'];
        $query = DB::table($this->table);
        $table_name_data = 'product_parent_by_package_params';
        $orderField = $table_name_data.'.name';
        $table_name_data_key = 'product_parent_by_package_params_id';
        $selectString = $table_name_data.".name,".$table_name_data.".name as text ,".$table_name_data.'.id';
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('product', 'product.id', '=', $this->table . '.product_id');
        $query->join($table_name_data, $table_name_data . '.id', '=', $this->table . '.' . $table_name_data_key);
        $query->where($this->table . '.product_id', '=', $product_id);
        $query->orderBy($orderField, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }
}
