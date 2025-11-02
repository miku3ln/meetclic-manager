<?php


namespace App\Models\FinanSoft;

use Illuminate\Support\Facades\DB;
use Auth;

use App\Models\ModelManager;

class FinaProdBarra extends ModelManager
{

    protected $table = 'FINA_PRODBARRA';
    protected $fieldMain = "PRBA_CODIGO";

    protected $fillable = array(
        'PRBA_ID',
        'COMP_ID',
        'PROD_ID',
        'PRBA_CODIGO',
        'PRBA_FECHA',

    );

    public $timestamps = false;


    public static function getRulesModel()
    {
        $rules = [
        ];
        return $rules;
    }


    /*MANAGER MAINS*/
    public function getByCodeBarras($params)
    {
        try {
            $tableCurrent = $this->getTable();

            // 🔧 Conexión PDO a Firebird
            $initPdoFinanSoft = new InitBdd();
            $pdo = $initPdoFinanSoft->getPDO();

            // 📥 Filtro de búsqueda
            $searchProductId = $params["PRBA_CODIGO"];
            $whereClause = "WHERE PRBA_CODIGO = ?";
            $bindings = [$searchProductId];

            // 📦 Consulta de datos completa
            $selectProductos = $this->getStringSelect([]);
            $sql = "SELECT FIRST 1 $selectProductos FROM $tableCurrent $whereClause ORDER BY PRBA_FECHA ASC";

            $stmt = $pdo->prepare($sql);
            $stmt->execute($bindings);
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);

            $count = $data == false ? 0 : count($data);
            return [
                'total' => $count,
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

            // 📦 Consulta de datos completa
            $selectProductos = $this->getStringSelect([]);
            $sql = "SELECT $selectProductos FROM $tableCurrent $whereClause ORDER BY PRBA_FECHA ASC";

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

