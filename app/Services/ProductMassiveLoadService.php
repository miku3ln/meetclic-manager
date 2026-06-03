<?php

namespace App\Services;

use App\Models\ProductCategory;
use App\Models\Products\Product;
use App\Models\TaxByBusiness;
use App\Services\Inventory\MeasurementConversionService;
use App\Utils\Inventory\MeasurementConversionUtil;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ProductMassiveLoadService
{

    private const TYPE_MEASURE = [
        'MASA',
        'UNIDAD',
        'VOLUMEN',
        'RECETA'
    ];

    public static function findErrorByColumn(
        array  $errors,
        string $column
    ): ?array
    {

        foreach ($errors as $error) {

            if (
                isset($error['column']) &&
                strtolower(trim($error['column'])) === strtolower(trim($column))
            ) {

                return $error;
            }
        }

        return null;
    }

    public function processFile($file, $businessId, $paramsTax): array
    {
        $spreadsheet = IOFactory::load(
            $file->getPathname()
        );

        $sheet = $spreadsheet->getActiveSheet();

        /*
        |--------------------------------------------------------------------------
        | SOLO LEER A:L
        |--------------------------------------------------------------------------
        */

        $highestRow = $sheet->getHighestDataRow();

        $rows = $sheet->rangeToArray(
            "A1:L{$highestRow}",
            null,
            true,
            false,
            false
        );

        $taxMain = $paramsTax["tax"];

        $notTaxMain = $paramsTax["not-tax"];
        $allowConfigTax = $paramsTax["allowConfigTax"];


        if (count($rows) <= 1) {

            return [
                "success" => false,
                "message" => "Archivo vacío",
                "html" => $this->generateAlertHtml(
                    "danger",
                    "El archivo está vacío"
                ),
                "data" => []
            ];
        }

        $headers = $rows[0];

        $this->validateHeaders($headers);

        unset($rows[0]);

        $response = [];
        $hasErrors = false;

        foreach ($rows as $index => $row) {

            if ($this->isEmptyRow($row)) {
                continue;
            }

            $item = $this->buildRow(
                $headers,
                $row
            );

            $validation = $this->validateItem(
                $item,
                $index + 1,
                ['allowConfigTax' => $allowConfigTax, 'tax' => $taxMain, 'not-tax' => $notTaxMain],
                $rows
            );

            $item['status'] = $validation['status'];
            $item['message'] = $validation['message'];
            $item['errors'] = $validation['errors'];
            $item['row'] = $index + 1;

            if ($validation['status'] === 'ERROR') {
                $hasErrors = true;
            }

            $response[] = $item;
        }

        foreach ($response as $index => $row) {
            $errors = [];
            $errorsCurrent = $row["errors"];

            $item = $row;
            $typeMeasure = trim(
                mb_strtoupper(
                    $item[self::COLUMN_TYPE_MEASURE] ?? ''
                )
            );
            if ($typeMeasure == "RECETA") {

                $error =
                    self::findErrorByColumn(
                        $item['errors'],
                        self::COLUMN_RECIPE
                    );

                if ($error) {


                } else {
                    $recipeItemsText = $item[self::COLUMN_RECIPE];
                    $recipeData = $this->parseRecipeIngredients($recipeItemsText);
                    if (count($recipeData) == 0) {
                        $response[$index]['status'] = "ERROR";
                        $response[$index]['message'] = $response[$index]['message'] . " & " . "No tiene una estructura de receta correcta";
                        $setError = [
                            'row' => $row["row"],
                            'column' => self::COLUMN_RECIPE,
                            'message' => 'No tiene una estructura de receta correcta'
                        ];
                        $response[$index]['errors'][] = $setError;
                        $hasErrors = true;

                    } else {
                        $existDataAllCount = 0;
                        foreach ($recipeData as $indexData => $rowData) {
                            $valueSearch = $rowData["codigoProduct"];
                            $errorsFiltered = array_filter(
                                $response,
                                function ($item) use ($valueSearch) {

                                    return isset($item[self::COLUMN_CODE])
                                        &&
                                        $item[self::COLUMN_CODE] === $valueSearch;
                                }
                            );

                            if (count($errorsFiltered) == 0) {
                                $response[$index]['status'] = "ERROR";
                                $setError = [
                                    'row' => $row["row"],
                                    'column' => self::COLUMN_RECIPE,
                                    'message' => 'El codigo  :' . $valueSearch . " no pertenece al documento o no existe.!"
                                ];
                                $response[$index]['errors'][] = $setError;
                                $hasErrors = true;
                            } else {
                                $existDataAllCount++;
                            }
                        }
                        if ($existDataAllCount == count($recipeData)) {
                            $response[$index]["recipeData"] = $recipeData;
                        }


                    }
                }


            }

        }

        return [
            "success" => !$hasErrors,
            "message" => $hasErrors
                ? "El archivo contiene errores"
                : "Archivo validado correctamente",
            "data" => $response
        ];
    }

    private function validateHeaders(
        array $headers
    ): void
    {

        foreach (
            self::REQUIRED_COLUMNS as $field
        ) {

            if (
                !in_array(
                    $field,
                    $headers
                )
            ) {

                throw new \Exception(
                    "Falta columna {$field}"
                );
            }
        }
    }

    private function buildRow(
        array $headers,
        array $row
    ): array
    {
        $response = [];

        foreach ($headers as $index => $header) {

            $header = trim($header);

            if ($header === '') {
                continue;
            }

            $response[$header] = $row[$index] ?? null;
        }

        return $response;
    }

    private const COLUMN_CODE = 'Codigo';
    private const COLUMN_NAME = 'Nombre';
    private const COLUMN_DESCRIPTION = 'Descripcion';
    private const COLUMN_CATEGORY = 'Categoria';
    private const COLUMN_SUBCATEGORY = 'Subcategoria';
    private const COLUMN_TYPE_MEASURE = 'Tipo Medida';
    private const COLUMN_PC = 'PC/PRODUCCCION';
    private const COLUMN_PVP = 'PVP';
    private const COLUMN_TAX = 'Tiene Iva';
    private const COLUMN_INVENTORY = 'Inventario';
    private const COLUMN_RECIPE = 'Receta';
    private const COLUMN_IS_SALE = 'VENTA';

    private const REQUIRED_COLUMNS = [

        self::COLUMN_CODE,
        self::COLUMN_NAME,
        self::COLUMN_DESCRIPTION,
        self::COLUMN_CATEGORY,
        self::COLUMN_SUBCATEGORY,
        self::COLUMN_TYPE_MEASURE,
        self::COLUMN_PC,
        self::COLUMN_PVP,
        self::COLUMN_TAX,
        self::COLUMN_INVENTORY,
        self::COLUMN_RECIPE,
        self::COLUMN_IS_SALE,

    ];

    private function validateItem(
        array $item,
        int   $row,
              $paramsTax,
              $rowsAll
    ): array
    {

        $errors = [];

        $this->validateCode($item, $row, $errors);

        $this->validateName($item, $row, $errors);

        $this->validateDescription($item, $row, $errors);

        $this->validateTypeMeasure($item, $row, $errors);

        $this->validateProductionCost($item, $row, $errors);

        $this->validatePvp($item, $row, $errors);

        $this->validateInventory($item, $row, $errors);

        $this->validateRecipe($item, $row, $errors);

        $this->validateDuplicateCode($item, $row, $errors);
        $this->validateTax($item, $row, $errors, $paramsTax);
        $this->validateSale($item, $row, $errors, $paramsTax);

        if (count($errors) > 0) {

            return [
                'status' => 'ERROR',
                'message' => 'Fila inválida',
                'errors' => $errors
            ];
        }

        return [
            'status' => 'SUCCESS',
            'message' => 'Producto válido',
            'errors' => []
        ];
    }

    private const TYPE_MEASURE_RULES = [

        'MASA' => [
            'examples' => [
                '40kg',
                '40 kilos',
                '40 libras',
                '2.5kg'
            ],
            'regex' => '/^\d+(\.\d+)?\s?(kg|kilos|kilo|libras|libra|lb|g|gramos)?$/i'
        ],

        'UNIDAD' => [
            'examples' => [
                '1',
                '2',
                '55'
            ],
            'regex' => '/^\d+$/'
        ],

        'VOLUMEN' => [
            'examples' => [
                '1l',
                '2 litros',
                '500ml'
            ],
            'regex' => '/^\d+(\.\d+)?\s?(l|lt|litros|litro|ml)?$/i'
        ],

        'RECETA' => [
            'examples' => [],
            'regex' => null
        ]
    ];

    private function validateProductionCost(
        array $item,
        int   $row,
        array &$errors
    ): void
    {

        $this->validateNumericField(
            $item,
            self::COLUMN_PC,
            'Costo requerido',
            'Costo inválido',
            $row,
            $errors
        );
    }

    private function validateInventory(
        array $item,
        int   $row,
        array &$errors
    ): void
    {

        $typeMeasure = trim(
            mb_strtoupper(
                $item[self::COLUMN_TYPE_MEASURE] ?? ''
            )
        );

        /*
        |--------------------------------------------------------------------------
        | RECETA NO REQUIERE INVENTARIO
        |--------------------------------------------------------------------------
        */

        if ($typeMeasure === 'RECETA') {
            return;
        }

        $value = trim(
            $item[self::COLUMN_INVENTORY] ?? ''
        );

        /*
        |--------------------------------------------------------------------------
        | REQUERIDO
        |--------------------------------------------------------------------------
        */

        if ($value === '') {

            $errors[] = [
                'row' => $row,
                'column' => self::COLUMN_INVENTORY,
                'message' => 'Inventario requerido'
            ];

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | REGLAS NO EXISTEN
        |--------------------------------------------------------------------------
        */

        if (
            !isset(
                self::TYPE_MEASURE_RULES[$typeMeasure]
            )
        ) {

            return;
        }

        $rule = self::TYPE_MEASURE_RULES[$typeMeasure];

        /*
        |--------------------------------------------------------------------------
        | REGEX
        |--------------------------------------------------------------------------
        */

        if (
            !preg_match(
                $rule['regex'],
                $value
            )
        ) {

            $examples = implode(
                ', ',
                $rule['examples']
            );

            $errors[] = [
                'row' => $row,
                'column' => self::COLUMN_INVENTORY,
                'message' => "Formato inválido. Ejemplos válidos: {$examples}"
            ];
        }
    }

    private function validateRecipe(
        array $item,
        int   $row,
        array &$errors

    ): void
    {

        $typeMeasure = trim(
            mb_strtoupper(
                $item[self::COLUMN_TYPE_MEASURE] ?? ''
            )
        );

        /*
        |--------------------------------------------------------------------------
        | SOLO VALIDA SI ES RECETA
        |--------------------------------------------------------------------------
        */

        if ($typeMeasure !== 'RECETA') {
            return;
        }

        $recipe = trim(
            $item[self::COLUMN_RECIPE] ?? ''
        );

        if ($recipe === '') {

            $errors[] = [
                'row' => $row,
                'column' => self::COLUMN_RECIPE,
                'message' => 'La receta es requerida'
            ];

            return;
        }

        $recipeItems = explode(
            '/',
            $recipe
        );

        $recipeItems = array_filter(
            array_map(
                'trim',
                $recipeItems
            )
        );

        if (count($recipeItems) <= 0) {

            $errors[] = [
                'row' => $row,
                'column' => self::COLUMN_RECIPE,
                'message' => 'Receta inválida'
            ];
        }


    }

    private function validateDuplicateCode(
        array $item,
        int   $row,
        array &$errors
    ): void
    {

        $code = trim(
            $item[self::COLUMN_CODE] ?? ''
        );

        if ($code === '') {
            return;
        }

        if (
            Product::where(
                'code',
                $code
            )->exists()
        ) {

            $errors[] = [
                'row' => $row,
                'column' => self::COLUMN_CODE,
                'message' => 'Código duplicado'
            ];
        }
    }

    private function validateSale(
        array $item,
        int   $row,
        array &$errors,
              $paramsTax
    ): void
    {
        $columnName = self::COLUMN_IS_SALE;
        $valueCurrent = trim(
            $item[$columnName] ?? ''
        );
        $valueCurrentValidate = $this->normalizeTax($valueCurrent);
        if ($valueCurrent === '') {
            $errors[] = [
                'row' => $row,
                'column' => $columnName,
                'message' => 'Requerido '
            ];

            return;
        }


    }

    private function validateTax(
        array $item,
        int   $row,
        array &$errors,
              $paramsTax
    ): void
    {
        $columnName = self::COLUMN_TAX;
        $valueCurrent = trim(
            $item[$columnName] ?? ''
        );
        $valueCurrentValidate = $this->normalizeTax($valueCurrent);
        if ($valueCurrent === '') {
            $errors[] = [
                'row' => $row,
                'column' => $columnName,
                'message' => 'Requerido '
            ];

            return;
        } else {
            $allowConfigTax = $paramsTax['allowConfigTax'];
            $taxMain = $paramsTax['tax'];
            $notTaxMain = $paramsTax['not-tax'];
            if (!$allowConfigTax) {
                $message = "";
                if (count($notTaxMain) == 0) {
                    $message .= "Iva 0 sin configurar";
                }
                if (count($taxMain) == 0) {
                    $message .= "Iva principal sin configurar";
                }
                $errors[] = [
                    'row' => $row,
                    'column' => $columnName,
                    'message' => $message
                ];
                return;

            }
        }


    }

    private function validateDescription(
        array $item,
        int   $row,
        array &$errors
    ): void
    {

        if (
            empty(
            trim(
                $item[self::COLUMN_DESCRIPTION] ?? ''
            )
            )
        ) {

            $errors[] = [
                'row' => $row,
                'column' => self::COLUMN_DESCRIPTION,
                'message' => 'Descripción vacía'
            ];
        }
    }

    private function validateName(
        array $item,
        int   $row,
        array &$errors
    ): void
    {

        if (
            empty(
            trim(
                $item[self::COLUMN_NAME] ?? ''
            )
            )
        ) {

            $errors[] = [
                'row' => $row,
                'column' => self::COLUMN_NAME,
                'message' => 'Nombre vacío'
            ];
        }
    }

    private function validateCode(
        array $item,
        int   $row,
        array &$errors
    ): void
    {

        if (
            empty(
            trim(
                $item[self::COLUMN_CODE] ?? ''
            )
            )
        ) {

            $errors[] = [
                'row' => $row,
                'column' => self::COLUMN_CODE,
                'message' => 'Código vacío'
            ];
        }
    }

    private function validateNumericField(
        array  $item,
        string $field,
        string $requiredMessage,
        string $invalidMessage,
        int    $row,
        array  &$errors
    ): void
    {

        $value = trim(
            $item[$field] ?? ''
        );

        if (empty($value)) {

            $errors[] = [
                'row' => $row,
                'column' => $field,
                'message' => $requiredMessage
            ];

            return;
        }

        if (
            !is_numeric(
                str_replace(',', '.', $value)
            )
        ) {

            $errors[] = [
                'row' => $row,
                'column' => $field,
                'message' => $invalidMessage
            ];
        }
    }

    private function validatePvp(
        array $item,
        int   $row,
        array &$errors
    ): void
    {

        $this->validateNumericField(
            $item,
            self::COLUMN_PVP,
            'PVP requerido',
            'PVP inválido',
            $row,
            $errors
        );
    }

    private function validateTypeMeasure(
        array $item,
        int   $row,
        array &$errors
    ): void
    {

        $value = trim(
            $item[self::COLUMN_TYPE_MEASURE] ?? ''
        );

        if (empty($value)) {

            $errors[] = [
                'row' => $row,
                'column' => self::COLUMN_TYPE_MEASURE,
                'message' => 'Tipo medida requerido'
            ];

            return;
        }

        if (
            !$this->isValidTypeMeasure($value)
        ) {

            $errors[] = [
                'row' => $row,
                'column' => self::COLUMN_TYPE_MEASURE,
                'message' => 'Tipo medida inválido'
            ];
        }
    }

    private function isValidTypeMeasure(
        ?string $value
    ): bool
    {

        $value = trim(
            mb_strtoupper($value)
        );

        return in_array(
            $value,
            self::TYPE_MEASURE
        );
    }

    private function isEmptyRow(
        array $row
    ): bool
    {

        return count(
                array_filter($row)
            ) === 0;
    }

    public function generateHtmlTable(array $data): string
    {
        $html = '

    <div class="massive-load">

        <div class="table-responsive">

            <table class="table massive-load__table align-middle">

                <thead class="massive-load__thead">

                    <tr>

                        <th>#</th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>Subcategoría</th>
                        <th>Tipo Medida</th>
                        <th>PC/PRODUCCIÓN</th>
                        <th>PVP</th>
                        <th>Tiene IVA</th>
                        <th>Inventario</th>
                        <th>Receta</th>
                        <th>Estado</th>
                        <th>Mensaje</th>

                    </tr>

                </thead>

                <tbody>
    ';

        foreach ($data as $item) {

            $rowClass = '';

            if ($item['status'] === 'SUCCESS') {
                $rowClass = 'massive-load__row--success';
            }

            if ($item['status'] === 'ERROR') {
                $rowClass = 'massive-load__row--error';
            }

            if ($item['status'] === 'WARNING') {
                $rowClass = 'massive-load__row--warning';
            }

            $html .= '

            <tr class="' . $rowClass . '">

                <td>
                    ' . $item['row'] . '
                </td>

                ' . $this->buildCell(
                    $item,
                    'Codigo'
                ) . '

                ' . $this->buildCell(
                    $item,
                    'Nombre'
                ) . '

                ' . $this->buildCell(
                    $item,
                    'Descripcion'
                ) . '

                ' . $this->buildCell(
                    $item,
                    'Categoria'
                ) . '

                ' . $this->buildCell(
                    $item,
                    'Subcategoria'
                ) . '

                ' . $this->buildCell(
                    $item,
                    'Tipo Medida'
                ) . '

                ' . $this->buildCell(
                    $item,
                    'PC/PRODUCCCION'
                ) . '

                ' . $this->buildCell(
                    $item,
                    'PVP'
                ) . '

                ' . $this->buildCell(
                    $item,
                    'Tiene Iva'
                ) . '

                ' . $this->buildCell(
                    $item,
                    'Inventario'
                ) . '

                ' . $this->buildCell(
                    $item,
                    'Receta'
                ) . '

                <td>

                    ' . $this->buildStatusBadge(
                    $item['status']
                ) . '

                </td>

                <td>

                    ' . $item['message'] . '

                </td>

            </tr>

        ';
        }

        $html .= '

                </tbody>

            </table>

        </div>

    </div>

    <style>

        .massive-load{
            width:100%;
        }

        .massive-load__table{
            width:100%;
            font-size:14px;
            border-collapse:collapse;
        }

        .massive-load__thead th{
            background:#0d6efd;
            color:#fff;
            text-align:center;
            white-space:nowrap;
            border:1px solid #dfe3e8;
            vertical-align:middle;
            padding:10px;
            font-weight:600;
        }

        .massive-load__table td{
            border:1px solid #dee2e6;
            vertical-align:middle;
            background:#fff;
            padding:8px;
        }

        /* =========================================
           BORDE IZQUIERDO POR FILA
           ========================================= */

        .massive-load__row--success{
            border-left:5px solid #198754;
        }

        .massive-load__row--warning{
            border-left:5px solid #ffc107;
        }

        .massive-load__row--error{
            border-left:5px solid #dc3545;
        }

        /* =========================================
           CELDA CON ERROR
           ========================================= */

        .massive-load__cell--error{
            background:#ffebeb !important;
            border:2px solid #dc3545 !important;
            color:#842029;
            font-weight:700;
            position:relative;
        }

        .massive-load__cell--error::after{
            content:"ERROR";
            position:absolute;
            top:-10px;
            right:4px;
            background:#dc3545;
            color:#fff;
            font-size:10px;
            padding:2px 5px;
            border-radius:4px;
            font-weight:700;
        }

        /* =========================================
           BADGES
           ========================================= */

        .massive-load__badge{
            padding:6px 10px;
            border-radius:8px;
            font-size:12px;
            font-weight:700;
            display:inline-block;
        }

        .massive-load__badge--success{
            background:#198754;
            color:#fff;
        }

        .massive-load__badge--warning{
            background:#ffc107;
            color:#000;
        }

        .massive-load__badge--error{
            background:#dc3545;
            color:#fff;
        }
