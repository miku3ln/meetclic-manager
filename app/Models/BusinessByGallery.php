<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class BusinessByGallery extends Model
{
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';
    /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $table = 'business_by_gallery';

    protected $fillable = array('description', 'src', 'position', 'type', 'config', 'type', 'config', 'business_id', 'created_at', 'updated_at', 'deleted_at', 'status', 'title', 'subtitle');

    public $timestamps = true;


    public function getAdminBusiness($params)
    {
        $sort = 'asc';
        $field = 'status';
        $query = DB::table($this->table);

        $business_id = isset($params["filters"]["business_id"]) ? $params["filters"]["business_id"] : null;
        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];

        }
        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $selectString = "$this->table.id ,$this->table.src,$this->table.position,$this->table.type,$this->table.config,$this->table.business_id,$this->table.created_at,$this->table.updated_at,$this->table.deleted_at,$this->table.status,$this->table.title,$this->table.subtitle,$this->table.description
        ";

        $select = DB::raw($selectString);
        $query->select($select);
        if ($business_id) {

            $query->where("business_id", $business_id);
        }


        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = "%" . $searchValue . "%";
            $query->where($this->table . '.title', 'like', $likeSet)
                ->orWhere($this->table . '.subtitle', 'like', $likeSet)
                ->orWhere($this->table . '.description', 'like', $likeSet);
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

    public function getAdminBusinessData($params)
    {
        $result = $this->getAdminBusiness($params);
        return $result;

    }

    public function getGalleryByBusiness($params)
    {
        $sort = 'asc';
        $field = 'position';
        $query = DB::table($this->table);
        $business_id = isset($params["filters"]["business_id"]) ? $params["filters"]["business_id"] : null;
        $selectString = "$this->table.id ,$this->table.src,$this->table.position,$this->table.type,$this->table.config,$this->table.business_id,$this->table.created_at,$this->table.updated_at,$this->table.deleted_at,$this->table.status,$this->table.title,$this->table.subtitle,$this->table.description
        ";
        $select = DB::raw($selectString);
        $query->select($select);
        if ($business_id) {
            $query->where($this->table . ".business_id", $business_id);
        }
        $query->orderBy($field, $sort);
        $result = $query->get()->toArray();
        return $result;
    }
}
