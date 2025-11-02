<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class BusinessPanoramaByPoints extends Model
{
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';

    protected $table = 'business_panorama_by_points';

    protected $fillable = array(
        "id",//*
        "business_by_panorama_id",//*
        "panorama_points_id",//*
        "panorama_id",//*
        "status"

    );
    public $attributesData = array(
        "business_by_panorama_id",//*
        "panorama_points_id",//*
        "panorama_id",//*
        "status"

    );
    public $timestamps = false;

    public function getActionsManager()
    {
        $model_entity = $this->getUpperCaseTable($this->table);
        $action_get_form = $model_entity . "'\'" . $model_entity . "Controller" . "@getForm" . $model_entity;
        $action_get_form = str_replace("'", "", $action_get_form);
        $action_save = $model_entity . "'\'" . $model_entity . "Controller" . "@postSave";
        $action_save = str_replace("'", "", $action_save);
        $action_load = $model_entity . "'\'" . $model_entity . "Controller" . "@getList" . $model_entity;
        $action_load = str_replace("'", "", $action_load);
        $model_entity = $this->getCamelCase();
        return [
            "action_get_form" => $action_get_form,
            "action_save_" . $model_entity => $action_save,
            "action_load_" . $model_entity . "s" => $action_load];
    }

    public function getUpperCaseTable($name_change)
    {
        $table = $name_change;
        $arrayNames = explode("_", $table);
        $model_entity = "";
        foreach ($arrayNames as $name) {
            // your code
            $model_entity .= ucfirst($name);
        }

        return $model_entity;
    }

    public function getCamelCase()
    {

        return lcfirst($this->getUpperCaseTable($this->table));
    }

    public function findAllByAttributes($attributes = array(), $values = array(), $columns = array('*'))
    {
        $response = DB::table($this->table)
            ->select($columns);
        if (!is_array($attributes) || !is_array($values)) {
            throw new Exception('$attributes and $values should be array.');
        }
        if (count($attributes) < 1 || count($values) < 1) {
            throw new Exception('$attributes and $values can not be empty.');
        }
        if (count($attributes) != count($values)) {
            throw new Exception('$attributes and $values must have the same length.');
        }
        foreach ($attributes as $key => $attribute) {
            $response->where($attribute, "=", $values[$key]);
        }
        return $response->get()->toArray();
    }


    public function getPointsByPanorama($params)
    {

        $business_by_panorama_id = $params["business_by_panorama_id"];
        $query = DB::table($this->table)
            ->select(
                $this->table . '.*',
                DB::raw("(panorama.title) as `p_title` ,(panorama.subtitle) as `p_subtitle`,(panorama.description) as `p_description`,(panorama.type_panorama) as `p_type_panorama`,(panorama.points_allow) as `p_points_allow`,(panorama.src) as `p_src`,(panorama.type_breakdown) as `p_type_breakdown`")
                , DB::raw("(panorama_points.title) as `pp_title` ,(panorama_points.subtitle) as `pp_subtitle`,(panorama_points.description) as `pp_description`,(panorama_points.next_type) as `pp_next_type`,(panorama_points.coordinate_x) as `pp_coordinate_x`,(panorama_points.coordinate_y) as `pp_coordinate_y`")

            )
            ->join('panorama', $this->table . '.panorama_id', '=', 'panorama.id')
            ->join('panorama_points', $this->table . '.panorama_points_id', '=', 'panorama_points.id');

        $query->where("business_by_panorama_id", $business_by_panorama_id);

        return $query->get()->toArray();
    }


}
