<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Multimedia;

class TemplateSliderByImages extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'template_slider_by_images';

    protected $fillable = array(
        'source',//*
        'template_slider_id',//*
        'title',
        'subtitle',
        'options_title',
        'button_name',
        'options_button',
        'options_subtitle',
        'options_all',
        'options_source',
        'position',
        'status',
        'type_button',
        'type_multimedia'
    );
    protected $attributesData = [
        ['column' => 'source', 'type' => 'string', 'defaultValue' => 'nothing', 'required' => 'true'],
        ['column' => 'template_slider_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'title', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'subtitle', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'options_title', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'button_name', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'options_button', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'options_subtitle', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'options_all', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'options_source', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'status', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'position', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'type_button', 'type' => 'integer', 'defaultValue' => 0, 'required' => 'true'],
        ['column' => 'type_multimedia', 'type' => 'integer', 'defaultValue' => 0, 'required' => 'true'],


    ];
    public $timestamps = false;

    protected $field_main = 'source';

    public static function getRulesModel()
    {
        $rules = [
            "source" => "required|max:350",
            "template_slider_id" => "required|numeric",
            "position" => "required|numeric",
            "type_button" => "required|numeric",
            "type_multimedia" => "required|numeric",

            "status" => "required",
            "button_name" => "max:45"
        ];
        return $rules;
    }


    /*MANAGER MAINS*/

    public function getAdminData($params)
    {
        $sort = 'asc';
        $field = 'status';
        $query = DB::table($this->table);
        $template_slider_id = $params['filters']['template_slider_id'];
        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "$this->table.id,$this->table.status,$this->table.position,$this->table.options_source,$this->table.options_all,$this->table.type_button,$this->table.source,template_slider.value as template_slider,
template_slider.id as template_slider_id,
$this->table.title,$this->table.subtitle,$this->table.options_title,$this->table.button_name,$this->table.options_button,$this->table.options_subtitle,$this->table.type_multimedia";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('template_slider', 'template_slider.id', '=', $this->table . '.template_slider_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;


            $query->where($this->table . '.title', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.subtitle', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.position', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.button_name', 'like', '%' . $likeSet . '%');


        }
        $query->where($this->table . '.template_slider_id', '=', $template_slider_id);

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
        return $this->getAdminData($params);
    }

    public function getAdminActivitiesGamification($params)
    {
        return $this->getAdminData($params);
    }

    public function getAdminRewardsGamification($params)
    {
        return $this->getAdminData($params);
    }

    public function saveDataManager($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        $modelMultimedia = new Multimedia;

        DB::beginTransaction();
        try {
            $modelName = 'TemplateSliderByImages';
            $model = new TemplateSliderByImages();
            $createUpdate = true;
            $auxResource = "";
            if (isset($attributesPost["id"]) && $attributesPost["id"] != "null" && $attributesPost["id"] != "-1") {
                $model = TemplateSliderByImages::find($attributesPost['id']);
                $createUpdate = false;
                $auxResource = $model->source;

            } else {
                $createUpdate = true;

            }

            $source = $attributesPost["source"];
            $pathSet = "/uploads/web/slider/images";
            $change = $attributesPost["change"];
            $successMultimediaModel = $modelMultimedia->managerUploadModel(
                array(
                    'createUpdate' => $createUpdate,
                    'source' => $source,
                    'pathSet' => $pathSet,
                    'change' => $change,
                    'auxResource' => $auxResource
                )
            );
            $successMultimedia = $successMultimediaModel['success'];
            if ($successMultimedia) {
                $currentResource = '';

                $source = $currentResource . $successMultimediaModel['source'];

                $templateSliderByImagesData = $attributesPost;
                $templateSliderByImagesData['source'] = $source;
                $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $templateSliderByImagesData, 'attributesData' => $this->attributesData));
                $paramsValidate = array(
                    'inputs' => $attributesSet,
                    'rules' => self::getRulesModel(),

                );
                $validateResult = $this->validateModel($paramsValidate);
                $success = $validateResult["success"];
                if ($success) {
                    $model->fill($attributesSet);
                    $success = $model->save();
                } else {
                    $success = false;
                    $msj = "Problemas al guardar  TemplateSliderByImages.";
                    $errors = $validateResult["errors"];
                }
                if (!$success) {
                    DB::rollBack();

                } else {
                    DB::commit();
                }
                $result = [
                    "errors" => $errors,
                    "msj" => $msj,
                    "success" => $success
                ];

                return ($result);
            } else {
                $msj = "Problemas al guardar la imagen.";
                DB::rollBack();
                throw new \Exception($msj);
            }

        } catch (Exception $e) {
            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "errors" => $errors
            );
            return ($result);
        }
    }

    public function saveData($params)
    {
        return $this->saveDataManager($params);
    }

    public function saveDataActivitiesGamification($params)
    {
        return $this->saveDataManager($params);
    }

    public function saveDataRewardsGamification($params)
    {
        return $this->saveDataManager($params);
    }

    public function getListSelect2($params)
    {
        $textValue = $this->table . '.' . $this->field_main;
        $field = $textValue;
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$textValue as text";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('template_slider', 'template_slider.id', '=', $this->table . '.template_slider_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.source', 'like', '%' . $likeSet . '%');
            $query->orWhere("template_slider.value", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.title', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.subtitle', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.options_title', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.button_name', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.options_button', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.options_subtitle', 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getSliderGalleryFrontend($params = array())
    {
        $template_slider_id = $params['template_slider_id'];
        $language = isset($params['language']) ? ($params['language'] == 'es' ? null : $params['language']) : null;

        $selectString = "$this->table.id,$this->table.options_source,$this->table.options_all,$this->table.source,
$this->table.template_slider_id,$this->table.title,$this->table.subtitle,$this->table.subtitle,$this->table.options_title,$this->table.button_name,$this->table.options_button,$this->table.options_subtitle,$this->table.type_button,$this->table.type_multimedia";
        if ($language) {
            $selectString .= ',language_template_slider_by_images.title title_lang,language_template_slider_by_images.subtitle subtitle_lang,language_template_slider_by_images.description description_lang
           ';
        }


        $select = DB::raw($selectString);
        $query = DB::table($this->table);
        $query->select($select);
        if ($language) {

            $state = 'ACTIVE';
            $query->leftJoin('language_template_slider_by_images', function ($query) use ($language, $state) {
                $query->on('template_slider_by_images.id', '=', 'language_template_slider_by_images.template_slider_by_images_id');
                $query->join('language', 'language_template_slider_by_images.language_id', '=', 'language.id');
                $query->where('language_template_slider_by_images.state', '=', $state);
                $query->where('language.initials', '=', $language);
            });

        }
        $query->where("$this->table.template_slider_id", '=', $template_slider_id);
        $query->where("$this->table.status", '=', self::STATE_ACTIVE);

        $field = $this->table . '.position';
        $sort = 'ASC';
        $query->orderBy($field, $sort);

        $data = $query->get()->toArray();

        return $data;
    }
}
