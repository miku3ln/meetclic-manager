<?php

namespace App\Models;

use App\Models\TemplateSliderByImages;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;

use URL;

class TemplateSlider extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'template_slider';
    const POSITION_SECTION_SLIDER_MAIN = 0;
    const POSITION_SECTION_SLIDER_ACTIVITIES_GAMIFICATION = 1;
    const POSITION_SECTION_SLIDER_REWARDS_GAMIFICATION = 2;

    protected $fillable = array(
        'value',//*
        'description',
        'status',//*
        'template_information_id',//*
        'position_section',//*
        'code',//*


    );
    protected $attributesData = [
        ['column' => 'value', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'status', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true'],
        ['column' => 'template_information_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'position_section', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],

        ['column' => 'code', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],


    ];
    public $timestamps = false;

    protected $field_main = 'value';


    public static function getRulesModel($id = null)
    {
        $rules = [


            "value" => "required|max:150",
            "status" => "required",
            "template_information_id" => "required|numeric",
            "position_section" => "required|numeric",
            "code" => "required|max:150|unique:template_slider,code",
        ];
        if ($id) {
            $rules = [
                "value" => "required|max:150",
                "status" => "required",
                "template_information_id" => "required|numeric",
                "position_section" => "required|numeric",
                "code" => "required|max:150|unique:template_slider,code," . $id,
            ];
        }

        return $rules;
    }

    /*MANAGER MAINS*/
    public function getAdminData($params)
    {
        $sort = 'asc';
        $field = 'status';
        $query = DB::table($this->table);
        $template_information_id = $params['filters']['template_information_id'];
        $position_section = $params['filters']['position_section'];

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "$this->table.id,$this->table.value,$this->table.description,$this->table.status,$this->table.code,template_information.value as template_information,
template_information.id as template_information_id
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('template_information', 'template_information.id', '=', $this->table . '.template_information_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;

            $query->where($this->table . '.value', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere("template_information.value", 'like', '%' . $likeSet . '%');

        }
        $query->where($this->table . '.template_information_id', '=', $template_information_id);
        $query->where($this->table . '.position_section', '=', $position_section);

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
        return $result;
    }

    public function getAdminActivitiesGamification($params)
    {
        $result = $this->getAdminData($params);
        return $result;
    }

    public function getAdminRewardsGamification($params)
    {
        $result = $this->getAdminData($params);
        return $result;
    }

    public function saveManager($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        DB::beginTransaction();
        try {
            $modelName = 'TemplateSlider';
            $model = new TemplateSlider();
            $createUpdate = true;
            $id = null;
            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = TemplateSlider::find($attributesPost[$modelName]['id']);
                $id = $attributesPost[$modelName]['id'];
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }

            $templateSliderData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $templateSliderData, 'attributesData' => $this->attributesData));
            $paramsValidate = array(
                'inputs' => $attributesSet,
                'rules' => self::getRulesModel($id),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            $template_information_id = $attributesPost[$modelName]["template_information_id"];
            $position_section = $attributesPost[$modelName]["position_section"];
            if ($success) {

                if ($attributesSet['status'] == 'ACTIVE') {
                    if (false) {
                        if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                            $idCurrent = $attributesPost[$modelName]["id"];
                            TemplateSlider::where('status', 'ACTIVE')
                                ->where('template_information_id', '=', $template_information_id)
                                ->where('position_section', '=', $position_section)
                                ->whereNotIn('id', [$idCurrent])
                                ->update(['status' => 'INACTIVE']);
                        } else {
                            TemplateSlider::where('status', 'ACTIVE')
                                ->where('template_information_id', '=', $template_information_id)
                                ->where('position_section', '=', $position_section)
                                ->update(['status' => 'INACTIVE']);
                        }
                    }

                }
                $model->fill($attributesSet);
                $success = $model->save();
            } else {
                $success = false;
                $msj = "Problemas al guardar  TemplateSlider.";
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
        return $this->saveManager($params);
    }

    public function saveDataActivitiesGamification($params)
    {
        return $this->saveManager($params);
    }

    public function saveDataRewardsGamification($params)
    {
        return $this->saveManager($params);
    }

    public function getListSelect2($params)
    {
        $textValue = $this->table . '.' . $this->field_main;
        $field = $textValue;
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$textValue as text";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('template_information', 'template_information.id', '=', $this->table . '.template_information_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.value', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.status', 'like', '%' . $likeSet . '%');
            $query->orWhere("template_information.value", 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getSliderMainDataFrontend($params = array())
    {
        $template_information_id = $params['template_information_id'];
        $position_section = isset($params['position_section']) ? $params['position_section'] : self::POSITION_SECTION_SLIDER_MAIN;


        $selectString = "$this->table.id ,$this->table.value ,$this->table.description";
        $select = DB::raw($selectString);
        $query = DB::table($this->table);
        $query->select($select);
        $query->where("$this->table.status", '=', self::STATE_ACTIVE);
        $query->where("$this->table.template_information_id", '=', $template_information_id);
        $query->where("$this->table.position_section", '=', $position_section);

        $data = $query->first();

        return $data;
    }

    public function getSliderDataFrontendByCode($params = array())
    {
        $template_information_id = $params['template_information_id'];
        $position_section = isset($params['position_section']) ? $params['position_section'] : self::POSITION_SECTION_SLIDER_MAIN;

        $code = $params['code'];

        $selectString = "$this->table.id ,$this->table.value ,$this->table.description";
        $select = DB::raw($selectString);
        $query = DB::table($this->table);
        $query->select($select);
        $query->where("$this->table.status", '=', self::STATE_ACTIVE);
        $query->where("$this->table.template_information_id", '=', $template_information_id);
        $query->where("$this->table.position_section", '=', $position_section);
        $query->where("$this->table.code", '=', $code);

        $data = $query->first();

        return $data;
    }

    public function getSliderMainFrontend($params = array())
    {
        $dataSlider = $this->getSliderMainDataFrontend($params);
        $resourcePathServer = $params['resourcePathServer'];

        $result = array();
        if ($dataSlider != false) {
            $template_slider_id = $dataSlider->id;
            $modelSG = new TemplateSliderByImages();

            $dataGallery = $modelSG->getSliderGalleryFrontend(array(
                'template_slider_id' => $template_slider_id,
                'language' => $params['language']
            ));

            if (count($dataGallery) > 0) {
                $setPush = (array)$dataSlider;
                $result['slider'] = $setPush;
                $setPushData = array();
                foreach ($dataGallery as $key => $value) {
                    $setPush = (array)$value;
                    $setPush['source'] = URL($resourcePathServer . $setPush['source']);
                    $setPushData[] = $setPush;

                }
                $result['slider']['data'] = $setPushData;
                $result['slider']['language'] = $params['language'];
                $result['resourcePathServer'] = $params['resourcePathServer'];
            }


        }
        return $result;
    }

    public function getSliderSubSectionCodeByMainFrontend($params = array())
    {
        $dataSlider = $this->getSliderDataFrontendByCode($params);
        $resourcePathServer = $params['resourcePathServer'];
        $language = $params['language'] == 'es' ? null : $params['language'];

        $result = array();
        if ($dataSlider != false) {
            $template_slider_id = $dataSlider->id;
            $modelSG = new TemplateSliderByImages();

            $dataGallery = $modelSG->getSliderGalleryFrontend(array(
                'template_slider_id' => $template_slider_id,
                'language' => $params['language']
            ));

            if (count($dataGallery) > 0) {
                $setPush = (array)$dataSlider;
                $result['slider'] = $setPush;
                $setPushData = array();
                foreach ($dataGallery as $key => $value) {
                    $setPush = (array)$value;
                    $setPush['source'] = URL($resourcePathServer . $setPush['source']);
                    $title = $language == null ? $value->title : (isset($value->title_lang) && $value->title_lang ? $value->title_lang : $value->title);
                    $subtitle = $language == null ? $value->subtitle : (isset($value->subtitle_lang) && $value->subtitle_lang ? $value->subtitle_lang : $value->subtitle);
                    $setPush["title"] = $title;
                    $setPush["subtitle"] = $subtitle;
                    if ($value->type_button == 1) {
                        $options_button=$value->options_button;
                        $options_button = json_decode($options_button, true);
                        $setPush["options_button"] = $options_button;
                    }
                    $setPushData[] = $setPush;

                }
                $result['slider']['data'] = $setPushData;
                $result['slider']['language'] = $params['language'];
                $result['resourcePathServer'] = $params['resourcePathServer'];
            }


        }
        return $result;
    }

    public function getSliderOneFrontend($params = array())
    {

        $resourcePathServer = $params['resourcePathServer'];
        $sliderNumber = "one";
        $result = array();
        $path = $resourcePathServer . "/uploads/frontend/home/slider/$sliderNumber";
        $setPush = [];
        $setPush['source'] = URL($path . "/imagenes3-01.png");
        $setPush['title'] = "VIVIMOS LOGISTICA";
        $setPush['subtitle'] = "Traemos tus compras, cuando lo necesites , de forma fácil, rápida y segura.";


        array_push($result, $setPush);


        $setPush = [];
        $setPush['source'] = URL($path . "/imagenes3-02.png");
        $setPush['title'] = "VIVIMOS LOGISTICA";
        $setPush['subtitle'] = "Traemos tus compras, cuando lo necesites , de forma fácil, rápida y segura.";
        array_push($result, $setPush);

        $setPush = [];
        $setPush['source'] = URL($path . "/imagenes3-03.png");
        $setPush['title'] = "VIVIMOS LOGISTICA";
        $setPush['subtitle'] = "Traemos tus compras, cuando lo necesites , de forma fácil, rápida y segura.";
        array_push($result, $setPush);

        $setPush = [];
        $setPush['source'] = URL($path . "/imagenes3-04.png");
        $setPush['title'] = "VIVIMOS LOGISTICA";
        $setPush['subtitle'] = "Traemos tus compras, cuando lo necesites , de forma fácil, rápida y segura.";
        //array_push($result, $setPush);


        $setPush = [];
        $setPush['source'] = URL($path . "/imagenes-05.jpg");
        $setPush['title'] = "VIVIMOS LOGISTICA";
        $setPush['subtitle'] = "Traemos tus compras, cuando lo necesites , de forma fácil, rápida y segura.";
        //  array_push($result, $setPush);

        $setPush = [];
        $setPush['source'] = URL($path . "/imagenes-06.jpg");
        $setPush['title'] = "VIVIMOS LOGISTICA";
        $setPush['subtitle'] = "Traemos tus compras, cuando lo necesites , de forma fácil, rápida y segura.";
        //   array_push($result, $setPush);
        return $result;
    }

    public function getSliderTwoFrontend($params = array())
    {

        $resourcePathServer = $params['resourcePathServer'];
        $sliderNumber = "two";
        $result = array();
        $path = $resourcePathServer . "/uploads/frontend/home/slider/$sliderNumber";
        $setPush = [];
        $setPush['source'] = URL($path . "/imagenes3-01.png");
        $setPush['title'] = "TASTY FRUITS";
        $setPush['subtitle'] = "¡La vida sabe bien con frutas, y si son de Ecuador, mejor!";


        array_push($result, $setPush);


        $setPush = [];
        $setPush['source'] = URL($path . "/imagenes3-02.png");
        $setPush['title'] = "TASTY FRUITS";
        $setPush['subtitle'] = "¡La vida sabe bien con frutas, y si son de Ecuador, mejor!";
        array_push($result, $setPush);

        $setPush = [];
        $setPush['source'] = URL($path . "/imagenes3-03.png");
        $setPush['title'] = "TASTY FRUITS";
        $setPush['subtitle'] = "¡La vida sabe bien con frutas, y si son de Ecuador, mejor!";
        array_push($result, $setPush);

        $setPush = [];
        $setPush['source'] = URL($path . "/imagenes3-04.png");
        $setPush['title'] = "TASTY FRUITS";
        $setPush['subtitle'] = "¡La vida sabe bien con frutas, y si son de Ecuador, mejor!";
        array_push($result, $setPush);


        $setPush = [];
        $setPush['source'] = URL($path . "/imagenes3-05.png");
        $setPush['title'] = "TASTY FRUITS";
        $setPush['subtitle'] = "¡La vida sabe bien con frutas, y si son de Ecuador, mejor!";
        array_push($result, $setPush);
        return $result;
    }

    public function getSliderThreeFrontend($params = array())
    {
        $resourcePathServer = $params['resourcePathServer'];
        $sliderNumber = "three";
        $result = array();
        $path = $resourcePathServer . "/uploads/frontend/home/slider/$sliderNumber";
        $setPush = [];
        $setPush['source'] = URL($path . "/imagenes3-01.png");
        $setPush['title'] = "UN MUNDO DE OPCIONES";
        $setPush['subtitle'] = "Productos procesados bajo estrictos procesos de selección y de control de manufactura y calidad.";


        array_push($result, $setPush);


        $setPush = [];
        $setPush['source'] = URL($path . "/imagenes3-02.png");
        $setPush['title'] = "UN MUNDO DE OPCIONES";
        $setPush['subtitle'] = "Productos procesados bajo estrictos procesos de selección y de control de manufactura y calidad.";
        array_push($result, $setPush);

        $setPush = [];
        $setPush['source'] = URL($path . "/imagenes3-03.png");
        $setPush['title'] = "UN MUNDO DE OPCIONES";
        $setPush['subtitle'] = "Productos procesados bajo estrictos procesos de selección y de control de manufactura y calidad.";
        array_push($result, $setPush);

        $setPush = [];
        $setPush['source'] = URL($path . "/imagenes3-04.png");
        $setPush['title'] = "UN MUNDO DE OPCIONES";
        $setPush['subtitle'] = "Productos procesados bajo estrictos procesos de selección y de control de manufactura y calidad.";
        array_push($result, $setPush);


        return $result;
    }


}
