<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessByProduct extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'business_by_products';

    protected $fillable = array('business_id', 'products_id');

    public $timestamps = false;


    public function getListProductServices($params)
    {
        $result = [];
        $typeProduct = $params['filters']['typeProduct'];
        $modelPI = new \App\Models\ProductInventory();

        if ($typeProduct == "true") {//productos


            $result = $modelPI->getListProductISales($params);
            $modelPBUI = new \App\Models\ProductByUnityInventory();
            $modelPBPUB = new \App\Models\ProductInventoryByPriceUnityBox();

            foreach ($result as $key => $valueCurrent) {
                $value = (array)$valueCurrent;
                $result[$key] = $value;
                $codigo = $value["codigo"];
                $nombre = $value["nombre"];
                $precio_venta = $value["precio_venta"];
                $porcentaje = $value["porcentaje"];

                $descripcion = $value["descripcion"];
                $priceCurrent = round(($precio_venta * $porcentaje / 100) + $precio_venta, 2);
                $descriptionSet = $descripcion == null ? "" : " / " . $descripcion;
                $detalle = $descripcion == null ? $nombre : $nombre . " " . $descripcion;
                $text = $codigo . " - " . $nombre . " $" . $priceCurrent . " (" . $porcentaje . " %)" . $descriptionSet;
                if ($value["porcentaje"] == 0) {
                    $result[$key]["text"] = $text . " (SIN IVA" . ")";
                } else {
                    $result[$key]["text"] = $text . " (CON IVA" . ")";
                }
                $result[$key]["detalle"] = $detalle;
                $ptm_type_box = $value["ptm_type_box"];
                $dataBoxContent = array();
                if ($ptm_type_box == 0) {

                    $modelInventory = $modelPBUI->findByAttributes(array("product_inventory_id" => $value["row_gestion_id"]));
                    $modelPrice = $modelPBPUB->findByAttributes(array("product_inventory_id" => $value["row_gestion_id"]));
                    if ($modelInventory && $modelPrice) {
                        $prices = array(
                            array(
                                "id" => $modelPrice->id,
                                "price" => $modelPrice->price,
                                "prioridad" => $modelPrice->priority,

                            )
                        );
                        $dataBoxContent = array(
                            "units" => $modelInventory->units,
                            "prices" => $prices
                        );
                    }


                }
                $result[$key]["dataBoxContent"] = $dataBoxContent;

            }
        } else {

            $result = $modelPI->getListProductSSales($params);

            foreach ($result as $key => $valueCurrent) {
                $value = (array)$valueCurrent;
                $result[$key] = $value;
                $has_iva = 0;
                $codigo = $value["codigo"];
                $nombre = $value["nombre"];
                $precio_venta = $value["precio_venta"];
                $porcentaje = $value["porcentaje"];

                $descripcion = $value["descripcion"];
                $priceCurrent = round(($precio_venta * $porcentaje / 100) + $precio_venta, 2);
                $descriptionSet = $descripcion == null ? "" : " / " . $descripcion;
                $detalle = $descripcion == null ? $nombre : $nombre . " " . $descripcion;
                $text = $codigo . " - " . $nombre . " $" . $priceCurrent . $descriptionSet;
                if ($value["porcentaje"] > 0) {
                    $result[$key]["text"] = $text . " (CON IVA" . ")";
                } else {
                    $result[$key]["text"] = $text . " (SIN IVA" . ")";
                }


                $result[$key]["has_iva"] = $has_iva;
                $result[$key]["cantidad_unidades_caja"] = "-1";
                $result[$key]["producto_tipo_medida_id"] = "-1";
                $result[$key]["tipo_caja"] = "-1";
                $result[$key]["valor"] = "-1";
                $result[$key]["ptm_type_box"] = 1;
              /*  $result[$key]["inventario"] = 1;//maxRow
                $result[$key]["kardex_promedio"] = 1000000;//minRowKardex
                $result[$key]["valor_kardex_promedio"] = 1000000;//minRowKardex*/


            }
        }


        return $result;

    }


}
