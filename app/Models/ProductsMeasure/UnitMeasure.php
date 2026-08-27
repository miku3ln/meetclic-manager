<?php

namespace App\Models\ProductsMeasure;

use App\Core\Traits\RepositoryTrait;
use App\Models\ModelManager;
use Illuminate\Support\Facades\DB;

class UnitMeasure extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    use RepositoryTrait;

    protected $table = 'unit_measure';

    protected $fillable = [
        'product_measure_type_id',
        'name',
        'symbol',
        'factor_to_base',
        'is_base',
        'decimal_precision',
        'state'
    ];

    protected $attributesData = [
        ['column' => 'product_measure_type_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'name', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'symbol', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'factor_to_base', 'type' => 'double', 'defaultValue' => 1, 'required' => 'true'],
        ['column' => 'is_base', 'type' => 'integer', 'defaultValue' => 0, 'required' => 'false'],
        ['column' => 'decimal_precision', 'type' => 'integer', 'defaultValue' => 2, 'required' => 'false'],
        ['column' => 'state', 'type' => 'string', 'defaultValue' => self::STATE_ACTIVE, 'required' => 'false']
    ];

    public $timestamps = false;

    protected $field_main = 'name';

    public static function getRulesModel()
    {
        return [
            'product_measure_type_id' => 'required|numeric',
            'name' => 'required|string|max:100',
            'symbol' => 'required|string|max:100',
            'factor_to_base' => 'required|numeric',
            'is_base' => 'numeric',
            'decimal_precision' => 'numeric'
        ];
    }

    public function getAdmin($params)
    {
        $tblUnitMeasure = $this->table;
        $tblProductMeasureType = 'product_measure_type';

        $query = DB::table($tblUnitMeasure);

        $query->select([
            $tblUnitMeasure . '.id',
            $tblUnitMeasure . '.product_measure_type_id',
            $tblUnitMeasure . '.name',
            $tblUnitMeasure . '.symbol',
            $tblUnitMeasure . '.factor_to_base',
            $tblUnitMeasure . '.is_base',
            $tblUnitMeasure . '.decimal_precision',
            $tblUnitMeasure . '.state',

            $tblProductMeasureType . '.value as product_measure_type',
            $tblProductMeasureType . '.description as product_measure_type_description',
            $tblProductMeasureType . '.abbreviation as product_measure_type_abbreviation',
            $tblProductMeasureType . '.prefix as product_measure_type_prefix',
            $tblProductMeasureType . '.symbol as product_measure_type_symbol',
            $tblProductMeasureType . '.business_id'
        ]);

        $query->join(
            $tblProductMeasureType,
            $tblUnitMeasure . '.product_measure_type_id',
            '=',
            $tblProductMeasureType . '.id'
        );

        /*
         * Filtro por tipo de medida
         */
        if (!empty($params['filters']['product_measure_type_id'])) {
            $query->where(
                $tblUnitMeasure . '.product_measure_type_id',
                '=',
                $params['filters']['product_measure_type_id']
            );
        }

        /*
         * Filtro por estado
         */
        $params["sortType"]="desc";
        if (!empty($params['filters']['state'])) {
            $query->where(
                $tblUnitMeasure . '.state',
                '=',
                $params['filters']['state']
            );
        }

        /*
         * Filtro por unidad base
         */
        if (
            isset($params['filters']['is_base']) &&
            $params['filters']['is_base'] !== ''
        ) {
            $query->where(
                $tblUnitMeasure . '.is_base',
                '=',
                $params['filters']['is_base']
            );
        }

        /*
         * Búsqueda
         */
        $search = $params['searchPhrase'] ?? null;

        $this->applySearch(
            $query,
            $search,
            [
                $tblUnitMeasure . '.name',
                $tblUnitMeasure . '.symbol',
                $tblProductMeasureType . '.value',
                $tblProductMeasureType . '.description',
                $tblProductMeasureType . '.abbreviation',
                $tblProductMeasureType . '.prefix'
            ]
        );

        /*
         * Paginación y ordenamiento
         */
        return $this->paginateQuery(
            $query,
            $params,
            $tblUnitMeasure . '.id'
        );
    }

    public function saveData($params)
    {
        $success = false;
        $msj = "";
        $result = [];
        $errors = [];

        $attributesPost = $params["attributesPost"]['UnitMeasure'];

        DB::beginTransaction();

        try {

            $model = new UnitMeasure();
            $isUpdate = false;
            if (
                isset($attributesPost["id"]) &&
                $attributesPost["id"] != "null" &&
                $attributesPost["id"] != "-1"
            ) {
                $model = UnitMeasure::find($attributesPost["id"]);
                $isUpdate = true;
                if (!$model) {
                    throw new \Exception("Registro no encontrado.");
                }
            }

            $attributesSet = $this->getValuesModel([
                'fillAble' => $this->fillable,
                'haystack' => $attributesPost,
                'attributesData' => $this->attributesData
            ]);

            $paramsValidate = [
                'inputs' => $attributesSet,
                'rules' => self::getRulesModel()
            ];

            $validateResult = $this->validateModel($paramsValidate);

            $success = $validateResult["success"];

            if ($success) {

                $model->fill($attributesSet);

                $success = $model->save();

                if (!$success) {
                    $msj = "Problemas al guardar UnitMeasure.";
                    DB::rollBack();
                } else {
                    $modelUnitConfig = new MeasureUnitConfig();
                    $is_default = $attributesPost['is_base'];
                    $product_measure_type_id = $attributesPost['product_measure_type_id'];
                    $measure_type_config_id = -1;
                    $unit_measure_id = $model->id;
                    $modelTypeConfig = new MeasureTypeConfig();
                    $modelTypeConfig = $modelTypeConfig->where('product_measure_type_id', $product_measure_type_id)
                        ->first();

                    if ($modelTypeConfig) {
                        $measure_type_config_id = $modelTypeConfig->id;
                    } else {
                        $msj = "Problemas al encontrar Type Configuration.";
                        DB::rollBack();
                    }
                    if ($isUpdate) {
                        $modelUnitConfig = $modelUnitConfig
                            ->where('unit_measure_id', $unit_measure_id)
                            ->first();
                        $modelUnitConfig->is_default = $is_default;
                        $modelUnitConfig->state = 1;
                        $modelUnitConfig->measure_type_config_id = $measure_type_config_id;

                    } else {
                        $attributesSetRelation = [
                            "measure_type_config_id" => $measure_type_config_id,
                            "is_default" => $is_default,
                            "state" => 1,
                            "unit_measure_id" => $unit_measure_id,
                        ];

                        $paramsValidateRelation = [
                            'inputs' => $attributesSetRelation,
                            'rules' => $modelUnitConfig::getRulesModel()
                        ];

                        $validateResult = $modelUnitConfig->validateModel($paramsValidateRelation);

                        $success = $validateResult["success"];
                        if (!$success) {
                            $msj = "Problemas al guardar UnitMeasure Configuration.";
                            DB::rollBack();
                        }else{
                            $modelUnitConfig->fill($attributesSetRelation);

                        }
                    }
                    $modelUnitConfig->save();
                    DB::commit();
                }

            } else {

                $success = false;
                $msj = "Problemas al validar UnitMeasure.";
                $errors = $validateResult["errors"];

                DB::rollBack();
            }

            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "success" => $success
            ];

            return $result;

        } catch (\Exception $e) {

            DB::rollBack();

            $msj = $e->getMessage();

            return [
                "success" => false,
                "msj" => $msj,
                "errors" => $errors
            ];
        }
    }

    public function getListSelect2($params)
    {
        $tblUnitMeasure = $this->table;
        $tblProductMeasureType = 'product_measure_type';

        $field = $tblUnitMeasure . '.name';

        $query = DB::table($tblUnitMeasure);

        $query->select([
            $tblUnitMeasure . '.id',

            DB::raw(
                "CONCAT(" .
                $tblUnitMeasure . ".name, ' (', " .
                $tblUnitMeasure . ".symbol, ')') as text"
            ),

            $tblUnitMeasure . '.name',
            $tblUnitMeasure . '.symbol',
            $tblUnitMeasure . '.factor_to_base',
            $tblUnitMeasure . '.decimal_precision',
            $tblUnitMeasure . '.product_measure_type_id',
            $tblUnitMeasure . '.is_base',
            $tblUnitMeasure . '.state',

            $tblProductMeasureType . '.value as product_measure_type',
            $tblProductMeasureType . '.description as product_measure_type_description'
        ]);

        $query->join(
            $tblProductMeasureType,
            $tblProductMeasureType . '.id',
            '=',
            $tblUnitMeasure . '.product_measure_type_id'
        );

        /*
         * Solo unidades activas
         */
        $query->where(
            $tblUnitMeasure . '.state',
            '=',
            self::STATE_ACTIVE
        );

        /*
         * Buscar
         */
        if (
            isset($params["filters"]['search_value']["term"]) &&
            $params["filters"]['search_value']["term"] !== ''
        ) {

            $likeSet = $params["filters"]['search_value']["term"];

            $query->where(function ($q) use (
                $likeSet,
                $tblUnitMeasure,
                $tblProductMeasureType
            ) {

                $q->where(
                    $tblUnitMeasure . '.id',
                    'like',
                    '%' . $likeSet . '%'
                );

                $q->orWhere(
                    $tblUnitMeasure . '.name',
                    'like',
                    '%' . $likeSet . '%'
                );

                $q->orWhere(
                    $tblUnitMeasure . '.symbol',
                    'like',
                    '%' . $likeSet . '%'
                );

                $q->orWhere(
                    $tblProductMeasureType . '.value',
                    'like',
                    '%' . $likeSet . '%'
                );

                $q->orWhere(
                    $tblProductMeasureType . '.description',
                    'like',
                    '%' . $likeSet . '%'
                );
            });
        }

        /*
         * Filtrar por tipo de medida
         */
        if (
            isset($params["filters"]['product_measure_type_id']) &&
            $params["filters"]['product_measure_type_id'] !== ''
        ) {

            $query->where(
                $tblUnitMeasure . '.product_measure_type_id',
                '=',
                $params["filters"]['product_measure_type_id']
            );
        }

        /*
         * Excluir una unidad
         *
         * Útil para que:
         * origen != destino
         */
        if (
            isset($params["filters"]['exclude_unit_measure_id']) &&
            $params["filters"]['exclude_unit_measure_id'] !== ''
        ) {

            $query->where(
                $tblUnitMeasure . '.id',
                '!=',
                $params["filters"]['exclude_unit_measure_id']
            );
        }

        $query
            ->limit(10)
            ->orderBy($field, 'asc');

        return $query->get()->toArray();
    }
}