.massive-load__cell-content{
    display:flex;
    flex-direction:column;
    gap:4px;
}

.massive-load__error-message{
    font-size:11px;
    color:#dc3545;
    font-weight:700;
    line-height:1.2;
}
        /* =========================================
           RESPONSIVE
           ========================================= */

        .table-responsive{
            overflow:auto;
        }

    </style>
    ';

        return $html;
    }

    private function buildCell(
        array  $item,
        string $field
    ): string
    {

        $class = '';

        $tooltip = '';

        if (!empty($item['errors'])) {

            foreach ($item['errors'] as $error) {

                if ($error['column'] === $field) {

                    $class = 'massive-load__cell--error';

                    $tooltip = '
                    <div class="massive-load__error-message">
                       <span class="not-view"> Fila ' . $error['row'] . ':</span>
                        ' . $error['message'] . '
                    </div>
                ';

                    break;
                }
            }
        }

        $value = $item[$field] ?? '';

        return '

        <td class="' . $class . '">

            <div class="massive-load__cell-content">

                ' . $value . '

                ' . $tooltip . '

            </div>

        </td>

    ';
    }

    private function buildStatusBadge(
        string $status
    ): string
    {

        switch ($status) {

            case 'SUCCESS':

                return '

                <span class="
                    massive-load__badge
                    massive-load__badge--success
                ">
                    SUCCESS
                </span>

            ';

            case 'WARNING':

                return '

                <span class="
                    massive-load__badge
                    massive-load__badge--warning
                ">
                    WARNING
                </span>

            ';

            default:

                return '

                <span class="
                    massive-load__badge
                    massive-load__badge--error
                ">
                    ERROR
                </span>

            ';
        }
    }

    private function generateAlertHtml(
        string $type,
        string $message
    ): string
    {

        return '
        <div class="alert alert-' . $type . '">
            ' . $message . '
        </div>';
    }

    private const PRODUCT_TYPE_PRODUCT = 1;

    private const PRODUCT_TYPE_RECIPE = 2;
    private const INVENTORY_TYPE_UNIT = 1;

    private const INVENTORY_TYPE_WEIGHT = 2;

    private const INVENTORY_TYPE_VOLUME = 3;

    private const INVENTORY_TYPE_RECIPE = 4;
    private const TRADE_OWNER_ID = 1;


    private const MEASURE_TYPE_MASS = 1;
    private const MEASURE_TYPE_LENGTH = 2;
    private const MEASURE_TYPE_VOLUME = 3;
    private const MEASURE_TYPE_AREA = 4;
    private const MEASURE_TYPE_UNIT = 1;
    private const MEASURE_TYPE_RECIPE = null;


    private const MEASURE_RELATIONS = [

        'MASA' => [

            'product_type'
            => 'MEASURABLE',

            'inventory_type'
            => 'RAW',

            'measure_type_id'
            => self::MEASURE_TYPE_MASS,
        ],
        'LONGITUD' => [

            'product_type'
            => 'MEASURABLE',

            'inventory_type'
            => 'RAW',

            'measure_type_id'
            => self::MEASURE_TYPE_LENGTH,
        ],
        'VOLUMEN' => [

            'product_type'
            => 'MEASURABLE',

            'inventory_type'
            => 'RAW',

            'measure_type_id'
            => self::MEASURE_TYPE_VOLUME,
        ],
        'AREA' => [

            'product_type'
            => 'MEASURABLE',
            'inventory_type'
            => 'RAW',

            'measure_type_id'
            => self::MEASURE_TYPE_AREA,
        ],

        'UNIDAD' => [

            'product_type'
            => 'UNIT',

            'inventory_type'
            => 'FOR_SALE',

            'measure_type_id'
            => self::MEASURE_TYPE_UNIT,
        ],

        'RECETA' => [

            'product_type'
            => 'MIXED',

            'inventory_type'
            => 'PROCESSED',

            'measure_type_id'
            => self::MEASURE_TYPE_RECIPE,
        ],
    ];


    private function normalizeDecimal(
        $value
    ): float
    {

        return (float)str_replace(
            ',',
            '.',
            trim($value)
        );
    }

    private function normalizeTax(
        $value
    ): int
    {


        return in_array($value, [
            'SI',
            'si',
            true,
            'yes',
            'YES',
            '1',
            1,
            'TRUE'
        ]) ? 0 : 1;
    }

    private function loadTaxByBusiness(
        array $businessIds
    ): array
    {

        $rows = ProductCategory::query()
            ->select([

                'product_category.id as category_id',

                'product_category.value as category_value',

                'product_subcategory.id as subcategory_id',

                'product_subcategory.value as subcategory_value',

            ])
            ->join(
                'product_subcategory',
                'product_subcategory.product_category_id',
                '=',
                'product_category.id'
            )
            ->whereIn(
                'product_category.business_id',
                $businessIds
            )
            ->where(
                'product_category.state',
                'ACTIVE'
            )
            ->where(
                'product_subcategory.state',
                'ACTIVE'
            )
            ->orderBy(
                'product_category.value'
            )
            ->orderBy(
                'product_subcategory.value'
            )
            ->get();
    }

    private function loadCatalogsCategoriesByBusiness(
        array $businessIds
    ): array
    {

        $rows = ProductCategory::query()
            ->select([

                'product_category.id as category_id',

                'product_category.value as category_value',

                'product_subcategory.id as subcategory_id',

                'product_subcategory.value as subcategory_value',

            ])
            ->join(
                'product_subcategory',
                'product_subcategory.product_category_id',
                '=',
                'product_category.id'
            )
            ->whereIn(
                'product_category.business_id',
                $businessIds
            )
            ->where(
                'product_category.state',
                'ACTIVE'
            )
            ->where(
                'product_subcategory.state',
                'ACTIVE'
            )
            ->orderBy(
                'product_category.value'
            )
            ->orderBy(
                'product_subcategory.value'
            )
            ->get();

        $result = [];

        foreach ($rows as $row) {

            $categoryId = $row->category_id;

            /*
            |--------------------------------------------------------------------------
            | CATEGORY
            |--------------------------------------------------------------------------
            */

            if (!isset($result[$categoryId])) {

                $result[$categoryId] = [

                    'id'
                    => $categoryId,

                    'value'
                    => $row->category_value,

                    'data'
                    => []
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | SUBCATEGORY
            |--------------------------------------------------------------------------
            */

            $result[$categoryId]['data'][] = [

                'id'
                => $row->subcategory_id,

                'value'
                => $row->subcategory_value,
            ];
        }

        return array_values($result);
    }

    public function createSubcategory($params)
    {
        $product_category_id = $params['product_category_id'];
        $business_id = $params['business_id'];
        $value = $params['value'];

        return ['id' => 69, 'text' => $value];
    }

    public function createCategory($params)
    {

        $business_id = $params['business_id'];
        $value = $params['value'];

        return ['id' => 69, 'text' => $value];
    }

    private function resolveCategoryAndSubcategory(
        array  &$catalogIndex,
        string $category,
        string $subcategory,
        int    $businessId
    ): array
    {

        /*
        |--------------------------------------------------------------------------
        | NORMALIZAR KEYS
        |--------------------------------------------------------------------------
        */

        $categoryKey = mb_strtoupper(
            trim($category)
        );

        $subcategoryKey = mb_strtoupper(
            trim($subcategory)
        );

        /*
        |--------------------------------------------------------------------------
        | DEFAULT
        |--------------------------------------------------------------------------
        */

        $productCategoryId = null;

        $productSubcategoryId = null;

        /*
        |--------------------------------------------------------------------------
        | EXISTE CATEGORIA
        |--------------------------------------------------------------------------
        */

        if (
            isset(
                $catalogIndex[$categoryKey]
            )
        ) {

            $productCategoryId =
                $catalogIndex[$categoryKey]['category_id'];

            /*
            |--------------------------------------------------------------------------
            | EXISTE SUBCATEGORIA
            |--------------------------------------------------------------------------
            */

            if (
                isset(
                    $catalogIndex[$categoryKey]
                    ['subcategories']
                    [$subcategoryKey]
                )
            ) {

                $productSubcategoryId =
                    $catalogIndex[$categoryKey]
                    ['subcategories']
                    [$subcategoryKey]
                    ['subcategory_id'];

            } else {

                /*
                |--------------------------------------------------------------------------
                | CREAR SUBCATEGORIA
                |--------------------------------------------------------------------------
                */

                $newSubcategory =
                    $this->createSubcategory([
                        'value' => $subcategory,
                        'product_category_id' => $productCategoryId,
                        'business_id' => $businessId
                    ]);

                $productSubcategoryId =
                    $newSubcategory['id'];

                /*
                |--------------------------------------------------------------------------
                | ACTUALIZAR INDEX
                |--------------------------------------------------------------------------
                */

                $catalogIndex[$categoryKey]
                ['subcategories']
                [$subcategoryKey] = [

                    'subcategory_id' =>
                        $productSubcategoryId
                ];


            }

        } else {

            /*
            |--------------------------------------------------------------------------
            | CREAR CATEGORIA
            |--------------------------------------------------------------------------
            */
            $newCategory =
                $this->createCategory([
                    'value' => $category,
                    'business_id' => $businessId
                ]);
            $productCategoryId =
                $newCategory["id"];
            /*
            |--------------------------------------------------------------------------
            | CREAR SUBCATEGORIA
            |--------------------------------------------------------------------------
            */

            $newSubcategory =
                $this->createSubcategory([
                    'value' => $subcategory,
                    'product_category_id' => $productCategoryId,
                    'business_id' => $businessId
                ]);
            $productSubcategoryId =
                $newSubcategory["id"];

            /*
            |--------------------------------------------------------------------------
            | ACTUALIZAR INDEX
            |--------------------------------------------------------------------------
            */

            $catalogIndex[$categoryKey] = [

                'category_id' =>
                    $productCategoryId,

                'subcategories' => [

                    $subcategoryKey => [

                        'subcategory_id' =>
                            $productSubcategoryId
                    ]
                ]
            ];

        }

        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        return [

            'product_category_id' =>
                $productCategoryId,

            'product_subcategory_id' =>
                $productSubcategoryId,

            'catalogIndex' =>
                $catalogIndex
        ];
    }

    public function getTaxByBusiness($params)
    {

        $businessIds = $params["businessId"];
        $priority = $params["priority"];
        $row = TaxByBusiness::query()
            ->select([

                'tax_by_business.tax_id as tax_id',
                'tax_by_business.priority as tax_priority',
                'tax.percentage as tax_percentage',
                'tax.state as tax_state',

            ])
            ->join(
                'tax',
                'tax.id',
                '=',
                'tax_by_business.tax_id'
            )
            ->whereIn(
                'tax_by_business.business_id',
                $businessIds
            )
            ->where(
                'tax_by_business.priority',
                '=', $priority
            )
            ->where(
                'tax_by_business.state',
                'ACTIVE'
            )
            ->first();


        return $row ? $row->toArray() : [];
    }

    public static function parseRecipeIngredients(
        string $recipe
    ): array
    {

        $result = [];

        /*
        |--------------------------------------------------------------------------
        | SPLIT INGREDIENTS
        |--------------------------------------------------------------------------
        */

        $ingredients =
            explode('/', $recipe);

        foreach ($ingredients as $item) {

            /*
            |--------------------------------------------------------------------------
            | CLEAN TEXT
            |--------------------------------------------------------------------------
            */

            $item =
                trim(
                    preg_replace(
                        '/\s+/',
                        ' ',
                        $item
                    )
                );

            if (empty($item)) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | EXAMPLES SUPPORTED
            |--------------------------------------------------------------------------
            |
            | 200gr INGRE-PA
            | 350 gr INGRE-AR
            | 1 INGRE-HU
            | 75gr INGRE-PA
            |
            |--------------------------------------------------------------------------
            */

            preg_match(
                '/^([\d]+(?:\.[\d]+)?)\s*([a-zA-Z]+)?\s+(.+)$/u',
                $item,
                $matches
            );

            if (!isset($matches[1])) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | AMOUNT
            |--------------------------------------------------------------------------
            */

            $amount =
                (float)$matches[1];

            /*
            |--------------------------------------------------------------------------
            | MEASURE
            |--------------------------------------------------------------------------
            */

            $measure =
                isset($matches[2]) &&
                !empty($matches[2])

                    ?

                    strtolower(
                        trim($matches[2])
                    )

                    :

                    'u';

            /*
            |--------------------------------------------------------------------------
            | PRODUCT CODE
            |--------------------------------------------------------------------------
            */

            $codigoProduct =
                isset($matches[3])

                    ?

                    trim($matches[3])

                    :

                    null;

            /*
            |--------------------------------------------------------------------------
            | AMOUNT TEXT
            |--------------------------------------------------------------------------
            */

            $amountText =
                $amount
                .
                (
                $measure !== 'u'
                    ? $measure
                    : ''
                );

            /*
            |--------------------------------------------------------------------------
            | PUSH
            |--------------------------------------------------------------------------
            */

            $result[] = [

                'amount' =>
                    $amount,

                'medida' =>
                    $measure,

                'amountText' =>
                    $amountText,

                'codigoProduct' =>
                    $codigoProduct,
            ];
        }

        return $result;
    }

    public function buildProductsForInsert($params): array
    {
        $result = [];
        $haystack = $params['haystack'];
        $businessIdMeetclic = 1;

        $businessIdManager = $params['businessIdManager'];
        $paramsTax = $params["paramsTax"];

        $taxMain = $paramsTax["tax"];
        $notTaxMain = $paramsTax["not-tax"];
        $allowConfigTax = $paramsTax["allowConfigTax"];


        //
        $catalogs = $this->loadCatalogsCategoriesByBusiness([$businessIdMeetclic, $businessIdManager]);

        /*
        |--------------------------------------------------------------------------
        | INDEXAR PARA BUSQUEDA RAPIDA
        |--------------------------------------------------------------------------
        */

        $catalogIndex = [];

        foreach ($catalogs as $category) {

            $categoryName = mb_strtoupper(
                trim($category['value'])
            );

            $catalogIndex[$categoryName] = [
                'category_id' => $category['id'],
                'subcategories' => []
            ];

            foreach ($category['data'] as $subcategory) {

                $subcategoryName = mb_strtoupper(
                    trim($subcategory['value'])
                );

                $catalogIndex[$categoryName]['subcategories'][$subcategoryName] = [
                    'subcategory_id' => $subcategory['id']
                ];
            }
        }

        foreach ($haystack as $index => $row) {
            $COLUMN_TYPE_MEASURE = -1;
            $product_type = -1;
            $inventory_type = -1;
            $product_trademark_id = self:: TRADE_OWNER_ID;
            $product_category_id = -1;
            $product_subcategory_id = -1;
            $product_measure_type_id = -1;
            $code = $row[self::COLUMN_CODE];
            $category = $row[self::COLUMN_CATEGORY];//needle
            $subcategory = $row[self::COLUMN_SUBCATEGORY];//needle
            $catalogResponse =
                $this->resolveCategoryAndSubcategory(
                    $catalogIndex,
                    $category,
                    $subcategory,
                    $businessIdManager
                );

            $product_category_id =
                $catalogResponse['product_category_id'];

            $product_subcategory_id =
                $catalogResponse['product_subcategory_id'];

            $catalogIndex =
                $catalogResponse['catalogIndex'];


            $tax = $row[self::COLUMN_TAX];

            $isRecipe = $row[self::COLUMN_TYPE_MEASURE] == 'RECETA';
            $typeMeasure = trim(
                mb_strtoupper(
                    $row[self::COLUMN_TYPE_MEASURE]
                )
            );


            $priceBuyCost = $this->normalizeDecimal(
                $row[self::COLUMN_PC]
            );

            $pvp = $this->normalizeDecimal(
                $row[self::COLUMN_PVP]
            );

            /*$inventoryTotal = $this->normalizeInventory(
                $row[self::COLUMN_INVENTORY]
            );*/
            $valueTextTax = $row[self::COLUMN_TAX];
            $hasTax = $this->normalizeTax(
                $valueTextTax
            );


            $product_id = null;
            $measureConfig =
                self::MEASURE_RELATIONS[$typeMeasure];
            $product_type = $measureConfig['product_type'];
            $inventory_type = $measureConfig['inventory_type'];
            $product_measure_type_id = $measureConfig['measure_type_id'];
            $inventory_movement = [];
            $product_stock = [];
            $product_inventory = [];
            $recipeData = [];

            if ($isRecipe) {

                $component_product_id = -1;
                $quantity = -1;
                $unit_measure_id = -1;
                $product_recipe_data = [
                    'product_id' => $product_id,
                    'component_product_id' => $component_product_id,
                    'quantity' => $quantity,
                    'unit_measure_id' => $unit_measure_id,
                ];
                $recipeItemsText = $row[self::COLUMN_RECIPE];

                $recipeData = $this->parseRecipeIngredients($recipeItemsText);


            } else {
                $inventoryTotal = -1;
                $unit_measure_id = 0;
                $quantity_input = 0;
                $unit_input_id = 0;
                $conversion_factor = 0;
                $reference_type = 'INVENTARIO_INICIAL';
                $reference_id = $product_id;
                $description = 'Carga inicial';

                $conversionManagement = [];
                $params = [
                    'measureType' => $row[self::COLUMN_TYPE_MEASURE],
                    'value' => $row[self::COLUMN_INVENTORY],
                    'convertToBase' => ['base']
                ];
                $conversionManagement =
                    MeasurementConversionUtil::normalizeToBase(
                        $params
                    );
                if ($conversionManagement["success"]) {
                    $dataConversion = $conversionManagement["data"];
                    $output = $dataConversion['output'];
                    $input = $dataConversion['input'];
                    $conversion = $dataConversion['conversion'];

                    $conversion_factor = $conversion['factor'];
                    $quantity = $output['quantity'];
                    $unit_measure_id = $output['unit_measure_id'];
                    $inventoryTotal = $quantity;
                    $quantity_input = $input['quantity'];
                    $unit_input_id = $input['unit_measure_id'];

                }
                $inventory_movement = [
                    'business_id' => $businessIdManager,
                    'product_id' => $product_id,
                    'movement_type' => 'IN',// enum('IN','OUT','ADJUST') ,
                    'quantity' => $inventoryTotal,
                    'unit_measure_id' => $unit_measure_id,
                    'quantity_input' => $quantity_input,
                    'unit_input_id' => $unit_input_id,
                    'conversion_factor' => $conversion_factor,
                    'reference_type' => $reference_type,
                    'reference_id' => $reference_id,
                    'description' => $description,
                    'conversionManagement' => $conversionManagement
                ];
                $quantity = $inventoryTotal;
                $quantity_base = $conversion_factor;


                $product_stock = [
                    'product_id' => $product_id,
                    'quantity' => $quantity,
                    'quantity_base' => $quantity_base,
                    'unit_measure_id' => $unit_measure_id,
                ];

                $avarage_kardex_value = -1;
                $quantity_units = $quantity;
                $sale_price = $pvp;
                $total_price = -1;
                $tax_id = -1;
                $profit = -1;
                $profit_type = -1;
                $note = 'Ingreso por primera vez';
                $sale_price2 = $pvp;
                $sale_price3 = $pvp;
                $sale_price4 = $pvp;
                if ($allowConfigTax) {
                    if ($hasTax) {
                        $tax_id = $taxMain['tax_id'];
                        $avarage_kardex_value = $taxMain['tax_percentage'];

                    } else {
                        $tax_id = $notTaxMain['tax_id'];
                        $avarage_kardex_value = $notTaxMain['tax_percentage'];

                    }
                }
                $totalCurrentPrice = $quantity_units * $pvp;
                $total_price = ($totalCurrentPrice);
                $product_inventory = [
                    'business_id' => $businessIdManager,
                    'avarage_kardex_value' => $avarage_kardex_value,
                    'tax' => $avarage_kardex_value,// enum('SI','NO') DEFAULT 'NO',
                    'quantity_units' => $quantity_units,
                    'sale_price' => $sale_price,
                    'total_price' => $total_price,
                    'product_id' => $product_id,
                    'tax_id' => $tax_id,
                    'profit' => $profit,
                    'profit_type' => $profit_type, //tinyint(1) NOT NULL,
                    'note' => $note,
                    'sale_price2' => $sale_price2,
                    'sale_price3' => $sale_price3,
                    'sale_price4' => $sale_price4,
                ];

            }

            $business_by_products = [
                'business_id' => $businessIdManager,
                'products_id' => $product_id,
            ];
            $product = [
                'id' => null,
                'code' => $code,
                'name' => $row[self::COLUMN_NAME],
                'product_type' => $product_type,
                'inventory_type' => $inventory_type,
                'state' => 'ACTIVE',
                'product_trademark_id' => $product_trademark_id,
                'product_category_id' => $product_category_id,
                'product_subcategory_id' => $product_subcategory_id,
                'source' => null,
                'description' => $row[self::COLUMN_DESCRIPTION],
                'code_provider' => 'none-code',
                'code_product' => $code,
                'has_tax' => $hasTax,
                'is_service' => 0,
                'user_id' => 1,
                'product_measure_type_id' => $product_measure_type_id,
                'view_online' => 1,
                'business_by_products' => $business_by_products,
                'inventory_movement' => $inventory_movement,
                'product_stock' => $product_stock,
                'product_inventory' => $product_inventory,
                'recipeData' => $recipeData

            ];
            $result[] = $product;
        }
dd("");
        return $result;
    }
}
