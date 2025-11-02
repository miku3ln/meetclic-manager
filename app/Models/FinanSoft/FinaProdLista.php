<?php


namespace App\Models\FinanSoft;

use Illuminate\Support\Facades\DB;
use Auth;

use App\Models\ModelManager;

class FinaProdLista extends ModelManager
{

    protected $table = 'FINA_PRODLISTA';
    protected $fieldMain = "LIPR_JUEVES";

    protected $fillable = array(
        'COMP_ID',
        'LIST_ID',
        'PROD_ID',
        'PROD_PRECIO',
        'LIPR_FHINI',
        'LIPR_FHFIN',
        'LIPR_PRECIO',
        'LIPR_OFERTA',
        'LIPR_GANANCIA',
        'LIPR_REDONDEAR',

    );

    public $timestamps = false;


    public static function getRulesModel()
    {
        $rules = [
        ];
        return $rules;
    }

    public function getAllByProduct($params)
    {
        try {
            $tableCurrent = $this->getTable();

            // 🔧 Conexión PDO a Firebird
            $initPdoFinanSoft = new InitBdd();
            $pdo = $initPdoFinanSoft->getPDO();

            // 📥 Filtro de búsqueda
            $searchProductId = $params["product_id"];
            $whereClause = "WHERE PROD_ID = ?";
            $bindings = [$searchProductId];
            $main = 'prodlista2';
            $list_precios = 'list_pre';

            // 📦 Consulta de datos completa
            $selectProductos  = $this->getStringSelect(['alias' => $main, 'viewTableIndex' => true]);
            $selecListaPrecios= (new FinaListaPrecios())->getStringSelect(['alias' => $list_precios, 'viewTableIndex' => true]);

            $selectAll = $this->removeDuplicateFields($selectProductos . ',' . $selecListaPrecios);

            $sql = "SELECT $selectAll  FROM $tableCurrent $main
     LEFT JOIN FINA_LISTAPRECIOS    $list_precios ON $main.LIST_ID = $list_precios.LIST_ID

         $whereClause ";

            $stmt = $pdo->prepare($sql);
            $stmt->execute($bindings);
            $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return [
                'total' => count($data),
                'rows' => $data,
                "success" => true,
            ];

        } catch (\PDOException $e) {
            return [
                'total' => 0,
                'rows' => [],
                "success" => false,
                "message" => $e->getMessage()
            ];
        } catch (\Exception $e) {
            return [
                'total' => 0,
                'rows' => [],
                "success" => false,
                "message" => $e->getMessage()

            ];
        }
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




}
