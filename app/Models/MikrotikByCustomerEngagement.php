<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;
use App\Utils\Mikrotik\MikrotickManager;
use App\Utils\Mikrotik\RouterosAPICustom;

class MikrotikByCustomerEngagement extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'mikrotik_by_customer_engagement';

    protected $fillable = array(
        'customer_id',//*
        'address',//*
        'engagement_number',//*
        'invoice_sale_id',//*
        'type_ethernet',//*
        'mikrotik_rate_limit_id',//*
        'assigned_ip',//*
        'mac_computer',//*
        'computer_state',//*
        'antenna_assigned_ip',
        'antenna_mac_computer',
        'antenna_state',//*
        'mikrotik_dhcp_server_id',//*
        'business_id',//*
        'antenna_mikrotik_dhcp_server_id',//*

    );
    protected $attributesData = [
        ['column' => 'customer_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'address', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'engagement_number', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'invoice_sale_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'type_ethernet', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'mikrotik_rate_limit_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'assigned_ip', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'mac_computer', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'computer_state', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true'],
        ['column' => 'antenna_assigned_ip', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'antenna_mac_computer', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'antenna_state', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true'],
        ['column' => 'mikrotik_dhcp_server_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'business_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'antenna_mikrotik_dhcp_server_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'false'],

    ];
    public $timestamps = false;

    protected $field_main = 'address';

    public static function getRulesModel()
    {
        $rules = ["customer_id" => "required|numeric",
            "address" => "required",
            "engagement_number" => "required|numeric",
            "invoice_sale_id" => "required|numeric",
            "type_ethernet" => "required|numeric",
            "mikrotik_rate_limit_id" => "required|numeric",
            "assigned_ip" => "required|max:200",
            "mac_computer" => "required|max:200",
            "computer_state" => "required",
            "antenna_assigned_ip" => "max:200",
            "antenna_mac_computer" => "max:200",
            "antenna_state" => "required",
            "mikrotik_dhcp_server_id" => "required|numeric",
            "antenna_mikrotik_dhcp_server_id" => "numeric",

            "business_id" => "required|numeric"
        ];
        return $rules;
    }


    /*MANAGER MAINS*/

    public function getAdmin($params)
    {
        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "$this->table.id,CONCAT(people.name,' ',people.last_name) as customer,
customer.id as customer_id,
$this->table.address,$this->table.engagement_number,invoice_sale.invoice_code as invoice_sale,
invoice_sale.id as invoice_sale_id,
$this->table.type_ethernet,mikrotik_rate_limit.name as mikrotik_rate_limit,
mikrotik_rate_limit.id as mikrotik_rate_limit_id,
$this->table.assigned_ip,$this->table.mac_computer,$this->table.computer_state,$this->table.antenna_assigned_ip,$this->table.antenna_mac_computer,$this->table.antenna_state,mikrotik_dhcp_server.name as mikrotik_dhcp_server,
mikrotik_dhcp_server.id as mikrotik_dhcp_server_id,
$this->table.business_id
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('customer', 'customer.id', '=', $this->table . '.customer_id');
        $query->join('people', 'customer.people_id', '=', 'people.id');
        $query->join('invoice_sale', 'invoice_sale.id', '=', $this->table . '.invoice_sale_id');
        $query->join('mikrotik_rate_limit', 'mikrotik_rate_limit.id', '=', $this->table . '.mikrotik_rate_limit_id');
        $query->join('mikrotik_dhcp_server', 'mikrotik_dhcp_server.id', '=', $this->table . '.mikrotik_dhcp_server_id');


        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {

                $query->orWhere("customer.identification_document", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.address', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.engagement_number', 'like', '%' . $likeSet . '%');
                $query->orWhere("invoice_sale.invoice_code", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.type_ethernet', 'like', '%' . $likeSet . '%');
                $query->orWhere("mikrotik_rate_limit.name", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.assigned_ip', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.mac_computer', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.computer_state', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.antenna_assigned_ip', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.antenna_mac_computer', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.antenna_state', 'like', '%' . $likeSet . '%');
                $query->orWhere("mikrotik_dhcp_server.name", 'like', '%' . $likeSet . '%');

            });;

        }
        $business_id = ($params['filters']["business_id"]);
        $query->where($this->table . ".business_id", "=", $business_id);
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


    public function saveData($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        $data = [];
        DB::beginTransaction();
        try {
            $modelName = 'MikrotikByCustomerEngagement';
            $model = new MikrotikByCustomerEngagement();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = MikrotikByCustomerEngagement::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $mikrotikByCustomerEngagementData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $mikrotikByCustomerEngagementData, 'attributesData' => $this->attributesData));
            $paramsValidate = array(
                'modelAttributes' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            $type_ethernet = $attributesSet["type_ethernet"];

            $conecctionManager = null;
            $API = new RouterosAPICustom();

            $API->debug = false;
            if ($success) {
                $model->fill($attributesSet);
                $success = $model->save();
                if ($createUpdate) {
                    $currentMikotik = null;
                    $modelDHCS = new MikrotikDhcpServer();
                    $modelTC = new MikrotikTypeConection();
                    $modelRL = new MikrotikRateLimit();

                    $modelC = new Customer();
                    $customer_id = $attributesSet["customer_id"];
                    $customerInformation = $modelC->getCustomerInformation([
                        "filters" => [
                            "customer_id" => $customer_id
                        ]
                    ]);
                    $mikrotik_dhcp_server_id = $attributesSet["mikrotik_dhcp_server_id"];
                    $mikrotik_rate_limit_id = $attributesSet["mikrotik_rate_limit_id"];

                    $currentMikotikDHCPS = $modelDHCS::find($mikrotik_dhcp_server_id);
                    if ($currentMikotikDHCPS) {
                        $mikrotik_type_conection_id = $currentMikotikDHCPS->mikrotik_type_conection_id;
                        $currentMikotik = $modelTC::find($mikrotik_type_conection_id);
                        $modelRLData = $modelRL::find($mikrotik_rate_limit_id);
                        if ($currentMikotik) {
                            if ($API->connect($currentMikotik->ip_conection, $currentMikotik->user, $currentMikotik->password)) {
                                $assigned_ip = $attributesSet["assigned_ip"];
                                $mac_computer = $attributesSet["mac_computer"];
                                $engagement_number = $attributesSet["engagement_number"];
                                $computer_state = $attributesSet["computer_state"];
                                $commandOne = "/ip dhcp-server lease add";
                                $commandTwo = "address=";
                                $commandTwoValue = $assigned_ip;

                                $commandThree = "mac-address=";
                                $commandThreeValue = $mac_computer;

                                $commandFour = "comment=";
                                $commandFourValue = $customerInformation->name . " " . $customerInformation->last_name . "-" . $engagement_number;

                                $commandFive = "rate-limit=";
                                $commandFiveValue = $modelRLData->name;

                                $commandSix = "server=";
                                $commandSixValue = $currentMikotikDHCPS->name;

                                $commandSeven = "disabled=";
                                $commandSevenValue = $computer_state == "ACTIVE" ? "no" : "yes";
                                $commandManager = $commandOne . " " . $commandTwo . $commandTwoValue . " " . $commandThree . $commandThreeValue . " " . $commandFour . $commandFourValue . " " . $commandFive . $commandFiveValue . " " . $commandSix . $commandSixValue . " " . $commandSeven . $commandSevenValue;

                                $newComm = "/ip/dhcp-server/lease/add";
                                $paramsCurrentComm = [
                                    "address" => $commandTwoValue,
                                    "mac-address" => $commandThreeValue,
                                    "comment" => $commandFourValue,
                                    "rate-limit" => $commandFiveValue,
                                    "server" => $commandSixValue,
                                    "disabled" => $commandSevenValue,
                                   // "active-address" => $commandTwoValue,
                                  //  "active-mac-address" => $commandThreeValue,

                                ];


                                if (true) {

                                    $READ = $API->comm($newComm, $paramsCurrentComm);

                                } else {
                                    $API->write($newComm, false);
                                    $API->write('=address=' . $commandTwoValue, false);       // nombre
                                    $API->write('=mac-address=' . $commandThreeValue, false);
                                    $API->write('=comment=' . $commandFourValue, true);
                                    $API->write('=rate-limit=' . $commandFiveValue, true);
                                    $API->write('=server=' . $commandSixValue, true);
                                    $API->write('=disabled=' . $commandSevenValue, false);
                                    $API->write('=active-address=' . $commandTwoValue, false);
                                    $API->write('=active-mac-address=' . $commandThreeValue, false);
                                    $READ = $API->read(false);
                                }


                                $resultResponseMikrotik = ($READ);
                                $ARRAY = $resultResponseMikrotik;
                                $validation = is_array($ARRAY) && count($ARRAY) > 0 && isset($ARRAY["!trap"]);

                                if ($validation) {   // si hay mas de 1 queue.
                                    $msj .= 'Errores  Microtik Manager Config PC --01';
                                    $errors = [];
                                    $dataRows = $ARRAY["!trap"];
                                    foreach ($dataRows as $key => $row) {
                                        foreach ($row as $keyCol => $col) {
                                            $msj .= $keyCol . " : " . $col . "";
                                        }
                                    }
                                    $success = false;

                                } else { // si no hay ningun binding
                                    $success = true;

                                }
                                $data["mikrotikManager"] = [
                                    "resultResponseMikrotik" => $resultResponseMikrotik,
                                    "READ" => $READ,
                                    "commandManager" => $commandManager
                                ];
                                $API->disconnect();


                            } else {
                                $msj = 'No se ha podido conectarse al mikrotik de la PC';
                                $success = false;
                                $errors = [];
                            }
                        } else {
                            $msj = 'No se ha podido obtener Informacion de Mikrotik PC';
                            $success = false;
                            $errors = [];
                        }

                    } else {
                        $success = false;
                        $msg = "Problemas al obtener Informacion de Mikrotik DHCP PC.";
                        $errors = [];
                    }
                    if ($type_ethernet == 0) {
                        $mikrotik_dhcp_server_id = $attributesSet["antenna_mikrotik_dhcp_server_id"];
                        $currentMikotikDHCPS = $modelDHCS::find($mikrotik_dhcp_server_id);
                        if ($currentMikotikDHCPS) {
                            $mikrotik_type_conection_id = $currentMikotikDHCPS->mikrotik_type_conection_id;
                            $currentMikotik = $modelTC::find($mikrotik_type_conection_id);
                            if ($currentMikotik) {
                                if ($API->connect($currentMikotik->ip_conection, $currentMikotik->user, $currentMikotik->password)) {
                                    $assigned_ip = $attributesSet["antenna_assigned_ip"];
                                    $mac_computer = $attributesSet["antenna_mac_computer"];
                                    $engagement_number = $attributesSet["engagement_number"];
                                    $computer_state = $attributesSet["antenna_computer_state"];
                                    $commandOne = "/ip dhcp-server lease add";
                                    $commandTwo = "address=";
                                    $commandTwoValue = $assigned_ip;

                                    $commandThree = "mac-address=";
                                    $commandThreeValue = $mac_computer;

                                    $commandFour = "comment=";
                                    $commandFourValue = $customerInformation->name . " " . $customerInformation->last_name . "-" . $engagement_number;

                                    $commandFive = "rate-limit=";
                                    $commandFiveValue = $modelRLData->name;

                                    $commandSix = "server=";
                                    $commandSixValue = $currentMikotikDHCPS->name;

                                    $commandSeven = "disabled=";
                                    $commandSevenValue = $computer_state == "ACTIVE" ? "no" : "yes";
                                    $commandManager = $commandOne . " " . $commandTwo . $commandTwoValue . " " . $commandThree . $commandThreeValue . " " . $commandFour . $commandFourValue . " " . $commandFive . $commandFiveValue . " " . $commandSix . $commandSixValue . " " . $commandSeven . $commandSevenValue;


                                    $newComm = "/ip/dhcp-server/lease/add";
                                    $paramsCurrentComm = [
                                        "address" => $commandTwoValue,
                                        "mac-address" => $commandThreeValue,
                                        "comment" => $commandFourValue,
                                        "rate-limit" => $commandFiveValue,
                                        "server" => $commandSixValue,
                                        "disabled" => $commandSevenValue,
                                        // "active-address" => $commandTwoValue,
                                        //  "active-mac-address" => $commandThreeValue,

                                    ];

                                    if (true) {
                                        $READ = $API->comm($newComm, $paramsCurrentComm);
                                    } else {
                                        $API->write($newComm, false);
                                        $API->write('=address=' . $commandTwoValue, false);       // nombre
                                        $API->write('=mac-address=' . $commandThreeValue, false);
                                        $API->write('=comment=' . $commandFourValue, true);
                                        $API->write('=rate-limit=' . $commandFiveValue, true);
                                        $API->write('=server=' . $commandSixValue, true);
                                        $API->write('=disabled=' . $commandSevenValue, false);
                                        $API->write('=active-address=' . $commandTwoValue, false);
                                        $API->write('=active-mac-address=' . $commandThreeValue, false);
                                        $READ = $API->read(false);
                                    }
                                    $resultResponseMikrotik = ($READ);
                                    $ARRAY = $resultResponseMikrotik;
                                    $validation = is_array($ARRAY) && count($ARRAY) > 0 && isset($ARRAY["!trap"]);

                                    if ($validation) {   // si hay mas de 1 queue.
                                        $msj .= 'Errores  Microtik Manager Config PC --02';
                                        $errors = [];
                                        $dataRows = $ARRAY["!trap"];
                                        foreach ($dataRows as $key => $row) {
                                            foreach ($row as $keyCol => $col) {
                                                $msj .= $keyCol . " : " . $col . "";
                                            }
                                        }
                                        $success = false;

                                    } else { // si no hay ningun binding
                                        $success = true;

                                    }
                                    $data["mikrotikManagerAntenna"] = [
                                        "resultResponseMikrotik" => $resultResponseMikrotik,
                                        "READ" => $READ,
                                        "commandManager" => $commandManager
                                    ];
                                    $API->disconnect();


                                } else {
                                    $msj = 'No se ha podido conectarse al mikrotik de la Antenna';
                                    $success = false;
                                    $errors = [];
                                }
                            } else {
                                $msj = 'No se ha podido obtener Informacion de Mikrotik Antenna';
                                $success = false;
                                $errors = [];
                            }

                        } else {
                            $success = false;
                            $msj = "Problemas al obtener Informacion de Mikrotik DHCP Antenna.";
                            $errors = [];
                        }
                    }
                }


            } else {
                $success = false;
                $msj = "Problemas al guardar  MikrotikByCustomerEngagement.";
                $errors = $validateResult["errors"];
            }
            if (!$success) {
                DB::rollBack();

            } else {
                $msj="Guardado Correctamente";
                DB::commit();
            }
            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "message" => $msj,
                "data" => $data,
                "success" => $success
            ];


            return ($result);
        } catch (Exception $e) {
            DB::rollBack();
            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "message" => $msj,
                "data" => $data,

                "errors" => $errors
            );
            return ($result);
        }

    }

    public function getListSelect2($params)
    {
        $textValue = $this->table . '.' . $this->field_main;
        $field = $textValue;
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$textValue as text";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('customer', 'customer.id', '=', $this->table . '.customer_id');
        $query->join('invoice_sale', 'invoice_sale.id', '=', $this->table . '.invoice_sale_id');
        $query->join('mikrotik_rate_limit', 'mikrotik_rate_limit.id', '=', $this->table . '.mikrotik_rate_limit_id');
        $query->join('mikrotik_dhcp_server', 'mikrotik_dhcp_server.id', '=', $this->table . '.mikrotik_dhcp_server_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere("customer.identification_document", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.address', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.engagement_number', 'like', '%' . $likeSet . '%');
                $query->orWhere("invoice_sale.invoice_code", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.type_ethernet', 'like', '%' . $likeSet . '%');
                $query->orWhere("mikrotik_rate_limit.name", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.assigned_ip', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.mac_computer', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.computer_state', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.antenna_assigned_ip', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.antenna_mac_computer', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.antenna_state', 'like', '%' . $likeSet . '%');
                $query->orWhere("mikrotik_dhcp_server.name", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.business_id', 'like', '%' . $likeSet . '%');
            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function dataModel($params)
    {

        $id = $params["filters"]["id"];
        $query = DB::table($this->table);
        $selectString = "$this->table.id,customer.identification_document as customer,
customer.id as customer_id,
$this->table.address,$this->table.engagement_number,invoice_sale.invoice_code as invoice_sale,
invoice_sale.id as invoice_sale_id,
$this->table.type_ethernet,mikrotik_rate_limit.name as mikrotik_rate_limit,
mikrotik_rate_limit.id as mikrotik_rate_limit_id,
$this->table.assigned_ip,$this->table.mac_computer,$this->table.computer_state,$this->table.antenna_assigned_ip,$this->table.antenna_mac_computer,$this->table.antenna_state,mikrotik_dhcp_server.name as mikrotik_dhcp_server,
mikrotik_dhcp_server.id as mikrotik_dhcp_server_id,
$this->table.business_id
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('customer', 'customer.id', '=', $this->table . '.customer_id');
        $query->join('invoice_sale', 'invoice_sale.id', '=', $this->table . '.invoice_sale_id');
        $query->join('mikrotik_rate_limit', 'mikrotik_rate_limit.id', '=', $this->table . '.mikrotik_rate_limit_id');
        $query->join('mikrotik_dhcp_server', 'mikrotik_dhcp_server.id', '=', $this->table . '.mikrotik_dhcp_server_id');


        $query->where($this->table . ".id", "=", $id);
        $result = $query->first();

        return $result;

    }

    public function managerDisabledEnabledCustomer($params)
    {

        $active = $params["active"];
        $filtersManager = [
            "filters" => [
                'id' => $params["id"]
            ]
        ];

        $data = [];
        $data = [];
        $type_ethernet = null;
        $success = false;
        $message = "No se realizo la gestion.";
        $resultData = $this->dataModel($filtersManager);
        if ($resultData) {
            $type_ethernet = $resultData->type_ethernet;
            $data["type_ethernet"] = $type_ethernet;
            $data["pc"] = $resultData;

            $API = new RouterosAPICustom();
            $modelDHCS = new MikrotikDhcpServer();
            $modelTC = new MikrotikTypeConection();
            $modelRL = new MikrotikRateLimit();

            $message = "";
            $msj = "";
            $mikrotik_dhcp_server_id = $resultData->mikrotik_dhcp_server_id;
            $mikrotik_rate_limit_id = $resultData->mikrotik_rate_limit_id;

            $currentMikotikDHCPS = $modelDHCS::find($mikrotik_dhcp_server_id);
            if ($currentMikotikDHCPS) {
                $mikrotik_type_conection_id = $currentMikotikDHCPS->mikrotik_type_conection_id;
                $currentMikotik = $modelTC::find($mikrotik_type_conection_id);
                $modelRLData = $modelRL::find($mikrotik_rate_limit_id);
                if ($currentMikotik) {
                    if ($API->connect($currentMikotik->ip_conection, $currentMikotik->user, $currentMikotik->password)) {
                        $assigned_ip = $resultData->assigned_ip;
                        $mac_computer = $resultData->mac_computer;
                        $engagement_number = $resultData->engagement_number;
                        $computer_state = $resultData->computer_state;
                        $commandOne = "/ip dhcp-server lease add";
                        $commandTwo = "address=";
                        $commandTwoValue = $assigned_ip;

                        $commandThree = "mac-address=";
                        $commandThreeValue = $mac_computer;
                        $newComm = "/ip/firewall/address-list/getall";
                        $address = $commandTwoValue;
                        $list = 'BlockLeaseIPs';
                        if ($active == "true") {
                            $API->write("/ip/firewall/address-list/getall", false);
                            $API->write('?address=' . $address, true);
                            //   2M/2M   [TX/RX]
                            $READ = $API->read(false);
                            if (count($READ)) {
                                $ARRAY = $API->parse_response($READ);
                                $API->write("/ip/firewall/address-list/remove", false);

                                $API->write('=.id=' . $ARRAY[0]['.id']);
                                $READ = $API->read(false);
                                $ARRAY = $API->parse_response($READ);
                                if (count($ARRAY) == 0) {
                                    $message = 'Ip Desbloqueada Bloqueada Pc';
                                    $success = true;
                                    $errors = [];
                                } else {
                                    $message = 'Ip No desbloqead PC';
                                    $success = false;
                                    $errors = [];
                                }
                            } else {
                                $message = 'Ip No Encontrada PC';
                                $success = false;
                                $errors = [];
                            }

                        } else {


                            $API->write("/ip/firewall/address-list/add", false);
                            $API->write('=address=' . $address, false);       // nombre
                            $API->write('=list=' . $list, true);       // nombre
                            $READ = $API->read(false);
                            $ARRAY = $API->parse_response($READ);
                            if (is_string($ARRAY)) {
                                $message = 'Ip Bloqueada Pc';
                                $success = true;
                                $errors = [];
                            } else {
                                if (isset($ARRAY["!trap"])) {
                                    $message .= 'Errores  Microtik Manager Config PC ';
                                    $errors = [];
                                    $dataRows = $ARRAY["!trap"];
                                    foreach ($dataRows as $key => $row) {
                                        foreach ($row as $keyCol => $col) {
                                            $message .= $keyCol . " : " . $col . "";
                                        }
                                    }
                                    $success = false;
                                }

                            }
                        }
                        $API->disconnect();

                    } else {
                        $msj = 'No se ha podido conectarse al mikrotik de la PC';
                        $success = false;
                        $errors = [];
                    }
                } else {
                    $msj = 'No se ha podido obtener Informacion de Mikrotik PC';
                    $success = false;
                    $errors = [];
                }

            } else {
                $success = false;
                $msg = "Problemas al obtener Informacion de Mikrotik DHCP PC.";
                $errors = [];
            }

            if ($type_ethernet == 0) {

                $data["antenna"] = [];

            }
        } else {

        }
        $result = [
            "success" => $success,
            "data" => $data,
            "message" => $message
        ];
        return $result;

    }
}
