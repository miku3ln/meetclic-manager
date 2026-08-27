<?php

namespace App\Models\ProductsMeasure;

use App\Core\Traits\RepositoryTrait;
use App\Models\ModelManager;
use Illuminate\Support\Facades\DB;

class MeasureConversion extends ModelManager
{
    const TYPE_STANDARD = 'STANDARD';
    const TYPE_CUSTOM = 'CUSTOM';

    const STATE_ACTIVE = 1;
    const STATE_INACTIVE = 0;

    use RepositoryTrait;

    protected $table = 'measure_conversion';

    protected $fillable = [
        'business_id',
        'product_id',
        'from_unit_measure_id',
        'to_unit_measure_id',
        'factor',
        'conversion_type',
        'description',
        'state'
    ];

    protected $attributesData = [
        [
            'column' => 'business_id',
            'type' => 'integer',
            'defaultValue' => 0,
            'required' => 'true'
        ],
        [
            'column' => 'product_id',
            'type' => 'integer',
            'defaultValue' => null,
            'required' => 'false'
        ],
        [
            'column' => 'from_unit_measure_id',
            'type' => 'integer',
            'defaultValue' => '',
            'required' => 'true'
        ],
        [
            'column' => 'to_unit_measure_id',
            'type' => 'integer',
            'defaultValue' => '',
            'required' => 'true'
        ],
        [
            'column' => 'factor',
            'type' => 'double',
            'defaultValue' => 1,
            'required' => 'true'
        ],
        [
            'column' => 'conversion_type',
            'type' => 'string',
            'defaultValue' => self::TYPE_STANDARD,
            'required' => 'true'
        ],
        [
            'column' => 'description',
            'type' => 'string',
            'defaultValue' => '',
            'required' => 'false'
        ],
        [
            'column' => 'state',
            'type' => 'integer',
            'defaultValue' => self::STATE_ACTIVE,
            'required' => 'false'
        ]
    ];

    public $timestamps = false;

    protected $field_main = 'description';

    public static function getRulesModel()
    {
        return [
            'business_id' => 'required|numeric',
            'product_id' => 'nullable|numeric',
            'from_unit_measure_id' => 'required|numeric',
            'to_unit_measure_id' => 'required|numeric|different:from_unit_measure_id',
            'factor' => 'required|numeric',
            'conversion_type' => 'required|string|max:50',
            'description' => 'nullable|string|max:255',
            'state' => 'numeric'
        ];
    }

    public function getAdmin($params)
    {
        $tblMeasureConversion = $this->table;

        $tblFromUnit = 'unit_measure as from_unit';
        $tblToUnit = 'unit_measure as to_unit';

        $query = DB::table($tblMeasureConversion);

        $query->select([
            $tblMeasureConversion . '.id',
            $tblMeasureConversion . '.business_id',
            $tblMeasureConversion . '.product_id',
            $tblMeasureConversion . '.from_unit_measure_id',
            $tblMeasureConversion . '.to_unit_measure_id',
            $tblMeasureConversion . '.factor',
            $tblMeasureConversion . '.conversion_type',
            $tblMeasureConversion . '.description',
            $tblMeasureConversion . '.state',

            'from_unit.name as from_unit_measure',
            'from_unit.factor_to_base as from_unit_factor_to_base',
            'from_unit.decimal_precision as from_unit_decimal_precision',

            'from_unit.symbol as from_unit_measure_symbol',
            'from_unit.product_measure_type_id as from_product_measure_type_id',

            'to_unit.name as to_unit_measure',
            'to_unit.symbol as to_unit_measure_symbol',
            'to_unit.factor_to_base as to_unit_factor_to_base',
            'to_unit.decimal_precision as to_unit_decimal_precision',

            'to_unit.product_measure_type_id as to_product_measure_type_id'
        ]);

        $query->join(
            'unit_measure as from_unit',
            $tblMeasureConversion . '.from_unit_measure_id',
            '=',
            'from_unit.id'
        );

        $query->join(
            'unit_measure as to_unit',
            $tblMeasureConversion . '.to_unit_measure_id',
            '=',
            'to_unit.id'
        );

        /*
         * Filtro por empresa
         */
        if (
            isset($params['filters']['business_id']) &&
            $params['filters']['business_id'] !== ''
        ) {
            $query->where(
                $tblMeasureConversion . '.business_id',
                '=',
                $params['filters']['business_id']
            );
        }

        /*
         * Filtro por producto
         */
        if (
            isset($params['filters']['product_id']) &&
            $params['filters']['product_id'] !== ''
        ) {
            $query->where(
                $tblMeasureConversion . '.product_id',
                '=',
                $params['filters']['product_id']
            );
        }

        /*
         * Desde unidad
         */
        if (!empty($params['filters']['from_unit_measure_id'])) {
            $query->where(
                $tblMeasureConversion . '.from_unit_measure_id',
                '=',
                $params['filters']['from_unit_measure_id']
            );
        }

        /*
         * Hacia unidad
         */
        if (!empty($params['filters']['to_unit_measure_id'])) {
            $query->where(
                $tblMeasureConversion . '.to_unit_measure_id',
                '=',
                $params['filters']['to_unit_measure_id']
            );
        }

        /*
         * Tipo de conversión
         */
        if (!empty($params['filters']['conversion_type'])) {
            $query->where(
                $tblMeasureConversion . '.conversion_type',
                '=',
                $params['filters']['conversion_type']
            );
        }

        /*
         * Estado
         */
        if (
            isset($params['filters']['state']) &&
            $params['filters']['state'] !== ''
        ) {
            $query->where(
                $tblMeasureConversion . '.state',
                '=',
                $params['filters']['state']
            );
        }

        /*
         * Orden descendente
         */
        $params["sortType"] = "desc";

        /*
         * Búsqueda
         */
        $search = $params['searchPhrase'] ?? null;

        $this->applySearch(
            $query,
            $search,
            [
                'from_unit.name',
                'from_unit.symbol',
                'to_unit.name',
                'to_unit.symbol',
                $tblMeasureConversion . '.description',
                $tblMeasureConversion . '.conversion_type'
            ]
        );

        return $this->paginateQuery(
            $query,
            $params,
            $tblMeasureConversion . '.id'
        );
    }

