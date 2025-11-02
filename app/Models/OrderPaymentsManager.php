<?php

namespace App\Models;

use App\Utils\Util;
use App\Models\OrderShoppingByCustomerDelivery;
use App\Models\OrderShoppingByDelivery;

use App\Models\People;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Models\OrderShoppingCart;

use App\Models\OrderPaymentsDocument;
use App\Components\EmailUtil;


class OrderPaymentsManager extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    const TYPE_PAYMENT_CUSTOMER_PAYPAL = 0;
    const TYPE_PAYMENT_CUSTOMER_API_CREDIT_CARDS = 1;
    const TYPE_PAYMENT_CUSTOMER_BANK_DEPOSIT = 2;
    const TYPE_PAYMENT_CUSTOMER_CASH = 3;

    const MANAGER_SATE_CREATE = 0;//PENDIENTE
    const MANAGER_SATE_EXECUTED = 1;//INICIADO
    const MANAGER_SATE_DELIVERED = 2;//ENTREGADO
    const MANAGER_SATE_REJECTED = 3;//RECHAZADO

    const SATE_CREATE = 'CREATED';//
    const SATE_EXECUTED = 'TO DELIVER';//INICIADO
    const SATE_DELIVERED = 'DELIVERY';//ENTREGADO
    const SATE_REJECTED = 'CANCELED';//RECHAZADO
    protected $table = 'order_payments_manager';

    protected $fillable = array(
        'business_id',//*
        'manager_state',//*
        'start',//*
        'manager_id',
        'payer_id',
        'token',
        'type_payment_customer',//*
        'type_user'
    );
    protected $attributesData = [
        ['column' => 'business_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'manager_state', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'start', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'manager_id', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'payer_id', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'token', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'type_payment_customer', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'type_user', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'start';

    public function orderShoppingCart()
    {
        return $this->hasOne(OrderShoppingCart::class);
    }

    public static function getRulesModel()
    {
        $rules = ["business_id" => "required|numeric",
            "manager_state" => "required|numeric",
            "start" => "required",
            "token" => "max:350",
            "type_payment_customer" => "required|numeric",
            "type_user" => "required|numeric",

        ];
        return $rules;
    }

    public function getDataAdmin($params)
    {
        $sort = 'asc';
        $field = 'start';
        $query = DB::table($this->table);

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $business_id = $params['filters']['business_id'];
        $type_payment_customer = $params['filters']['type_payment_customer'];
        $manager_state = $params['filters']['manager_state'];

        $selectString = "$this->table.id,$this->table.business_id,$this->table.manager_state,$this->table.start,$this->table.manager_id,$this->table.payer_id,$this->table.token,$this->table.type_payment_customer
        ,order_shopping_cart.same_billing_address,order_shopping_cart.state,order_shopping_cart.subtotal,order_shopping_cart.subtotal,order_shopping_cart.description,order_shopping_cart.shipping,order_shopping_cart.shipping,order_shopping_cart.id order_shopping_cart_id
        ,order_shopping_by_customer_delivery.payer_email  ,order_shopping_by_customer_delivery.document,order_shopping_by_customer_delivery.company,order_shopping_by_customer_delivery.address_main,order_shopping_by_customer_delivery.city,order_shopping_by_customer_delivery.city,order_shopping_by_customer_delivery.state_province_id,order_shopping_by_customer_delivery.zipcode,order_shopping_by_customer_delivery.country_id,order_shopping_by_customer_delivery.address_secondary,order_shopping_by_customer_delivery.phone
       ,people.last_name,people.name,people.birthdate,people.age ,people.id people_id
       ,countries.name country
       ,provinces.name state_province
        ,order_payments_document.source,order_payments_document.account_bank,order_payments_document.number_bank";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('order_shopping_cart', $this->table . '.id', '=', 'order_shopping_cart.order_payments_manager_id');
        $query->leftJoin('order_payments_document', 'order_payments_manager.id', '=', 'order_payments_document.order_payments_manager_id');
        $query->join('order_shopping_by_customer_delivery', 'order_shopping_cart.order_shopping_by_customer_delivery_id', '=', 'order_shopping_by_customer_delivery.id');
        $query->join('people', 'order_shopping_by_customer_delivery.people_id', '=', 'people.id');
        $query->join('countries', 'order_shopping_by_customer_delivery.country_id', '=', 'countries.id');
        $query->join('provinces', 'provinces.id', '=', 'order_shopping_by_customer_delivery.state_province_id');

        $query->where($this->table . '.business_id', '=', $business_id);

        if ($type_payment_customer > -1) {
            $query->where($this->table . '.type_payment_customer', '=', $type_payment_customer);
        }
        if ($manager_state > -1) {
            $query->where($this->table . '.manager_state', '=', $manager_state);


        }
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where($this->table . '.manager_id', 'like', '%' . $likeSet . '%');
            $query->orWhere('order_shopping_by_customer_delivery.payer_email', 'like', '%' . $likeSet . '%');
            $query->orWhere('people.last_name', 'like', '%' . $likeSet . '%');
            $query->orWhere('people.name', 'like', '%' . $likeSet . '%');
            $query->orWhere('people.name', 'like', '%' . $likeSet . '%');

        }

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

    /*MANAGER MAINS*/

    public function getAdmin($params)
    {
        $result = $this->getDataAdmin($params);
        $modelDelivery = new OrderShoppingByDelivery();
        foreach ($result['rows'] as $key => $row) {

            $order_shopping_cart_id = $row->order_shopping_cart_id;
            $same_billing_address = $row->same_billing_address;
            $result['rows'][$key] = (array)$row;

            $orderShoppingCart = OrderShoppingCart::find($order_shopping_cart_id);
            $orderShoppingCartDetails = $orderShoppingCart->orderShoppingCartByDetails;
            $result['rows'][$key]['details'] = $orderShoppingCartDetails;

            if ($same_billing_address == 0) {
                $modelDeliveryData = $modelDelivery->getDelivery(
                    [
                        'filters' => [
                            'order_shopping_cart_id' => $order_shopping_cart_id
                        ]]
                );
                $result['rows'][$key]['billing'] = $modelDeliveryData;
            }


        }

        return $result;
    }

    public function getAdminEvent($params)
    {
        $result = $this->getDataAdmin($params);
        $modelDelivery = new OrderShoppingByDelivery();
        $modelEventRegistration = new \App\Models\EventsTrailsRegistrationByCustomer;

        foreach ($result['rows'] as $key => $row) {

            $order_shopping_cart_id = $row->order_shopping_cart_id;
            $same_billing_address = $row->same_billing_address;
            $result['rows'][$key] = (array)$row;


            $orderShoppingCart = OrderShoppingCart::find($order_shopping_cart_id);
            $orderShoppingCartDetails = $orderShoppingCart->orderShoppingCartByDetails;
            $manager_id = null;
            $details = [];
            foreach ($orderShoppingCartDetails as $keyDetails => $rowDetails) {

                $manager_id = $rowDetails->id;
                $dataCurrent = $modelEventRegistration->getManagementFormRegister(['filters' => [
                    'manager_id' => $manager_id
                ]]);
                $setPush = (array)$rowDetails->attributes;
                $setPush['data'] = $dataCurrent;
                $details[] = $setPush;
            }


            $result['rows'][$key]['details'] = $details;


            if ($same_billing_address == 0) {
                $modelDeliveryData = $modelDelivery->getDelivery(
                    [
                        'filters' => [
                            'order_shopping_cart_id' => $order_shopping_cart_id
                        ]]
                );
                $result['rows'][$key]['billing'] = $modelDeliveryData;
            }


        }

        return $result;
    }

    public function getDataAdminCustomer($params)
    {
        $sort = 'asc';
        $field = 'start';
        $query = DB::table($this->table);

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $user = Auth::user();
        $user_id = $user->id;
        $type_payment_customer = $params['filters']['type_payment_customer'];
        $manager_state = $params['filters']['manager_state'];

        $selectString = "$this->table.id,$this->table.business_id,$this->table.manager_state,$this->table.start,$this->table.manager_id,$this->table.payer_id,$this->table.token,$this->table.type_payment_customer
        ,order_shopping_cart.same_billing_address,order_shopping_cart.state,order_shopping_cart.subtotal,order_shopping_cart.subtotal,order_shopping_cart.description,order_shopping_cart.shipping,order_shopping_cart.shipping,order_shopping_cart.id order_shopping_cart_id
        ,order_shopping_by_customer_delivery.payer_email  ,order_shopping_by_customer_delivery.document,order_shopping_by_customer_delivery.company,order_shopping_by_customer_delivery.address_main,order_shopping_by_customer_delivery.city,order_shopping_by_customer_delivery.city,order_shopping_by_customer_delivery.state_province_id,order_shopping_by_customer_delivery.zipcode,order_shopping_by_customer_delivery.country_id,order_shopping_by_customer_delivery.address_secondary,order_shopping_by_customer_delivery.phone
       ,people.last_name,people.name,people.birthdate,people.age ,people.id people_id
       ,countries.name country
       ,provinces.name state_province
        ,order_payments_document.source,order_payments_document.account_bank,order_payments_document.number_bank
        ,order_shopping_cart.user_id";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('order_shopping_cart', $this->table . '.id', '=', 'order_shopping_cart.order_payments_manager_id');
        $query->leftJoin('order_payments_document', 'order_payments_manager.id', '=', 'order_payments_document.order_payments_manager_id');
        $query->join('order_shopping_by_customer_delivery', 'order_shopping_cart.order_shopping_by_customer_delivery_id', '=', 'order_shopping_by_customer_delivery.id');
        $query->join('people', 'order_shopping_by_customer_delivery.people_id', '=', 'people.id');
        $query->join('countries', 'order_shopping_by_customer_delivery.country_id', '=', 'countries.id');
        $query->join('provinces', 'provinces.id', '=', 'order_shopping_by_customer_delivery.state_province_id');


        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $tableCurrent = $this->table;
            $query->where(function ($query) use ($likeSet, $tableCurrent
            ) {
                $query->where($tableCurrent . '.manager_id', 'like', '%' . $likeSet . '%');
                $query->orWhere('order_shopping_by_customer_delivery.payer_email', 'like', '%' . $likeSet . '%');
                $query->orWhere('people.last_name', 'like', '%' . $likeSet . '%');
                $query->orWhere('people.name', 'like', '%' . $likeSet . '%');
            });


        }
        if ($type_payment_customer > -1) {
            $query->where($this->table . '.type_payment_customer', '=', $type_payment_customer);
        }
        if ($manager_state > -1) {
            $query->where($this->table . '.manager_state', '=', $manager_state);


        }
        $query->where('order_shopping_cart.user_id', '=', $user_id);
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

    public function getAdminCustomer($params)
    {
        $result = $this->getDataAdminCustomer($params);
        $modelDelivery = new OrderShoppingByDelivery();
        foreach ($result['rows'] as $key => $row) {

            $order_shopping_cart_id = $row->order_shopping_cart_id;
            $same_billing_address = $row->same_billing_address;
            $result['rows'][$key] = (array)$row;

            $orderShoppingCart = OrderShoppingCart::find($order_shopping_cart_id);
            $orderShoppingCartDetails = $orderShoppingCart->orderShoppingCartByDetails;
            $result['rows'][$key]['details'] = $orderShoppingCartDetails;

            if ($same_billing_address == 0) {
                $modelDeliveryData = $modelDelivery->getDelivery(
                    [
                        'filters' => [
                            'order_shopping_cart_id' => $order_shopping_cart_id
                        ]]
                );
                $result['rows'][$key]['billing'] = $modelDeliveryData;
            }


        }

        return $result;
    }

    public function getAdminCustomerEvents($params)
    {

        $result = $this->getDataAdminCustomer($params);
        $modelDelivery = new OrderShoppingByDelivery();


        $modelEventRegistration = new \App\Models\EventsTrailsRegistrationByCustomer;
        foreach ($result['rows'] as $key => $row) {

            $order_shopping_cart_id = $row->order_shopping_cart_id;
            $same_billing_address = $row->same_billing_address;
            $result['rows'][$key] = (array)$row;

            $orderShoppingCart = OrderShoppingCart::find($order_shopping_cart_id);
            $orderShoppingCartDetails = $orderShoppingCart->orderShoppingCartByDetails;
            $manager_id = null;
            $details = [];
            foreach ($orderShoppingCartDetails as $keyDetails => $rowDetails) {

                $manager_id = $rowDetails->id;
                $dataCurrent = $modelEventRegistration->getManagementFormRegister(['filters' => [
                    'manager_id' => $manager_id
                ]]);
                $setPush = (array)$rowDetails->attributes;
                $setPush['data'] = $dataCurrent;
                $details[] = $setPush;
            }


            $result['rows'][$key]['details'] = $details;


            if ($same_billing_address == 0) {
                $modelDeliveryData = $modelDelivery->getDelivery(
                    [
                        'filters' => [
                            'order_shopping_cart_id' => $order_shopping_cart_id
                        ]]
                );
                $result['rows'][$key]['billing'] = $modelDeliveryData;
            }


        }

        return $result;
    }

    public function saveData($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        DB::beginTransaction();
        try {
            $modelName = 'OrderPaymentsManager';
            $model = new OrderPaymentsManager();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = OrderPaymentsManager::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $orderPaymentsManagerData = $attributesPost[$modelName];
            $orderPaymentsManagerData['start'] = Util::DateCurrent();
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $orderPaymentsManagerData, 'attributesData' => $this->attributesData));
            $paramsValidate = array(
                'inputs' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            if ($success) {
                $model->fill($attributesSet);
                $success = $model->save();
            } else {
                $success = false;
                $msj = "Problemas al guardar  OrderPaymentsManager.";
                $errors = $validateResult["errors"];
            }
            if (!$success) {
                DB::rollBack();

            } else {
                DB::commit();
            }
            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "success" => $success
            ];


            return ($result);
        } catch (Exception $e) {

            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
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
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.business_id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.manager_state', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.start', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.manager_id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.payer_id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.token', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.type_payment_customer', 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function saveDataOrderShipping($params)
    {
        $success = false;
        $msj = "Se guardo correctamente.";
        $result = array();
        $attributesPost = $params;
        $errors = array();
        DB::beginTransaction();
        $data = [];
        try {
            $modelName = 'OrderPaymentsManager';
            $model = new OrderPaymentsManager();
            $orderPaymentsManagerData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $orderPaymentsManagerData, 'attributesData' => $this->attributesData));
            $paramsValidate = array(
                'inputs' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            if ($success) {
                $model->fill($attributesSet);
                $success = $model->save();
                $order_payments_manager_id = $model->id;
                $type_user = $model->type_user;

                $modelOSC = new OrderShoppingCart();
                $attributesPost['OrderShoppingCart']['order_payments_manager_id'] = $order_payments_manager_id;
                $attributesPost['OrderShoppingCart']['type_user'] = $type_user;
                $resultManagerSave = $modelOSC->saveDataOrderShipping($attributesPost);
                $success = $resultManagerSave["success"];
                if (!$success) {
                    $errors = $resultManagerSave["errors"];
                    $msj = $resultManagerSave["msj"];


                } else {
                    $data['OrderPaymentsManager'] = $model;
                    $data['ManagerCheckout'] = $resultManagerSave['data'];
                    if ($model->type_payment_customer == 2) {

                        $modelOPD = new OrderPaymentsDocument();
                        $attributesPost['OrderPaymentsDocument']['order_payments_manager_id'] = $order_payments_manager_id;
                        $resultManagerSave = $modelOPD->saveDataShipping($attributesPost['OrderPaymentsDocument']);
                        $success = $resultManagerSave["success"];
                        if (!$success) {
                            $errors = $resultManagerSave["errors"];
                            $msj = $resultManagerSave["msj"];
                        }

                    }
                }

            } else {
                $success = false;
                $msj = "Problemas al guardar gestion de Pagos.";
                $errors = $validateResult["errors"];
            }
            if (!$success) {
                DB::rollBack();

            } else {
                DB::commit();
            }
            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "success" => $success,
                'data' => $data
            ];


            return ($result);
        } catch (Exception $e) {

            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "errors" => $errors,
                'data' => $data
            );
            return ($result);
        }

    }

    public function saveDataManagerOrderShipping($params)
    {

        $result = [];

        $Payments = $params['Payments'];
        $OrderShopping = $params['OrderShopping'];
        $OrderBillingDetails = $params['OrderBillingDetails'];
        $OrderBillingCustomer = $params['OrderBillingCustomer'];

        $type = $Payments['type'];
        $BUSINESS_MANAGER_ID = $params['BUSINESS_MANAGER_ID'];
        $OrderPaymentsManager = [];
        $OrderShoppingCart = [];
        $OrderShoppingByCustomerDelivery = [];
        $OrderShoppingCartByDetailsData = [];
        $user = Auth::user();
        $user_id = $params['user_id'];
        $type_user = ($user_id == 'null' || $user_id == null || $user_id == '') ? 0 : 1;
        $manager_id = '';
        $payer_id = '';
        $token = '';
        $type_payment_customer = $type;
        $manager_state = '';
        $state = self::SATE_CREATE;
        switch ($type) {
            case self::TYPE_PAYMENT_CUSTOMER_PAYPAL:
                $manager_state = self::MANAGER_SATE_EXECUTED;
                $manager_id = $Payments['PaymentPost']->id;
                $payer_id = $Payments['PaymentPost']->payerID;
                $token = 'paypal-token';
                $state = self::SATE_EXECUTED;

                break;
            case self::TYPE_PAYMENT_CUSTOMER_API_CREDIT_CARDS:
                $manager_state = self::MANAGER_SATE_EXECUTED;
                $transaction = $Payments['PaymentPost']->transaction;
                $manager_id = $transaction->id;
                $payer_id = $transaction->status_detail;
                $state = self::SATE_EXECUTED;
                break;
            case self::TYPE_PAYMENT_CUSTOMER_BANK_DEPOSIT:
                $manager_state = self::MANAGER_SATE_CREATE;
                $manager_id = $OrderBillingCustomer->payer_email . '-' . $OrderBillingCustomer->last_name;
                $payer_id = $OrderBillingCustomer->payer_email;
                $state = self::SATE_CREATE;

                break;
        }

        $OrderPaymentsManager['business_id'] = $BUSINESS_MANAGER_ID;
        $OrderPaymentsManager['manager_state'] = $manager_state;
        $OrderPaymentsManager['manager_id'] = $manager_id;
        $OrderPaymentsManager['payer_id'] = $payer_id;

        $OrderPaymentsManager['start'] = Util::DateCurrent();
        $OrderPaymentsManager['type_payment_customer'] = $type_payment_customer;
        $OrderPaymentsManager['type_user'] = $type_user;


        $tax = 0;
        $total = $OrderShopping->subtotal;
        $OrderShoppingCart['subtotal'] = $OrderShopping->subtotal;
        $OrderShoppingCart['description'] = 'Entrega Pendiente de los productos a : ' . $OrderBillingCustomer->first_name . ' ' . $OrderBillingCustomer->last_name;;
        $OrderShoppingCart['shipping'] = $OrderShopping->shipping;
        $OrderShoppingCart['user_id'] = $user_id;
        $OrderShoppingCart['same_billing_address'] = ($OrderBillingCustomer->same_billing_address == false) ? 0 : 1;
        $OrderShoppingCart['state'] = $state;

        $OrderBillingDetails = $params['OrderBillingDetails'];
        $type_registration = \App\Models\EventsTrailsRegistrationByCustomer::TYPE_REGISTRATION_WEB;
        foreach ($OrderBillingDetails as $key => $row) {
            $product_id = $row->id;
            $quantity = $row->count;
            $measure_id = isset($row->measure_id) ? $row->measure_id : -1;
            $measure = isset($row->measure) ? $row->measure : '';

            $price = isset($row->price)?$row->price:(isset($row->sale_price)?$row->sale_price:0);

            $price_discount = isset($row->price_discount) ? $row->price_discount : 0;
            $price_before = isset($row->price_before) ? $row->price_before : 0;
            $allow_discount = isset($row->allow_discount) ? $row->allow_discount : 0;
            $promotion_id = isset($row->promotion_id) ? $row->promotion_id : 0;

            $product_color = isset($row->product_color) ? $row->product_color : 0;
            $product_color_id = isset($row->product_color_id) ? $row->product_color_id : 0;
            $product_sizes_id = isset($row->product_sizes_id) ? $row->product_sizes_id : 0;
            $product_sizes = isset($row->product_sizes) ? $row->product_sizes : 0;
            $type_variant = isset($row->type_variant) ? $row->type_variant : 0;


            $name = $row->name;
            $OrderShoppingCartByDetailsData[] = [
                'product_id' => $product_id,
                'quantity' => $quantity,
                'measure_id' => $measure_id,
                'measure' => $measure,
                'price' => $price,
                'price_discount' => $price_discount,
                'price_before' => $price_before,
                'allow_discount' => $allow_discount,
                'promotion_id' => $promotion_id,
                'name' => $name,
                'product_color' => $product_color,
                'product_color_id' => $product_color_id,
                'product_sizes_id' => $product_sizes_id,
                'product_sizes' => $product_sizes,
                'type_variant' => $type_variant,


            ];


        }

        $OrderShoppingByCustomerDelivery['last_name'] = $OrderBillingCustomer->last_name;
        $OrderShoppingByCustomerDelivery['name'] = $OrderBillingCustomer->first_name;
        $OrderShoppingByCustomerDelivery['age'] = 0;
        $OrderShoppingByCustomerDelivery['gender'] = 3;
        $OrderShoppingByCustomerDelivery['birthdate'] = '1987-07-24';
        $OrderShoppingByCustomerDelivery['payer_email'] = $OrderBillingCustomer->payer_email;
        $OrderShoppingByCustomerDelivery['company'] = $OrderBillingCustomer->company;
        $OrderShoppingByCustomerDelivery['phone'] = $OrderBillingCustomer->phone;
        $OrderShoppingByCustomerDelivery['address_main'] = $OrderBillingCustomer->address_main;
        $OrderShoppingByCustomerDelivery['city'] = $OrderBillingCustomer->city;
        $OrderShoppingByCustomerDelivery['state_province_id'] = $OrderBillingCustomer->state_province_id;//PROVINCIA O PAIS EN ESTE CASO PAIS
        $OrderShoppingByCustomerDelivery['zipcode'] = $OrderBillingCustomer->zipcode;
        $OrderShoppingByCustomerDelivery['country_id'] = $OrderBillingCustomer->country_id;
        $OrderShoppingByCustomerDelivery['user_id'] = $user_id;
        $OrderShoppingByCustomerDelivery['address_secondary'] = $OrderBillingCustomer->address_secondary;
        $OrderShoppingByCustomerDelivery['document'] = $OrderBillingCustomer->document;

        $OrderShoppingByDelivery = [];

        if ($OrderBillingCustomer->same_billing_address == false) {
            $OrderShoppingByDelivery['last_name'] = $OrderBillingCustomer->billing_last_name;
            $OrderShoppingByDelivery['name'] = $OrderBillingCustomer->billing_first_name;
            $OrderShoppingByDelivery['age'] = 0;
            $OrderShoppingByDelivery['gender'] = 3;
            $OrderShoppingByDelivery['birthdate'] ='1987-07-24';
            $OrderShoppingByDelivery['payer_email'] = $OrderBillingCustomer->billing_payer_email;
            $OrderShoppingByDelivery['company'] = $OrderBillingCustomer->billing_company;
            $OrderShoppingByDelivery['phone'] = $OrderBillingCustomer->billing_phone;
            $OrderShoppingByDelivery['address_main'] = $OrderBillingCustomer->billing_address_main;
            $OrderShoppingByDelivery['city'] = $OrderBillingCustomer->billing_city;
            $OrderShoppingByDelivery['state_province_id'] = $OrderBillingCustomer->billing_state_province_id;//PROVINCIA O PAIS EN ESTE CASO PAIS
            $OrderShoppingByDelivery['zipcode'] = $OrderBillingCustomer->billing_zipcode;
            $OrderShoppingByDelivery['country_id'] = $OrderBillingCustomer->billing_country_id;
            $OrderShoppingByDelivery['user_id'] = $user_id;
            $OrderShoppingByDelivery['address_secondary'] = $OrderBillingCustomer->billing_address_secondary;
            $OrderShoppingByDelivery['document'] = $OrderBillingCustomer->billing_document;


        }

        $managerData = [
            'OrderPaymentsManager' => $OrderPaymentsManager,
            'OrderShoppingByCustomerDelivery' => $OrderShoppingByCustomerDelivery,
            'OrderShoppingCart' => $OrderShoppingCart,
            'OrderShoppingCartByDetailsData' => $OrderShoppingCartByDetailsData,

        ];
        if ($OrderBillingCustomer->same_billing_address == false) {
            $managerData['OrderShoppingByDelivery'] = $OrderShoppingByDelivery;
        }


        if (self::TYPE_PAYMENT_CUSTOMER_BANK_DEPOSIT == $type) {
            $managerData['OrderPaymentsDocument'] = $params['OrderPaymentsDocument'];
        }

        $result = $this->saveDataOrderShipping($managerData);

        return $result;

    }

    public function deliverOrder($params)
    {
        $success = false;
        $msj = "Se guardo correctamente.";
        $result = array();
        $attributesPost = $params;
        $errors = array();

        DB::beginTransaction();
        try {
            $modelName = 'OrderPaymentsManager';
            $id = $attributesPost[$modelName]['id'];
            $model = OrderPaymentsManager::find($id);
            $type_payment_customer = $model->type_payment_customer;
            $manager_state = $model->manager_state;

            $allowChangeState = true;
            $msj = '';
            if ($type_payment_customer != self::TYPE_PAYMENT_CUSTOMER_BANK_DEPOSIT) {
                if ($manager_state == self::MANAGER_SATE_DELIVERED) {
                    $allowChangeState = false;
                    $msj = 'Se ha realizado anteriormente la entrega.';
                } else if ($manager_state == self::MANAGER_SATE_REJECTED) {
                    $allowChangeState = false;
                    $msj = 'Estado rechazado anteriormente.';
                }
            } else {
                if ($manager_state == self::MANAGER_SATE_CREATE) {
                    $allowChangeState = false;
                    $msj = 'No se ha verificado el documento de deposito.';
                } else if ($manager_state == self::MANAGER_SATE_DELIVERED) {
                    $allowChangeState = false;
                    $msj = 'Se ha realizado anteriormente la entrega.';
                } else if ($manager_state == self::MANAGER_SATE_REJECTED) {
                    $allowChangeState = false;
                    $msj = 'Estado rechazado anteriormente.';
                }

            }
            if ($allowChangeState) {

                $orderShoppingCart = $model->orderShoppingCart;
                $orderShoppingCart->state = 'DELIVERED';
                $success = $orderShoppingCart->save();
                if ($success) {
                    $model->manager_state = self::MANAGER_SATE_DELIVERED;
                    $orderShoppingCartDetails = $orderShoppingCart->orderShoppingCartByDetails;
                    $success = $model->save();

                    if ($success) {
                        $msjCustomer = 'Orden Enviada al Cliente.';


                        $modelOPM = $model;
                        $orderShoppingCart = $modelOPM->orderShoppingCart;

                        $order_shopping_by_customer_delivery_id = $orderShoppingCart->order_shopping_by_customer_delivery_id;
                        $modelOSBCD = OrderShoppingByCustomerDelivery::find($order_shopping_by_customer_delivery_id);
                        $modelP = People::find($modelOSBCD->people_id);

                        $OrderBillingCustomer = null;
                        $contactSubject = 'Información de Orden de Envio';
                        $customerName = $modelP->last_name . ' ' . $modelP->name;
                        $customerEmail = $modelOSBCD->payer_email;
                        $contactMessage = '<p>' . $msjCustomer . '</p>';
                        $contactOrderTitle = '<h1> Orden #' . $modelOPM->manager_id . ' o codigo de registro #' . $modelOPM->id . '</h1>';
                        $dataMessage = [
                            'contactSubject' => $contactSubject,
                            'customerName' => $customerName,
                            'customerEmail' => $customerEmail,
                            'contactMessage' => $contactMessage,
                            'contactOrderTitle' => $contactOrderTitle,
                        ];
                        $emailUtil = new  EmailUtil();
                        $typeTemplate = 'delivered';
                        $data['email-customer'] = $emailUtil->sendMailCustomerShop(
                            [
                                'mailSend' => $customerEmail,
                                'typeTemplate' => $typeTemplate,
                                'dataMessage' => $dataMessage
                            ]
                        );

                    } else {
                        $errors = [];
                        $msj = 'No se pudo guardar Order Payments Manager';
                    }
                } else {
                    $errors = [];
                    $msj = 'No se pudo guardar Order Shopping Cart';
                }

            }

            if (!$success) {
                DB::rollBack();

            } else {
                DB::commit();
            }
            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "success" => $success
            ];


            return ($result);
        } catch (Exception $e) {

            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "errors" => $errors
            );
            return ($result);
        }

    }

    public function changeStateBankOrder($params)
    {
        $success = false;
        $msj = "Se guardo correctamente.";
        $result = array();
        $attributesPost = $params;
        $errors = array();

        DB::beginTransaction();
        try {
            $modelName = 'OrderPaymentsManager';
            $id = $attributesPost[$modelName]['id'];
            $model = OrderPaymentsManager::find($id);
            $type_payment_customer = $model->type_payment_customer;
            $manager_state = $model->manager_state;
            $manager_state_change = $attributesPost[$modelName]['manager_state'];
            $allowChangeState = true;
            $user = Auth::user();

            $msj = '';
            if ($type_payment_customer == self::TYPE_PAYMENT_CUSTOMER_BANK_DEPOSIT) {
                if ($manager_state == self::MANAGER_SATE_CREATE) {
                    $allowChangeState = true;
                    $msj = '';

                } else if ($manager_state == self::MANAGER_SATE_DELIVERED) {
                    $allowChangeState = false;
                    $msj = 'Se ha realizado anteriormente la verificacion.';
                } else if ($manager_state == self::MANAGER_SATE_REJECTED) {
                    $allowChangeState = false;
                    $msj = 'Estado rechazado anteriormente.';
                }
            } else {
                $allowChangeState = false;
                $msj = 'El tipo de pago debe de ser mediante deposito de banco.';
            }
            if ($allowChangeState) {
                $model->manager_state = $manager_state_change;
                $success = $model->save();
                $msjCustomer = '';
                if ($manager_state_change == self::MANAGER_SATE_EXECUTED) {

                    $msjCustomer = 'Orden Verificada y en lista por enviar sus productos.';

                } else if ($manager_state_change == self::MANAGER_SATE_REJECTED) {

                    $msjCustomer = 'Orden Verificada pero el deposito no es valido ';

                }


                $modelOPM = $model;
                $orderShoppingCart = $modelOPM->orderShoppingCart;

                $order_shopping_by_customer_delivery_id = $orderShoppingCart->order_shopping_by_customer_delivery_id;
                $modelOSBCD = OrderShoppingByCustomerDelivery::find($order_shopping_by_customer_delivery_id);
                $modelP = People::find($modelOSBCD->people_id);

                $OrderBillingCustomer = null;
                $contactSubject = 'Información de Orden';
                $customerName = $modelP->last_name . ' ' . $modelP->name;
                $customerEmail = $modelOSBCD->payer_email;
                $contactMessage = '<p>' . $msjCustomer . '</p>';
                $contactOrderTitle = '<h1> Orden #' . $modelOPM->manager_id . ' o codigo de registro #' . $modelOPM->id . '</h1>';
                $dataMessage = [
                    'contactSubject' => $contactSubject,
                    'customerName' => $customerName,
                    'customerEmail' => $customerEmail,
                    'contactMessage' => $contactMessage,
                    'contactOrderTitle' => $contactOrderTitle,
                ];
                $emailUtil = new  EmailUtil();
                $typeTemplate = 'checkoutVerified';
                $data['email-customer'] = $emailUtil->sendMailCustomerShop(
                    [
                        'mailSend' => $customerEmail,
                        'typeTemplate' => $typeTemplate,
                        'dataMessage' => $dataMessage
                    ]
                );

                if ($success) {

                } else {
                    $errors = [];
                    $msj = 'No se pudo guardar Order Shopping Cart';
                }

            }

            if (!$success) {
                DB::rollBack();

            } else {
                DB::commit();
            }
            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "success" => $success
            ];


            return ($result);
        } catch (Exception $e) {

            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "errors" => $errors
            );
            return ($result);
        }


    }


    public function saveDataManagerOrderShippingEvents($params)
    {

        $result = [];

        $Payments = $params['Payments'];
        $OrderShopping = $params['OrderShopping'];
        $OrderBillingDetails = $params['OrderBillingDetails'];
        $OrderBillingCustomer = $params['OrderBillingCustomer'];

        $type = $Payments['type'];
        $BUSINESS_MANAGER_ID = $params['BUSINESS_MANAGER_ID'];
        $OrderPaymentsManager = [];
        $OrderShoppingCart = [];
        $OrderShoppingByCustomerDelivery = [];
        $OrderShoppingCartByDetailsData = [];
        $user = Auth::user();
        $user_id = $params['user_id'];
        $type_user = ($user_id == 'null' || $user_id == null || $user_id == '') ? 0 : 1;
        $manager_id = '';
        $payer_id = '';
        $token = '';
        $type_payment_customer = $type;
        $manager_state = '';
        $state = self::SATE_CREATE;
        switch ($type) {
            case self::TYPE_PAYMENT_CUSTOMER_PAYPAL:
                $manager_state = self::MANAGER_SATE_EXECUTED;
                $manager_id = $Payments['PaymentPost']->id;
                $payer_id = $Payments['PaymentPost']->payerID;
                $token = 'paypal-token';
                $state = self::SATE_EXECUTED;

                break;
            case self::TYPE_PAYMENT_CUSTOMER_API_CREDIT_CARDS:
                $manager_state = self::MANAGER_SATE_EXECUTED;
                $transaction = $Payments['PaymentPost']->transaction;
                $manager_id = $transaction->id;
                $payer_id = $transaction->status_detail;
                $state = self::SATE_EXECUTED;
                break;
            case self::TYPE_PAYMENT_CUSTOMER_BANK_DEPOSIT:
                $manager_state = self::MANAGER_SATE_CREATE;
                $manager_id = $OrderBillingCustomer->payer_email . '-' . $OrderBillingCustomer->last_name;
                $payer_id = $OrderBillingCustomer->payer_email;
                $state = self::SATE_CREATE;

                break;
            case self::TYPE_PAYMENT_CUSTOMER_CASH:
                $manager_state = self::MANAGER_SATE_CREATE;
                $manager_id = $OrderBillingCustomer->payer_email . '-' . $OrderBillingCustomer->last_name;
                $payer_id = $OrderBillingCustomer->payer_email;
                $state = self::SATE_CREATE;
                break;
        }

        $OrderPaymentsManager['business_id'] = $BUSINESS_MANAGER_ID;
        $OrderPaymentsManager['manager_state'] = $manager_state;
        $OrderPaymentsManager['manager_id'] = $manager_id;
        $OrderPaymentsManager['payer_id'] = $payer_id;

        $OrderPaymentsManager['start'] = Util::DateCurrent();
        $OrderPaymentsManager['type_payment_customer'] = $type_payment_customer;
        $OrderPaymentsManager['type_user'] = $type_user;


        $tax = 0;
        $total = $OrderShopping->subtotal;
        $OrderShoppingCart['subtotal'] = $OrderShopping->subtotal;
        $OrderShoppingCart['description'] = 'Entrega Pendiente de los productos a : ' . $OrderBillingCustomer->first_name . ' ' . $OrderBillingCustomer->last_name;;
        $OrderShoppingCart['shipping'] = $OrderShopping->shipping;
        $OrderShoppingCart['user_id'] = $user_id;
        $OrderShoppingCart['same_billing_address'] = ($OrderBillingCustomer->same_billing_address == false) ? 0 : 1;
        $OrderShoppingCart['state'] = $state;

        $OrderBillingDetails = $params['OrderBillingDetails'];
        $type_registration =isset($params['type_registration'])?$params['type_registration']: \App\Models\EventsTrailsRegistrationByCustomer::TYPE_REGISTRATION_WEB;

        foreach ($OrderBillingDetails as $key => $row) {
            $product_id = $row->id;
            $quantity = $row->count;
            $measure_id = isset($row->measure_id) ? $row->measure_id : -1;
            $measure = isset($row->measure) ? $row->measure : '';
            $price = $row->price;
            $price_discount = isset($row->price_discount) ? $row->price_discount : 0;
            $price_before = isset($row->price_before) ? $row->price_before : 0;
            $allow_discount = isset($row->allow_discount) ? $row->allow_discount : 0;
            $promotion_id = isset($row->promotion_id) ? $row->promotion_id : 0;

            $product_color = isset($row->product_color) ? $row->product_color : 0;
            $product_color_id = isset($row->product_color_id) ? $row->product_color_id : 0;
            $product_sizes_id = isset($row->product_sizes_id) ? $row->product_sizes_id : 0;
            $product_sizes = isset($row->product_sizes) ? $row->product_sizes : 0;
            $type_variant = isset($row->type_variant) ? $row->type_variant : 0;
            $people = $row->people;
            $events_trails_project_id = $row->id;
            $events_trails_distances_id = $row->distance_id;
            $eventsTrailsRegistrationByCustomer = [];

            foreach ($people as $keyPeople => $rowPeople) {

                $events_trails_type_of_categories_id = $rowPeople->category_id;
                $user_id = $rowPeople->user_id->id;
                $kits = $rowPeople->kits;
                $orderEventKitsByCustomer = [];
                foreach ($kits as $keyKit => $rowKit) {

                    $product_id = $rowKit->value;
                    $size_id = $rowKit->sizes->model;
                    $color_id = $rowKit->colors->model;
                    $delivery = 0;
                    $orderEventKitsByCustomer[] = [
                        'events_trails_registration_by_customer_id' => null,
                        'product_id' => $product_id,
                        'size_id' => $size_id,
                        'color_id' => $color_id,
                        'delivery' => $delivery,
                    ];
                }

                $setPush = [
                    'events_trails_project_id' => $events_trails_project_id,
                    'events_trails_type_of_categories_id' => $events_trails_type_of_categories_id,
                    'events_trails_distances_id' => $events_trails_distances_id,
                    'type_registration' => $type_registration,
                    'user_id' => $user_id,
                    'manager_id' => null,

                    'orderEventKitsByCustomer' => $orderEventKitsByCustomer
                ];

                $eventsTrailsRegistrationByCustomer[] = $setPush;
            }


            $name = $row->name;
            $OrderShoppingCartByDetailsData[] = [
                'product_id' => $product_id,
                'quantity' => $quantity,
                'measure_id' => $measure_id,
                'measure' => $measure,
                'price' => $price,
                'price_discount' => $price_discount,
                'price_before' => $price_before,
                'allow_discount' => $allow_discount,
                'promotion_id' => $promotion_id,
                'name' => $name,
                'product_color' => $product_color,
                'product_color_id' => $product_color_id,
                'product_sizes_id' => $product_sizes_id,
                'product_sizes' => $product_sizes,
                'type_variant' => $type_variant,
                'eventsTrailsRegistrationByCustomer' => $eventsTrailsRegistrationByCustomer,

            ];


        }

        $OrderShoppingByCustomerDelivery['last_name'] = $OrderBillingCustomer->last_name;
        $OrderShoppingByCustomerDelivery['name'] = $OrderBillingCustomer->first_name;
        $OrderShoppingByCustomerDelivery['age'] = 0;
        $OrderShoppingByCustomerDelivery['gender'] = 3;
        $OrderShoppingByCustomerDelivery['birthdate'] = '';
        $OrderShoppingByCustomerDelivery['payer_email'] = $OrderBillingCustomer->payer_email;
        $OrderShoppingByCustomerDelivery['company'] = $OrderBillingCustomer->company;
        $OrderShoppingByCustomerDelivery['phone'] = $OrderBillingCustomer->phone;
        $OrderShoppingByCustomerDelivery['address_main'] = $OrderBillingCustomer->address_main;
        $OrderShoppingByCustomerDelivery['city'] = $OrderBillingCustomer->city;
        $OrderShoppingByCustomerDelivery['state_province_id'] = $OrderBillingCustomer->state_province_id;//PROVINCIA O PAIS EN ESTE CASO PAIS
        $OrderShoppingByCustomerDelivery['zipcode'] = $OrderBillingCustomer->zipcode;
        $OrderShoppingByCustomerDelivery['country_id'] = $OrderBillingCustomer->country_id;
        $OrderShoppingByCustomerDelivery['user_id'] = $user_id;
        $OrderShoppingByCustomerDelivery['address_secondary'] = $OrderBillingCustomer->address_secondary;
        $OrderShoppingByCustomerDelivery['document'] = $OrderBillingCustomer->document;

        $OrderShoppingByDelivery = [];

        if ($OrderBillingCustomer->same_billing_address == false) {
            $OrderShoppingByDelivery['last_name'] = $OrderBillingCustomer->billing_last_name;
            $OrderShoppingByDelivery['name'] = $OrderBillingCustomer->billing_first_name;
            $OrderShoppingByDelivery['age'] = 0;
            $OrderShoppingByDelivery['gender'] = 3;
            $OrderShoppingByDelivery['birthdate'] = '';
            $OrderShoppingByDelivery['payer_email'] = $OrderBillingCustomer->billing_payer_email;
            $OrderShoppingByDelivery['company'] = $OrderBillingCustomer->billing_company;
            $OrderShoppingByDelivery['phone'] = $OrderBillingCustomer->billing_phone;
            $OrderShoppingByDelivery['address_main'] = $OrderBillingCustomer->billing_address_main;
            $OrderShoppingByDelivery['city'] = $OrderBillingCustomer->billing_city;
            $OrderShoppingByDelivery['state_province_id'] = $OrderBillingCustomer->billing_state_province_id;//PROVINCIA O PAIS EN ESTE CASO PAIS
            $OrderShoppingByDelivery['zipcode'] = $OrderBillingCustomer->billing_zipcode;
            $OrderShoppingByDelivery['country_id'] = $OrderBillingCustomer->billing_country_id;
            $OrderShoppingByDelivery['user_id'] = $user_id;
            $OrderShoppingByDelivery['address_secondary'] = $OrderBillingCustomer->billing_address_secondary;
            $OrderShoppingByDelivery['document'] = $OrderBillingCustomer->billing_document;


        }

        $managerData = [
            'OrderPaymentsManager' => $OrderPaymentsManager,
            'OrderShoppingByCustomerDelivery' => $OrderShoppingByCustomerDelivery,
            'OrderShoppingCart' => $OrderShoppingCart,
            'OrderShoppingCartByDetailsData' => $OrderShoppingCartByDetailsData,

        ];
        if ($OrderBillingCustomer->same_billing_address == false) {
            $managerData['OrderShoppingByDelivery'] = $OrderShoppingByDelivery;
        }


        if (self::TYPE_PAYMENT_CUSTOMER_BANK_DEPOSIT == $type) {
            $managerData['OrderPaymentsDocument'] = $params['OrderPaymentsDocument'];
        }
        $result = $this->saveDataOrderShippingEvents($managerData);

        return $result;

    }

    public function saveDataOrderShippingEvents($params)
    {
        $success = false;
        $msj = "Se guardo correctamente.";
        $result = array();
        $attributesPost = $params;
        $errors = array();
        DB::beginTransaction();
        $data = [];
        try {
            $modelName = 'OrderPaymentsManager';
            $model = new OrderPaymentsManager();
            $orderPaymentsManagerData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $orderPaymentsManagerData, 'attributesData' => $this->attributesData));
            $paramsValidate = array(
                'inputs' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            if ($success) {
                $model->fill($attributesSet);
                $success = $model->save();
                $order_payments_manager_id = $model->id;
                $type_user = $model->type_user;

                $modelOSC = new OrderShoppingCart();
                $attributesPost['OrderShoppingCart']['order_payments_manager_id'] = $order_payments_manager_id;
                $attributesPost['OrderShoppingCart']['type_user'] = $type_user;
                $resultManagerSave = $modelOSC->saveDataOrderShippingEvents($attributesPost);
                $success = $resultManagerSave["success"];
                if (!$success) {
                    $errors = $resultManagerSave["errors"];
                    $msj = $resultManagerSave["msj"];


                } else {
                    $data['OrderPaymentsManager'] = $model;
                    $data['ManagerCheckout'] = $resultManagerSave['data'];
                    if ($model->type_payment_customer == 2) {
                        $modelOPD = new OrderPaymentsDocument();
                        $attributesPost['OrderPaymentsDocument']['order_payments_manager_id'] = $order_payments_manager_id;
                        $resultManagerSave = $modelOPD->saveDataShippingEvents($attributesPost['OrderPaymentsDocument']);
                        $success = $resultManagerSave["success"];
                        if (!$success) {
                            $errors = $resultManagerSave["errors"];
                            $msj = $resultManagerSave["msj"];
                        }

                    }
                }

            } else {
                $success = false;
                $msj = "Problemas al guardar gestion de Pagos.";
                $errors = $validateResult["errors"];
            }
            if (!$success) {
                DB::rollBack();

            } else {
                DB::commit();
            }
            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "success" => $success,
                'data' => $data
            ];


            return ($result);
        } catch (Exception $e) {

            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "errors" => $errors,
                'data' => $data
            );
            return ($result);
        }

    }
}
