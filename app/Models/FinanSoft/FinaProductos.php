<?php


namespace App\Models\FinanSoft;

use App\Models\FinanSoft\FinaUnidades;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\ModelManager;

use App\Models\FinanSoft\FinaExistencias;
use App\Models\FinanSoft\FinaClases;

class FinaProductos extends ModelManager
{

    protected $table = 'FINA_PRODUCTOS';
    protected $fieldMain = "PROD_NOMBRE";
    protected $fillable = array(
        'COMP_ID',
        'PROD_ID',
        'CLAS_ID',
        'PROD_NOMBRE',
        'PROD_NOMBRECOMPRA',
        'PROD_NOMBRESMALL',
        'UNID_ID',
        'PROD_EXCENTO',
        'PROD_SERVICIO',
        'PROD_PRECIO',
        'PROD_CANTIDAD',
        'PROD_MAX',
        'PROD_MIN',
        'PROD_COMISION',
        'PROD_MAXDESCUENTO',
        'PROD_COMENTARIO',
        'PROD_ESTATUS',
        'USUA_ID',
        'USUA_FECHA',
        'SUPLI_ID',
        'PROD_SERIES',
        'PROD_LOTES',
        'IMP_ID',
        'MONE_ID',
        'PROD_MODIFICAR',
        'PROD_CAMBIAR',
        'PROD_COMPUESTO',
        'PROD_MEDICAMENTO',
        'PROD_TIPOINV',
        'PROD_LISTA',
        'CUEN_NO',
        'CUEN_NO_COMPRAS',
        'CUEN_NO_INVENTARIO',
        'PROD_SINC',
        'UNID_ID_V',
        'UNID_ID_C',
        'PROD_SERIELONG',
        'PROD_PRODUCCION',
        'PROD_PVDESCUENTO',
        'PROD_ENVIOS',
        'PROD_RECARGO',
        'PROD_ORDEN',
        'PROD_PAQUETE',
        'PROD_TALLACOLOR',
        'PROD_WEB',


    );
    protected $attributesData = [
        ['column' => 'customer_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'number_box', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => 'None description', 'required' => 'true'],
        ['column' => 'address_id', 'type' => 'integer', 'defaultValue' => '1', 'required' => 'true'],
        ['column' => 'phone_id', 'type' => 'integer', 'defaultValue' => '1', 'required' => 'true'],
        ['column' => 'status', 'type' => 'string', 'defaultValue' => 'INITIALIZED', 'required' => 'true'],
        ['column' => 'user_id', 'type' => 'integer', 'defaultValue' => '1', 'required' => 'true'],
        ['column' => 'number_invoice', 'type' => 'string', 'defaultValue' => '0001', 'required' => 'true'],
        ['column' => 'created_at', 'type' => 'string', 'defaultValue' => '2022-06-27', 'required' => 'true'],
        ['column' => 'updated_at', 'type' => 'string', 'defaultValue' => '2022-06-27', 'required' => 'true'],
        ['column' => 'business_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
    ];

    public $timestamps = false;


    public static function getRulesModel()
    {
        $rules = [
        ];
        return $rules;
    }


    /*MANAGER MAINS*/

    public function getAdmin($request)
    {
        try {
            // 🔧 Conexión PDO a Firebird4
            $tableCurrent = $this->getTable();
            $initPdoFinanSoft = new InitBdd();
            $pdo = $initPdoFinanSoft->getPDO();
            // 📥 Parámetros de paginación y búsqueda
            $search = $request->input('searchPhrase', '');
            $sort = $request->input('sort', []);
            $sortField = key($sort) ?? $this->fieldMain;
            $sortDirection = strtoupper($sort[$sortField] ?? 'ASC');
            $page = max(1, (int)$request->input('current', 1));
            $perPage = (int)$request->input('rowCount', 10);
            $offset = ($page - 1) * $perPage;

            // 🔍 WHERE dinámico
            $whereClause = '';
            $bindings = [];
            $aliasProduct = "p";
            $aliasUnidad = "u";
            $aliasExistencia = "e";

            if (!empty($search)) {
                $searchLike = '%' . strtoupper($search) . '%'; // convierte a mayúsculas para evitar case sensitivity
                $whereClause = "WHERE
        UPPER($aliasProduct.PROD_NOMBRE) LIKE ? OR
        CAST($aliasProduct.PROD_ID AS VARCHAR(20)) LIKE ? OR
        CAST($aliasProduct.CLAS_ID AS VARCHAR(20)) LIKE ? OR
        CAST($aliasProduct.COMP_ID AS VARCHAR(20)) LIKE ?";

                $bindings = [$searchLike, $searchLike, $searchLike, $searchLike];
            }

            // 📊 Total de registros

            $countStmt = $pdo->prepare("SELECT COUNT(*) FROM $tableCurrent $aliasProduct $whereClause");
            $countStmt->execute($bindings);
            $total = (int)$countStmt->fetchColumn();

            // 📦 Datos paginados


            $selectProductos = $this->getStringSelect(["alias" => $aliasProduct, "viewTableIndex" => true]);
            $modelUnidad = new FinaUnidades();
            $modelExistencia = new FinaExistencias();
            $selectUnidad = $modelUnidad->getStringSelect(["alias" => $aliasUnidad, "viewTableIndex" => true]);
            $selectExistencia = $modelExistencia->getStringSelect(["alias" => $aliasExistencia, "viewTableIndex" => true]);

            $selectAll = $selectProductos . "," . $selectUnidad . "," . $selectExistencia;

            $selectAll = $this->removeDuplicateFields($selectAll);
            $sql = "SELECT FIRST $perPage SKIP $offset
                    $selectAll
                FROM $tableCurrent $aliasProduct
               INNER JOIN FINA_UNIDADES $aliasUnidad ON $aliasProduct.UNID_ID = $aliasUnidad.UNID_ID
              INNER JOIN FINA_EXISTENCIAS $aliasExistencia ON $aliasProduct.PROD_ID = $aliasExistencia.PROD_ID
                $whereClause
                ORDER BY $sortField $sortDirection";

            $stmt = $pdo->prepare($sql);
            $stmt->execute($bindings);
            $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            $modelHistorico = new FinaProductoHistorico();
            $modelCodigos = new FinaProdBarra();

            foreach ($data as $key => $value) {
                $product_id = $value["PROD_ID"];
                $historicData = $modelHistorico->getAllByProduct(["product_id" => $product_id]);
                $codigosData = $modelCodigos->getAllByProduct(["product_id" => $product_id]);

                $historic = [];
                $codigos = [];

                if ($historicData["success"]) {
                    $historic = $historicData["rows"];
                }
                if ($codigosData["success"]) {
                    $codigos = $codigosData["rows"];
                }
                $data[$key]["historic"] = $historic;
                $data[$key]["codecs"] = $codigos;

            }
            // ✅ Respuesta JSON estándar para grids
            return response()->json([
                'total' => $total,
                'rows' => $data,
                'current' => $page,
                'rowCount' => $perPage,
            ]);

        } catch (\PDOException $e) {
            return response()->json(['error' => 'DB Error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unexpected Error: ' . $e->getMessage()], 500);
        }
    }

    public function getProductantes($request)//TODO MAKE DATA LEO
    {
        try {
            $searchCode = $request->input('searchPhrase', '');

            $tiempoConexion = microtime(true);
            $pdo = (new InitBdd())->getPDO();
            // Procedimiento "ejecutable" (sin SUSPEND): retorna 1 fila con datos o 1 fila con NULLs
            $sql = 'EXECUTE PROCEDURE GET_PRODBARRA_BY_CODE(?)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$searchCode]);
            // Firebird devuelve 1 fila; validamos si realmente tiene datos
            $row = $stmt->fetch(); // FETCH_ASSOC por defecto
            $success = false;
            $dataCurrent = [];
            $count = $row == false ? 0 : count($row);

            if ($count) {
                $success = true;
                $dataCurrent = [
                    "PRBA_CODIGO" => $row["PRBA_CODIGO"],
                    "PRBA_FECHA" => $row["PRBA_FECHA"],
                    "PRBA_ID" => $row["PRBA_ID"],
                    "PROD_ID" => $row["PROD_ID"],
                    "COMP_ID" => $row["COMP_ID"]
                ];
            } else {

            }
            $fin = microtime(true);
            return [
                'success' => $success,
                "timeProcess" => ["init" => $tiempoConexion, "end" => $fin],
                'seconds'   => round($fin - $tiempoConexion, 6),
                'rows' => $dataCurrent,
            ];


        } catch (\PDOException $e) {
            return response()->json(['success' => false, 'error' => 'DB Error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Unexpected Error: ' . $e->getMessage()], 500);
        }
    }

    public function getProduct($request)//TODO MAKE DATA LEO
    {
        try {

            $pdo = (new InitBdd())->getPDO();


            $searchCode = $request->input('searchPhrase', '');

            $modelCodigos = new FinaProdBarra();
            $dataCode = [];
            $codecData = $modelCodigos->getByCodeBarras(['PRBA_CODIGO' => $searchCode]);
            if ($codecData['success']) {
                $dataCode = $codecData['rows'];

            }

            $count = $dataCode == false ? 0 : count($dataCode);

            if ($count > 0) {
                $productId = $dataCode["PROD_ID"];
                $row = $this->getProductById(["productId" => $productId, "pdo" => $pdo]);
                return response()->json([
                    'success' => true,
                    'information' => $row,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'information' => null,
                    'message' => 'Producto no encontrado'
                ]);
            }


        } catch (\PDOException $e) {
            return response()->json(['success' => false, 'error' => 'DB Error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Unexpected Error: ' . $e->getMessage()], 500);
        }
    }

    public function getProduct22($request)//TODO MAKE DATA LEO
    {
        try {
            $tableCurrent = $this->getTable();
            $pdo = (new InitBdd())->getPDO();

            // Entradas (se mantienen)
            $search = $request->input('searchPhrase', '');
            $p = 'p';
            $u = 'u';
            $e = 'e';
            $clas = 'clas';
            $dep = 'dep';

            // SELECTs (si no necesitas siempre todo, reduce columnas aquí)
            $selectProductos = $this->getStringSelect(['alias' => $p, 'viewTableIndex' => true]);
            $selectUnidad = (new FinaUnidades())->getStringSelect(['alias' => $u, 'viewTableIndex' => true]);
            $selectExistencia = (new FinaExistencias())->getStringSelect(['alias' => $e, 'viewTableIndex' => true]);
            $selectClases = (new FinaClases())->getStringSelect(['alias' => $clas, 'viewTableIndex' => true]);
            $selectDepartamento = (new FinaDepartamentos())->getStringSelect(['alias' => $dep, 'viewTableIndex' => true]);

            $selectAll = $this->removeDuplicateFields($selectProductos . ',' . $selectUnidad . ',' . $selectExistencia . ',' . $selectClases . ',' . $selectDepartamento);

            // 🔍 Exclusivo por PROD_ID (índice)
            $whereClause = "WHERE $p.PROD_ID LIKE  ?";
            $bindings = ["%{$search}%"];

            // ⚡️ SOLO UNA FILA, SIN ORDER BY (más rápido con búsqueda exacta)
            $sql = "SELECT FIRST 1
                    $selectAll
                FROM $tableCurrent $p
                LEFT JOIN FINA_UNIDADES    $u ON $p.UNID_ID = $u.UNID_ID
                LEFT JOIN FINA_EXISTENCIAS $e ON $p.PROD_ID = $e.PROD_ID
                LEFT JOIN FINA_CLASES $clas ON $p.CLAS_ID = $clas.CLAS_ID
                LEFT JOIN FINA_DEPARTAMENTOS $dep ON $clas.DEPA_ID = $dep.DEPA_ID
                $whereClause";

            $stmt = $pdo->prepare($sql);
            $stmt->execute($bindings);
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (!$row) {
                return response()->json([
                    'success' => false,
                    'information' => null,
                    'message' => 'Producto no encontrado'
                ]);
            }

            // Carga extras SOLO si existe el recurso
            $prodId = $row['PROD_ID'];
            $modelHistorico = new FinaProductoHistorico();
            $modelCodigos = new FinaProdBarra();
            $modelProdUnidades = new FinaProdUnidades();
            $modelFinaProdLista = new FinaProdLista();

            $historic = [];
            $codigos = [];
            $preciosPorUnidades = [];
            $prodListaData = [];

            $h = $modelHistorico->getAllByProduct(['product_id' => $search]);
            if (!empty($h['success'])) $historic = $h['rows'] ?? [];

            $c = $modelCodigos->getAllByProduct(['product_id' => $search]);


            if (!empty($c['success'])) $codigos = $c['rows'] ?? [];

            $uni = $modelProdUnidades->getAllByProduct(['product_id' => $search]);
            if (!empty($uni['success'])) $preciosPorUnidades = $uni['rows'] ?? [];

            $prodLista = $modelFinaProdLista->getAllByProduct(['product_id' => $search]);
            if (!empty($prodLista['success'])) $prodListaData = $prodLista['rows'] ?? [];

            $row['historic'] = $historic;
            $row['codecs'] = $codigos;
            $row['preciosPorUnidades'] = $preciosPorUnidades;
            $row['prodLista'] = $prodListaData;

            return response()->json([
                'success' => true,
                'information' => $row,
            ]);

        } catch (\PDOException $e) {
            return response()->json(['success' => false, 'error' => 'DB Error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Unexpected Error: ' . $e->getMessage()], 500);
        }
    }

    public function getProductById($params)
    {
        $search = $params["productId"];
        $tableCurrent = $this->getTable();
        $pdo = $params["pdo"];
        $p = 'p';
        $u = 'u';
        $e = 'e';
        $clas = 'clas';
        $dep = 'dep';

        // SELECTs (si no necesitas siempre todo, reduce columnas aquí)
        $selectProductos = $this->getStringSelect(['alias' => $p, 'viewTableIndex' => true]);
        $selectUnidad = (new FinaUnidades())->getStringSelect(['alias' => $u, 'viewTableIndex' => true]);
        $selectExistencia = (new FinaExistencias())->getStringSelect(['alias' => $e, 'viewTableIndex' => true]);
        $selectClases = (new FinaClases())->getStringSelect(['alias' => $clas, 'viewTableIndex' => true]);
        $selectDepartamento = (new FinaDepartamentos())->getStringSelect(['alias' => $dep, 'viewTableIndex' => true]);

        $selectAll = $this->removeDuplicateFields($selectProductos . ',' . $selectUnidad . ',' . $selectExistencia . ',' . $selectClases . ',' . $selectDepartamento);

        // 🔍 Exclusivo por PROD_ID (índice)
        $whereClause = "WHERE $p.PROD_ID LIKE  ?";
        $bindings = ["%{$search}%"];

        // ⚡️ SOLO UNA FILA, SIN ORDER BY (más rápido con búsqueda exacta)
        $sql = "SELECT FIRST 1
                    $selectAll
                FROM $tableCurrent $p
                LEFT JOIN FINA_UNIDADES    $u ON $p.UNID_ID = $u.UNID_ID
                LEFT JOIN FINA_EXISTENCIAS $e ON $p.PROD_ID = $e.PROD_ID
                LEFT JOIN FINA_CLASES $clas ON $p.CLAS_ID = $clas.CLAS_ID
                LEFT JOIN FINA_DEPARTAMENTOS $dep ON $clas.DEPA_ID = $dep.DEPA_ID
                $whereClause";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($bindings);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);


        $modelHistorico = new FinaProductoHistorico();
        $modelCodigos = new FinaProdBarra();
        $modelProdUnidades = new FinaProdUnidades();
        $modelFinaProdLista = new FinaProdLista();

        $h = $modelHistorico->getAllByProduct(['product_id' => $search]);
        if (!empty($h['success'])) $historic = $h['rows'] ?? [];

        $c = $modelCodigos->getAllByProduct(['product_id' => $search]);


        if (!empty($c['success'])) $codigos = $c['rows'] ?? [];

        $uni = $modelProdUnidades->getAllByProduct(['product_id' => $search]);
        if (!empty($uni['success'])) $preciosPorUnidades = $uni['rows'] ?? [];

        $prodLista = $modelFinaProdLista->getAllByProduct(['product_id' => $search]);
        if (!empty($prodLista['success'])) $prodListaData = $prodLista['rows'] ?? [];

        $row['historic'] = $historic;
        $row['codecs'] = $codigos;
        $row['preciosPorUnidades'] = $preciosPorUnidades;
        $row['prodLista'] = $prodListaData;

        return $row;
    }

    public
    function getProduct2($request)
    {
        try {
            // 🔧 Conexión PDO a Firebird4
            $tableCurrent = $this->getTable();
            $initPdoFinanSoft = new InitBdd();
            $pdo = $initPdoFinanSoft->getPDO();
            // 📥 Parámetros de paginación y búsqueda
            $search = $request->input('searchPhrase', '');
            $sort = $request->input('sort', []);
            $sortField = key($sort) ?? $this->fieldMain;
            $sortDirection = strtoupper($sort[$sortField] ?? 'ASC');
            $page = max(1, (int)$request->input('current', 1));
            $perPage = (int)$request->input('rowCount', 10);
            $offset = ($page - 1) * $perPage;

            // 🔍 WHERE dinámico
            $whereClause = '';
            $bindings = [];
            $aliasProduct = "p";
            $aliasUnidad = "u";
            $aliasExistencia = "e";

            $searchLike = '%' . strtoupper($search) . '%'; // convierte a mayúsculas para evitar case sensitivity
            $whereClause = "WHERE
        UPPER($aliasProduct.PROD_NOMBRE) LIKE ? OR
        CAST($aliasProduct.PROD_ID AS VARCHAR(20)) LIKE ? OR
        CAST($aliasProduct.CLAS_ID AS VARCHAR(20)) LIKE ? OR
        CAST($aliasProduct.COMP_ID AS VARCHAR(20)) LIKE ?";

            $bindings = [$searchLike, $searchLike, $searchLike, $searchLike];


            $selectProductos = $this->getStringSelect(["alias" => $aliasProduct, "viewTableIndex" => true]);
            $modelUnidad = new FinaUnidades();
            $modelExistencia = new FinaExistencias();
            $selectUnidad = $modelUnidad->getStringSelect(["alias" => $aliasUnidad, "viewTableIndex" => true]);
            $selectExistencia = $modelExistencia->getStringSelect(["alias" => $aliasExistencia, "viewTableIndex" => true]);

            $selectAll = $selectProductos . "," . $selectUnidad . "," . $selectExistencia;

            $selectAll = $this->removeDuplicateFields($selectAll);
            $sql = "SELECT
                    $selectAll
                FROM $tableCurrent $aliasProduct
               INNER JOIN FINA_UNIDADES $aliasUnidad ON $aliasProduct.UNID_ID = $aliasUnidad.UNID_ID
              INNER JOIN FINA_EXISTENCIAS $aliasExistencia ON $aliasProduct.PROD_ID = $aliasExistencia.PROD_ID
                $whereClause";

            $stmt = $pdo->prepare($sql);
            $stmt->execute($bindings);
            $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            $modelHistorico = new FinaProductoHistorico();
            $modelCodigos = new FinaProdBarra();

            foreach ($data as $key => $value) {
                $product_id = $value["PROD_ID"];
                $historicData = $modelHistorico->getAllByProduct(["product_id" => $product_id]);
                $codigosData = $modelCodigos->getAllByProduct(["product_id" => $product_id]);

                $historic = [];
                $codigos = [];

                if ($historicData["success"]) {
                    $historic = $historicData["rows"];
                }
                if ($codigosData["success"]) {
                    $codigos = $codigosData["rows"];
                }
                $data[$key]["historic"] = $historic;
                $data[$key]["codecs"] = $codigos;

            }
            // ✅ Respuesta JSON estándar para grids
            return response()->json([
                'information' => $data,
                'success' => true,
            ]);

        } catch (\PDOException $e) {
            return response()->json(['error' => 'DB Error: ' . $e->getMessage(), 'success' => false], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unexpected Error: ' . $e->getMessage(), 'success' => false], 500);
        }
    }

    public
    function saveData($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        $data = null;
        DB::beginTransaction();
        try {

            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "data" => $data,

                "success" => $success
            ];

            return ($result);
        } catch (Exception $e) {
            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "data" => $data,
                "errors" => $errors
            );
            return ($result);
        }
    }


}
