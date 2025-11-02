<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RouteMapByAdventureTypes extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'route_map_by_adventure_types';

    protected $fillable = array('adventure_type', 'id', 'business_by_routes_map_id');

    public $timestamps = false;
    const apnea = 0;
    const bicycleTouring = 1;// cicloturismo
    const bungee = 2;
    const rafting = 3;
    const ride = 4;//cabalgata
    const mountaineering = 5;//montañismo
    const trekking = 6;//senderismo
    const mountainBiking = 7;//Ciclismo de montaña
    const climbing = 8; //escalada
    const canopy = 9;
    const camping = 10;//camping
    const overLanding = 11;
    const rappel = 12;//rápel
    const viaFerrata = 13;//vías ferratas
    const canyoning = 14;//barranquismo
    const paragliding = 15;//parapente
    const apneaText = "Apnea";
    const bicycleTouringText = "Cicloturismo";
    const bungeeText = "Bungee";
    const raftingText = "Rafting";
    const rideText = "Cabalgata";
    const mountaineeringText = "Montañismo";
    const trekkingText = "Senderismo";
    const mountainBikingText = "Ciclismo de montaña";
    const climbingText = "Escalada";
    const canopyText = "Canopy";
    const campingText = "Camping";
    const overLandingText = "Overlanding";
    const rappelText = "Rápel";//
    const viaFerrataText = "Vías ferratas";
    const canyoningText = "Barranquismo";
    const paraglidingText = "Parapente";

    public function getAdventureTypes($params)
    {


        $business_by_routes_map_id = $params["business_by_routes_map_id"];
        $query = DB::table($this->table);
        $comparate = "IF($this->table.adventure_type=" . self::apnea . ",'" . self::apneaText . "',IF($this->table.adventure_type=" . self::bicycleTouring . ",'" . self::bicycleTouringText . "',IF($this->table.adventure_type=" . self::bungee . ",'" . self::bungeeText . "',IF($this->table.adventure_type=" . self::rafting . ",'" . self::raftingText . "',IF($this->table.adventure_type=" . self::ride . ",'" . self::rideText . "',IF($this->table.adventure_type=" . self::mountaineering . ",'" . self::mountaineeringText . "',IF($this->table.adventure_type=" . self::trekking . ",'" . self::trekkingText . "',IF($this->table.adventure_type=" . self::mountainBiking . ",'" . self::mountainBikingText . "',IF($this->table.adventure_type=" . self::climbing . ",'" . self::climbingText . "',IF($this->table.adventure_type=" . self::canopy . ",'" . self::canopyText . "',IF($this->table.adventure_type=" . self::camping . ",'" . self::campingText . "',IF($this->table.adventure_type=" . self::overLanding . ",'" . self::overLandingText . "',IF($this->table.adventure_type=" . self::rappel . ",'" . self::rappelText . "',IF($this->table.adventure_type=" . self::viaFerrata . ",'" . self::viaFerrataText . "',IF($this->table.adventure_type=" . self::canyoning . ",'" . self::canyoningText . "',IF($this->table.adventure_type=" . self::paragliding . ",'" . self::paraglidingText . "',2)))))))))))))))) as adventure_adventure_type_text";
        $selectString = "$this->table.id ,$this->table.business_by_routes_map_id,$comparate,$this->table.adventure_type";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->where("business_by_routes_map_id", '=', $business_by_routes_map_id);

        $data = $query->get()->toArray();

        return $data;
    }

    public function searchNeedleAdventureType($params)
    {
        $result = array();
        $haystack = $params["haystack"];
        $keySearch = $params["keySearch"];
        $type = isset($params["type"]) ? $params["type"] : "create";

        $needle = $params["needle"];

        foreach ($haystack as $key => $value) {
            if ($type == "create") {

                $equalValue = $value->$keySearch;
                if ($equalValue == $needle) {
                    $result = $value;
                    return $result;
                }
            }else{
                $equalValue = $value;
                if ($equalValue == $needle) {
                    $result = array("search"=>$value);
                    return $result;
                }
            }
        }

        return $result;
    }
}
