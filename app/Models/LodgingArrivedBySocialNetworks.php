<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;


class LodgingArrivedBySocialNetworks extends Model
{
    const typeSocialNetworksFacebook = 0;
    const typeSocialNetworksFacebookText = "Facebook";

    const typeSocialNetworksInstagram = 1;
    const typeSocialNetworksInstagramText = "Instagram";

    const typeSocialNetworksTwitter = 2;
    const typeSocialNetworksTwitterText = "Twitter";

    const typeSocialNetworksYoutube = 3;
    const typeSocialNetworksYoutubeText = "Youtube";

    const typeSocialNetworksSpotify = 4;
    const typeSocialNetworksSpotifyText = "Spotify";
    
    const typeSocialNetworksOthers = 5;
    const typeSocialNetworksOthersText = "Otras";
    protected $table = 'lodging_arrived_by_social_networks';

    protected $fillable = array(
        "type_social_networks",//*
        "lodging_by_arrived_id",//*
    );
    public $attributesData = array(
        "type_social_networks",//*
        "lodging_by_arrived_id",//*
    );
    public $timestamps = false;
    public static function getRulesModel()
    {
        $rules = [
            "type_social_networks" => 'required',
            "lodging_by_arrived_id" => 'required'
        ];
        return $rules;
    }
    public static function validateModel($modelAttributes)
    {
        $rules = LodgingArrivedBySocialNetworks::getRulesModel();
        $validation = Validator::make($modelAttributes, $rules);
        $success = $validation->passes();
        $errors = [];
        if (!$success) {
            $errors = $validation->errors()->all();
        }
        $result = array("success" => $success, "errors" => $errors);
        return $result;
    }

    public function getSocialNetworksOfLodgingArrived($params)
    {


        $lodging_by_arrived_id = $params["lodging_by_arrived_id"];
        $query = DB::table($this->table);
        $compare = "IF($this->table.type_social_networks=" . self::typeSocialNetworksFacebook . ",'" . self::typeSocialNetworksFacebookText . "',IF($this->table.type_social_networks=" . self::typeSocialNetworksInstagram . ",'" . self::typeSocialNetworksInstagramText . "',IF($this->table.type_social_networks=" . self::typeSocialNetworksTwitter . ",'" . self::typeSocialNetworksTwitterText . "',IF($this->table.type_social_networks=" . self::typeSocialNetworksYoutube . ",'" . self::typeSocialNetworksYoutubeText . "',IF($this->table.type_social_networks=" . self::typeSocialNetworksSpotify . ",'" . self::typeSocialNetworksSpotifyText . "',IF($this->table.type_social_networks=" . self::typeSocialNetworksOthers . ",'" . self::typeSocialNetworksOthersText . "',2)))))) as type_social_networks_text";
        $selectString = "$this->table.id lodging_by_payment_credit_card_id ,$this->table.lodging_by_arrived_id,$compare,$this->table.type_social_networks";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->where("lodging_by_arrived_id", '=', $lodging_by_arrived_id);
        $data = $query->get()->first();
        return $data;
    }

}
