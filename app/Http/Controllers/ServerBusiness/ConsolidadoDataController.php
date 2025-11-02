<?php

namespace App\Http\Controllers\ServerBusiness;

use App\Models\FinanSoft\FinaProductos;
use App\Models\SystemCurrent\ProductCodebar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\FinanSoft\InitBdd;


class ConsolidadoDataController extends Controller
{
    /**
     * Recibe datos de producto desde el frontend
     * Ruta: POST /api/meetclickmanager-e/es/sendDataView
     */
    public function sendDataViewFrontendWeb(Request $request)
    {

        $datos = $request->all();
        $COMP_RNC = $datos["business"]["COMP_RNC"];
        $productData = json_decode($datos["product"], true);

        $modelProduct = new ProductCodebar();

        $attributesSet = $productData;
        $attributesSet["COMP_RNC"] = $COMP_RNC;

        $paramsValidate = array(
            'inputs' => $attributesSet,
            'rules' => $modelProduct::getRulesModel(),

        );
        $validateResult = $modelProduct->validateModel($paramsValidate);

        $success = $validateResult["success"];
        $message = "";
        $modelInformation = null;
        if ($success) {
            $modelProduct->COMP_RNC = $COMP_RNC;
            $modelProduct->fill($attributesSet);
            $success = $modelProduct->save();
            $message = "Valores Registrados";
            $modelInformation = $modelProduct;
        } else {
            $message = "Valores errones";

        }
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => [
                'information' => $modelInformation,

            ]
        ]);
    }

    public function viewCodeBarProducts()
    {
        $host = env("FIREBIRD_HOST");
        $port = env("FIREBIRD_PORT");
        $locationBdd = env("FIREBIRD_DATABASE");
        $nameKey = env("FIREBIRD_NAME_KEY");
        $userName = env("FIREBIRD_USERNAME");
        $password = env("FIREBIRD_PASSWORD");
        $result = [];
        $business = ["COMP_NOMBRE" => "LISTO"];
        try {


            $dns = $nameKey . ":" . "dbname=" . $host . "/" . $port . ":" . $locationBdd . ";charset=UTF8";
            $pdo = new \PDO(
                $dns,
                $userName,
                $password
            );

            $stmt = $pdo->query("SELECT FIRST 20 * FROM VIEW_CODEBAR_PRODUCTS");
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            $stmtBusiness = $pdo->query("SELECT FIRST 1 * FROM FINA_COMPANIA");
            $resultBusiness = $stmtBusiness->fetchAll(\PDO::FETCH_ASSOC);
            $business = count($resultBusiness) > 0 ? $resultBusiness[0] : ["COMP_NOMBRE" => "LISTO"];
        } catch (\PDOException $e) {

        }
        $sendParams = [
            "dataProducts" => $result,
            "business" => $business,
            "bootstrapVersion" => "3"
        ];

        return view('systemCurrent.viewCodeBarProducts', $sendParams);


    }

    public function getDataViewAdminRegisters(Request $request)
    {

        $params = $request->all();
        $sort = 'asc';
        $tableMain = "product_codebar";
        $field = $tableMain . '.PRBA_CODIGO';
        $query = DB::table($tableMain);

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];

        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $selectString = $tableMain . ".PRBA_CODIGO," . $tableMain . ".COMP_RNC," . $tableMain . ".PROD_PRECIO," . $tableMain . ".PROD_NOMBRE ," . "company.COMP_NOMBRE ";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('company', $tableMain . '.COMP_RNC', '=', 'company.COMP_RNC');

        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = "%" . $searchValue . "%";
            $query->orWhere($tableMain . '.PROD_NOMBRE', 'like', $likeSet);
            $query->orWhere('company.COMP_NOMBRE', 'like', $likeSet);


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

    public function getProductsManager(Request $request)
    {
        $modelFinanProduct = new FinaProductos();

        return $modelFinanProduct->getAdmin($request);
    }

    public function getProductManager(Request $request)
    {
        $modelFinanProduct = new FinaProductos();
        return $modelFinanProduct->getProduct($request);
    }

    public function updateComentarioProducto(Request $request)
    {
        try {
            $datos = $request->all();
            $product = $datos["product"];

            $productoId = $product["id"];
            $comentario = $product["comentario"];

            // 🔧 Conexión PDO a Firebird
            $pdo = new \PDO(
                env("FIREBIRD_NAME_KEY") . ":dbname=" . env("FIREBIRD_HOST") . "/" . env("FIREBIRD_PORT") . ":" . env("FIREBIRD_DATABASE") . ";charset=UTF8",
                env("FIREBIRD_USERNAME"),
                env("FIREBIRD_PASSWORD"),
                [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
            );

            // 🔄 Actualización de comentario
            $sql = "UPDATE FINA_PRODUCTOS SET PROD_COMENTARIO = ? WHERE PROD_ID = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$comentario, $productoId]);

            $rowsAffected = $stmt->rowCount();

            return response()->json([
                'success' => true,
                'updated' => $rowsAffected,
                'message' => $rowsAffected
                    ? 'Comentario actualizado correctamente.'
                    : 'No se encontró el producto.',
            ]);

        } catch (\PDOException $e) {
            return response()->json([
                'success' => false,
                'error' => 'DB Error: ' . $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Unexpected Error: ' . $e->getMessage()
            ], 500);
        }
    }

}
