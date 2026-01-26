<?php

namespace App\Models;

use App\Models\Gamification\ConfigurationGamificationUtil;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Multimedia;
use App\Models\GamificationByPoints;

class GamificationByProcess extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'gamification_by_process';

    public function pointsRelation()
    {
        // gamification_by_points.gamification_by_process_id -> gamification_by_process.id
        return $this->hasOne(GamificationByPoints::class, 'gamification_by_process_id', 'id');
    }

    public static function findProcessWithPointsAndBusiness(int $processId): ?array
    {
        $row = DB::table('gamification_by_process as p')
            ->join('gamification_by_points as pts', 'pts.gamification_by_process_id', '=', 'p.id')
            ->join('business_by_gamification as bg', 'bg.gamification_id', '=', 'p.gamification_id')
            ->join('business as b', 'b.id', '=', 'bg.business_id')
            ->leftJoin('tracking_click_types as tct', 'tct.id', '=', 'p.tracking_click_type_id')
            ->leftJoin('tracking_sources as ts', 'ts.id', '=', 'p.tracking_source_id')
            ->where('p.id', $processId)
            ->select([
                // --- process base ---
                'p.id',
                'p.source',
                'p.title',
                'p.subtitle',
                'p.description',
                'p.state',
                'p.valid_from',
                'p.valid_until',
                'p.frequency_limit_type',
                'p.frequency_limit_value',
                'p.has_source',
                'p.entity',
                'p.entity_id',
                'p.url_manager',
                'p.gamification_id',
                'p.gamification_type_activity_id',
                'p.is_url',
                'p.type_manager',
                'p.execution_channel',
                'p.user_id',
                'p.unique_code',
                'p.allow_golden',
                'p.icon_class',
                'p.campaign_code_template',
                'p.tracking_click_type_id',
                'p.tracking_source_id',

                // --- points ---
                'pts.id as gamification_by_points_id',
                'pts.points as points',

                // --- business ---
                'b.id as business_id',
                'b.title as business_name',

                // --- tracking (opcional pero útil) ---
                'tct.code as tracking_type_code',
                'ts.code as tracking_source_code',
            ])
            ->first();

        return $row ? (array)$row : null;
    }

    protected $fillable = array(
        'source',//*
        'title',//*
        'subtitle',
        'description',//*
        'state',//*
        'has_source',//*
        'entity',//*
        'entity_id',//*
        'url_manager',//*
        'gamification_id',//*
        'gamification_type_activity_id',//*
        'is_url',//*
        'type_manager',//*
        'user_id',//*
        'unique_code',//*
        'allow_golden',//*
        'icon_class',//*
        'tracking_click_type_id',
        'tracking_source_id',
        'execution_channel',


    );
    protected $attributesData = [
        ['column' => 'source', 'type' => 'string', 'defaultValue' => 'nothing', 'required' => 'true'],
        ['column' => 'title', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'subtitle', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'state', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true'],
        ['column' => 'has_source', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'entity', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'entity_id', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'url_manager', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'gamification_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'gamification_type_activity_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'is_url', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'type_manager', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'user_id', 'type' => 'integer', 'user_id' => '0', 'required' => 'true'],
        ['column' => 'unique_code', 'type' => 'string', 'unique_code' => '0', 'required' => 'true'],
        ['column' => 'allow_golden', 'type' => 'integer', 'allow_golden' => '1', 'required' => 'true'],
        ['column' => 'icon_class', 'type' => 'integer', 'icon_class' => 'fa fa', 'required' => 'true'],

        ['column' => 'tracking_click_type_id', 'type' => 'integer', 'icon_class' => 'fa fa', 'required' => 'true'],
        ['column' => 'tracking_source_id', 'type' => 'integer', 'icon_class' => 'fa fa', 'required' => 'true'],
        ['column' => 'execution_channel', 'type' => 'string', 'icon_class' => 'fa fa', 'required' => 'true'],


    ];
    public $timestamps = false;

    protected $field_main = 'id';

    public static function getRulesModel()
    {
        $rules = ["source" => "required|max:350",
            "title" => "required",
            "description" => "required",
            "state" => "required",
            "has_source" => "required|numeric",
            "entity" => "required|max:200",
            "entity_id" => "required|max:200",
            "url_manager" => "required",
            "gamification_id" => "required|numeric",
            "gamification_type_activity_id" => "required|numeric",
            "is_url" => "required|numeric",
            "type_manager" => "required|numeric",
            "user_id" => "required|numeric",
            "unique_code" => "required",
            "allow_golden" => "required",
            "icon_class" => "required",
            "tracking_click_type_id" => "required",
            "tracking_source_id" => "required",
            "execution_channel" => "required",

        ];
        return $rules;
    }


    /*MANAGER MAINS*/

    public function getAdmin($params)
    {
        $sort = 'desc';
        $field = $this->field_main;
        $query = DB::table($this->table);

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "$this->table.id,$this->table.source,$this->table.title,$this->table.subtitle,$this->table.description,$this->table.state,$this->table.has_source,$this->table.entity,$this->table.entity_id,$this->table.url_manager,gamification.value as gamification,
    $this->table.valid_from,$this->table.valid_until,$this->table.frequency_limit_type,$this->table.frequency_limit_value,$this->table.execution_channel,
 $this->table.campaign_code_template,
tracking_click_types.id tracking_type_code,tracking_click_types.code tracking_type_code_view,CONCAT(tracking_click_types.code,'-',tracking_click_types.uid) tracking_type_name,
tracking_sources.id tracking_source_code,tracking_sources.code tracking_source_code_view,CONCAT(tracking_sources.code ,'-',tracking_sources.uid) tracking_source_name,

gamification.id as gamification_id,
gamification_type_activity.title as gamification_type_activity,
gamification_type_activity.id as gamification_type_activity_id,
gamification_by_points.points,gamification_by_points.id gamification_by_points_id,
$this->table.is_url,$this->table.type_manager,$this->table.unique_code";
        $selectString .= ",
CASE
  WHEN $this->table.entity = 1 THEN 'product'
  WHEN $this->table.entity = 3 THEN 'business_form'
  WHEN $this->table.entity = 4 THEN 'business_route'
  ELSE 'none'
END as entity_table,

CASE
  WHEN $this->table.entity = 1 THEN product.name
  WHEN $this->table.entity = 3 THEN business_form.name
  WHEN $this->table.entity = 4 THEN business_route.name
  ELSE NULL
END as entity_name
";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('gamification', 'gamification.id', '=', $this->table . '.gamification_id');
        $query->join('gamification_type_activity', 'gamification_type_activity.id', '=', $this->table . '.gamification_type_activity_id');
        $query->join('gamification_by_points', $this->table . '.id', '=', 'gamification_by_points.gamification_by_process_id');

        $query->join('tracking_click_types', $this->table . '.tracking_click_type_id', '=', 'tracking_click_types.id');
        $query->join('tracking_sources', $this->table . '.tracking_source_id', '=', 'tracking_sources.id');

        $gamification_id = ($params['filters']['gamification_id']);
        $query->where($this->table . '.gamification_id', '=', $gamification_id);

        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;

            $query->where(function ($query) use (
                $likeSet
            ) {

                $query->where($this->table . '.title', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.subtitle', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.url_manager', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.unique_code', 'like', '%' . $likeSet . '%');

                $query->orWhere("gamification.value", 'like', '%' . $likeSet . '%');
                $query->orWhere("gamification_by_points.points", 'like', '%' . $likeSet . '%');
                $query->orWhere("tracking_click_types.uid", 'like', '%' . $likeSet . '%');
                $query->orWhere("tracking_sources.uid", 'like', '%' . $likeSet . '%');


            });
        }
        $tableRelation = 'product as product';
        $tableRelationMain = 'gamification_by_process';
        $paramsCurrent = [
            'tableRelation' => $tableRelation,
            'tableRelationMain' => $tableRelationMain
        ];
        $query->leftJoin($tableRelation, function ($query)
        use (
            $paramsCurrent
        ) {
            $tableRelation = "product";
            $tableRelationMain = $paramsCurrent['tableRelationMain'];
            $query->on($tableRelation . '.id', '=', $tableRelationMain . '.entity_id');
        });


        $tableRelation = 'askwer_form as business_form';
        $tableRelationMain = 'gamification_by_process';
        $paramsCurrent = [
            'tableRelation' => $tableRelation,
            'tableRelationMain' => $tableRelationMain
        ];
        $query->leftJoin($tableRelation, function ($query)
        use (
            $paramsCurrent
        ) {
            $tableRelation = "business_form";
            $tableRelationMain = $paramsCurrent['tableRelationMain'];
            $query->on($tableRelation . '.id', '=', $tableRelationMain . '.entity_id');
        });

        $tableRelation = 'routes_drawing as business_route';
        $tableRelationMain = 'gamification_by_process';
        $paramsCurrent = [
            'tableRelation' => $tableRelation,
            'tableRelationMain' => $tableRelationMain
        ];
        $query->leftJoin($tableRelation, function ($query)
        use (
            $paramsCurrent
        ) {
            $tableRelation = "business_route";
            $tableRelationMain = $paramsCurrent['tableRelationMain'];
            $query->on($tableRelation . '.id', '=', $tableRelationMain . '.entity_id');
        });
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


    public function saveData($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        DB::beginTransaction();
        try {
            $modelName = 'GamificationByProcess';
            $model = new GamificationByProcess();
            $modelChildren = null;
            $createUpdate = true;

            $modelMultimedia = new Multimedia;
            $auxResource = "";
            if (isset($attributesPost["id"]) && $attributesPost["id"] != "null" && $attributesPost["id"] != "-1") {
                $model = GamificationByProcess::find($attributesPost['id']);
                $createUpdate = false;
                $modelChildren = GamificationByPoints::find($attributesPost['gamification_by_points_id']);
                $auxResource = $model->source;
            } else {
                $modelChildren = new GamificationByPoints();

                $createUpdate = true;
            }

            $gamificationByProcessData = $attributesPost;
            $gamificationByProcessData["allow_golden"] = 1;
            $gamificationByProcessData["icon_class"] = "fa fa-data";

            $source = $gamificationByProcessData["source"];
            $pathSet = "/uploads/gamification/gamificationByProcess";
            $change = $gamificationByProcessData["change"];
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
                $source = $successMultimediaModel['source'];
                $gamificationByProcessData['source'] = $source;

                $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $gamificationByProcessData, 'attributesData' => $this->attributesData));
                $user = Auth::user();
                $user_id = $user->id;
                $attributesSet['user_id'] = $user_id;

                $paramsValidate = array(
                    'modelAttributes' => $attributesSet,
                    'rules' => self::getRulesModel(),

                );

                $validateResult = $this->validateModel($paramsValidate);
                $success = $validateResult["success"];
                $data = [];
                if ($success) {


                    $model->fill($attributesSet);
                    $success = $model->save();

                    $gamification_by_process_id = $model->id;
                    $attributesSet = [
                        'gamification_by_process_id' => $gamification_by_process_id,
                        'points' => $attributesPost['points'],

                    ];
                    $data['processModel'] = $model;
                    $paramsValidate = array(
                        'modelAttributes' => $attributesSet,
                        'rules' => GamificationByPoints::getRulesModel(),
                    );

                    $validateResult = GamificationByPoints::validateModel($paramsValidate);
                    $success = $validateResult["success"];
                    if ($success) {
                        $modelChildren->fill($attributesSet);
                        $success = $modelChildren->save();
                        $data['pointsModel'] = $modelChildren;

                    } else {
                        $success = false;
                        $msj = "Problemas al guardar  Points.";
                        $errors = $validateResult["errors"];
                    }


                } else {
                    $success = false;
                    $msj = "Problemas al guardar  GamificationByProcess.";
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
                    'data' => $data,
                    "success" => $success
                ];


            } else {
                $msj = "Problemas al guardar la imagen.";
                DB::rollBack();
                throw new \Exception($msj);
            }


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

    public function getListSelect2($params)
    {
        $textValue = $this->table . '.' . $this->field_main;
        $field = $textValue;
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$textValue as text";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('gamification', 'gamification.id', '=', $this->table . '.gamification_id');
        $query->join('gamification_type_activity', 'gamification_type_activity.id', '=', $this->table . '.gamification_type_activity_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.source', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.title', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.subtitle', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.state', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.has_source', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.entity', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.entity_id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.url_manager', 'like', '%' . $likeSet . '%');
            $query->orWhere("gamification.value", 'like', '%' . $likeSet . '%');
            $query->orWhere("gamification_type_activity.source", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.is_url', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.type_manager', 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    private function applyDistanceFilter($query, array $filters): void
    {
        $distanceKm = (float)($filters['distance'] ?? 0);
        $lat = (float)($filters['lat'] ?? 0);
        $lng = (float)($filters['lng'] ?? 0);

        if ($distanceKm <= 0) return;

        // ✅ distancia en KM
        $haversine = "
        (6371 * acos(
            cos(radians(?)) * cos(radians(business.street_lat)) *
            cos(radians(business.street_lng) - radians(?)) +
            sin(radians(?)) * sin(radians(business.street_lat))
        ))
    ";


        // ✅ filtro en WHERE (no HAVING) -> evita el bug en el subquery count
        $query->whereRaw("$haversine <= ?", [$lat, $lng, $lat, $distanceKm]);

    }


    private function applySubcategoryFilter($query, array $filters): void
    {
        $idsString = $filters['subCategoryIdsString'] ?? null;
        if (!$idsString) return;

        $ids = array_values(array_filter(array_map('intval', explode(',', $idsString))));
        if (empty($ids)) return;

        $query
            ->whereIn('business_subcategories.id', $ids);
    }


    public function getAdminGamificationFrontendHome(array $params): array
    {
        $table = $this->table;
        $primaryKey = $table . '.id';

        $sort = 'asc';
        $field = $this->field_main;

        if (!empty($params['sort']) && is_array($params['sort'])) {
            $sortField = array_key_first($params['sort']);
            $sortDir = strtolower($params['sort'][$sortField] ?? 'asc');

            $allowedSortFields = [
                "$table.id",
                "$table.title",
                "$table.subtitle",
                "$table.state",
                "$table.valid_from",
                "$table.valid_until",
                "gamification.value",
                "gamification_by_points.points",
                // si quieres ordenar por distancia:
                // "distance_km",
            ];

            if (in_array($sortField, $allowedSortFields, true)) {
                $field = $sortField;
            }
            $sort = in_array($sortDir, ['asc', 'desc'], true) ? $sortDir : 'asc';
        }

        $page = max((int)($params['current'] ?? 1), 1);
        $perPage = (int)($params['rowCount'] ?? 10);

        $baseQuery = DB::table($table)
            ->join('gamification', 'gamification.id', '=', $table . '.gamification_id')
            ->join('gamification_type_activity', 'gamification_type_activity.id', '=', $table . '.gamification_type_activity_id')
            ->join('gamification_by_points', $table . '.id', '=', 'gamification_by_points.gamification_by_process_id')
            ->join('business_by_gamification', 'gamification.id', '=', 'business_by_gamification.gamification_id')
            ->join('business', 'business.id', '=', 'business_by_gamification.business_id')
            ->join('business_location', 'business.id', '=', 'business_location.business_id')
            ->join('zones', 'business_location.zones_id', '=', 'zones.id')
            ->join('cities', 'zones.city_id', '=', 'cities.id')
            ->join('provinces', 'cities.province_id', '=', 'provinces.id')
            ->join('users', $table . '.user_id', '=', 'users.id')
            ->join('tracking_click_types', $table . '.tracking_click_type_id', '=', 'tracking_click_types.id')
            ->join('tracking_sources', $table . '.tracking_source_id', '=', 'tracking_sources.id')
            ->join('business_subcategories', 'business_subcategories.id', '=', 'business.business_subcategories_id');

        //->leftJoin('product', 'product.id', '=', $table . '.entity_id')

        // Search
        if (isset($params['searchPhrase']) && $params['searchPhrase'] !== "") {
            $searchPhrase = trim((string)($params['searchPhrase'] ?? ''));
            if ($searchPhrase !== '') {
                $like = '%' . $searchPhrase . '%';
                $baseQuery->where(function ($q) use ($table, $like) {
                    $q->where($table . '.title', 'like', $like)
                        ->orWhere($table . '.subtitle', 'like', $like)
                        ->orWhere($table . '.description', 'like', $like)
                        ->orWhere($table . '.url_manager', 'like', $like)
                        ->orWhere($table . '.unique_code', 'like', $like)
                        ->orWhere('gamification.value', 'like', $like)
                        ->orWhere('gamification_by_points.points', 'like', $like);
                });
            }
        }
        // ✅ Filtros
        $filters = $params['filters'] ?? [];
        $allowLocation = isset($filters["check"]) && ($filters["check"] == "true");

        if ($allowLocation) {
            $this->applyDistanceFilter($baseQuery, $filters);
        }
        // subcategorías (opcional)
        $this->applySubcategoryFilter($baseQuery, $filters);
        // ✅ TOTAL robusto incluso con HAVING (subquery)
        $total = DB::query()
            ->fromSub(
                (clone $baseQuery)->select($primaryKey)->distinct(),
                't'
            )
            ->count();

        // Data select
        $select = [
            "$table.id",
            "$table.source",
            "$table.title",
            "$table.subtitle",
            "$table.description",
            "$table.state",
            "$table.has_source",
            "$table.entity",
            "$table.entity_id",
            "$table.url_manager",
            "$table.valid_from",
            "$table.valid_until",
            "$table.frequency_limit_type",
            "$table.frequency_limit_value",
            "$table.execution_channel",

            "tracking_click_types.id as tracking_type_code",
            "tracking_click_types.code as tracking_type_code_view",
            DB::raw("CONCAT(tracking_click_types.code,'-',tracking_click_types.uid) as tracking_type_name"),

            "tracking_sources.id as tracking_source_code",
            "tracking_sources.code as tracking_source_code_view",
            DB::raw("CONCAT(tracking_sources.code,'-',tracking_sources.uid) as tracking_source_name"),

            "business.title as business_name",
            "business.id as business_id",
            "business.street_1 as business_street_one",
            "business.street_2 as business_street_two",
            "business.street_lat as business_lat",
            "business.street_lng as business_lng",

            "zones.name as zones_name",
            "cities.name as cities_name",
            "provinces.name as provinces_name",

            "gamification.value as gamification",
            "gamification.id as gamification_id",

            "gamification_type_activity.title as gamification_type_activity",
            "gamification_type_activity.id as gamification_type_activity_id",

            "gamification_by_points.points",
            "gamification_by_points.id as gamification_by_points_id",

            "$table.is_url",
            "$table.type_manager",
            "$table.unique_code",

            //  "product.id as product_id",
            //  "product.name as product_name",

            "$table.user_id",
            "users.name as user_name",
            "users.avatar as avatarImgUser",
            "business_subcategories.name as business_subcategories_name"

        ];

        if ($allowLocation) {

            $lat = (float)($filters['lat'] ?? 0);
            $lng = (float)($filters['lng'] ?? 0);
            $distanceKm = (float)($filters['distance'] ?? 0);
            $distanceSql = "
    (6371 * acos(
        cos(radians($lat)) * cos(radians(business.street_lat)) *
        cos(radians(business.street_lng) - radians($lng)) +
        sin(radians($lat)) * sin(radians(business.street_lat))
    ))
";
            if ($distanceKm > 0) {
                $select[] = DB::raw("$distanceSql AS distance_km");
            }
        }
        $dataQuery = (clone $baseQuery)
            ->select($select)
            ->orderBy($field, $sort);

        if ($perPage > 0) {
            $offset = ($page - 1) * $perPage;
            $dataQuery->offset($offset)->limit($perPage);
        }

        $rows = $dataQuery->get();


        return [
            'total' => $total,
            'rows' => $rows,
            'current' => $page,
            'rowCount' => $perPage,
        ];
    }

    public function getSubcategoriesDataByProcess(): array
    {
        $table = $this->table;

        $baseQuery = DB::table($table)
            ->join('gamification', 'gamification.id', '=', $table . '.gamification_id')
            ->join('business_by_gamification', 'gamification.id', '=', 'business_by_gamification.gamification_id')
            ->join('business', 'business.id', '=', 'business_by_gamification.business_id')
            ->join('business_subcategories', 'business_subcategories.id', '=', 'business.business_subcategories_id')
            ->join('business_categories', 'business_subcategories.business_categories_id', '=', 'business_categories.id');

        $rows = (clone $baseQuery)
            ->select([
                'business_categories.id as category_id',
                'business_categories.name as category_name',
                'business_subcategories.id as subcategory_id',
                'business_subcategories.name as subcategory_name',
                'business_categories.icon_class as category_icon_class',
                'business_subcategories.icon_class as subcategory_icon_class',

            ])
            ->distinct()
            ->orderBy('business_categories.name', 'asc')
            ->orderBy('business_subcategories.name', 'asc')
            ->get();

        // Agrupa a estructura final
        $categories = $rows
            ->groupBy('category_id')
            ->map(function ($items) {
                $first = $items->first();
                return [
                    'id' => (int)$first->category_id,
                    'text' => $first->category_name,
                    'icon' => $first->category_icon_class, // aquí luego mapeas icono por categoría si quieres
                    'children' => $items->map(function ($row) {
                        return [
                            'id' => (int)$row->subcategory_id,
                            'text' => $row->subcategory_name,
                            'icon' => $row->subcategory_icon_class, // aquí luego mapeas icono por subcategoría si quieres
                        ];
                    })->values()->toArray(),
                ];
            })
            ->values()
            ->toArray();


        return $categories;
    }

    public function getAdminGamificationFrontend($params)
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

        $selectString = "$this->table.id,$this->table.source,$this->table.title,$this->table.subtitle,$this->table.description,$this->table.state,$this->table.has_source,$this->table.entity,$this->table.entity_id,$this->table.url_manager
        ,$this->table.valid_from,$this->table.valid_until,$this->table.frequency_limit_type,$this->table.frequency_limit_value,$this->table.execution_channel,

        tracking_click_types.id tracking_type_code,tracking_click_types.code tracking_type_code_view,CONCAT(tracking_click_types.code,'-',tracking_click_types.uid) tracking_type_name,
tracking_sources.id tracking_source_code,tracking_sources.code tracking_source_code_view,CONCAT(tracking_sources.code ,'-',tracking_sources.uid) tracking_source_name,
business.title business_name, business.id business_id
        ,gamification.value as gamification,
gamification.id as gamification_id,
gamification_type_activity.title as gamification_type_activity,
gamification_type_activity.id as gamification_type_activity_id,
gamification_by_points.points,gamification_by_points.id gamification_by_points_id,
$this->table.is_url,$this->table.type_manager,$this->table.unique_code
,product.id product_id,product.name product_name";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('gamification', 'gamification.id', '=', $this->table . '.gamification_id');
        $query->join('gamification_type_activity', 'gamification_type_activity.id', '=', $this->table . '.gamification_type_activity_id');
        $query->join('gamification_by_points', $this->table . '.id', '=', 'gamification_by_points.gamification_by_process_id');
        $query->join('business_by_gamification', 'gamification.id', '=', 'business_by_gamification.gamification_id');
        $query->join('business', 'business.id', '=', 'business_by_gamification.business_id');
        $query->join('tracking_click_types', $this->table . '.tracking_click_type_id', '=', 'tracking_click_types.id');
        $query->join('tracking_sources', $this->table . '.tracking_source_id', '=', 'tracking_sources.id');

        $business_id = ($params['filters']['business_id']);
        $query->where('business_by_gamification.business_id', '=', $business_id);
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;

            $query->where(function ($query) use (
                $likeSet
            ) {

                $query->where($this->table . '.title', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.subtitle', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.url_manager', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.unique_code', 'like', '%' . $likeSet . '%');
                $query->orWhere("gamification.value", 'like', '%' . $likeSet . '%');
                $query->orWhere("gamification_by_points.points", 'like', '%' . $likeSet . '%');
            });
        }
        $tableRelation = 'product';
        $tableRelationMain = 'gamification_by_process';
        $paramsCurrent = [
            'tableRelation' => $tableRelation,
            'tableRelationMain' => $tableRelationMain
        ];
        $query->leftJoin($tableRelation, function ($query)
        use (
            $paramsCurrent
        ) {
            $tableRelation = $paramsCurrent['tableRelation'];
            $tableRelationMain = $paramsCurrent['tableRelationMain'];
            $query->on($tableRelation . '.id', '=', $tableRelationMain . '.entity_id');
        });
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

    public function getProcessDefaultByBusinessData($params)
    {
        $gamification_id = $params["gamification_id"];
        $business_id = $params["business_id"];
        $business = $params["business"];

        $SHARE_PROFILE_WHATSAPP_MC = ConfigurationGamificationUtil::getProcessFieldsByUniqueCode("SHARE_PROFILE_WHATSAPP_MC");

        $currentInformation = ["gamification_id" => $gamification_id, "business_id" => $business_id];
        $paramsProcess = array_merge($SHARE_PROFILE_WHATSAPP_MC, $currentInformation);
        $SHARE_PROFILE_WHATSAPP_MC = $this->getTypeProcessDefaultByBusiness($paramsProcess);


        $VIEW_RATE_WEB_MC = ConfigurationGamificationUtil::getProcessFieldsByUniqueCode("VIEW_RATE_WEB_MC");
        $paramsProcess = array_merge($VIEW_RATE_WEB_MC, $currentInformation);
        $VIEW_RATE_WEB_MC_DATA = $this->getTypeProcessDefaultByBusiness($paramsProcess);

        $VIEW_REWARDS_WEB_MC = ConfigurationGamificationUtil::getProcessFieldsByUniqueCode("VIEW_REWARDS_WEB_MC");
        $paramsProcess = array_merge($VIEW_REWARDS_WEB_MC, $currentInformation);
        $VIEW_REWARDS_WEB_MC_DATA = $this->getTypeProcessDefaultByBusiness($paramsProcess);



        $REGISTER_PROFILE_FORM_SUBMIT_MC= ConfigurationGamificationUtil::getProcessFieldsByUniqueCode("REGISTER_PROFILE_FORM_SUBMIT_MC");
        $paramsProcess = array_merge($REGISTER_PROFILE_FORM_SUBMIT_MC, $currentInformation);
        $REGISTER_PROFILE_FORM_SUBMIT_MC_DATA = $this->getTypeProcessDefaultByBusiness($paramsProcess);


        $REGISTER_RATE_FORM_SUBMIT_MC= ConfigurationGamificationUtil::getProcessFieldsByUniqueCode("REGISTER_RATE_FORM_SUBMIT_MC");
        $paramsProcess = array_merge($REGISTER_RATE_FORM_SUBMIT_MC, $currentInformation);
        $REGISTER_RATE_FORM_SUBMIT_MC_DATA = $this->getTypeProcessDefaultByBusiness($paramsProcess);

        $VIEW_REGISTERS_RATE_QR_SCAN_TICKET_MC= ConfigurationGamificationUtil::getProcessFieldsByUniqueCode("VIEW_REGISTERS_RATE_QR_SCAN_TICKET_MC");
        $paramsProcess = array_merge($VIEW_REGISTERS_RATE_QR_SCAN_TICKET_MC, $currentInformation);
        $VIEW_REGISTERS_RATE_QR_SCAN_TICKET_MC_DATA = $this->getTypeProcessDefaultByBusiness($paramsProcess);


        $REGISTER_SUGGESTION_SUBMIT_MC= ConfigurationGamificationUtil::getProcessFieldsByUniqueCode("REGISTER_SUGGESTION_SUBMIT_MC");
        $paramsProcess = array_merge($REGISTER_SUGGESTION_SUBMIT_MC, $currentInformation);
        $REGISTER_SUGGESTION_SUBMIT_MC_DATA = $this->getTypeProcessDefaultByBusiness($paramsProcess);

        $VIEW_SUGGESTION_WEB_MC= ConfigurationGamificationUtil::getProcessFieldsByUniqueCode("VIEW_SUGGESTION_WEB_MC");
        $paramsProcess = array_merge($VIEW_SUGGESTION_WEB_MC, $currentInformation);
        $VIEW_SUGGESTION_WEB_MC_DATA = $this->getTypeProcessDefaultByBusiness($paramsProcess);

        $VIEW_REGISTERS_SUGGESTION_WEB_MC= ConfigurationGamificationUtil::getProcessFieldsByUniqueCode("VIEW_REGISTERS_SUGGESTION_WEB_MC");
        $paramsProcess = array_merge($VIEW_REGISTERS_SUGGESTION_WEB_MC, $currentInformation);
        $VIEW_REGISTERS_SUGGESTION_WEB_MC_DATA = $this->getTypeProcessDefaultByBusiness($paramsProcess);


        $VIEW_TASK_QR_SCAN_TICKET_MC= ConfigurationGamificationUtil::getProcessFieldsByUniqueCode("VIEW_TASK_QR_SCAN_TICKET_MC");
        $paramsProcess = array_merge($VIEW_TASK_QR_SCAN_TICKET_MC, $currentInformation);
        $VIEW_TASK_QR_SCAN_TICKET_MC_DATA = $this->getTypeProcessDefaultByBusiness($paramsProcess);

        $VIEW_TASK_WEB_MC= ConfigurationGamificationUtil::getProcessFieldsByUniqueCode("VIEW_TASK_WEB_MC");
        $paramsProcess = array_merge($VIEW_TASK_WEB_MC, $currentInformation);
        $VIEW_TASK_WEB_MC_DATA = $this->getTypeProcessDefaultByBusiness($paramsProcess);


        $AYNI_YACHAY_SHOP_WEB_MC= ConfigurationGamificationUtil::getProcessFieldsByUniqueCode("AYNI_YACHAY_SHOP_WEB_MC");
        $paramsProcess = array_merge($AYNI_YACHAY_SHOP_WEB_MC, $currentInformation);
        $AYNI_YACHAY_SHOP_WEB_MC_DATA = $this->getTypeProcessDefaultByBusiness($paramsProcess);


        $VIEW_PROFILE_WEB_MC= ConfigurationGamificationUtil::getProcessFieldsByUniqueCode("VIEW_PROFILE_WEB_MC");
        $paramsProcess = array_merge($VIEW_PROFILE_WEB_MC, $currentInformation);
        $VIEW_PROFILE_WEB_MC_DATA = $this->getTypeProcessDefaultByBusiness($paramsProcess);
        return [
            "SHARE_PROFILE_WHATSAPP_MC" => [
                "success" => $SHARE_PROFILE_WHATSAPP_MC !== null,
                "data" => $SHARE_PROFILE_WHATSAPP_MC,
                "urlDefault"=>route("rate-register-business")
            ],
            "VIEW_REWARDS_WEB_MC"=>[
                "success" => $VIEW_REWARDS_WEB_MC_DATA !== null,
                "data" => $VIEW_REWARDS_WEB_MC_DATA,
                "urlDefault"=>route("rate-register-business",$business)

            ],
            "AYNI_YACHAY_SHOP_WEB_MC"=>[
                "success" => $AYNI_YACHAY_SHOP_WEB_MC_DATA !== null,
                "data" => $AYNI_YACHAY_SHOP_WEB_MC_DATA,
                "urlDefault"=>route("shop-business",$business)

            ],
            "VIEW_TASK_WEB_MC"=>[
                "success" => $VIEW_TASK_WEB_MC_DATA !== null,
                "data" => $VIEW_TASK_WEB_MC_DATA,
                "urlDefault"=>route('businessPullkay', app()->getLocale())."/".$business
            ],
            "VIEW_TASK_QR_SCAN_TICKET_MC"=>[
                "success" => $VIEW_TASK_QR_SCAN_TICKET_MC_DATA !== null,
                "data" => $VIEW_TASK_QR_SCAN_TICKET_MC_DATA,
                "urlDefault"=>route("rate-register-business",$business)
            ],
            "VIEW_REGISTERS_SUGGESTION_WEB_MC"=>[
                "success" => $VIEW_REGISTERS_SUGGESTION_WEB_MC_DATA !== null,
                "data" => $VIEW_REGISTERS_SUGGESTION_WEB_MC_DATA,
                "urlDefault"=>route("rate-register-business",$business)
            ],
            "VIEW_SUGGESTION_WEB_MC"=>[
                "success" => $VIEW_SUGGESTION_WEB_MC_DATA !== null,
                "data" => $VIEW_SUGGESTION_WEB_MC_DATA,
                "urlDefault"=>route("rates-registers-business",$business)
            ],
            "REGISTER_SUGGESTION_SUBMIT_MC"=>[
                "success" => $REGISTER_SUGGESTION_SUBMIT_MC_DATA !== null,
                "data" => $REGISTER_SUGGESTION_SUBMIT_MC_DATA,
                "urlDefault"=>route("rate-register-business",$business)
            ],
            "VIEW_REGISTERS_RATE_QR_SCAN_TICKET_MC"=>[
                "success" => $VIEW_REGISTERS_RATE_QR_SCAN_TICKET_MC_DATA !== null,
                "data" => $VIEW_REGISTERS_RATE_QR_SCAN_TICKET_MC_DATA,
                "urlDefault"=>route("rate-register-business",$business)
            ],
            "VIEW_RATE_WEB_MC"=>[
                "success" => $VIEW_RATE_WEB_MC_DATA !== null,
                "data" => $VIEW_RATE_WEB_MC_DATA,
                "urlDefault"=>route("rate-register-business",$business)
            ],
            "REGISTER_RATE_FORM_SUBMIT_MC"=>[
                "success" => $REGISTER_RATE_FORM_SUBMIT_MC_DATA !== null,
                "data" => $REGISTER_RATE_FORM_SUBMIT_MC_DATA,
                "urlDefault"=>route("rate-register-business",$business)
            ],
            "REGISTER_PROFILE_FORM_SUBMIT_MC"=>[
                "success" => $REGISTER_PROFILE_FORM_SUBMIT_MC_DATA !== null,
                "data" => $REGISTER_PROFILE_FORM_SUBMIT_MC_DATA,
                "urlDefault"=>route("rate-register-business",$business)
            ],
            "VIEW_PROFILE_WEB_MC"=>[
                "success" => $VIEW_PROFILE_WEB_MC_DATA !== null,
                "data" => $VIEW_PROFILE_WEB_MC_DATA,
                "urlDefault"=>route("rate-register-business",$business)
            ],
        ];

    }

    public function getTypeProcessDefaultByBusiness($params)
    {
        $gamification_id = $params["gamification_id"];
        $business_id = $params["business_id"];
        $unique_code = $params["unique_code"];
        $tracking_source_id = $params["tracking_source_id"];
        $gamification_type_activity_id = $params["gamification_type_activity_id"];
        $execution_channel = $params["execution_channel"];
        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$this->table.source,$this->table.title,$this->table.subtitle,$this->table.description,$this->table.state,$this->table.has_source,$this->table.entity,$this->table.entity_id,$this->table.url_manager
        ,$this->table.valid_from,$this->table.valid_until,$this->table.frequency_limit_type,$this->table.frequency_limit_value,$this->table.execution_channel,

        tracking_click_types.id tracking_type_code,tracking_click_types.code tracking_type_code_view,CONCAT(tracking_click_types.code,'-',tracking_click_types.uid) tracking_type_name,
tracking_sources.id tracking_source_code,tracking_sources.code tracking_source_code_view,CONCAT(tracking_sources.code ,'-',tracking_sources.uid) tracking_source_name,
business.title business_name, business.id business_id
        ,gamification.value as gamification,
gamification.id as gamification_id,
gamification_type_activity.title as gamification_type_activity,
gamification_type_activity.id as gamification_type_activity_id,
gamification_by_points.points,gamification_by_points.id gamification_by_points_id,
$this->table.is_url,$this->table.type_manager,$this->table.unique_code";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('gamification', 'gamification.id', '=', $this->table . '.gamification_id');
        $query->join('gamification_type_activity', 'gamification_type_activity.id', '=', $this->table . '.gamification_type_activity_id');
        $query->join('gamification_by_points', $this->table . '.id', '=', 'gamification_by_points.gamification_by_process_id');
        $query->join('business_by_gamification', 'gamification.id', '=', 'business_by_gamification.gamification_id');
        $query->join('business', 'business.id', '=', 'business_by_gamification.business_id');
        $query->join('tracking_click_types', $this->table . '.tracking_click_type_id', '=', 'tracking_click_types.id');
        $query->join('tracking_sources', $this->table . '.tracking_source_id', '=', 'tracking_sources.id');
        $query->where('gamification_by_process.gamification_id', '=', $gamification_id);
        $query->where('business_by_gamification.business_id', '=', $business_id);
        $query->where('gamification_by_process.unique_code', '=', $unique_code);
        $query->where('gamification_by_process.tracking_source_id', '=', $tracking_source_id);
        $query->where('gamification_by_process.gamification_type_activity_id', '=', $gamification_type_activity_id);
        $query->where('gamification_by_process.execution_channel', '=', $execution_channel);


        $query->orderBy($field, $sort);

        $data = $query->first();


        return $data;
    }

}