    public function saveData($params)
    {
        $success = false;
        $msj = "";
        $errors = [];

        $attributesPost = $params["attributesPost"]['MeasureConversion'];

        DB::beginTransaction();

        try {

            $model = new MeasureConversion();

            if (
                isset($attributesPost["id"]) &&
                $attributesPost["id"] != "null" &&
                $attributesPost["id"] != "-1"
            ) {

                $model = MeasureConversion::find($attributesPost["id"]);

                if (!$model) {
                    throw new \Exception(
                        "Registro de conversión no encontrado."
                    );
                }
            }

            /*
             * Obtener solamente campos fillable
             */
            $attributesSet = $this->getValuesModel([
                'fillAble' => $this->fillable,
                'haystack' => $attributesPost,
                'attributesData' => $this->attributesData
            ]);

            /*
             * Validar
             */
            $paramsValidate = [
                'inputs' => $attributesSet,
                'rules' => self::getRulesModel()
            ];

            $validateResult = $this->validateModel(
                $paramsValidate
            );

            $success = $validateResult["success"];

            if (!$success) {

                $errors = $validateResult["errors"];

                $msj = "Problemas al validar MeasureConversion.";

                DB::rollBack();

                return [
                    "success" => false,
                    "msj" => $msj,
                    "errors" => $errors
                ];
            }

            /*
             * Validar que las unidades existan
             */
            $fromUnit = UnitMeasure::find(
                $attributesSet['from_unit_measure_id']
            );

            if (!$fromUnit) {
                throw new \Exception(
                    "La unidad de medida origen no existe."
                );
            }

            $toUnit = UnitMeasure::find(
                $attributesSet['to_unit_measure_id']
            );

            if (!$toUnit) {
                throw new \Exception(
                    "La unidad de medida destino no existe."
                );
            }

            /*
             * Evitar conversión hacia la misma unidad
             */
            if (
                (int)$attributesSet['from_unit_measure_id'] ===
                (int)$attributesSet['to_unit_measure_id']
            ) {
                throw new \Exception(
                    "La unidad origen y destino no pueden ser iguales."
                );
            }

            /*
             * El factor debe ser mayor a cero
             */
            if ((float)$attributesSet['factor'] <= 0) {
                throw new \Exception(
                    "El factor de conversión debe ser mayor a cero."
                );
            }

            /*
             * Evitar duplicados
             */
            $queryDuplicate = MeasureConversion::where(
                'from_unit_measure_id',
                $attributesSet['from_unit_measure_id']
            )
                ->where(
                    'to_unit_measure_id',
                    $attributesSet['to_unit_measure_id']
                )
                ->where(
                    'business_id',
                    $attributesSet['business_id']
                );

            if (!empty($attributesSet['product_id'])) {

                $queryDuplicate->where(
                    'product_id',
                    $attributesSet['product_id']
                );

            } else {

                $queryDuplicate->whereNull('product_id');
            }

            /*
             * Si estamos editando ignoramos el registro actual
             */
            if ($model->id) {
                $queryDuplicate->where(
                    'id',
                    '!=',
                    $model->id
                );
            }

            if ($queryDuplicate->exists()) {

                throw new \Exception(
                    "Ya existe una conversión entre estas unidades."
                );
            }

            /*
             * Guardar
             */
            $model->fill($attributesSet);

            $success = $model->save();

            if (!$success) {

                throw new \Exception(
                    "Problemas al guardar MeasureConversion."
                );
            }

            DB::commit();

            return [
                "errors" => [],
                "msj" => "",
                "success" => true
            ];

        } catch (\Exception $e) {

            DB::rollBack();

            return [
                "success" => false,
                "msj" => $e->getMessage(),
                "errors" => $errors
            ];
        }
    }
}
