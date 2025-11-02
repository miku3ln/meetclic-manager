<?php

namespace App\Models\ApiRest;

use Illuminate\Support\Facades\DB;

class GetDataModel
{
    protected $table = 'business';

    public function getDataManagerBusiness($params)
    {

        $sort = 'asc';
        $field = $this->table . '.title';
        $query = DB::table($this->table);
        if (isset($params['sort']) && count($params['sort']) > 0) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];

        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $selectString = "$this->table.id ,$this->table.options_map,$this->table.description ,$this->table.title ,$this->table.email,$this->table.page_url,$this->table.phone_value,$this->table.street_1,$this->table.street_2,$this->table.street_lat,$this->table.street_lng,$this->table.user_id,$this->table.business_subcategories_id,$this->table.status,$this->table.qualification,$this->table.source
,business_subcategories.name business_subcategories
,business_categories.name business_categories,business_categories.id business_categories_id
,countries.name countries,countries.id countries_id
,zones.name zone,zones.id zones_id
,cities.name city,cities.id cities_id
,provinces.name province,provinces.id provinces_id
,business_location.id business_location_id
,business_disbursement.id business_disbursement_id,business_disbursement.bank_id,business_disbursement.account_number,business_disbursement.type_account";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->leftJoin('business_subcategories', $this->table . ".business_subcategories_id", '=', 'business_subcategories.id');
        $query->leftJoin('business_categories', "business_subcategories.business_categories_id", '=', 'business_categories.id');
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
        $user_id = 1;
        $query->leftJoin('business_disbursement', function ($query)
        use (
            $user_id

        ) {
            $query->on('business_disbursement.business_id', '=', 'business.id');
        });
        if (isset($params['searchPhrase']) && $params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = "%" . $searchValue . "%";


            $query->where(function ($query) use (
                $likeSet
            ) {
                $query->where($this->table . '.description', 'like', $likeSet);
                $query->orWhere($this->table . '.title', 'like', $likeSet);
                $query->orWhere($this->table . '.email', 'like', $likeSet);
                $query->orWhere($this->table . '.page_url', 'like', $likeSet);
                $query->orWhere($this->table . '.phone_value', 'like', $likeSet);

            });

        }
        $query->where($this->table . ".user_id", "=", $user_id);
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
}
