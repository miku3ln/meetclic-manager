<?php


namespace App\Models\FinanSoft;

use Auth;

use App\Models\ModelManager;

class FinaProdUnidades extends ModelManager
{

    protected $table = 'FINA_PRODUNIDADES';
    protected $fieldMain = "LIST_ID";

    protected $fillable = array(//FINA_LISTAPRECIOS
        'PRUN_ID',
        'COMP_ID',
        'PROD_ID',
        'LIST_ID',
        'UNID_ID',
        'PRUN_CONVERSION',
        'PRUN_PRECIO',
        'PRUN_BARRA',

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
            $list_precios = 'list_pre';
            $main = 'prounida';
            $unidades = 'finUnidades';

            // 📥 Filtro de búsqueda
            $searchProductId = $params["product_id"];
            $whereClause = "WHERE PROD_ID = ?";
            $bindings = [$searchProductId];

            // 📦 Consulta de datos completa

            $selectProductos  = $this->getStringSelect(['alias' => $main, 'viewTableIndex' => true]);


            $selecListaPrecios= (new FinaListaPrecios())->getStringSelect(['alias' => $list_precios, 'viewTableIndex' => true]);
            $selecFinUnidades= (new FinaUnidades())->getStringSelect(['alias' => $unidades, 'viewTableIndex' => true]);

            $selectAll = $this->removeDuplicateFields($selectProductos . ',' . $selecListaPrecios.','.$selecFinUnidades);

            $sql = "SELECT $selectAll FROM $tableCurrent  $main
              LEFT JOIN FINA_LISTAPRECIOS    $list_precios ON $main.LIST_ID = $list_precios.LIST_ID
            LEFT JOIN FINA_UNIDADES    $unidades ON $main.UNID_ID = $unidades.UNID_ID
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



}
