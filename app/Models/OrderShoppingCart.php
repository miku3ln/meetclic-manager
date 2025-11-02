<?php

namespace App\Models;


use Illuminate\Support\Facades\DB;
use Auth;
use App\Models\OrderShoppingCartByDetails;
use App\Models\People;
use App\Models\OrderShoppingByCustomerDelivery;
use App\Models\OrderShoppingByDelivery;


class OrderShoppingCart extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    const STATE_CANCELED = 'CANCELED';
    const STATE_TO_DELIVER = 'TO DELIVER';
    const STATE_DELIVERED = 'DELIVERED';

    protected $table = 'order_shopping_cart';

    protected $fillable = array(
        'order_payments_manager_id',//*
        'state',//*
        'subtotal',//*
        'description',//*
        'shipping',//*
        'created_at',
        'updated_at',
        'deleted_at',
        'user_id',
        'order_shopping_by_customer_delivery_id',//*
        'same_billing_address'
    );
    protected $attributesData = [
        ['column' => 'order_payments_manager_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'state', 'type' => 'string', 'defaultValue' => 'TO DELIVER', 'required' => 'true'],
        ['column' => 'subtotal', 'type' => 'double', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'shipping', 'type' => 'double', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'created_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'updated_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'deleted_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'user_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'order_shopping_by_customer_delivery_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'same_billing_address', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = true;

    protected $field_main = 'state';

    public function orderShoppingCartByDetails()
    {
        return $this->hasMany(OrderShoppingCartByDetails::class);
    }


    public static function getRulesModel()
    {
        $rules = ["order_payments_manager_id" => "required|numeric",
            "state" => "required",
            "subtotal" => "required|numeric",
            "description" => "required",
            "shipping" => "required|numeric",
            "user_id" => "numeric",
            "order_shopping_by_customer_delivery_id" => "required|numeric",
            "same_billing_address" => "required|numeric"

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

        $selectString = "$this->table.id,order_payments_manager.start as order_payments_manager,
order_payments_manager.id as order_payments_manager_id,
$this->table.state,$this->table.same_billing_address,$this->table.subtotal,$this->table.description,$this->table.shipping,$this->table.created_at,$this->table.updated_at,$this->table.deleted_at,$this->table.user_id,order_shopping_by_customer_delivery.payer_email as order_shopping_by_customer_delivery,
order_shopping_by_customer_delivery.id as order_shopping_by_customer_delivery_id
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('order_payments_manager', 'order_payments_manager.id', '=', $this->table . '.order_payments_manager_id');
        $query->join('order_shopping_by_customer_delivery', 'order_shopping_by_customer_delivery.id', '=', $this->table . '.order_shopping_by_customer_delivery_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere("order_payments_manager.start", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.state', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.subtotal', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.shipping', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.created_at', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.updated_at', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.deleted_at', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.user_id', 'like', '%' . $likeSet . '%');
            $query->orWhere("order_shopping_by_customer_delivery.payer_email", 'like', '%' . $likeSet . '%');;

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


    public function saveDataOrderShipping($params)
    {
        $success = false;
        $msj = "Se guardo correctamente.";

        $result = array();
        $attributesPost = $params;
        $errors = array();
        $data = [];
        try {
            $modelPeople = new People();
            $peopleData = [
                'People' => [
                    'last_name' => $params['OrderShoppingByCustomerDelivery']['last_name'],
                    'name' => $params['OrderShoppingByCustomerDelivery']['name'],
                    'birthdate' => $params['OrderShoppingByCustomerDelivery']['birthdate'],
                    'age' => $params['OrderShoppingByCustomerDelivery']['age'],
                    'gender' => $params['OrderShoppingByCustomerDelivery']['gender'],
                ]
            ];
            $resultManagerSave = $modelPeople->saveDataOrderShipping($peopleData);
            $success = $resultManagerSave['success'];
            if ($success) {

                $people_id = $resultManagerSave['model']->id;
                $modelOSBCD = new OrderShoppingByCustomerDelivery();
                $params['OrderShoppingByCustomerDelivery']['people_id'] = $people_id;
                $resultManagerSave = $modelOSBCD->saveDataOrderShipping($params);
                $success = $resultManagerSave['success'];
                if ($success) {
                    $order_shopping_by_customer_delivery_id = $resultManagerSave['model']->id;
                    $modelName = 'OrderShoppingCart';
                    $model = new OrderShoppingCart();
                    $orderShoppingCartData = $attributesPost[$modelName];
                    $orderShoppingCartData['order_shopping_by_customer_delivery_id'] = $order_shopping_by_customer_delivery_id;
                    $orderShoppingCartData['state'] = self::STATE_TO_DELIVER;
                    $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $orderShoppingCartData, 'attributesData' => $this->attributesData));
                    $paramsValidate = array(
                        'inputs' => $attributesSet,
                        'rules' => self::getRulesModel(),

                    );
                    $validateResult = $this->validateModel($paramsValidate);
                    $success = $validateResult["success"];
                    if ($success) {
                        $model->state = self::STATE_TO_DELIVER;
                        $model->fill($attributesSet);
                        $success = $model->save();
                        $order_shopping_cart_id = $model->id;
                        $data['OrderShoppingCart'] = $model;
                        $same_billing_address = $model->same_billing_address;
                        $detailsData = $params['OrderShoppingCartByDetailsData'];

                        $modelOSCD = new OrderShoppingCartByDetails();
                        foreach ($detailsData as $key => $row) {
                            $rowCurrent = $row;
                            $rowCurrent['order_shopping_cart_id'] = $order_shopping_cart_id;
                            $setManager = [];
                            $setManager['OrderShoppingCartByDetails'] = $rowCurrent;
                            $resultManagerSave = $modelOSCD->saveDataOrderShipping($setManager);
                            $success = $resultManagerSave['success'];
                            if (!$success) {
                                $msj = $resultManagerSave['msj'];
                                $errors = $resultManagerSave['errors'];
                            }

                        }

                        //DELIVERY NOT INFORMATION INVOICE HEADER
                        if ($same_billing_address == 0) {
                            $keyBillingOtherDelivery = 'billing_';
                            $modelPeople = new People();
                            $peopleData = [
                                'People' => [
                                    'last_name' => $params['OrderShoppingByDelivery']['last_name'],
                                    'name' => $params['OrderShoppingByDelivery']['name'],
                                    'birthdate' => $params['OrderShoppingByDelivery']['birthdate'],
                                    'age' => $params['OrderShoppingByDelivery']['age'],
                                    'gender' => $params['OrderShoppingByDelivery']['gender'],
                                ]
                            ];
                            $resultManagerSave = $modelPeople->saveDataOrderShipping($peopleData);
                            $success = $resultManagerSave['success'];
                            if ($success) {
                                $people_id = $resultManagerSave['model']->id;
                                $modelOSBCD = new OrderShoppingByDelivery();
                                $payer_email = $params['OrderShoppingByDelivery']['payer_email'];
                                $company = $params['OrderShoppingByDelivery']['company'];
                                $address_secondary = $params['OrderShoppingByDelivery']['address_secondary'];
                                $city = $params['OrderShoppingByDelivery']['city'];
                                $state_province_id = $params['OrderShoppingByDelivery']['state_province_id'];
                                $zipcode = $params['OrderShoppingByDelivery']['zipcode'];
                                $country_id = $params['OrderShoppingByDelivery']['country_id'];
                                $user_id = $params['OrderShoppingByDelivery']['user_id'];
                                $phone = $params['OrderShoppingByDelivery']['phone'];
                                $address_main = $params['OrderShoppingByDelivery']['address_main'];
                                $document = $params['OrderShoppingByDelivery']['document'];

                                $setData = [
                                    'people_id' => $people_id,
                                    'payer_email' => $payer_email,
                                    'company' => $company,
                                    'address_secondary' => $address_secondary,
                                    'city' => $city,
                                    'state_province_id' => $state_province_id,
                                    'zipcode' => $zipcode,
                                    'country_id' => $country_id,
                                    'user_id' => $user_id,
                                    'phone' => $phone,
                                    'address_main' => $address_main,
                                    'order_shopping_cart_id' => $order_shopping_cart_id,
                                    'document' => $document

                                ];
                                $resultManagerSave = $modelOSBCD->saveDataOrderShipping(
                                    [
                                        'OrderShoppingByDelivery' => $setData

                                    ]
                                );
                                $success = $resultManagerSave['success'];
                                if (!$success) {
                                    $msj = $resultManagerSave['msj'];
                                    $errors = $resultManagerSave['errors'];
                                }
                            } else {

                                $msj = $resultManagerSave['msj'];
                                $errors = $resultManagerSave['errors'];
                            }
                        }


                    } else {
                        $success = false;
                        $msj = "Problemas al guardar  OrderShoppingCart.";
                        $errors = $validateResult["errors"];
                    }

                } else {
                    $msj = $resultManagerSave['msj'];
                    $errors = $resultManagerSave['errors'];
                }

            } else {
                $msj = $resultManagerSave['msj'];
                $errors = $resultManagerSave['errors'];
            }
            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "success" => $success,
                "data" => $data

            ];
            return ($result);
        } catch (Exception $e) {

            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "errors" => $errors,
                "data" => $data

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
        $query->join('order_payments_manager', 'order_payments_manager.id', '=', $this->table . '.order_payments_manager_id');
        $query->join('order_shopping_by_customer_delivery', 'order_shopping_by_customer_delivery.id', '=', $this->table . '.order_shopping_by_customer_delivery_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere("order_payments_manager.start", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.state', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.subtotal', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.shipping', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.created_at', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.updated_at', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.deleted_at', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.user_id', 'like', '%' . $likeSet . '%');
            $query->orWhere("order_shopping_by_customer_delivery.payer_email", 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getOrderShoppingCart($params)
    {
        $selectString = "$this->table.id,$this->table.state,$this->table.same_billing_address,$this->table.subtotal,$this->table.description,$this->table.shipping,$this->table.created_at,$this->table.updated_at,$this->table.deleted_at,$this->table.user_id,order_shopping_by_customer_delivery.payer_email as order_shopping_by_customer_delivery,$this->table.same_billing_address
       ,order_payments_manager.start as order_payments_manager,order_payments_manager.id as order_payments_manager_id,order_payments_manager.business_id,order_payments_manager.manager_state,order_payments_manager.start,manager_id,order_payments_manager.payer_id,order_payments_manager.token,order_payments_manager.type_payment_customer,order_payments_manager.end,order_payments_manager.type_user
,order_shopping_by_customer_delivery.id as order_shopping_by_customer_delivery_id,order_shopping_by_customer_delivery.people_id,order_shopping_by_customer_delivery.payer_email,order_shopping_by_customer_delivery.company,order_shopping_by_customer_delivery.address_secondary,order_shopping_by_customer_delivery.city,order_shopping_by_customer_delivery.state_province_id,order_shopping_by_customer_delivery.zipcode,order_shopping_by_customer_delivery.country_id,order_shopping_by_customer_delivery.phone,order_shopping_by_customer_delivery.address_main,order_shopping_by_customer_delivery.document
 ,people.name ,people.last_name,people.age,people.gender
        ,provinces.name state_province
        ,countries.name country
        ,order_payments_document.source,order_payments_document.account_bank,order_payments_document.number_bank";
        $id = $params['filters']['id'];
        $language = isset($params['filters']['language']) ? ($params['filters']['language'] == 'es' ? null : $params['filters']['language']) : null;
        $select = DB::raw($selectString);
        $query = DB::table($this->table);
        $query->select($select);
        $query->join('order_payments_manager', 'order_payments_manager.id', '=', $this->table . '.order_payments_manager_id');
        $query->leftJoin('order_payments_document', 'order_payments_manager.id', '=', 'order_payments_document.order_payments_manager_id');
        $query->join('order_shopping_by_customer_delivery', 'order_shopping_by_customer_delivery.id', '=', $this->table . '.order_shopping_by_customer_delivery_id');
        $query->join('provinces', 'provinces.id', '=', 'order_shopping_by_customer_delivery.state_province_id');
        $query->join('countries', 'countries.id', '=', 'order_shopping_by_customer_delivery.country_id');
        $query->join('people', 'people.id', '=', 'order_shopping_by_customer_delivery.people_id');

        $query->where($this->table . '.id', '=', $id);

        $data = $query->first();

        return $data;
    }

    public function getCheckoutDetailsFrontend($params)
    {
        $id = $params['filters']['id'];
        $language = $params['filters']['language'];

        $model = $this->getOrderShoppingCart($params);

        $success = false;
        $details = [];
        $delivery = [];
        $invoiceHeader = [];
        $same_billing_address = 1;
        if ($model) {


            $invoiceHeader = [];
            $modelChildren = new OrderShoppingCartByDetails();
            $details = $modelChildren->getDataDetails(
                [
                    'filters' => ['order_shopping_cart_id' => $id]
                ]
            );
            $invoiceHeader = (object)[
                'people_id' => $model->people_id,
                'name' => $model->name,
                'last_name' => $model->last_name,
                'payer_email' => $model->payer_email,
                'company' => $model->company,
                'address_secondary' => $model->address_secondary,
                'city' => $model->city,
                'state_province_id' => $model->state_province_id,
                'state_province' => $model->state_province,
                'zipcode' => $model->zipcode,
                'country_id' => $model->country_id,
                'country' => $model->country,
                'user_id' => $model->user_id,
                'phone' => $model->phone,
                'address_main' => $model->address_main,
                'document' => $model->document
            ];
            if (!$details) {
                $success = false;
            } else {
                $same_billing_address = $model->same_billing_address;
                $success = true;
                if ($same_billing_address == 0) {
                    $modelDelivery = new OrderShoppingByDelivery();
                    $modelDeliveryData = $modelDelivery->getDelivery(
                        [
                            'filters' => [
                                'order_shopping_cart_id' => $id
                            ]]
                    );
                    if (!$modelDeliveryData) {
                        $success = false;
                    } else {
                        $success = true;
                        $delivery = (object)[
                            'people_id' => $modelDeliveryData->people_id,
                            'name' => $modelDeliveryData->name,
                            'last_name' => $modelDeliveryData->last_name,
                            'payer_email' => $modelDeliveryData->payer_email,
                            'company' => $modelDeliveryData->company,
                            'address_secondary' => $modelDeliveryData->address_secondary,
                            'city' => $modelDeliveryData->city,
                            'state_province_id' => $modelDeliveryData->state_province_id,
                            'state_province' => $modelDeliveryData->state_province,
                            'zipcode' => $modelDeliveryData->zipcode,
                            'country_id' => $modelDeliveryData->country_id,
                            'country' => $modelDeliveryData->country,
                            'user_id' => $modelDeliveryData->user_id,
                            'phone' => $modelDeliveryData->phone,
                            'address_main' => $modelDeliveryData->address_main,
                            'document' => $modelDeliveryData->document
                        ];
                    }

                } else {

                    $delivery = $invoiceHeader;

                }
            }


        }
        $result = (object)[
            'checkout' => $model,
            'details' => $details,
            'delivery' => $delivery,
            'invoiceHeader' => $invoiceHeader,
            'success' => $success,
            'language' => $language,
            'same_billing_address' => $same_billing_address,
            'filtersPage' => (object)$params['filters']

        ];

        return $result;
    }

    public function saveDataOrderShippingEvents($params)
    {
        $success = false;
        $msj = "Se guardo correctamente.";

        $result = array();
        $attributesPost = $params;
        $errors = array();
        $data = [];
        try {
            $modelPeople = new People();
            $peopleData = [
                'People' => [
                    'last_name' => $params['OrderShoppingByCustomerDelivery']['last_name'],
                    'name' => $params['OrderShoppingByCustomerDelivery']['name'],
                    'birthdate' => $params['OrderShoppingByCustomerDelivery']['birthdate'],
                    'age' => $params['OrderShoppingByCustomerDelivery']['age'],
                    'gender' => $params['OrderShoppingByCustomerDelivery']['gender'],
                ]
            ];
            $resultManagerSave = $modelPeople->saveDataOrderShippingEvents($peopleData);
            $success = $resultManagerSave['success'];
            if ($success) {

                $people_id = $resultManagerSave['model']->id;
                $modelOSBCD = new OrderShoppingByCustomerDelivery();
                $params['OrderShoppingByCustomerDelivery']['people_id'] = $people_id;
                $resultManagerSave = $modelOSBCD->saveDataOrderShippingEvents($params);
                $success = $resultManagerSave['success'];
                if ($success) {
                    $order_shopping_by_customer_delivery_id = $resultManagerSave['model']->id;
                    $modelName = 'OrderShoppingCart';
                    $model = new OrderShoppingCart();
                    $orderShoppingCartData = $attributesPost[$modelName];
                    $orderShoppingCartData['order_shopping_by_customer_delivery_id'] = $order_shopping_by_customer_delivery_id;
                    $orderShoppingCartData['state'] = self::STATE_TO_DELIVER;
                    $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $orderShoppingCartData, 'attributesData' => $this->attributesData));
                    $paramsValidate = array(
                        'inputs' => $attributesSet,
                        'rules' => self::getRulesModel(),

                    );
                    $validateResult = $this->validateModel($paramsValidate);
                    $success = $validateResult["success"];
                    if ($success) {

                        $model->state = self::STATE_TO_DELIVER;
                        $model->fill($attributesSet);
                        $success = $model->save();
                        $order_shopping_cart_id = $model->id;
                        $data['OrderShoppingCart'] = $model;
                        $same_billing_address = $model->same_billing_address;
                        $detailsData = $params['OrderShoppingCartByDetailsData'];

                        $modelOSCD = new OrderShoppingCartByDetails();

                        foreach ($detailsData as $key => $row) {

                            $rowCurrent = $row;
                            $rowCurrent['order_shopping_cart_id'] = $order_shopping_cart_id;
                            $setManager = [];
                            $setManager['OrderShoppingCartByDetails'] = $rowCurrent;
                            $resultManagerSave = $modelOSCD->saveDataOrderShippingEvents($setManager);
                            $success = $resultManagerSave['success'];
                            if (!$success) {
                                $msj = $resultManagerSave['msj'];
                                $errors = $resultManagerSave['errors'];
                            } else {//

                                $eventsTrailsRegistrationByCustomerData = $row['eventsTrailsRegistrationByCustomer'];
                                $modelCurrentCustomer = new \App\Models\EventsTrailsRegistrationByCustomer();

                                $manager_id = $resultManagerSave['model']->id;
                                foreach ($eventsTrailsRegistrationByCustomerData as $keyRegister => $rowRegister) {
                                    $rowRegister['manager_id'] = $manager_id;
                                    $resultManagerSave = $modelCurrentCustomer->saveDataCustomerRegister([
                                        'EventsTrailsRegistrationByCustomer' => $rowRegister
                                    ]);
                                    $success = $resultManagerSave['success'];
                                    if (!$success) {
                                        $msj = $resultManagerSave['msj'];
                                        $errors = $resultManagerSave['errors'];
                                    } else {//

                                        $orderEventKitsByCustomerData = $rowRegister['orderEventKitsByCustomer'];
                                        $modelCurrent = new \App\Models\OrderEventKitsByCustomer();
                                        $events_trails_registration_by_customer_id = $resultManagerSave['model']->id;

                                        foreach ($orderEventKitsByCustomerData as $keyRegisterKit => $rowRegisterKit) {
                                            $setPushCurrent = (array)$rowRegisterKit;
                                            $setPushCurrent['events_trails_registration_by_customer_id'] = $events_trails_registration_by_customer_id;
                                            $resultManagerSave = $modelCurrent->saveDataCustomerRegisterKit([
                                                'OrderEventKitsByCustomer' => $setPushCurrent
                                            ]);
                                            $success = $resultManagerSave['success'];
                                            if (!$success) {
                                                $msj = $resultManagerSave['msj'];
                                                $errors = $resultManagerSave['errors'];
                                            } else {//


                                            }
                                        }
                                    }
                                }

                            }

                        }

                        //DELIVERY NOT INFORMATION INVOICE HEADER
                        if ($same_billing_address == 0) {
                            $keyBillingOtherDelivery = 'billing_';
                            $modelPeople = new People();
                            $peopleData = [
                                'People' => [
                                    'last_name' => $params['OrderShoppingByDelivery']['last_name'],
                                    'name' => $params['OrderShoppingByDelivery']['name'],
                                    'birthdate' => $params['OrderShoppingByDelivery']['birthdate'],
                                    'age' => $params['OrderShoppingByDelivery']['age'],
                                    'gender' => $params['OrderShoppingByDelivery']['gender'],
                                ]
                            ];
                            $resultManagerSave = $modelPeople->saveDataOrderShippingEvents($peopleData);
                            $success = $resultManagerSave['success'];
                            if ($success) {
                                $people_id = $resultManagerSave['model']->id;
                                $modelOSBCD = new OrderShoppingByDelivery();
                                $payer_email = $params['OrderShoppingByDelivery']['payer_email'];
                                $company = $params['OrderShoppingByDelivery']['company'];
                                $address_secondary = $params['OrderShoppingByDelivery']['address_secondary'];
                                $city = $params['OrderShoppingByDelivery']['city'];
                                $state_province_id = $params['OrderShoppingByDelivery']['state_province_id'];
                                $zipcode = $params['OrderShoppingByDelivery']['zipcode'];
                                $country_id = $params['OrderShoppingByDelivery']['country_id'];
                                $user_id = $params['OrderShoppingByDelivery']['user_id'];
                                $phone = $params['OrderShoppingByDelivery']['phone'];
                                $address_main = $params['OrderShoppingByDelivery']['address_main'];
                                $document = $params['OrderShoppingByDelivery']['document'];

                                $setData = [
                                    'people_id' => $people_id,
                                    'payer_email' => $payer_email,
                                    'company' => $company,
                                    'address_secondary' => $address_secondary,
                                    'city' => $city,
                                    'state_province_id' => $state_province_id,
                                    'zipcode' => $zipcode,
                                    'country_id' => $country_id,
                                    'user_id' => $user_id,
                                    'phone' => $phone,
                                    'address_main' => $address_main,
                                    'order_shopping_cart_id' => $order_shopping_cart_id,
                                    'document' => $document

                                ];
                                $resultManagerSave = $modelOSBCD->saveDataOrderShippingEvents(
                                    [
                                        'OrderShoppingByDelivery' => $setData

                                    ]
                                );
                                $success = $resultManagerSave['success'];
                                if (!$success) {
                                    $msj = $resultManagerSave['msj'];
                                    $errors = $resultManagerSave['errors'];
                                }
                            } else {

                                $msj = $resultManagerSave['msj'];
                                $errors = $resultManagerSave['errors'];
                            }
                        }


                    } else {
                        $success = false;
                        $msj = "Problemas al guardar  OrderShoppingCart.";
                        $errors = $validateResult["errors"];
                    }

                } else {
                    $msj = $resultManagerSave['msj'];
                    $errors = $resultManagerSave['errors'];
                }

            } else {
                $msj = $resultManagerSave['msj'];
                $errors = $resultManagerSave['errors'];
            }
            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "success" => $success,
                "data" => $data

            ];
            return ($result);
        } catch (Exception $e) {

            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "errors" => $errors,
                "data" => $data

            );
            return ($result);
        }

    }
}
