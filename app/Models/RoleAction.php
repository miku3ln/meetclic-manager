<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class RoleAction extends Model
{
    public $timestamps = false;

    protected $table = 'actions_by_role'; //Database table used by the model

    protected $fillable = array('role_id', 'action_id');
    public
    function getDataActionManager($params)
    {
        $sort = 'asc';
        $field = 'status';
        $query = DB::table($this->table);


        $selectString = "$this->table.id,$this->table.action_id,$this->table.role_id
       ,actions.name actions_name,actions.link actions_manager ";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->leftJoin('business_location', function ($query)
        use (
            $selectString

        ) {


            $query->on('business_location.business_id', '=', 'business.id');
            $query->join('zones', "business_location.zones_id", '=', 'zones.id');
            $query->join('cities', "zones.city_id", '=', 'cities.id');
            $query->join('provinces', "cities.province_id", '=', 'provinces.id');
            $query->join('countries', "provinces.country_id", '=', 'countries.id');
        });
        $query->join('business_subcategories', "$this->table.business_subcategories_id", '=', 'business_subcategories.id');
        $query->join('business_categories', "business_subcategories.business_categories_id", '=', 'business_categories.id');
        $allowCondition = false;
        $nameColumn = "";
        $dataIn = array();
        if ($allowFilters) {

            if ($params["filters"]["categories"]["keys"] != "") {//only categories
                $categoriesIn = explode(',', $params["filters"]["categories"]["keys"]);
                $dataIn = $categoriesIn;
                $allowCondition = true;
                $nameColumn = "business_categories.id";


            } else {//only subcategories

                if ($params["filters"]["subcategories"]["keys"] != "") {
                    $subCategoriesIn = explode(',', $params["filters"]["subcategories"]["keys"]);
                    $allowCondition = true;
                    $dataIn = $subCategoriesIn;
                    $nameColumn = "business_subcategories.id";

                }
            }

            if ($allowCondition) {
                $query->whereIn($nameColumn, $dataIn);
            }

        }
        $nameColumn = "business_categories.id";
        $query->whereIn($nameColumn, [1, 3]);
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = "%" . $searchValue . "%";
            $query->where("$this->table.description", 'like', $likeSet)
                ->orWhere("$this->table.title", 'like', $likeSet)
                ->orWhere("$this->table.email", 'like', $likeSet)
                ->orWhere("$this->table.page_url", 'like', $likeSet)
                ->orWhere("$this->table.phone_value", 'like', $likeSet)
                ->orWhere('countries.name', 'like', $likeSet)
                ->orWhere('business_subcategories.name', 'like', $likeSet);
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
        $result['paramsfilters'] = array(
            $nameColumn,
            $dataIn,
        );

        return $result;
    }
}
