<?php


namespace App\Models\FinanSoft;

use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\ModelManager;

class FinaExistencias extends ModelManager
{

    protected $table = 'FINA_EXISTENCIAS';
    protected $fieldMain = "PROD_EXISTENCIA";

    protected $fillable = array(
        'EXIS_ID',
        'COMP_ID',
        'SUCU_ID',
        'ALMA_ID',
        'PROD_ID',
        'PROD_EXISTENCIA',
        'PROD_RESERVA',
        'PROD_COSTO',
        'PROD_COSTOPROMEDIO',
        'PROD_COSTOMANEJO',
        'PROD_LOCALIZACION',
        'PROD_COSTOLF',
        'PROD_EXISTENCIATOTAL'

    );

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
            $tableCurrent = $this->getTable();
            // 🔧 Conexión PDO a Firebird
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

            if (!empty($search)) {
                $searchLike = '%' . strtoupper($search) . '%'; // convierte a mayúsculas para evitar case sensitivity

                $whereClause = "WHERE
        UPPER(PROD_NOMBRE) LIKE ? OR
        CAST(PROD_ID AS VARCHAR(20)) LIKE ? OR
        CAST(CLAS_ID AS VARCHAR(20)) LIKE ? OR
        CAST(COMP_ID AS VARCHAR(20)) LIKE ?";

                $bindings = [$searchLike, $searchLike, $searchLike, $searchLike];
            }

            // 📊 Total de registros

            $countStmt = $pdo->prepare("SELECT COUNT(*) FROM $tableCurrent $whereClause");
            $countStmt->execute($bindings);
            $total = (int)$countStmt->fetchColumn();

            // 📦 Datos paginados
            $selectProductos = $this->getStringSelect([]);

            $sql = "SELECT FIRST $perPage SKIP $offset
                    $selectProductos
                FROM $tableCurrent
                $whereClause
                ORDER BY $sortField $sortDirection";

            $stmt = $pdo->prepare($sql);
            $stmt->execute($bindings);
            $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

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

    public function saveData($params)
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
