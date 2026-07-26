<?php

namespace App\Http\Controllers\PointSales;

use App\Http\Controllers\PointSalesBaseController;

use App\Models\EntityHasInvoiceSale;
use App\Models\InvoiceSale;
use App\Models\InvoiceSaleByDetails;
use App\Models\InvoiceSales\InventoryMovement;
use App\Models\InvoiceSales\InvoiceSaleMeta;
use App\Models\InvoiceSales\InvoiceSalePayment;
use App\Models\InvoiceSales\PosPaymentMethod;
use App\Models\InvoiceSales\PuntoEmision;
use App\Models\Products\Product;
use App\Models\Products\ProductRecipe;
use App\Modules\PointSales\Constants\ProductClassification;
use App\Modules\PointSales\Services\ProductSalesService;
use App\Modules\PointSales\Services\StockDiscountService;
use App\Services\Inventory\MeasureResolverService;
use App\Services\ProductMassiveLoadService;
use App\Utils\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends PointSalesBaseController
{
    private MeasureResolverService $measureResolverService;


    public function __construct(ProductSalesService $service, StockDiscountService $serviceStock, MeasureResolverService $measureResolverService)
    {
        $this->service = $service;
        $this->stockDiscountService = $serviceStock;
        $this->measureResolverService =
            $measureResolverService;

    }

    public function getCatalogMeasure(Request $request)//POS-PRODUCTS -INIT-ONE
    {
        $params = $request->all();
        $businessId = $params['business_id'] ?? 0;
        $data =
            $this->measureResolverService
                ->getCatalog(
                    $businessId
                );
        return response()->json($data);
    }

    public function getCatalogTax(Request $request)//POS-PRODUCTS -INIT-ONE
    {
        $params = $request->all();
        $businessId = $params['business_id'] ?? 0;
        $service = new ProductMassiveLoadService();
        $taxMain = $service->getTaxByBusiness([
            "businessId" => [$businessId],
            "priority" => 1
        ]);

        $notTaxMain = $service->getTaxByBusiness([
            "businessId" => [$businessId],
            "priority" => 2
        ]);
        $data = [];
        if (count($taxMain) > 0) {
            $data[] = $taxMain;
        }
        if (count($notTaxMain) > 0) {
            $data[] = $notTaxMain;
        }
        return response()->json($data);
    }

    public function getProductsSales(Request $request)//POS-PRODUCTS -INIT-ONE
    {

        $params = $request->all();
        $filters = [
            'searchPhrase' => isset($params["searchPhrase"]) ? $params["searchPhrase"] : '',
            'current' => $params["current"],
            'rowCount' => $params["rowCount"],
            'business_id' => $params["business_id"],
            'filters' => [
                'business_id' => $params["business_id"],
            ]
        ];
        $data = $this->service->getProducts($filters);
        $this->user = $request->get('auth_user');
        return response()->json($data);
    }
    public function getCategoryByBusiness(Request $request)//POS-PRODUCTS -INIT-ONE
    {

        $params = $request->all();

        $filters = [
            'searchPhrase' => isset($params["searchPhrase"]) ? $params["searchPhrase"] : '',
            'current' => $params["current"],
            'rowCount' => $params["rowCount"],
            'business_id' => $params["business_id"],
            'filters' => [
                'business_id' => $params["business_id"],
            ]
        ];
        $data = $this->service->getCategoryByBusiness($filters);
        $this->user = $request->get('auth_user');
        return response()->json($data);
    }
    public function generateKeysManager(Request $request)
    {
        try {

            // ======================================================
            // Configurar OpenSSL
            // ======================================================
            $opensslConf = env('OPENSSL_CONF');

            if (empty($opensslConf) || !file_exists($opensslConf)) {
                return response()->json([
                    'success' => false,
                    'step' => 'openssl_conf',
                    'message' => 'No se encontró el archivo openssl.cnf.',
                    'path' => $opensslConf,
                ], 500);
            }

            putenv("OPENSSL_CONF={$opensslConf}");
            $_ENV['OPENSSL_CONF'] = $opensslConf;
            $_SERVER['OPENSSL_CONF'] = $opensslConf;

            // ======================================================
            // Configuración RSA
            // ======================================================
            $config = [
                'config' => $opensslConf,
                'private_key_bits' => 4096,
                'private_key_type' => OPENSSL_KEYTYPE_RSA,
            ];

            // ======================================================
            // Generar clave privada
            // ======================================================
            $key = openssl_pkey_new($config);

            if ($key === false) {
                return response()->json([
                    'success' => false,
                    'step' => 'openssl_pkey_new',
                    'message' => 'Error al generar la clave.',
                    'config_file' => $opensslConf,
                    'openssl_errors' => $this->getOpenSSLErrors(),
                ], 500);
            }

            // ======================================================
            // Exportar privada
            // ======================================================
            if (!openssl_pkey_export($key, $privateKey, null, $config)) {
                return response()->json([
                    'success' => false,
                    'step' => 'openssl_pkey_export',
                    'message' => 'Error al exportar la clave privada.',
                    'openssl_errors' => $this->getOpenSSLErrors(),
                ], 500);
            }

            // ======================================================
            // Obtener pública
            // ======================================================
            $details = openssl_pkey_get_details($key);

            if ($details === false || !isset($details['key'])) {
                return response()->json([
                    'success' => false,
                    'step' => 'openssl_pkey_get_details',
                    'message' => 'No se pudo obtener la clave pública.',
                    'openssl_errors' => $this->getOpenSSLErrors(),
                ], 500);
            }

            $publicKey = $details['key'];

            // ======================================================
            // Crear directorio
            // ======================================================
            $dir = storage_path('app/keys');

            if (!is_dir($dir) && !mkdir($dir, 0755, true)) {
                return response()->json([
                    'success' => false,
                    'step' => 'mkdir',
                    'message' => 'No se pudo crear el directorio.',
                    'path' => $dir,
                ], 500);
            }

            // ======================================================
            // Guardar archivos
            // ======================================================
            $privatePath = $dir . DIRECTORY_SEPARATOR . 'private.pem';
            $publicPath = $dir . DIRECTORY_SEPARATOR . 'public.pem';

            if (file_put_contents($privatePath, $privateKey) === false) {
                return response()->json([
                    'success' => false,
                    'step' => 'save_private_key',
                    'message' => 'No se pudo guardar la clave privada.',
                    'path' => $privatePath,
                ], 500);
            }

            if (file_put_contents($publicPath, $publicKey) === false) {
                return response()->json([
                    'success' => false,
                    'step' => 'save_public_key',
                    'message' => 'No se pudo guardar la clave pública.',
                    'path' => $publicPath,
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'Claves RSA generadas correctamente.',
                'data' => [
                    'private_key_path' => $privatePath,
                    'public_key_path' => $publicPath,
                    'openssl_conf' => $opensslConf,
                ],
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'step' => 'exception',
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => app()->environment('local')
                    ? explode("\n", $e->getTraceAsString())
                    : [],
            ], 500);
        }
    }

    private function getOpenSSLErrors(): array
    {
        $errors = [];

        while ($error = openssl_error_string()) {
            $errors[] = $error;
        }

        return $errors;
    }
    public function getSubCategoryByBusiness(Request $request)//POS-PRODUCTS -INIT-ONE
    {
        $params = $request->all();

        $filters = [
            'searchPhrase' => isset($params["searchPhrase"]) ? $params["searchPhrase"] : '',
            'current' => $params["current"],
            'rowCount' => $params["rowCount"],
            'business_id' => $params["business_id"],
            'filters' => [
                'business_id' => $params["business_id"],
            ]
        ];
        $data = $this->service->getSubCategoryByBusiness($filters);
        $this->user = $request->get('auth_user');
        return response()->json($data);
    }
    public function getProductsManagement(Request $request)//POS-PRODUCTS -INIT-ONE
    {

        $params = $request->all();
        $filters = [
            'searchPhrase' => isset($params["searchPhrase"]) ? $params["searchPhrase"] : '',
            'current' => $params["current"],
            'rowCount' => $params["rowCount"],
            'business_id' => $params["business_id"],

            'filters' => [
                'type' => 'MANAGEMENT',
                'business_id' => $params["business_id"],
            ]
        ];
        $data = $this->service->getProductsManagement($filters);
        $this->user = $request->get('auth_user');
        return response()->json($data);
    }

    public function getProductsByTypeForRecipe(Request $request)//POS-PRODUCTS -INIT-ONE
    {

        $params = $request->all();
        $filters = [
            'searchPhrase' => isset($params["searchPhrase"]) ? $params["searchPhrase"] : '',
            'business_id' => $params["business_id"],
            'inventory_type' => $params["inventory_type"],
            'componentProductId' => $params["componentProductId"],
            'current' => $params["current"],
            'rowCount' => $params["rowCount"],
            'filters' => [
                'business_id' => $params["business_id"],
                'inventory_type' => $params["inventory_type"],
                'componentProductId' => $params["componentProductId"],
            ]
        ];
        $data = $this->service->getProductsByTypeForRecipe($filters);
        $this->user = $request->get('auth_user');
        return response()->json($data);
    }
    public function getProductsCategoriesByBusiness(Request $request)//POS-PRODUCTS -INIT-ONE
    {

        $params = $request->all();
        $filters = [
            'searchPhrase' => isset($params["searchPhrase"]) ? $params["searchPhrase"] : '',
            'business_id' => $params["business_id"],
            'filters' => [
                'business_id' => $params["business_id"],
            ]
        ];
        $data = $this->service->getProductsCategoriesByBusiness($filters);
        $this->user = $request->get('auth_user');
        return response()->json($data);
    }

    public function getProductsRecipeSales(Request $request)//POS-PRODUCTS -INIT-ONE
    {

        $params = $request->all();
        $filters = [
            'searchPhrase' => isset($params["searchPhrase"]) ? $params["searchPhrase"] : '',
            'current' => $params["current"],
            'rowCount' => $params["rowCount"],
            'business_id' => $params["business_id"],
            'component_product_id' => $params["component_product_id"],

            'filters' => [
                'business_id' => $params["business_id"],
                'component_product_id' => $params["component_product_id"],

            ]
        ];
        $data = $this->service->getProductsRecipeShopPage($filters);
        $this->user = $request->get('auth_user');
        return response()->json($data);
    }

    public function obtenerPuntoEmisionUsuario($business_id, $userId)
    {
        $resultado = DB::table('user_punto_emision as upe')
            ->join('puntos_emision as pe', 'upe.punto_emision_id', '=', 'pe.id')
            ->join('emisores as e', 'pe.emisor_id', '=', 'e.id')
            ->select([
                // 1. Todos los Datos de la tabla Base: user_punto_emision
                'upe.id as user_punto_emision_id',
                'upe.user_id',
                'upe.punto_emision_id',
                'upe.estado as asignacion_estado',
                'upe.created_at as asignacion_created_at',
                'upe.updated_at as asignacion_updated_at',

                // 2. Todos los Datos de la tabla: puntos_emision
                'pe.emisor_id',
                'pe.id as pe_id ',
                'pe.establecimiento',
                'pe.punto_emision',
                'pe.factura_inicial',
                'pe.nota_credito_inicial',
                'pe.nota_debito_inicial',
                'pe.comprobante_retencion_inicial',
                'pe.liquidacion_compra_inicial',
                'pe.guia_remision_inicial',
                'pe.factura_actual',
                'pe.nota_credito_actual',
                'pe.nota_debito_actual',
                'pe.comprobante_retencion_actual',
                'pe.liquidacion_compra_actual',
                'pe.guia_remision_actual',
                'pe.informacion_adicional as punto_informacion_adicional',
                'pe.estado as punto_estado',
                'pe.created_at as punto_created_at',
                'pe.updated_at as punto_updated_at',

                // 3. Todos los Datos de la tabla: emisores
                'e.razon_social',
                'e.nombre_comercial',
                'e.ruc',
                'e.dir_matriz',
                // Añade aquí cualquier otro campo que tenga tu tabla 'emisores' (ej: e.obligado_contabilidad, e.contribuyente_especial, etc.)
            ])
            ->where('upe.user_id', $userId)
            ->where('e.business_id', $business_id)
            ->first(); // Retorna una sola fila (objeto) o null si no existe

        if (!$resultado) {
            return [
                'success' => false,
                'message' => 'El usuario no tiene ningún punto de emisión ni emisor vinculado.'
            ];
        }

        return [
            'success' => true,
            'data' => $resultado
        ];
    }

    public function generateTicket(Request $request)//POS-PRODUCTS-SALES -INIT-TWO
    {
        $payload = $request->json()->all();
        $dataAllow = false;
        // 👇 Si NO viene body → simulamos
        $type = "mixed_fail_only";
        $bodyCurrent = $payload["body"];
        $errors = [];
        $result = [];
        DB::beginTransaction();
        try {
            $success = false;
            $message = "";
            $items = $bodyCurrent;
            $calculated = $this->stockDiscountService->process(["items" => $bodyCurrent]);
            $total = 0;
            $subTotal = 0;
            $value_taxes = 0;
            $provider = '';
            $reference = '';
            $extra_data = '';
            foreach ($items as $item) {
                $total += $item['total'];
                $subTotal += $item['subtotal'];

                if ($item['hasTax'] == 'SI') {
                    $value_taxes += $subTotal * $item['valuePercentageTax'] / 100;
                }

            }

            // 2. validar inventario
            $validated = $this->stockDiscountService->validateStock($calculated);
            $headerGet = $payload["header"];
            $invoice_sale_id = -1;
            $isTypeInvoice = $headerGet["typeSave"] == "SAVE";
            $ticket_code = $isTypeInvoice ? 'TICKET-' : ($headerGet["ticketCode"] ?? 'TICKET-NONE');

            $typeService = $headerGet['typeService'];
            $service_type = $typeService == 'service' ? 'DINE_IN' : 'TAKEAWAY';
            $voucher_type_id = $isTypeInvoice ? 1 : 2;
            $debt = $isTypeInvoice ? 0 : 1;
            $userId = $headerGet["userId"];
            $business_id = $headerGet["business_id"];
            $resultInformation = $this->obtenerPuntoEmisionUsuario($business_id, $userId);
            // Inicializamos variables con valores por defecto por seguridad
            $establishment = "-1";
            $emissionPoint = "-1";
            $invoiceCode = 0;
            $pe_id = -1;
            if ($resultInformation['success']) {
                $puntoData = $resultInformation['data'];

                // Asignamos el establecimiento y punto de emisión desde la base de datos
                $establishment = $puntoData->establecimiento;
                $emissionPoint = $puntoData->punto_emision;

                // Calcular el secuencial numérico que le corresponde a esta factura
                // Si factura_actual es mayor a 0, le sumamos 1, sino empezamos desde factura_inicial + 1
                $invoiceCode = $puntoData->factura_actual + 1;
                $pe_id = $puntoData->pe_id;

            }
            $header = [// invoice_sale
                "customer_id" => $headerGet["customer_id"],
                "invoice_code" => $invoiceCode,
                "invoice_value" => 0,
                "discount_value" => 0,
                "status" => $isTypeInvoice ? "ISSUED" : "PENDING",
                "user_id" => $userId,
                "observations" => isset($headerGet["observations"]) ? $headerGet["observations"] : "",
                "value_taxes" => $value_taxes,
                "subtotal" => $subTotal,
                "invoice_date" => Util::DateCurrent(),
                "created_at" => Util::DateCurrent(),
                "establishment" => $establishment,
                "emission_point" => $emissionPoint,
                "voucher_type_id" => $voucher_type_id,
                "mixed_payment" => 1,
                "has_retention" => 0,
                "now_after_retention" => 0,
                "debt" => $debt,
                "type_of_discount" => 0,
                "discount_type_invoice" => 0,
                "authorization_number" => 0,
                "type_of_document_issuance" => 0,

            ];
            $modelInvoice = new InvoiceSale();
            $attributesSetInvoice = $header;
            $paramsValidate = array(
                'modelAttributes' => $attributesSetInvoice,
                'rules' => $modelInvoice::getRulesModel(),
            );
            $validateInvoice = $modelInvoice->validateModel($paramsValidate);

            if ($validateInvoice['success']) {
                $success = true;
                $message = "";
                $modelInvoice->fill($attributesSetInvoice);
                $modelInvoice->save();
                $invoice_sale_id = $modelInvoice->id;
                $attributesSetInvoice["id"] = $invoice_sale_id;


                //business_by_invoice_sale
                $business_by_invoice_sale = [
                    "entidad_data_id" => $business_id,
                    "factura_venta_id" => $invoice_sale_id
                ];

                $modelInvoiceByBusiness = new EntityHasInvoiceSale();
                $paramsValidate = array(
                    'modelAttributes' => $business_by_invoice_sale,
                    'rules' => $modelInvoiceByBusiness::getRulesModel(),
                );
                $validateInvoiceByBusiness = $modelInvoiceByBusiness->validateModel($paramsValidate);
                $payment_method_id = -1;


                if ($validateInvoiceByBusiness['success']) {
                    $modelInvoiceByBusiness->fill($business_by_invoice_sale);
                    $modelInvoiceByBusiness->save();
                    if ($headerGet['paymentMethod'] == 'CASH') {
                        $payment_method_id = PosPaymentMethod::ID_CASH;
                        $provider = 'MONEY';
                        $reference = 'C2B';
                        $extra_data = '{"type":"none"}';
                    } else if ($headerGet['paymentMethod'] == 'CARD') {
                        $payment_method_id = PosPaymentMethod::ID_CARD;
                        $provider = 'NONE-CARD-TYPE';
                        $reference = 'NONE-CARD-REFERENCE';
                        $extra_data = '{"type":"NONE-CARD"}';
                    } else if ($headerGet['paymentMethod'] == 'QR') {
                        $payment_method_id = PosPaymentMethod::ID_TRANSFER;
                        $provider = 'DEUNA';
                        $reference = 'DE UNA REFERENCIA ';
                        $extra_data = '{"type":"NONE-DE UNA"}';
                    } else if ($headerGet['paymentMethod'] == 'Deposito') {
                        $payment_method_id = PosPaymentMethod::ID_DEPOSIT;
                        $reference = 'DE UNA REFERENCIA ';
                        $extra_data = '{"type":"NONE-ID-BANCO"}';
                    }


                    $modelInvoiceByPayment = new InvoiceSalePayment();
                    $invoiceByPayment = [
                        'invoice_sale_id' => $invoice_sale_id,
                        'payment_method_id' => $payment_method_id,
                        'amount' => $total,
                        'provider' => $provider,
                        'reference' => $reference,
                        'extra_data' => $extra_data,
                        'created_at' => Util::DateCurrent(),
                        'update_at' => Util::DateCurrent()

                    ];

                    $paramsValidate = array(
                        'modelAttributes' => $invoiceByPayment,
                        'rules' => $modelInvoiceByPayment::getRulesModel(),
                    );

                    $validateInvoiceByPayment = $modelInvoiceByPayment->validateModel($paramsValidate);

                    if ($validateInvoiceByPayment['success']) {
                        $modelInvoiceByPayment->fill($invoiceByPayment);
                        $modelInvoiceByPayment->save();
                    } else {
                        $message = "No se pudo realizar el guardado de Factura by Payments!";
                        $success = false;
                        $errors = $validateInvoiceByPayment["errors"];
                        throw new \Exception($message);
                    }


                    $modelInvoiceByMeta = new InvoiceSaleMeta();
                    $invoiceByMeta = [
                        'invoice_sale_id' => $invoice_sale_id,
                        'ticket_code' => $ticket_code,
                        'service_type' => $service_type,
                        'created_at' => Util::DateCurrent(),
                        'update_at' => Util::DateCurrent()

                    ];

                    $paramsValidate = array(
                        'modelAttributes' => $invoiceByMeta,
                        'rules' => $modelInvoiceByMeta::getRulesModel(),
                    );
                    $validateInvoiceByMeta = $modelInvoiceByMeta->validateModel($paramsValidate);

                    if ($validateInvoiceByMeta['success']) {
                        $modelInvoiceByMeta->fill($invoiceByMeta);
                        $modelInvoiceByMeta->save();
                    } else {
                        $message = "No se pudo realizar el guardado de Factura by Payments!";
                        $success = false;
                        $errors = $validateInvoiceByMeta["errors"];
                        throw new \Exception($message);
                    }


                    $business_by_invoice_sale["id"] = $modelInvoiceByBusiness->id;
                    $success = true;
                    $detailsSales = [];
                    $inventoryDataOutput = [];
                    foreach ($validated as $itemValidate) {
                        $dataItem = $itemValidate["data"];
                        $typeProduct = $dataItem["type"];


                        $inventoryDataOutput = array_merge($inventoryDataOutput, $dataItem["inventory_movements"]);
                        if ($typeProduct == "MIXED") {
                            $dataRecipe = $dataItem["dataRecipe"];
                            foreach ($dataRecipe as $itemRecipe) {

                            }
                        } else {

                        }

                        $setPushItem = [
                            "product_id" => $dataItem["id"],
                            "quantity" => $dataItem["amount"],
                            "quantity_unit" => $dataItem["amount"],
                            "discount_percentage" => $dataItem["valuePercentageDiscount"],
                            "discount_percentage_unit" => $dataItem["valuePercentageDiscount"],
                            "discount_value" => 0,
                            "discount_value_unit" => 0,
                            "unit_price" => $dataItem["pvPrice"],
                            "unit_price_unit" => $dataItem["pvPrice"],
                            "management_type" => "U",
                            "tax_percentage" => $dataItem["valuePercentageTax"],
                            "subtotal" => $dataItem["subtotal"],
                            "total" => $dataItem["total"],
                            "description" => "Describir",
                            "product_type" => 0,
                            "invoice_sale_id" => $invoice_sale_id

                        ];
                        $modelInvoiceByBusinessDetails = new InvoiceSaleByDetails();
                        $paramsValidate = array(
                            'modelAttributes' => $setPushItem,
                            'rules' => $modelInvoiceByBusinessDetails::getRulesModel(),
                        );
                        $validateInvoiceByBusinessDetails = $modelInvoiceByBusinessDetails->validateModel($paramsValidate);
                        if ($validateInvoiceByBusinessDetails['success']) {
                            $message = "Producto Guardado";
                            $success = true;
                            $modelInvoiceByBusinessDetails->fill($setPushItem);
                            $modelInvoiceByBusinessDetails->save();
                            $detailsId = $modelInvoiceByBusinessDetails->id;
                            $setPushItem["id"] = $detailsId;
                        } else {
                            $message = "No se pudo realizar el guardado del Producto!";
                            $success = false;
                            $errors = $validateInvoiceByBusinessDetails["errors"];

                            throw new \Exception($message);
                        }
                        array_push($detailsSales, $setPushItem);
                    }

                    foreach ($inventoryDataOutput as $itemInventoryMovement) {
                        $modelInventoryMovement = new InventoryMovement();
                        $setPushCurrent = $itemInventoryMovement;
                        $setPushCurrent['reference_id'] = $invoice_sale_id;

                        $paramsValidate = array(
                            'modelAttributes' => $setPushCurrent,
                            'rules' => $modelInventoryMovement::getRulesModel(),
                        );

                        $validateInventoryMovement = $modelInventoryMovement->validateModel($paramsValidate);

                        if ($validateInventoryMovement['success']) {
                            $message = "Producto Movimiento Guardado";
                            $success = true;
                            $modelInventoryMovement->fill($setPushCurrent);
                            $modelInventoryMovement->save();


                        } else {
                            $message = "No se pudo realizar el guardado del Producto Movimiento!";
                            $success = false;
                            $errors = $validateInventoryMovement["errors"];

                            throw new \Exception($message);
                        }


                    }

                } else {
                    $message = "No se pudo realizar el guardado de Factura by Business.!";
                    $success = false;
                    $errors = $validateInvoiceByBusiness["errors"];
                    throw new \Exception($message);
                }

            } else {
                $success = false;
                $message = "No se pudo realizar el guardado de Factura.!";
                $errors = $validateInvoice["errors"];

                throw new \Exception($message);

            }
            if (!$success) {
                DB::rollBack();

            } else {
                if ($pe_id > 0) {
                    $modelEmision = new PuntoEmision();
                    $modelEmision->incrementarFactura($pe_id, $invoiceCode);
                }

                DB::commit();
            }
            $result = array(
                "success" => $success,
                "msj" => "Ticket Registrado.!",
                "data" => [
                    "detailsSales" => $detailsSales,
                    "business_by_invoice_sale" => $business_by_invoice_sale,
                    "invoice" => $attributesSetInvoice,
                    "inventoryDataOutput" => $inventoryDataOutput

                ],
                "errors" => []
            );
        } catch (\Exception $e) {
            $msj = $e->getMessage();
            $result = array(
                "success" => false,
                "msj" => $msj,
                "data" => [],
                "errors" => $errors
            );

        }
        return response()->json($result);

    }

    private function getMockDataWithTotals($type)
    {
        $items = $this->getMockData($type);

        $subtotal = 0;
        $tax_total = 0;
        $total = 0;

        foreach ($items as &$item) {

            $amount = $item["amount"];
            $price = floatval($item["pvPrice"]);
            $hasTax = $item["hasTax"] === "SI";
            $taxPercent = $item["tax"]["value_percentage"];


            // ✅ Cálculo línea
            $line_subtotal = $amount * $price;

            $line_tax = $hasTax
                ? ($line_subtotal * $taxPercent) / 100
                : 0;

            $line_total = $line_subtotal + $line_tax;

            // Guardar en item
            $item["line_subtotal"] = round($line_subtotal, 2);
            $item["line_tax"] = round($line_tax, 2);
            $item["line_total"] = round($line_total, 2);
            $item["status"] = "OK";

            // Acumulados
            $subtotal += $line_subtotal;
            $tax_total += $line_tax;
            $total += $line_total;
        }

        return [
            "items" => $items,
            "summary" => [
                "subtotal" => round($subtotal, 2),
                "tax_total" => round($tax_total, 2),
                "total" => round($total, 2)
            ]
        ];
    }

    private function getMockData($type)
    {
        switch ($type) {

            // =========================================
            // 1) TODOS LOS TIPOS OK
            // =========================================
            case 'all_types_ok':
                return [
                    [
                        "id" => 1,
                        "code" => "A-01-MEASURABLE",
                        "name" => "carne de res",
                        "type" => "MEASURABLE",
                        "amount" => 500,
                        "stock" => ["quantity" => 10000, "unit" => "g"],
                        "tax" => ["has_tax" => "SI", "value_percentage" => 12],
                        "price" => ["pv" => "1.5000"]
                    ],
                    [
                        "id" => 5,
                        "code" => "A-05-UNIT",
                        "name" => "huevos",
                        "type" => "UNIT",
                        "amount" => 10,
                        "stock" => ["quantity" => 100, "unit" => "u"],
                        "tax" => ["has_tax" => "NO", "value_percentage" => 0],
                        "price" => ["pv" => "0.5000"]
                    ],
                    [
                        "id" => 8,
                        "code" => "A-08-MIXED",
                        "name" => "carne apanada",
                        "type" => "MIXED",
                        "amount" => 2,
                        "stock" => ["quantity" => 10, "unit" => "u"],
                        "tax" => ["has_tax" => "NO", "value_percentage" => 0],
                        "price" => ["pv" => "1.0000"]
                    ]
                ];

            // =========================================
            // 2) UNO DE CADA UNO
            // =========================================
            case 'one_each':
                return [
                    [
                        "id" => 2,
                        "code" => "A-02-MEASURABLE",
                        "name" => "papas",
                        "type" => "MEASURABLE",
                        "amount" => 2000,
                        "stock" => ["quantity" => 100000, "unit" => "g"],
                        "tax" => ["has_tax" => "NO", "value_percentage" => 0],
                        "price" => ["pv" => "1.5000"]
                    ],
                    [
                        "id" => 6,
                        "code" => "A-06-UNIT",
                        "name" => "chorizo",
                        "type" => "UNIT",
                        "amount" => 5,
                        "stock" => ["quantity" => 250, "unit" => "u"],
                        "tax" => ["has_tax" => "NO", "value_percentage" => 0],
                        "price" => ["pv" => "0.8000"]
                    ],
                    [
                        "id" => 9,
                        "code" => "A-09-MIXED",
                        "name" => "carne molida frita",
                        "type" => "MIXED",
                        "amount" => 1,
                        "stock" => ["quantity" => 10, "unit" => "u"],
                        "tax" => ["has_tax" => "NO", "value_percentage" => 0],
                        "price" => ["pv" => "0.7500"]
                    ]
                ];

            // =========================================
            // 3) TODO FALLA INVENTARIO
            // =========================================
            case 'all_fail_inventory':
                return [
                    [
                        "id" => 1,
                        "amount" => 20000,
                        "code" => "A-01-MEASURABLE",
                        "name" => "carne de res",
                        "type" => "MEASURABLE",
                        "stock" => ["quantity" => 10000, "unit" => "g"],
                        "tax" => ["has_tax" => "SI", "value_percentage" => 12],
                        "price" => ["pv" => "1.5000"]
                    ],
                    [
                        "id" => 5,
                        "amount" => 500,
                        "code" => "A-05-UNIT",
                        "name" => "huevos",
                        "type" => "UNIT",
                        "stock" => ["quantity" => 100, "unit" => "u"],
                        "tax" => ["has_tax" => "NO", "value_percentage" => 0],
                        "price" => ["pv" => "0.5000"]
                    ]
                ];

            // =========================================
            // 4) MIXED FALLA
            // =========================================
            case 'mixed_fail_only':
                return [
                    [
                        "id" => 8,
                        "amount" => 50,
                        "code" => "A-08-MIXED",
                        "name" => "carne apanada",
                        "type" => "MIXED",
                        "stock" => ["quantity" => 10, "unit" => "u"],
                        "tax" => ["has_tax" => "NO", "value_percentage" => 0],
                        "price" => ["pv" => "1.0000"]
                    ]
                ];

            // =========================================
            // 5) UNIT FALLA
            // =========================================
            case 'unit_fail_only':
                return [
                    [
                        "id" => 5,
                        "amount" => 200,
                        "code" => "A-05-UNIT",
                        "name" => "huevos",
                        "type" => "UNIT",
                        "stock" => ["quantity" => 100, "unit" => "u"],
                        "tax" => ["has_tax" => "NO", "value_percentage" => 0],
                        "price" => ["pv" => "0.5000"]
                    ]
                ];

            // =========================================
            // 6) MEASURABLE FALLA
            // =========================================
            case 'measurable_fail_only':
                return [
                    [
                        "id" => 1,
                        "amount" => 20000,
                        "code" => "A-01-MEASURABLE",
                        "name" => "carne de res",
                        "type" => "MEASURABLE",
                        "stock" => ["quantity" => 10000, "unit" => "g"],
                        "tax" => ["has_tax" => "SI", "value_percentage" => 12],
                        "price" => ["pv" => "1.5000"]
                    ]
                ];

            // =========================================
            // 7) MIXED SIN RECETA
            // =========================================
            case 'mixed_no_recipe':
                return [
                    [
                        "id" => 30,
                        "amount" => 1,
                        "code" => "A-030-MIXED",
                        "name" => "mixto pollo huevo",
                        "type" => "MIXED",
                        "stock" => ["quantity" => 10, "unit" => "u"],
                        "tax" => ["has_tax" => "NO", "value_percentage" => 0],
                        "price" => ["pv" => "3.0000"]
                    ]
                ];

            // =========================================
            // 8) PRODUCTO NO EXISTE
            // =========================================
            case 'product_not_found':
                return [
                    [
                        "id" => 9999,
                        "amount" => 1,
                        "code" => "NOT_FOUND",
                        "name" => "no existe",
                        "type" => "UNIT",
                        "stock" => ["quantity" => 0, "unit" => "u"],
                        "tax" => ["has_tax" => "NO", "value_percentage" => 0],
                        "price" => ["pv" => "0"]
                    ]
                ];

            // =========================================
            // 9) DUPLICADOS
            // =========================================
            case 'duplicates':
                return [
                    [
                        "id" => 5,
                        "amount" => 5,
                        "code" => "A-05-UNIT",
                        "name" => "huevos",
                        "type" => "UNIT",
                        "stock" => ["quantity" => 100, "unit" => "u"],
                        "tax" => ["has_tax" => "NO", "value_percentage" => 0],
                        "price" => ["pv" => "0.5000"]
                    ],
                    [
                        "id" => 5,
                        "amount" => 10,
                        "code" => "A-05-UNIT",
                        "name" => "huevos",
                        "type" => "UNIT",
                        "stock" => ["quantity" => 100, "unit" => "u"],
                        "tax" => ["has_tax" => "NO", "value_percentage" => 0],
                        "price" => ["pv" => "0.5000"]
                    ]
                ];

            // =========================================
            // 10) MIXED COMPLEJO
            // =========================================
            case 'mixed_complex':
                return [
                    [
                        "id" => 17,
                        "amount" => 3,
                        "code" => "A-017-MIXED",
                        "name" => "choripapa",
                        "type" => "MIXED",
                        "stock" => ["quantity" => 10, "unit" => "u"],
                        "tax" => ["has_tax" => "NO", "value_percentage" => 0],
                        "price" => ["pv" => "1.7500"]
                    ]
                ];

            // =========================================
            // 11) ORDEN GRANDE
            // =========================================
            case 'full_order':
                return [
                    ["id" => 1, "amount" => 200, "code" => "A-01-MEASURABLE", "name" => "carne de res", "type" => "MEASURABLE", "stock" => ["quantity" => 10000, "unit" => "g"], "tax" => ["has_tax" => "SI", "value_percentage" => 12], "price" => ["pv" => "1.5000"]],
                    ["id" => 5, "amount" => 20, "code" => "A-05-UNIT", "name" => "huevos", "type" => "UNIT", "stock" => ["quantity" => 100, "unit" => "u"], "tax" => ["has_tax" => "NO", "value_percentage" => 0], "price" => ["pv" => "0.5000"]],
                    ["id" => 6, "amount" => 10, "code" => "A-06-UNIT", "name" => "chorizo", "type" => "UNIT", "stock" => ["quantity" => 250, "unit" => "u"], "tax" => ["has_tax" => "NO", "value_percentage" => 0], "price" => ["pv" => "0.8000"]],
                    ["id" => 8, "amount" => 3, "code" => "A-08-MIXED", "name" => "carne apanada", "type" => "MIXED", "stock" => ["quantity" => 10, "unit" => "u"], "tax" => ["has_tax" => "NO", "value_percentage" => 0], "price" => ["pv" => "1.0000"]],
                    ["id" => 17, "amount" => 2, "code" => "A-017-MIXED", "name" => "choripapa", "type" => "MIXED", "stock" => ["quantity" => 10, "unit" => "u"], "tax" => ["has_tax" => "NO", "value_percentage" => 0], "price" => ["pv" => "1.7500"]],
                ];

            // =========================================
            // 12) ZERO
            // =========================================
            case 'zero_amount':
                return [
                    [
                        "id" => 5,
                        "amount" => 0,
                        "code" => "A-05-UNIT",
                        "name" => "huevos",
                        "type" => "UNIT",
                        "stock" => ["quantity" => 100, "unit" => "u"],
                        "tax" => ["has_tax" => "NO", "value_percentage" => 0],
                        "price" => ["pv" => "0.5000"]
                    ]
                ];

            // =========================================
            // 13) NEGATIVO
            // =========================================
            case 'negative_amount':
                return [
                    [
                        "id" => 1,
                        "amount" => -5,
                        "code" => "A-01-MEASURABLE",
                        "name" => "carne de res",
                        "type" => "MEASURABLE",
                        "stock" => ["quantity" => 10000, "unit" => "g"],
                        "tax" => ["has_tax" => "SI", "value_percentage" => 12],
                        "price" => ["pv" => "1.5000"]
                    ]
                ];

            // =========================================
            // 14) PARCIAL
            // =========================================
            case 'partial_fail_mix':
                return [
                    ["id" => 1, "amount" => 200, "code" => "A-01-MEASURABLE", "name" => "carne de res", "type" => "MEASURABLE", "stock" => ["quantity" => 10000, "unit" => "g"], "tax" => ["has_tax" => "SI", "value_percentage" => 12], "price" => ["pv" => "1.5000"]],
                    ["id" => 5, "amount" => 500, "code" => "A-05-UNIT", "name" => "huevos", "type" => "UNIT", "stock" => ["quantity" => 100, "unit" => "u"], "tax" => ["has_tax" => "NO", "value_percentage" => 0], "price" => ["pv" => "0.5000"]],
                    ["id" => 8, "amount" => 1, "code" => "A-08-MIXED", "name" => "carne apanada", "type" => "MIXED", "stock" => ["quantity" => 10, "unit" => "u"], "tax" => ["has_tax" => "NO", "value_percentage" => 0], "price" => ["pv" => "1.0000"]],
                ];

            // =========================================
            // 15) VACÍO
            // =========================================
            case 'empty':
                return [];

            default:
                return [];
        }
    }
    public function setProductTypeSave(Request $request)//POS-PRODUCTS -INIT-ONE
    {
        $params = $request->all();
        $payload = json_decode($request->input('payload'), true);
        $sendData=$payload;
        if(isset($params['image'])){
            $sendData['image']=$params['image'];
        }
        $data = $this->service->setProductTypeSave($sendData);
        $this->user = $request->get('auth_user');
        return response()->json($data);
    }
    public function setCategoryByBusinessSave(Request $request)//POS-PRODUCTS -INIT-ONE
    {
        $params = $request->all();
        $payload = json_decode($request->input('payload'), true);
        $sendData=$payload;
        if(isset($params['image'])){
            $sendData['image']=$params['image'];
        }

        $data = $this->service->setCategoryByBusinessSave($sendData);
        $this->user = $request->get('auth_user');
        return response()->json($data);
    }
    public function setCategoryByBusinessUpdate(Request $request)//POS-PRODUCTS -INIT-ONE
    {
        $params = $request->all();
        $payload = json_decode($request->input('payload'), true);
        $sendData=$payload;
        if(isset($params['image'])){
            $sendData['image']=$params['image'];
        }

        $data = $this->service->setCategoryByBusinessUpdate($sendData);
        $this->user = $request->get('auth_user');
        return response()->json($data);
    }
    public function setSubCategoryByBusinessSave(Request $request)//POS-PRODUCTS -INIT-ONE
    {
        $params = $request->all();
        $payload = json_decode($request->input('payload'), true);
        $sendData=$payload;
        if(isset($params['image'])){
            $sendData['image']=$params['image'];
        }

        $data = $this->service->setSubCategoryByBusinessSave($sendData);
        $this->user = $request->get('auth_user');
        return response()->json($data);
    }
    public function setSubCategoryByBusinessUpdate(Request $request)//POS-PRODUCTS -INIT-ONE
    {
        $params = $request->all();
        $payload = json_decode($request->input('payload'), true);
        $sendData=$payload;
        if(isset($params['image'])){
            $sendData['image']=$params['image'];
        }
        $data = $this->service->setSubCategoryByBusinessUpdate($sendData);
        $this->user = $request->get('auth_user');
        return response()->json($data);
    }
    public function setProductTypeUpdate(Request $request)//POS-PRODUCTS -INIT-ONE
    {
        $params = json_decode($request->input('payload'), true) ?? [];
        if ($request->hasFile('image')) {
            $params['image'] = $request->file('image');
        }
        $data = $this->service->setProductTypeUpdate($params);
        $this->user = $request->get('auth_user');
        return response()->json($data);
    }
    public function setProductItemRecipeSave(Request $request)//POS-PRODUCTS -INIT-ONE
    {
        $params = $request->all();
        $data = $this->service->setProductItemRecipeSave($params);
        $this->user = $request->get('auth_user');
        return response()->json($data);
    }

    public function save2(Request $request)
    {
        $payload = $request->json()->all();


        $data = $this->service->setProductItemRecipeSave($payload);
        $this->user = $request->get('auth_user');
        return response()->json($data);
    }

    public function saveProductRecipe(Request $request)
    {
        $payload = $request->json()->all();

        DB::beginTransaction();

        $step = 'START';

        try {

            /**
             * Guardar receta
             */
            $step = 'PRODUCT_RECIPE_SAVE';

            $model = new ProductRecipe();

            $productId = $payload['component_product_id'];

            $saved = $model->saveFromArray($payload);


            /**
             * Buscar producto componente
             */
            $step = 'CHECK_COMPONENT_PRODUCT';

            $resultData = Product::find($productId);
            if (!$resultData) {
                throw new Exception(
                    "No existe producto componente ID: {$productId}"
                );
            }


            /**
             * Solo descuenta inventario si es procesado
             */
            if ($resultData->inventory_type == ProductClassification::INVENTORY_PROCESSED) {
                $step = 'INVENTORY_MOVEMENT_SAVE';
                $modelIM = new InventoryMovement();
                $dataInventoryMovement = [

                    'product_id' => $payload['component_product_id'],

                    'movement_type' => InventoryMovement::TYPE_OUT,

                    'quantity' => $payload['quantity_base'],

                    'unit_measure_id' => $payload['base_unit_measure_id'],

                    'quantity_input' => $payload['quantity_input'],

                    'unit_input_id' => $payload['unit_input_id'],

                    'conversion_factor' => $payload['conversion_factor'],

                    'reference_type' => 'INVENTARIO_DISCOUNT_BY_RECIPE',

                    'reference_id' => $saved->id,

                    'description' => 'Descuento por Registro de Receta by RECETA',
                ];
                $savedInventory = $modelIM->saveFromArray(
                    $dataInventoryMovement
                );

            }
            if ($model->existsComponentProduct($productId)) {
                $resultData->state = "ACTIVE";
                $resultData->save();
            }

            DB::commit();


            return response()->json([

                'success' => true,

                'msj' => 'Ingrediente guardado correctamente',

                'data' => [

                    'model' => $saved,

                    'recipe_id' => $saved->id,

                    'inventory_movement' => $savedInventory ?? null

                ],

                'errors' => []

            ]);


        } catch (\Throwable $e) {


            DB::rollBack();


            return response()->json([

                'success' => false,

                'msj' => 'Error guardando receta',

                'data' => [],

                'errors' => [

                    'step' => $step,

                    'message' => $e->getMessage(),

                    'line' => $e->getLine(),

                    'file' => $e->getFile()

                ]

            ]);
        }
    }

}
