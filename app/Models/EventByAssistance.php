<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;


class EventByAssistance extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'event_by_assistance';

    protected $fillable = array(
        'created_at',
        'updated_at',
        'deleted_at',
        'customer_id',//*
        'business_id'//*

    );
    protected $attributesData = [
        ['column' => 'created_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'updated_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'deleted_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'customer_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'business_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = true;

    protected $field_main = 'created_at';

    public static function getRulesModel()
    {
        $rules = ["customer_id" => "required|numeric",
            "business_id" => "required|numeric"
        ];
        return $rules;
    }


    /*MANAGER MAINS*/

    public function getAdmin($params)
    {
        $modelC = new Customer();
        $result = $modelC->getAdminNotAssistanceEvent($params);
        return $result;
    }


    public function saveData($params)
    {


        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        $dataSend = [];
        $whatsappResult = [];
        $mailResult = [];
        $linkCurrentManager = URL('es/managerInvitationOtavalo');
        DB::beginTransaction();
        try {


            $createUpdate = true;
            $entity_type = 0;

            $business_id = $attributesPost['business_id'];
            $mailingByDataSendData = $attributesPost;
            $all_customers = $attributesPost['all_customers'] == "true";

            $customersData = [];
            if ($all_customers) {

                /*    $modelCustomer = new \App\Models\Customer();
                    $business_id = $attributesPost['business_id'];
                    $customersData = $modelCustomer->getAllAdminEmailsRegisters([
                        'filters' => [
                            'business_id' => $business_id
                        ]
                    ]);*/
            } else {
                $customersData = $attributesPost['customers'];

            }
            if (count($customersData) > 0) {

                $date = \App\Utils\Util::DateCurrent();
                $toCountry = '+593';
                foreach ($customersData as $key => $row) {
                    $customer_id = $row['id'];
                    $model = new EventByAssistance();
                    $attributesSet = [
                        'customer_id' => $customer_id,
                        'business_id' => $business_id,

                    ];
                    $resultSearch = $this->allowAssit($attributesSet);
                    if ($resultSearch) {

                        $paramsValidate = array(
                            'modelAttributes' => $attributesSet,
                            'rules' => self::getRulesModel(),

                        );
                        $validateResult = $this->validateModel($paramsValidate);
                        $success = $validateResult["success"];
                        if ($success) {
                            $model->fill($attributesSet);
                            $success = $model->save();
                        } else {
                            $success = false;
                            $msj = "Problemas al guardar  el registro.";
                            $errors = $validateResult["errors"];
                            new \Exception ($msj);
                        }
                    } else {
                        $success = false;
                        $msj = "Este usuario ya esta registrado.";
                        $errors = [];
                        new \Exception ($msj);
                    }
                }


            } else {
                $success = false;
                $msj = "No existe clientes para enviar correos.";
                $errors = [
                    ''
                ];
            }
            $dataSend = [
                'whatsapp' => $whatsappResult,
                'mail' => $mailResult,

            ];

            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "message" => $msj,

                "success" => $success,
                'data' => $dataSend
            ];

            if (!$success) {
                DB::rollBack();

            } else {
                DB::commit();
            }
            return ($result);
        } catch (\Exception $e) {
            DB::rollBack();
            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "message" => $msj,
                "errors" => $errors,
                'data' => $dataSend
            );
            return ($result);
        }

    }

    public function allowAssit($params)
    {
        $textValue = $this->table . '.' . $this->field_main;
        $business_id = $params['business_id'];
        $customer_id = $params['customer_id'];

        $field = $textValue;
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$textValue as text";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('customer', 'customer.id', '=', $this->table . '.customer_id');
        $query->where($this->table . '.customer_id', '=', $customer_id);
        $query->where($this->table . '.business_id', '=', $business_id);


        $result = $query->first();
        if ($result) {
            $result = false;
        } else {
            $result = true;

        }

        return $result;

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
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.created_at', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.updated_at', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.deleted_at', 'like', '%' . $likeSet . '%');
                $query->orWhere("customer.identification_document", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.business_id', 'like', '%' . $likeSet . '%');
            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

}
