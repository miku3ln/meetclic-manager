<?php

namespace App\Models;


use App\Utils\Util;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Models\LodgingByPayment as LodgingByPayment;
use App\Models\LodgingByPaymentCreditCard as LodgingByPaymentCreditCard;

use App\Models\People as People;
use App\Models\Customer as Customer;
use App\Models\CustomerByInformation as CustomerByInformation;

use App\Models\RucType as RucType;

use App\Models\LodgingByCustomer as LodgingByCustomer;


use App\Models\LodgingCustomerAdditionalInformation as LodgingCustomerAdditionalInformation;
use App\Models\LodgingByCustomerLocation as LodgingByCustomerLocation;
use Illuminate\Support\Facades\Validator;


use App\Models\LodgingArrivedBySocialNetworks as LodgingArrivedBySocialNetworks;
use App\Models\LodgingByArrived as LodgingByArrived;
use App\Models\LodgingByTypeOfRoom as LodgingByTypeOfRoom;
use App\Models\BusinessByLodgingByPrice as BusinessByLodgingByPrice;
use App\Models\LodgingByReasons as LodgingByReasons;
use App\Models\InformationMail as InformationMail;
use App\Models\InformationPhoneOperator as InformationPhoneOperator;
use App\Models\InformationPhoneType as InformationPhoneType;
use App\Models\InformationPhone as InformationPhone;
use App\Models\InformationAddress;
use App\Models\InformationAddressType;

class Lodging extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lodging';
    const STATUS_DELIVERY_INIT = 0;
    const STATUS_DELIVERY_FINALIZED = 1;

    protected $fillable = array(
        "entry_at",//*
        "output_at",
        "number_people",//*
        "adults",
        "children",
        "number_rooms",//*
        "total_value",//*
        "payment_made",//*
        "description",
        "business_id",//*
        "status",//*
        "arrived_made",
        "rooms_add_made",
        "status_delivery",
        "delivery_date"


    );
    public $attributesData = array(
        "entry_at",//*
        "output_at",
        "number_people",//*
        "adults",
        "children",
        "number_rooms",//*
        "total_value",//*
        "payment_made",//*
        "description",
        "business_id",//*
        "status",//*
        "arrived_made",
        "rooms_add_made",
        "status_delivery",
        "delivery_date"


    );
    public $timestamps = true;

    public static function getRulesModel()
    {
        $rules = [
            "entry_at" => 'required',
            "number_people" => 'required',
            "number_rooms" => 'required',
            "total_value" => 'required',
            "payment_made" => 'required',
            "business_id" => 'required'
        ];
        return $rules;
    }

    public static function validateModel($modelAttributes)
    {
        $rules = self::getRulesModel();
        $validation = Validator::make($modelAttributes, $rules);
        $success = $validation->passes();
        $errors = [];
        if (!$success) {
            $errors = $validation->errors()->all();
        }
        $result = array("success" => $success, "errors" => $errors);
        return $result;
    }

    public function getAdminBusiness($params)
    {
        $sort = 'DESC';
        $field = 'id';
        $query = DB::table($this->table);

        $business_id = isset($params["filters"]["business_id"]) ? $params["filters"]["business_id"] : null;
        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];

        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $selectString = "$this->table.id ,$this->table.arrived_made  ,$this->table.rooms_add_made,$this->table.entry_at,$this->table.output_at,$this->table.number_people,$this->table.adults,$this->table.children,$this->table.number_rooms,$this->table.total_value,$this->table.payment_made,$this->table.created_at,$this->table.updated_at,$this->table.deleted_at,$this->table.description,$this->table.business_id,$this->table.status,$this->table.status_delivery,$this->table.delivery_date
        ";

        $select = DB::raw($selectString);
        $query->select($select);
        if ($business_id) {
            $query->where("business_id", $business_id);
        }


        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = "%" . $searchValue . "%";
            $query
                ->where($this->table . '.id', 'like', $likeSet);
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

    public function getAdminBusinessData($params)
    {
        $result = $this->getAdminBusiness($params);
        $business_id = $params["filters"]["business_id"];
        $modelLBP = new LodgingByPayment();
        $modelLBPCC = new  LodgingByPaymentCreditCard();
        $modelLBA = new LodgingByArrived();
        $modelLABSN = new  LodgingArrivedBySocialNetworks();
        $modelP = new People();
        $modelLBC = new LodgingByCustomer();
        $modelLCAI = new LodgingCustomerAdditionalInformation();
        $modelLBCL = new  LodgingByCustomerLocation();
        $modelLBTOR = new  LodgingByTypeOfRoom();
        $modelBBLBP = new BusinessByLodgingByPrice;
        $modelLBR = new LodgingByReasons();

        foreach ($result["rows"] as $key => $row) {


            $lodging_id = $row->id;
            $payment_made = $row->payment_made;
            $arrived_made = $row->arrived_made;

            $setPush = json_decode(json_encode($row), true);
            $result["rows"][$key] = $setPush;
            /* LodgingByPayment*/
            if ($payment_made == 1) {
                $lodgingByPayment = $modelLBP->getPayments(array("lodging_id" => $lodging_id));
                foreach ($lodgingByPayment as $keyLBP => $rowLBP) {
                    $lodging_by_payment_id = $rowLBP->lodging_by_payment_id;
                    $setPush = json_decode(json_encode($rowLBP), true);
                    $lodgingByPayment[$keyLBP] = $setPush;
                    if ($rowLBP->way_to_pay == $modelLBP::wayToPayCreditCards) {
                        $lodgingByPaymentCreditCard = $modelLBPCC->getPaymentsOfCreditCards(array("lodging_by_payment_id" => $lodging_by_payment_id));
                        $lodgingByPayment[$keyLBP]["LodgingByPaymentCreditCard"] = $lodgingByPaymentCreditCard;
                    }
                }
                $result["rows"][$key]["LodgingByPayment"] = $lodgingByPayment;
            }
            /* SOCIAL NETWORKS*/
            if ($arrived_made == 1) {
                $dataCurrent = array();
                $dataArrived = $modelLBA->getArrived(array("lodging_id" => $lodging_id));
                $lodging_by_arrived_id = $dataArrived->lodging_by_arrived_id;

                $dataCurrent = array(
                    "lodging_by_arrived_id" => $dataArrived->lodging_by_arrived_id,
                    "lodging_id" => $dataArrived->lodging_id,
                    "way_to_contact" => $dataArrived->way_to_contact,
                    "way_to_contact_text" => $dataArrived->way_to_contact_text,

                );

                if ($dataArrived->way_to_contact == $modelLBA::wayToContactNetworkSocial) {
                    $lodgingArrivedBySocialNetworks = $modelLABSN->getSocialNetworksOfLodgingArrived(array("lodging_by_arrived_id" => $lodging_by_arrived_id));
                    $dataCurrent["LodgingArrivedBySocialNetworks"] = $lodgingArrivedBySocialNetworks;
                }

                $result["rows"][$key]["LodgingByArrived"] = $dataCurrent;

                $LodgingByReasons = $modelLBR->getReasonByArrived(array("lodging_id" => $lodging_id));

                $result["rows"][$key]["LodgingByReasons"] = $LodgingByReasons;


            }

            /*People*/
            $customersData = $modelLBC->getLodgingCustomers(array("lodging_id" => $lodging_id));
            $People = array();
            foreach ($customersData as $keyC => $rowC) {
                $last_name = $rowC->last_name;
                $name = $rowC->name;
                $type_document = $rowC->type_document;
                $document_number = $rowC->document_number;
                $age = $rowC->age;
                $gender = $rowC->gender;
                $people_id = $rowC->people_id;
                $customer_by_information_id = $rowC->customer_by_information_id;
                $customer_id = $rowC->customer_id;
                $has_information_additional = $rowC->has_information_additional;
                $lodging_by_customer_id = $rowC->lodging_by_customer_id;
                $setPushData = array(
                    "people_id" => $people_id,
                    "last_name" => $last_name,
                    "name" => $name,
                    "type_document" => $type_document,
                    "document_number" => $document_number,
                    "age" => $age,
                    "gender" => $gender,
                    //LodgingByCustomer
                    "lodging_by_customer_id" => $lodging_by_customer_id,
                    "customer_by_information_id" => $customer_by_information_id,
                    "customer_id" => $customer_id,
                    "main" => $rowC->main,
                    "has_information_additional" => $rowC->has_information_additional,
                    "people_nationality_id" => $rowC->people_nationality_id,
                    "people_nationality_text" => $rowC->people_nationality_text,
                    "people_profession_id" => $rowC->people_profession_id,
                    "people_profession_text" => $rowC->people_profession_text


                );

                if ($has_information_additional == 1) {
                    $lodgingCustomerAdditionalInformation = $modelLCAI->getLodgingCustomerInformation(array(
                        "lodging_by_customer_id" => $lodging_by_customer_id));

                    $setPushData["phone"] = $lodgingCustomerAdditionalInformation->phone;
                    $setPushData["information_phone_id"] = $lodgingCustomerAdditionalInformation->information_phone_id;
                    $setPushData["mobile"] = $lodgingCustomerAdditionalInformation->mobile;
                    $setPushData["information_mobile_id"] = $lodgingCustomerAdditionalInformation->information_mobile_id;
                    $setPushData["mail"] = $lodgingCustomerAdditionalInformation->mail;
                    $setPushData["information_mail_id"] = $lodgingCustomerAdditionalInformation->information_mail_id;
                    $setPushData["postal_code"] = $lodgingCustomerAdditionalInformation->postal_code;
                    $setPushData["lodging_customer_additional_information_id"] = $lodgingCustomerAdditionalInformation->lodging_customer_additional_information_id;

                    $lodgingByCustomerLocation = $modelLBCL->getLodgingCustomerLocation(array(
                        "lodging_by_customer_id" => $lodging_by_customer_id));

                    if ($lodgingByCustomerLocation) {
                        $setPushData["lodging_by_customer_location"] = array(
                            "lodging_by_customer_location_id" => $lodgingByCustomerLocation->lodging_by_customer_location_id,
                            "country_code_id" => $lodgingByCustomerLocation->country_code_id,
                            "administrative_area_level_2" => $lodgingByCustomerLocation->administrative_area_level_2,
                            "administrative_area_level_1" => $lodgingByCustomerLocation->administrative_area_level_1,
                            "administrative_area_level_3" => $lodgingByCustomerLocation->administrative_area_level_3,
                            "options_map" => $lodgingByCustomerLocation->options_map,
                            "lodging_by_customer_id" => $lodgingByCustomerLocation->lodging_by_customer_id,
                            "information_address_location_current_id" => $lodgingByCustomerLocation->information_address_location_current_id,
                        );
                    } else {
                        $setPushData["lodging_by_customer_location"] = array();
                    }
                }
                array_push($People, $setPushData);

            }

            $result["rows"][$key]["People"] = $People;

            /*Rooms*/
            $LodgingByTypeOfRoom = $modelLBTOR->getRooms(array("lodging_id" => $lodging_id));
            $result["rows"][$key]["LodgingByTypeOfRoom"] = $LodgingByTypeOfRoom;

            $lodgingTypeOfRoomByPriceData = $modelBBLBP->getRoomsDataByBusiness(array("business_id" => $business_id));
            $result["rows"][$key]["lodgingTypeOfRoomByPriceData"] = $lodgingTypeOfRoomByPriceData;


        }


        return $result;

    }

    public function saveBusiness($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        $errorsCustomers = [];
        $isCreate = false;
        $isUpdate = true;

        DB::beginTransaction();
        try {

            $model = new Lodging();
            $createUpdate = true;
            if (isset($attributesPost["id"]) && $attributesPost["id"] != "null" && $attributesPost["id"] != "-1") {
                $model = Lodging::find($attributesPost['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }
            $lodgingData = $attributesPost;
            $business_id = $lodgingData["business_id"];
            $attributesSet = array(
                "entry_at" => $lodgingData["entry_at"],
                "number_people" => $lodgingData["number_people"],
                "adults" => $lodgingData["adults"],
                "children" => $lodgingData["children"],
                "number_rooms" => $lodgingData["number_rooms"],
                "total_value" => $lodgingData["total_value"],
                "payment_made" => $lodgingData["payment_made"],
                "description" => $lodgingData["description"],
                "business_id" => $business_id

            );
            if ($lodgingData["output_at"] != "null") {

                $attributesSet["output_at"] = $lodgingData["output_at"];
            }

            $validateResult = self::validateModel($attributesSet);

            $success = $validateResult["success"];
            if ($success) {


                $model->fill($attributesSet);
                $model->save();
                $lodging_id = $model->id;
                //PAYMENT
                $payment_made = $lodgingData["payment_made"];


                if ($createUpdate) {
                    if ($payment_made == 1) {

                        $lodgingByPaymentData = $lodgingData["LodgingByPayment"];


                        foreach ($lodgingByPaymentData as $attributes) {

                            $modelLBP = new LodgingByPayment();

                            $attributesSet = array(
                                "way_to_pay" => $attributes["way_to_pay"],
                                "lodging_id" => $lodging_id
                            );

                            $validateResult = LodgingByPayment::validateModel($attributesSet);
                            $success = $validateResult["success"];
                            if (!$success) {
                                $msj = "Problemas al guardar Lodging Payment";
                                array_push($errors, $validateResult["errors"]);


                            } else {
                                $modelLBP->fill($attributesSet);
                                $success = $modelLBP->save();
                                $lodging_by_payment_id = $modelLBP->id;
                                if (isset($attributes["LodgingByPaymentCreditCard"])) {
                                    $lodgingByPaymentCreditCardData = $attributes["LodgingByPaymentCreditCard"];
                                    foreach ($lodgingByPaymentCreditCardData as $attributesLBPCC) {
                                        $modelLBPCC = new LodgingByPaymentCreditCard();
                                        $attributesSet = array(
                                            "type_credit_card" => $attributesLBPCC["type_credit_card"],
                                            "lodging_by_payment_id" => $lodging_by_payment_id
                                        );

                                        $validateResult = LodgingByPaymentCreditCard::validateModel($attributesSet);
                                        $success = $validateResult["success"];
                                        if (!$success) {
                                            $msj = "Problemas al guardar LodgingByPaymentCreditCard";

                                            array_push($errors, $validateResult["errors"]);

                                        } else {
                                            $modelLBPCC->fill($attributesSet);
                                            $success = $modelLBPCC->save();
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

//PEOPLE
                $peopleData = $lodgingData["People"];

                foreach ($peopleData as $key => $attributes) {

                    $allowAddPeopleS2 = $attributes["allowAddPeopleS2"];

                    $isNewRecord = isset($attributes["people_id"]);

                    if ($allowAddPeopleS2 == 'false') {//valores existentes en lodging
                        $modelP = new People();
                        $isCreatePeople = $isCreate;
                        if (isset($attributes["people_id"])) {
                            $isCreatePeople = $isUpdate;
                            $modelP = People::find($attributes["people_id"]);
                        }


                        $attributesSet = array(
                            "last_name" => $attributes["last_name"],
                            "name" => $attributes["name"],
                            "age" => $attributes["age"],
                            "gender" => $attributes["gender"]
                        );
                        $validateResult = People::validateModel($attributesSet);
                        $success = $validateResult["success"];
                        if (!$success) {
                            $typeManagerCurrent = "Guardar";
                            if ($isCreatePeople) {
                                $typeManagerCurrent = "Actualizar";
                            }
                            $msj = "Problemas al $typeManagerCurrent Persona";

                            array_push($errors, $validateResult["errors"]);
                            array_push($errorsCustomers, [
                                'key' => $key,
                                'type' => 'People',
                                'isCreate' => $isCreatePeople,
                                'errors' => $validateResult["errors"],
                            ]);

                        } else {
                            $modelP->fill($attributesSet);
                            $success = $modelP->save();
                            $people_id = $modelP->id;
                            $modelC = new Customer();
                            $allowUpdateCustomer = $isCreate;

                            if (isset($attributes["customer_id"])) {
                                $modelC = Customer::find($attributes["customer_id"]);
                                $allowUpdateCustomer = $isUpdate;
                            }


                            $attributesSet = array(
                                "business_id" => $business_id,
                                "identification_document" => $attributes["document_number"],
                                "people_type_identification_id" => $attributes["type_document"],
                                "people_id" => $people_id,
                                "ruc_type_id" => RucType::RUC_TYPE_ANY
                            );
                            if ($allowUpdateCustomer) {
                                $attributesSet['customer_id'] = $attributes["customer_id"];
                            }
                            $validateResult = Customer::validateModel($attributesSet);

                            $success = $validateResult["success"];
                            if (!$success) {
                                $typeManagerCurrent = "Guardar";
                                if (isset($lodgingByCustomer["customer_by_information_id"])) {
                                    $typeManagerCurrent = "Actualizar";
                                }
                                $msj = "Problemas al $typeManagerCurrent Cliente";

                                array_push($errors, $validateResult["errors"]);
                                array_push($errorsCustomers, [
                                    'key' => $key,
                                    'type' => 'Customer',
                                    'isCreate' => $allowUpdateCustomer,
                                    'errors' => $validateResult["errors"],
                                ]);

                            } else {

                                $modelC->fill($attributesSet);
                                $success = $modelC->save();
                                $customer_id = $modelC->id;
                                $lodgingByCustomer = $attributes["LodgingByCustomer"];
                                $modelCBI = new CustomerByInformation();
                                $isLodgingByCustomer = $isCreate;
                                if (isset($lodgingByCustomer["customer_by_information_id"])) {
                                    $modelCBI = CustomerByInformation::find($lodgingByCustomer["customer_by_information_id"]);
                                    $isLodgingByCustomer = $isUpdate;

                                }


                                $attributesSet = array(
                                    "customer_id" => $customer_id,
                                    "people_nationality_id" => $lodgingByCustomer["people_nationality_id"],
                                    "people_profession_id" => $lodgingByCustomer["people_profession_id"],
                                );
                                $validateResult = CustomerByInformation::validateModel($attributesSet);

                                $success = $validateResult["success"];
                                if (!$success) {
                                    $typeManagerCurrent = "Guardar";
                                    if (isset($lodgingByCustomer["customer_by_information_id"])) {
                                        $typeManagerCurrent = "Actualizar";
                                    }
                                    $msj = "Problemas al $typeManagerCurrent Informacion Adicional";

                                    array_push($errors, $validateResult["errors"]);
                                    array_push($errorsCustomers, [
                                        'key' => $key,
                                        'type' => 'CustomerByInformation',
                                        'isCreate' => $isLodgingByCustomer,
                                        'errors' => $validateResult["errors"],
                                    ]);

                                } else {
                                    $modelCBI->fill($attributesSet);
                                    $success = $modelCBI->save();
                                    $modelLBC = new LodgingByCustomer();
                                    $isLodgingByCustomer = $isCreate;

                                    if (isset($lodgingByCustomer["lodging_by_customer_id"])) {
                                        $isLodgingByCustomer = $isUpdate;
                                        $modelLBC = LodgingByCustomer::find($lodgingByCustomer["lodging_by_customer_id"]);
                                    }

                                    $has_information_additional = $lodgingByCustomer["has_information_additional"];
                                    $attributesSet = array(
                                        "main" => $lodgingByCustomer["main"],
                                        "lodging_id" => $lodging_id,
                                        "has_information_additional" => $has_information_additional,
                                        "customer_id" => $customer_id,

                                    );
                                    $validateResult = LodgingByCustomer::validateModel($attributesSet);
                                    $success = $validateResult["success"];

                                    if (!$success) {
                                        $typeManagerCurrent = "Guardar";
                                        if (!$isLodgingByCustomer) {
                                            $typeManagerCurrent = "Actualizar";
                                        }
                                        $msj = "Problemas al $typeManagerCurrent Lodging By Customer";

                                        array_push($errors, $validateResult["errors"]);

                                        array_push($errorsCustomers, [
                                            'key' => $key,
                                            'type' => 'LodgingByCustomer',
                                            'isCreate' => $isLodgingByCustomer,
                                            'errors' => $validateResult["errors"],
                                        ]);
                                    } else {
                                        $modelLBC->fill($attributesSet);
                                        $success = $modelLBC->save();
                                        $lodging_by_customer_id = $modelLBC->id;
                                        if ($has_information_additional == 1) {

                                            $lodgingCustomerAdditionalInformation = $lodgingByCustomer["LodgingCustomerAdditionalInformation"];


                                            $modelIM = new InformationMail();
                                            $isInformationMail = $isCreate;
                                            if (isset($lodgingCustomerAdditionalInformation["information_mail_id"])) {
                                                $modelIM = InformationMail::find($lodgingCustomerAdditionalInformation["information_mail_id"]);
                                                $isInformationMail = $isUpdate;

                                            }


                                            $attributesSet = array(
                                                "value" => $lodgingCustomerAdditionalInformation["mail"],
                                                "state" => $modelIM::STATE_ACTIVE,
                                                "entity_id" => $customer_id,
                                                "main" => $modelIM::MAIN,
                                                "entity_type" => $modelIM::ENTITY_TYPE_CUSTOMER,
                                                "information_mail_type_id" => $modelIM::INFORMATION_TYPE_WITHOUT_SPECIFIC
                                            );

                                            $currentModel = $modelIM;
                                            $paramsValidateCurrent = array('fillAble' => $currentModel->getfillable(), 'haystack' => $attributesSet, 'attributesData' => $currentModel->getAttributesData());
                                            $attributesSet = $modelIM::getValuesModel($paramsValidateCurrent);
                                            $paramsValidate = array(
                                                'inputs' => $attributesSet,
                                                'rules' => $currentModel::getRulesModel(),

                                            );
                                            $validateResult = $currentModel::validateModel($paramsValidate);

                                            $success = $validateResult["success"];
                                            if (!$success) {
                                                $typeManagerCurrent = "Guardar";
                                                if (!$isInformationMail) {
                                                    $typeManagerCurrent = "Actualizar";
                                                }
                                                $msj = "Problemas al $typeManagerCurrent Mail";
                                                array_push($errors, $validateResult["errors"]);
                                                array_push($errorsCustomers, [
                                                    'key' => $key,
                                                    'type' => 'InformationMail',
                                                    'isCreate' => $isInformationMail,
                                                    'errors' => $validateResult["errors"],
                                                ]);

                                            } else {

                                                $modelIM->fill($attributesSet);
                                                $success = $modelIM->save();
                                                $information_phone_id = null;
                                                $information_mobile_id = null;

                                                $information_mail_id = $modelIM->id;
                                                //PHONE
                                                $phoneAdd = $lodgingCustomerAdditionalInformation["phone"] != '' ? true : false;
                                                if ($phoneAdd) {
                                                    $valueSet = $lodgingCustomerAdditionalInformation["phone"];
                                                    $modelPhone1 = new InformationPhone();
                                                    $isInformationPhone = $isCreate;

                                                    if (isset($lodgingCustomerAdditionalInformation["information_phone_id"]) && $lodgingCustomerAdditionalInformation["information_phone_id"]) {
                                                        $modelPhone1 = InformationPhone::find($lodgingCustomerAdditionalInformation["information_phone_id"]);
                                                        $isInformationPhone = $isUpdate;

                                                    }

                                                    $attributesSet = array(
                                                        "value" => $valueSet,
                                                        "state" => InformationPhone::STATE_ACTIVE,
                                                        "entity_id" => $customer_id,
                                                        "main" => InformationPhone::MAIN,
                                                        "entity_type" => InformationPhone::ENTITY_TYPE_CUSTOMER,
                                                        "information_phone_type_id" => InformationPhoneType::TYPE_HOUSE_ID,
                                                        "information_phone_operator_id" => InformationPhoneOperator::OPERATOR_NOT_SPECIFIC_ID,
                                                    );

                                                    $currentModel = $modelPhone1;
                                                    $paramsValidateCurrent = array('fillAble' => $currentModel->getfillable(), 'haystack' => $attributesSet, 'attributesData' => $currentModel->getAttributesData());
                                                    $attributesSet = $modelIM::getValuesModel($paramsValidateCurrent);
                                                    $paramsValidate = array(
                                                        'inputs' => $attributesSet,
                                                        'rules' => $currentModel::getRulesModel(),

                                                    );
                                                    $validateResult = $currentModel::validateModel($paramsValidate);
                                                    $success = $validateResult["success"];
                                                    if (!$success) {
                                                        $typeManagerCurrent = "Guardar";
                                                        if (!$isInformationPhone) {
                                                            $typeManagerCurrent = "Actualizar";
                                                        }
                                                        $msj = "Problemas al $typeManagerCurrent Phone House";

                                                        array_push($errors, $validateResult["errors"]);

                                                        array_push($errorsCustomers, [
                                                            'key' => $key,
                                                            'type' => 'InformationPhone1',
                                                            'isCreate' => $isInformationPhone,
                                                            'errors' => $validateResult["errors"],
                                                        ]);
                                                    } else {
                                                        $modelPhone1->fill($attributesSet);
                                                        $success = $modelPhone1->save();
                                                        $information_phone_id = $modelPhone1->id;
                                                    }
                                                }

                                                //MOBILE
                                                $mobileAdd = $lodgingCustomerAdditionalInformation["mobile"] != '' ? true : false;
                                                if ($mobileAdd) {
                                                    $valueSet = $lodgingCustomerAdditionalInformation["mobile"];
                                                    $modelPhone1 = new InformationPhone();
                                                    $isInformationPhone = $isCreate;
                                                    if (isset($lodgingCustomerAdditionalInformation["information_mobile_id"]) && $lodgingCustomerAdditionalInformation["information_mobile_id"]) {
                                                        $modelPhone1 = InformationPhone::find($lodgingCustomerAdditionalInformation["information_mobile_id"]);
                                                        $isInformationPhone = $isUpdate;

                                                    }


                                                    $attributesSet = array(
                                                        "value" => $valueSet,
                                                        "state" => InformationPhone::STATE_ACTIVE,
                                                        "entity_id" => $customer_id,
                                                        "main" => InformationPhone::MAIN,
                                                        "entity_type" => InformationPhone::ENTITY_TYPE_CUSTOMER,
                                                        "information_phone_type_id" => InformationPhoneType::TYPE_WORKFORCE_ID,
                                                        "information_phone_operator_id" => InformationPhoneOperator::OPERATOR_NOT_SPECIFIC_ID,
                                                    );

                                                    $currentModel = $modelPhone1;
                                                    $paramsValidateCurrent = array('fillAble' => $currentModel->getfillable(), 'haystack' => $attributesSet, 'attributesData' => $currentModel->getAttributesData());
                                                    $attributesSet = $modelIM::getValuesModel($paramsValidateCurrent);
                                                    $paramsValidate = array(
                                                        'inputs' => $attributesSet,
                                                        'rules' => $currentModel::getRulesModel(),

                                                    );
                                                    $validateResult = $currentModel::validateModel($paramsValidate);
                                                    $success = $validateResult["success"];
                                                    if (!$success) {
                                                        $typeManagerCurrent = "Guardar";
                                                        if (!$isInformationPhone) {
                                                            $typeManagerCurrent = "Actualizar";
                                                        }
                                                        $msj = "Problemas al $typeManagerCurrent Phone Personal";

                                                        array_push($errors, $validateResult["errors"]);
                                                        array_push($errorsCustomers, [
                                                            'key' => $key,
                                                            'type' => 'InformationPhone Movile',
                                                            'isCreate' => $isInformationPhone,
                                                            'errors' => $validateResult["errors"],
                                                        ]);

                                                    } else {
                                                        $modelPhone1->fill($attributesSet);
                                                        $success = $modelPhone1->save();
                                                        $information_mobile_id = $modelPhone1->id;
                                                    }
                                                }
                                                $modelLCAI = new LodgingCustomerAdditionalInformation();
                                                $isLodgingCustomerAdditionalInformation = $isCreate;

                                                if (isset($lodgingCustomerAdditionalInformation["lodging_customer_additional_information_id"])) {
                                                    $modelLCAI = LodgingCustomerAdditionalInformation::find($lodgingCustomerAdditionalInformation["lodging_customer_additional_information_id"]);
                                                    $isLodgingCustomerAdditionalInformation = $isUpdate;
                                                }


                                                $attributesSet = array(
                                                    "information_phone_id" => $information_phone_id,
                                                    "information_mobile_id" => $information_mobile_id,
                                                    "information_mail_id" => $information_mail_id,
                                                    "postal_code" => $lodgingCustomerAdditionalInformation["postal_code"],
                                                    "lodging_by_customer_id" => $lodging_by_customer_id,
                                                );
                                                $validateResult = LodgingCustomerAdditionalInformation::validateModel($attributesSet);
                                                $success = $validateResult["success"];
                                                if (!$success) {
                                                    $typeManagerCurrent = "Guardar";
                                                    if (!$isLodgingCustomerAdditionalInformation) {
                                                        $typeManagerCurrent = "Actualizar";
                                                    }
                                                    $msj = "Problemas al $typeManagerCurrent LodgingCustomerAdditionalInformation";
                                                    array_push($errors, $validateResult["errors"]);

                                                    array_push($errorsCustomers, [
                                                        'key' => $key,
                                                        'type' => 'LodgingCustomerAdditionalInformation',
                                                        'isCreate' => $isLodgingCustomerAdditionalInformation,
                                                        'errors' => $validateResult["errors"],
                                                    ]);
                                                } else {
                                                    $modelLCAI->fill($attributesSet);
                                                    $success = $modelLCAI->save();
                                                }

                                                $lodgingByCustomerLocation = $lodgingByCustomer["LodgingByCustomerLocation"];
                                                $modelIALC = new InformationAddress();
                                                $isInformationAddress = $isCreate;
                                                if (isset($lodgingByCustomerLocation["information_address_location_current_id"])) {
                                                    $modelIALC = InformationAddress::find($lodgingByCustomerLocation["information_address_location_current_id"]);
                                                    $isInformationAddress = $isUpdate;

                                                }


                                                $attributesSet = array(
                                                    "country_code_id" => $lodgingByCustomerLocation["country_code_id"],
                                                    "administrative_area_level_2" => $lodgingByCustomerLocation["administrative_area_level_2"] == "" ? "any-information" : $lodgingByCustomerLocation["administrative_area_level_2"],
                                                    "administrative_area_level_1" => isset($lodgingByCustomerLocation["administrative_area_level_1"]) ? $lodgingByCustomerLocation["administrative_area_level_1"] : "",
                                                    "administrative_area_level_3" => isset($lodgingByCustomerLocation["administrative_area_level_3"]) ? $lodgingByCustomerLocation["administrative_area_level_3"] : "",
                                                    "options_map" => isset($lodgingByCustomerLocation["options_map"]) ? $lodgingByCustomerLocation["options_map"] : "",
                                                    "entity_id" => $customer_id,
                                                    "entity_type" => 0,
                                                    'has_location' => 1,
                                                    'information_address_type_id' => InformationAddressType::TYPE_HOME,
                                                    'main' => 1,
                                                    'street_one' => 'Not Street',
                                                    'street_two' => 'Not Street',
                                                    'reference' => 'Not Reference',
                                                    'state' => 'ACTIVE'
                                                );
                                                $currentModel = $modelIALC;
                                                $paramsValidateCurrent = array('fillAble' => $currentModel->getfillable(), 'haystack' => $attributesSet, 'attributesData' => $currentModel->getAttributesData());
                                                $attributesSet = $modelIM::getValuesModel($paramsValidateCurrent);
                                                $paramsValidate = array(
                                                    'inputs' => $attributesSet,
                                                    'rules' => $currentModel::getRulesModel(),

                                                );
                                                $validateResult = $currentModel::validateModel($paramsValidate);

                                                $success = $validateResult["success"];
                                                if (!$success) {
                                                    $typeManagerCurrent = "Guardar";
                                                    if (!$isInformationAddress) {
                                                        $typeManagerCurrent = "Actualizar";
                                                    }
                                                    $msj = "Problemas al $typeManagerCurrent InformationAddress";
                                                    array_push($errors, $validateResult["errors"]);
                                                    array_push($errorsCustomers, [
                                                        'key' => $key,
                                                        'type' => 'InformationAddress',
                                                        'isCreate' => $isInformationAddress,
                                                        'errors' => $validateResult["errors"],
                                                    ]);

                                                } else {
                                                    $modelIALC->fill($attributesSet);
                                                    $success = $modelIALC->save();
                                                    $information_address_id = $modelIALC->id;
                                                    $modelLBCL = new LodgingByCustomerLocation();
                                                    $isLodgingByCustomerLocation = $isCreate;

                                                    if (isset($lodgingByCustomerLocation["lodging_by_customer_location_id"])) {
                                                        $modelLBCL = LodgingByCustomerLocation::find($lodgingByCustomerLocation["lodging_by_customer_location_id"]);
                                                    }

                                                    $attributesSet = array(
                                                        "information_address_id" => $information_address_id,
                                                        "lodging_by_customer_id" => $lodging_by_customer_id,
                                                    );
                                                    $validateResult = LodgingByCustomerLocation::validateModel($attributesSet);//ALEX

                                                    $success = $validateResult["success"];
                                                    if (!$success) {
                                                        $typeManagerCurrent = "Guardar";
                                                        if (!$isLodgingByCustomerLocation) {
                                                            $typeManagerCurrent = "Actualizar";
                                                        }
                                                        $msj = "Problemas al $typeManagerCurrent LodgingByCustomerLocation";
                                                        array_push($errors, $validateResult["errors"]);

                                                        array_push($errorsCustomers, [
                                                            'key' => $key,
                                                            'type' => 'LodgingByCustomerLocation',
                                                            'isCreate' => $isLodgingByCustomerLocation,
                                                            'errors' => $validateResult["errors"],
                                                        ]);
                                                    } else {
                                                        $modelLBCL->fill($attributesSet);
                                                        $success = $modelLBCL->save();
                                                    }
                                                }

                                            }


                                        } else {

                                            $modelLCAI = LodgingCustomerAdditionalInformation::getModelByLodgingByCustomerId($lodging_by_customer_id);
                                            if ($modelLCAI) {
                                                LodgingCustomerAdditionalInformation::destroy($modelLCAI->id);

                                            }
                                            $modelLBCL = LodgingByCustomerLocation::getModelByLodgingByCustomerId($lodging_by_customer_id);

                                            if ($modelLBCL) {
                                                LodgingByCustomerLocation::destroy($modelLBCL->id);
                                                InformationAddress::destroy($modelLBCL->information_address_id);

                                            }

                                        }
                                    }

                                }


                            }

                        }
                    } else {
                        $modelP = People::find($attributes["people_id"]);

                        $attributesSet = array(
                            "last_name" => $attributes["last_name"],
                            "name" => $attributes["name"],
                            "age" => $attributes["age"],
                            "gender" => $attributes["gender"]
                        );
                        $validateResult = People::validateModel($attributesSet);
                        $success = $validateResult["success"];
                        if (!$success) {
                            $typeManagerCurrent = "Guardar";
                            if (!$createUpdate) {
                                $typeManagerCurrent = "Actualizar";
                            }
                            $msj = "Problemas al $typeManagerCurrent Persona";
                            array_push($errors, $validateResult["errors"]);
                            array_push($errorsCustomers, [
                                'key' => $key,
                                'type' => 'People',
                                'isCreate' => $isUpdate,
                                'errors' => $validateResult["errors"],
                            ]);

                        } else {
                            $modelP->fill($attributesSet);
                            $success = $modelP->save();

                            $people_id = $modelP->id;
                            $modelC = Customer::find($attributes["customer_id"]);
                            $attributesSet = array(
                                "business_id" => $business_id,
                                "identification_document" => $attributes["document_number"],
                                "people_type_identification_id" => $attributes["type_document"],
                                "people_id" => $people_id,
                                "ruc_type_id" => RucType::RUC_TYPE_ANY,
                                'customer_id' => $attributes["customer_id"]
                            );

                            $validateResult = Customer::validateModel($attributesSet);
                            $success = $validateResult["success"];
                            if (!$success) {
                                $typeManagerCurrent = "Guardar";
                                if (!$createUpdate) {
                                    $typeManagerCurrent = "Actualizar";
                                }
                                $msj = "Problemas al $typeManagerCurrent Cliente";
                                array_push($errors, $validateResult["errors"]);

                                array_push($errorsCustomers, [
                                    'key' => $key,
                                    'type' => 'Customer',
                                    'isCreate' => $isUpdate,
                                    'errors' => $validateResult["errors"],
                                ]);
                            } else {

                                $modelC->fill($attributesSet);
                                $success = $modelC->save();
                                $customer_id = $modelC->id;
                                $lodgingByCustomer = $attributes["LodgingByCustomer"];
                                $modelCBI = CustomerByInformation::find($lodgingByCustomer["customer_by_information_id"]);
                                $attributesSet = array(
                                    "customer_id" => $customer_id,
                                    "people_nationality_id" => $lodgingByCustomer["people_nationality_id"],
                                    "people_profession_id" => $lodgingByCustomer["people_profession_id"],
                                );
                                $validateResult = CustomerByInformation::validateModel($attributesSet);
                                $success = $validateResult["success"];
                                if (!$success) {
                                    $typeManagerCurrent = "Guardar";
                                    if (!$createUpdate) {
                                        $typeManagerCurrent = "Actualizar";
                                    }
                                    $msj = "Problemas al $typeManagerCurrent Informacion Adicional";
                                    array_push($errors, $validateResult["errors"]);

                                    array_push($errorsCustomers, [
                                        'key' => $key,
                                        'type' => 'CustomerByInformation',
                                        'isCreate' => $isUpdate,
                                        'errors' => $validateResult["errors"],
                                    ]);
                                } else {
                                    $modelCBI->fill($attributesSet);
                                    $success = $modelCBI->save();
                                    $modelLBC = new LodgingByCustomer();
                                    $has_information_additional = $lodgingByCustomer["has_information_additional"];
                                    $attributesSet = array(
                                        "main" => $lodgingByCustomer["main"],
                                        "lodging_id" => $lodging_id,
                                        "has_information_additional" => $has_information_additional,
                                        "customer_id" => $customer_id,

                                    );
                                    $validateResult = LodgingByCustomer::validateModel($attributesSet);
                                    $success = $validateResult["success"];
                                    if (!$success) {
                                        $typeManagerCurrent = "Guardar";
                                        if (!$createUpdate) {
                                            $typeManagerCurrent = "Actualizar";
                                        }
                                        $msj = "Problemas al $typeManagerCurrent Lodging By Customer";
                                        array_push($errors, $validateResult["errors"]);
                                        array_push($errorsCustomers, [
                                            'key' => $key,
                                            'type' => 'LodgingByCustomer',
                                            'isCreate' => $isUpdate,
                                            'errors' => $validateResult["errors"],
                                        ]);

                                    } else {
                                        $modelLBC->fill($attributesSet);
                                        $success = $modelLBC->save();
                                        $lodging_by_customer_id = $modelLBC->id;


                                        if ($has_information_additional == 1) {

                                            $lodgingCustomerAdditionalInformation = $lodgingByCustomer["LodgingCustomerAdditionalInformation"];
                                            $modelIM = new InformationMail();

                                            if (isset($lodgingCustomerAdditionalInformation["information_mail_id"])) {
                                                $modelIM = InformationMail::find($lodgingCustomerAdditionalInformation["information_mail_id"]);
                                            }
                                            $attributesSet = array(
                                                "value" => $lodgingCustomerAdditionalInformation["mail"],
                                                "state" => InformationMail::STATE_ACTIVE,
                                                "entity_id" => $customer_id,
                                                "main" => InformationMail::MAIN,
                                                "entity_type" => InformationMail::ENTITY_TYPE_CUSTOMER,
                                                "information_mail_type_id" => InformationMail::INFORMATION_TYPE_WITHOUT_SPECIFIC
                                            );


                                            $currentModel = $modelIM;
                                            $paramsValidateCurrent = array('fillAble' => $currentModel->getfillable(), 'haystack' => $attributesSet, 'attributesData' => $currentModel->getAttributesData());
                                            $attributesSet = $modelIM::getValuesModel($paramsValidateCurrent);
                                            $paramsValidate = array(
                                                'inputs' => $attributesSet,
                                                'rules' => $currentModel::getRulesModel(),

                                            );
                                            $validateResult = $currentModel::validateModel($paramsValidate);
                                            $success = $validateResult["success"];
                                            if (!$success) {
                                                $typeManagerCurrent = "Guardar";
                                                if (!$createUpdate) {
                                                    $typeManagerCurrent = "Actualizar";
                                                }
                                                $msj = "Problemas al $typeManagerCurrent Mail";
                                                array_push($errors, $validateResult["errors"]);
                                                array_push($errorsCustomers, [
                                                    'key' => $key,
                                                    'type' => 'InformationMail',
                                                    'isCreate' => $isUpdate,
                                                    'errors' => $validateResult["errors"],
                                                ]);

                                            } else {

                                                $modelIM->fill($attributesSet);
                                                $success = $modelIM->save();
                                                $information_mail_id = $modelIM->id;
                                                $modelLCAI = new LodgingCustomerAdditionalInformation();

                                                //MOBILE
                                                $information_phone_id = $lodgingCustomerAdditionalInformation["information_phone_id"] == '' ? null : $lodgingCustomerAdditionalInformation["information_phone_id"];
                                                $information_mobile_id = $lodgingCustomerAdditionalInformation["information_mobile_id"] == '' ? null : $lodgingCustomerAdditionalInformation["information_mobile_id"];

                                                //PHONE
                                                $phoneAdd = $lodgingCustomerAdditionalInformation["phone"] != '' ? true : false;
                                                if ($phoneAdd) {
                                                    $valueSet = $lodgingCustomerAdditionalInformation["phone"];
                                                    $modelPhone1 = new InformationPhone();
                                                    if (!$createUpdate) {
                                                        if (isset($lodgingCustomerAdditionalInformation["information_phone_id"]) && $lodgingCustomerAdditionalInformation["information_phone_id"]) {
                                                            $modelPhone1 = InformationPhone::find($lodgingCustomerAdditionalInformation["information_phone_id"]);
                                                        }

                                                    }
                                                    $attributesSet = array(
                                                        "value" => $valueSet,
                                                        "state" => InformationPhone::STATE_ACTIVE,
                                                        "entity_id" => $customer_id,
                                                        "main" => InformationPhone::MAIN,
                                                        "entity_type" => InformationPhone::ENTITY_TYPE_CUSTOMER,
                                                        "information_phone_type_id" => InformationPhoneType::TYPE_HOUSE_ID,
                                                        "information_phone_operator_id" => InformationPhoneOperator::OPERATOR_NOT_SPECIFIC_ID,
                                                    );

                                                    $currentModel = $modelPhone1;
                                                    $paramsValidateCurrent = array('fillAble' => $currentModel->getfillable(), 'haystack' => $attributesSet, 'attributesData' => $currentModel->getAttributesData());
                                                    $attributesSet = $modelIM::getValuesModel($paramsValidateCurrent);
                                                    $paramsValidate = array(
                                                        'inputs' => $attributesSet,
                                                        'rules' => $currentModel::getRulesModel(),

                                                    );
                                                    $validateResult = $currentModel::validateModel($paramsValidate);
                                                    $success = $validateResult["success"];
                                                    if (!$success) {
                                                        $typeManagerCurrent = "Guardar";
                                                        if (!$createUpdate) {
                                                            $typeManagerCurrent = "Actualizar";
                                                        }
                                                        $msj = "Problemas al $typeManagerCurrent Phone House";
                                                        array_push($errors, $validateResult["errors"]);
                                                        array_push($errorsCustomers, [
                                                            'key' => $key,
                                                            'type' => 'InformationPhone Phone',
                                                            'isCreate' => $isUpdate,
                                                            'errors' => $validateResult["errors"],
                                                        ]);

                                                    } else {
                                                        $modelPhone1->fill($attributesSet);
                                                        $success = $modelPhone1->save();
                                                        $information_phone_id = $modelPhone1->id;
                                                    }
                                                }

                                                $mobileAdd = $lodgingCustomerAdditionalInformation["mobile"] != '' ? true : false;
                                                if ($mobileAdd) {
                                                    $valueSet = $lodgingCustomerAdditionalInformation["mobile"];
                                                    $modelPhone1 = new InformationPhone();
                                                    if (!$createUpdate) {
                                                        if (isset($lodgingCustomerAdditionalInformation["information_mobile_id"]) && $lodgingCustomerAdditionalInformation["information_mobile_id"]) {
                                                            $modelPhone1 = InformationPhone::find($lodgingCustomerAdditionalInformation["information_mobile_id"]);
                                                        }

                                                    }
                                                    $attributesSet = array(
                                                        "value" => $valueSet,
                                                        "state" => InformationPhone::STATE_ACTIVE,
                                                        "entity_id" => $customer_id,
                                                        "main" => InformationPhone::MAIN,
                                                        "entity_type" => InformationPhone::ENTITY_TYPE_CUSTOMER,
                                                        "information_phone_type_id" => InformationPhoneType::TYPE_WORKFORCE_ID,
                                                        "information_phone_operator_id" => InformationPhoneOperator::OPERATOR_NOT_SPECIFIC_ID,
                                                    );

                                                    $currentModel = $modelPhone1;
                                                    $paramsValidateCurrent = array('fillAble' => $currentModel->getfillable(), 'haystack' => $attributesSet, 'attributesData' => $currentModel->getAttributesData());
                                                    $attributesSet = $modelIM::getValuesModel($paramsValidateCurrent);
                                                    $paramsValidate = array(
                                                        'inputs' => $attributesSet,
                                                        'rules' => $currentModel::getRulesModel(),

                                                    );
                                                    $validateResult = $currentModel::validateModel($paramsValidate);
                                                    $success = $validateResult["success"];
                                                    if (!$success) {
                                                        $typeManagerCurrent = "Guardar";
                                                        if (!$createUpdate) {
                                                            $typeManagerCurrent = "Actualizar";
                                                        }
                                                        $msj = "Problemas al $typeManagerCurrent Phone Personal";
                                                        array_push($errors, $validateResult["errors"]);
                                                        array_push($errorsCustomers, [
                                                            'key' => $key,
                                                            'type' => 'InformationPhone Movile',
                                                            'isCreate' => $isUpdate,
                                                            'errors' => $validateResult["errors"],
                                                        ]);

                                                    } else {
                                                        $modelPhone1->fill($attributesSet);
                                                        $success = $modelPhone1->save();
                                                        $information_mobile_id = $modelPhone1->id;
                                                    }
                                                }


                                                $attributesSet = array(
                                                    "information_phone_id" => $information_phone_id,
                                                    "information_mobile_id" => $information_mobile_id,
                                                    "information_mail_id" => $information_mail_id,
                                                    "postal_code" => $lodgingCustomerAdditionalInformation["postal_code"],
                                                    "lodging_by_customer_id" => $lodging_by_customer_id,
                                                );
                                                $validateResult = LodgingCustomerAdditionalInformation::validateModel($attributesSet);
                                                $success = $validateResult["success"];
                                                if (!$success) {
                                                    $typeManagerCurrent = "Guardar";
                                                    if (!$createUpdate) {
                                                        $typeManagerCurrent = "Actualizar";
                                                    }
                                                    $msj = "Problemas al $typeManagerCurrent LodgingCustomerAdditionalInformation";
                                                    array_push($errors, $validateResult["errors"]);
                                                    array_push($errorsCustomers, [
                                                        'key' => $key,
                                                        'type' => 'LodgingCustomerAdditionalInformation',
                                                        'isCreate' => $isUpdate,
                                                        'errors' => $validateResult["errors"],
                                                    ]);
                                                } else {
                                                    $modelLCAI->fill($attributesSet);
                                                    $success = $modelLCAI->save();
                                                }

                                                $lodgingByCustomerLocation = $lodgingByCustomer["LodgingByCustomerLocation"];
                                                $modelIALC = InformationAddress::find($lodgingByCustomerLocation["information_address_location_current_id"]);
                                                $attributesSet = array(
                                                    "country_code_id" => $lodgingByCustomerLocation["country_code_id"],
                                                    "administrative_area_level_2" => $lodgingByCustomerLocation["administrative_area_level_2"] == "" ? "any-information" : $lodgingByCustomerLocation["administrative_area_level_2"],
                                                    "administrative_area_level_1" => isset($lodgingByCustomerLocation["administrative_area_level_1"]) ? $lodgingByCustomerLocation["administrative_area_level_1"] : "",
                                                    "administrative_area_level_3" => isset($lodgingByCustomerLocation["administrative_area_level_3"]) ? $lodgingByCustomerLocation["administrative_area_level_3"] : "",
                                                    "options_map" => isset($lodgingByCustomerLocation["options_map"]) ? $lodgingByCustomerLocation["options_map"] : "",
                                                    "entity_id" => $customer_id,
                                                    "entity_type" => 0,
                                                    'has_location' => 1,
                                                    'information_address_type_id' => InformationAddressType::TYPE_HOME,
                                                    'main' => 1,
                                                    'street_one' => 'Not Street',
                                                    'street_two' => 'Not Street',
                                                    'reference' => 'Not Reference',
                                                    'state' => 'ACTIVE'
                                                );
                                                $currentModel = $modelIALC;
                                                $paramsValidateCurrent = array('fillAble' => $currentModel->getfillable(), 'haystack' => $attributesSet, 'attributesData' => $currentModel->getAttributesData());
                                                $attributesSet = $modelIM::getValuesModel($paramsValidateCurrent);
                                                $paramsValidate = array(
                                                    'inputs' => $attributesSet,
                                                    'rules' => $currentModel::getRulesModel(),

                                                );
                                                $validateResult = $currentModel::validateModel($paramsValidate);
                                                $success = $validateResult["success"];
                                                if (!$success) {
                                                    $typeManagerCurrent = "Guardar";
                                                    if (!$createUpdate) {
                                                        $typeManagerCurrent = "Actualizar";
                                                    }
                                                    $msj = "Problemas al $typeManagerCurrent InformationAddress";
                                                    array_push($errors, $validateResult["errors"]);

                                                    array_push($errorsCustomers, [
                                                        'key' => $key,
                                                        'type' => 'InformationAddress',
                                                        'isCreate' => $isUpdate,
                                                        'errors' => $validateResult["errors"],
                                                    ]);
                                                } else {
                                                    $modelIALC->fill($attributesSet);
                                                    $success = $modelIALC->save();
                                                    $information_address_id = $modelIALC->id;
                                                    $modelLBCL = new LodgingByCustomerLocation();
                                                    $attributesSet = array(
                                                        "information_address_id" => $information_address_id,
                                                        "lodging_by_customer_id" => $lodging_by_customer_id,
                                                    );
                                                    $validateResult = LodgingByCustomerLocation::validateModel($attributesSet);
                                                    $success = $validateResult["success"];
                                                    if (!$success) {
                                                        $typeManagerCurrent = "Guardar";
                                                        if (!$createUpdate) {
                                                            $typeManagerCurrent = "Actualizar";
                                                        }
                                                        $msj = "Problemas al $typeManagerCurrent LodgingByCustomerLocation";
                                                        array_push($errors, $validateResult["errors"]);

                                                        array_push($errorsCustomers, [
                                                            'key' => $key,
                                                            'type' => 'LodgingByCustomerLocation',
                                                            'isCreate' => $isUpdate,
                                                            'errors' => $validateResult["errors"],
                                                        ]);
                                                    } else {
                                                        $modelLBCL->fill($attributesSet);
                                                        $success = $modelLBCL->save();
                                                    }
                                                }
                                            }


                                        } else {

                                            $modelLCAI = LodgingCustomerAdditionalInformation::getModelByLodgingByCustomerId($lodging_by_customer_id);
                                            if ($modelLCAI) {
                                                LodgingCustomerAdditionalInformation::destroy($modelLCAI->id);

                                            }
                                            $modelLBCL = LodgingByCustomerLocation::getModelByLodgingByCustomerId($lodging_by_customer_id);

                                            if ($modelLBCL) {
                                                LodgingByCustomerLocation::destroy($modelLBCL->id);
                                                InformationAddress::destroy($modelLBCL->information_address_id);

                                            }

                                        }
                                    }

                                }


                            }

                        }
                    }


                }


            } else {
                $success = false;
                $msj = "Problemas al guardar Lodging.";
                array_push($errors, $validateResult["errors"]);

            }
            $success = count($errors) == 0;
            if (!$success) {
                DB::rollBack();

            } else {
                DB::commit();
            }
            $result = [
                "errors" => $errors,
                'errorsCustomers' => $errorsCustomers,
                "msj" => $msj,
                "success" => $success,
            ];

            return ($result);
        } catch (Exception $e) {
            $msj = $e->getMessage();
            $result = array(
                "success" => false,
                "msj" => $msj,
                "errors" => $errors
            );
            DB::rollBack();
            return ($result);
        }
    }

    public function delivery($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        DB::beginTransaction();
        try {

            $id = $attributesPost['lodging_id'];
            $lodging_id = $id;
            $model = Lodging::find($id);
            $model->status_delivery = 1;
            if (!$model->output_at) {//cuando ya s asigno la fecha d salida :s
                $model->output_at = Util::DateCurrent();
            }
            $model->delivery_date = Util::DateCurrent();

            $success = $model->save();
            if (!$success) {
                $errors = [];
                $msj = "No se pudo realizar la entrega delas habitaciones";

            } else {
                $lodgingByTypeOfRoom = $attributesPost["LodgingByTypeOfRoom"];

                foreach ($lodgingByTypeOfRoom as $attributes) {
                    $lodging_type_of_room_by_price = $attributes["lodging_type_of_room_by_price_id"];
                    $modelLTORBP = LodgingTypeOfRoomByPrice::find($lodging_type_of_room_by_price);
                    $modelLTORBP->status = LodgingTypeOfRoomByPrice::STATUS_CLEANING;
                    $success = $modelLTORBP->save();
                    if (!$success) {
                        $msj = "Problemas al Actualizar estado Room";
                        $errors = array();
                        break;
                    }


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
                "success" => $success,
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

    public function results($params)
    {
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        $dateInit = $attributesPost["Lodging"]["date_init"];
        $dateEnd = $attributesPost["Lodging"]["date_end"];
        $business_id = $attributesPost["Lodging"]["business_id"];

        $dateInitManager = Util::FormatDate($dateInit, "Y-m-d 00:00:00");
        $dateEndManager = Util::FormatDate($dateEnd, "Y-m-d 23:59:59");
        $formatGroup = Util::formatGroup($dateInitManager, $dateEndManager);
        $success = true;
        $successResults = true;
        $dataResults = $this->managerResults(array(
            "filters" => array(
                "business_id" => $business_id,
                "dateInit" => $dateInit,
                "dateEnd" => $dateEnd,
                "formatGroup" => $formatGroup
            )

        ));
        $managerCategories = array();
        $dataManager = array();

        if (count($dataResults) == 0) {
            $successResults = false;
        } else {
            $successResults = true;
            $managerCategories = Util::getCategoriesByDates(array("endDateManager" => $dateEndManager, "initDateManager" => $dateInitManager));
//Classification data Categories of results
            $categories = $managerCategories["categories"];
            $categoriesDataManager = array();
            $haystack = $dataResults;
            $categoriesReport = array();
            foreach ($categories as $key => $category) {
                $dateCompare = $category["dateCompare"];
                $keyCompare = "entry_at_needle";
                $searchResult = Util::searchInArray(array("haystack" => $haystack, "needle" => $dateCompare, "keyCompare" => $keyCompare, 'all' => true));

                $categoryNeedle = $category;

                $categoryNeedle["data"] = $searchResult;


                array_push($categoriesDataManager, $categoryNeedle);
                array_push($categoriesReport, $category["category"]);
            }

            //Income Values
            $incomeDataLodging = array();
            //Income Values Type Payments Values
            $typePayments = array();
            $typePaymentsDataManager = array();
            //Income Values Type Payments Values
            $typeArrived = array();
            $typeArrivedDataManager = array();
            $totalIncomeTypePaymentData = array();

            $incomeArrivedDataLodging = array();
            $totalIncomeArrivedData = array();
            //Income People Values
            $people = array();
            $ages = array();
            $genders = array();
            $rooms = array();
            $incomeTypesPaymentDataLodging = array();
            //Reasons
            $typeArrivedReasons = array();
            $typeArrivedReasonsDataManager = array();
            $incomeArrivedReasonsDataLodging = array();
            $totalIncomeArrivedReasonsData = array();

            /*Gender*/
            $genderMan = array();
            $genderFemale = array();
            $genderLGBTI = array();
            $genderOthers = array();
            /*COUNTRIES*/
            $typeCountries = array();
            $typeCountriesDataManager = array();
            $incomeCountriesDataLodging = array();
            foreach ($categoriesDataManager as $key => $category) {
                $data = $category["data"];

                $sumIncome = 0;
                $sumIncomePeople = 0;
                $sumIncomeAges = 0;

                $sumIncomeGenderMan = 0;
                $sumIncomeGenderFemale = 0;
                $sumIncomeGenderLGBTI = 0;
                $sumIncomeGenderOthers = 0;

                $sumIncomeRooms = 0;
                if (!count($data) == 0) {

                    foreach ($data as $keyData => $valueCategory) {

                        $peopleData = $valueCategory["People"];

                        foreach ($peopleData as $keyPeople => $valuePeople) {
                            $people_nationality_text = $valuePeople["people_nationality_text"];
                            if (!in_array($people_nationality_text, $typeCountries)) {
                                array_push($typeCountries, $people_nationality_text);
                                array_push($typeCountriesDataManager, $category);
                            }
                            $gender = $valuePeople["gender"];
                            if ($gender == 0) {
                                $sumIncomeGenderMan++;
                            } else if ($gender == 1) {
                                $sumIncomeGenderFemale++;
                            } else if ($gender == 2) {
                                $sumIncomeGenderLGBTI++;
                            } else if ($gender == 3) {
                                $sumIncomeGenderOthers++;
                            }
                        }

                        $sumIncome += $valueCategory["total_value"];
                        $sumIncomePeople += $valueCategory["number_people"];
                        $sumIncomeRooms += $valueCategory["number_rooms"];
                        $arrived_made = $valueCategory["arrived_made"];
                        if ($arrived_made == 1) {
                            $LodgingByReasons = $valueCategory["LodgingByReasons"];
                            $reason_text = $LodgingByReasons["reason"];
                            if (!in_array($reason_text, $typeArrivedReasons)) {
                                array_push($typeArrivedReasons, $reason_text);
                                array_push($typeArrivedReasonsDataManager, $category);
                            }
                        }
                        //Classification Payments
                        if (isset($valueCategory["LodgingByPayment"]) || isset($valueCategory["LodgingByArrived"])) {
                            if (isset($valueCategory["LodgingByArrived"])) {
                                //Classification Arrived
                                $typeArrivedData = $valueCategory["LodgingByArrived"];
                                $needleTypeArrived = $typeArrivedData["way_to_contact_text"];
                                if (!in_array($needleTypeArrived, $typeArrived)) {
                                    array_push($typeArrived, $needleTypeArrived);
                                    array_push($typeArrivedDataManager, $category);
                                }
                            }
                            if (isset($valueCategory["LodgingByPayment"])) {
                                $typePaymentsData = $valueCategory["LodgingByPayment"];
                                foreach ($typePaymentsData as $keyDataTypePayment => $value) {
                                    $needleTypePayments = $value["way_to_pay_text"];
                                    if (!in_array($needleTypePayments, $typePayments)) {
                                        array_push($typePayments, $needleTypePayments);
                                        array_push($typePaymentsDataManager, $category);
                                    }
                                }
                            }
                        }


                    }
                }
                array_push($incomeDataLodging, $sumIncome);
                array_push($people, $sumIncomePeople);
                array_push($rooms, $sumIncomeRooms);
                array_push($ages, $sumIncomeAges);
                array_push($genderMan, $sumIncomeGenderMan);
                array_push($genderFemale, $sumIncomeGenderFemale);
                array_push($genderLGBTI, $sumIncomeGenderLGBTI);
                array_push($genderOthers, $sumIncomeGenderOthers);

            }

            foreach ($typePayments as $key => $value) {
                $color = "";
                $data = array();
                foreach ($categoriesDataManager as $key => $category) {
                    $dateCompare = $category["dateCompare"];
                    $keyCompare = "dateCompare";
                    $searchResult = Util::searchInArray(array("haystack" => $typePaymentsDataManager, "needle" => $dateCompare, "keyCompare" => $keyCompare, 'all' => true));

                    $sumTotal = 0;
                    if (count($searchResult) == 0) {
                        $sumTotal = 0;
                    } else {
                        $dataResultsManager = $category["data"];
                        foreach ($dataResultsManager as $keyValues => $valueLodging) {
                            if (isset($valueLodging["LodgingByPayment"])) {
                                $haystack = $valueLodging["LodgingByPayment"];
                                foreach ($haystack as $keySearch => $valueSearch) {
                                    if ($valueSearch["way_to_pay_text"] == $value) {
                                        $sumTotal++;

                                    }
                                }
                            }
                        }

                    }

                    array_push($data, $sumTotal);
                }

                if (LodgingByPayment::wayToPayCashText == $value) {
                    $color = "#31d698";

                } else if (LodgingByPayment::wayToPayCreditCardsText == $value) {
                    $color = "#d6b907";

                } else if (LodgingByPayment::wayToPayPaymentDocumentsText == $value) {
                    $color = "#cfd683";

                }

                array_push($incomeTypesPaymentDataLodging, array("type" => "column", "name" => $value, "color" => $color, "data" => $data));
            }

            foreach ($incomeTypesPaymentDataLodging as $key => $value) {
                $name = $value["name"];
                $color = $value["color"];
                $data = $value["data"];
                $total = 0;
                foreach ($data as $key2 => $value2) {
                    $total += $value2;
                }
                array_push($totalIncomeTypePaymentData, array("name" => $name, "color" => $color, "y" => $total));
            }

            array_push($incomeTypesPaymentDataLodging, array(
                "type" => "pie",
                "name" => "Total Pagos",
                "data" => $totalIncomeTypePaymentData,
                "center" => array(100, 80),
                "size" => 100,
                "showInLegend" => false,
                "dataLabels" => array("enabled" => false),

            ));


            /*  ARRIVED*/
            foreach ($typeArrived as $key => $value) {
                $color = "";
                $data = array();
                foreach ($categoriesDataManager as $key => $category) {
                    $dateCompare = $category["dateCompare"];
                    $keyCompare = "dateCompare";
                    $searchResult = Util::searchInArray(array("haystack" => $typeArrivedDataManager, "needle" => $dateCompare, "keyCompare" => $keyCompare, 'all' => true));

                    $sumTotal = 0;
                    if (count($searchResult) == 0) {
                        $sumTotal = 0;
                    } else {
                        $dataResultsManager = $category["data"];
                        foreach ($dataResultsManager as $keyValues => $valueLodging) {
                            if (isset($valueLodging["LodgingByArrived"])) {
                                $haystack = $valueLodging["LodgingByArrived"];
                                if ($haystack["way_to_contact_text"] == $value) {
                                    $sumTotal++;
                                }

                            }
                        }

                    }

                    array_push($data, $sumTotal);
                }

                if (LodgingByArrived::wayToContactOthersText == $value) {
                    $color = "#e3b01f";

                } else if (LodgingByArrived::wayToContactNewsPaperText == $value) {
                    $color = "#9f7809";

                } else if (LodgingByArrived::wayToContactNetworkSocialText == $value) {
                    $color = "#5d4603";

                } else if (LodgingByArrived::wayToContactRecommendationsText == $value) {
                    $color = "#f9bd0d";

                }
                array_push($incomeArrivedDataLodging, array("type" => "column", "name" => $value, "color" => $color, "data" => $data));
            }

            foreach ($incomeArrivedDataLodging as $key => $value) {
                $name = $value["name"];
                $color = $value["color"];
                $data = $value["data"];
                $total = 0;
                foreach ($data as $key2 => $value2) {
                    $total += $value2;
                }
                array_push($totalIncomeArrivedData, array("name" => $name, "color" => $color, "y" => $total));
            }
            array_push($incomeArrivedDataLodging, array(
                "type" => "pie",
                "name" => "Total",
                "data" => $totalIncomeArrivedData,
                "center" => array(100, 80),
                "size" => 100,
                "showInLegend" => false,
                "dataLabels" => array("enabled" => false),

            ));
            /*  ARRIVED REASONS*/
            foreach ($typeArrivedReasons as $key => $value) {
                $color = "";
                $data = array();
                foreach ($categoriesDataManager as $key => $category) {
                    $dateCompare = $category["dateCompare"];
                    $keyCompare = "dateCompare";
                    $searchResult = Util::searchInArray(array("haystack" => $typeArrivedReasonsDataManager, "needle" => $dateCompare, "keyCompare" => $keyCompare, 'all' => true));

                    $sumTotal = 0;
                    if (count($searchResult) == 0) {
                        $sumTotal = 0;
                    } else {
                        $dataResultsManager = $category["data"];
                        foreach ($dataResultsManager as $keyValues => $valueLodging) {
                            if (isset($valueLodging["LodgingByReasons"])) {
                                $haystack = $valueLodging["LodgingByReasons"];
                                if ($haystack["reason"] == $value) {
                                    $sumTotal++;
                                }

                            }
                        }

                    }

                    array_push($data, $sumTotal);
                }

                if (LodgingByReasons::reasonTypeJobText == $value) {
                    $color = "#e3b01f";

                } else if (LodgingByReasons::reasonTypeHolidayText == $value) {
                    $color = "#9f7809";

                } else if (LodgingByReasons::reasonTypeSpendTheNightText == $value) {
                    $color = "#5d4603";

                } else if (LodgingByReasons::reasonTypeOthersText == $value) {
                    $color = "#f9bd0d";

                } else if (LodgingByReasons::reasonTypeUnspecifiedText == $value) {
                    $color = "#f9bd0d";

                }
                array_push($incomeArrivedReasonsDataLodging, array("type" => "column", "name" => $value, "color" => $color, "data" => $data));
            }


            foreach ($incomeArrivedReasonsDataLodging as $key => $value) {
                $name = $value["name"];
                $color = $value["color"];
                $data = $value["data"];
                $total = 0;
                foreach ($data as $key2 => $value2) {
                    $total += $value2;
                }
                array_push($totalIncomeArrivedReasonsData, array("name" => $name, "color" => $color, "y" => $total));
            }
            array_push($incomeArrivedReasonsDataLodging, array(
                "type" => "pie",
                "name" => "Total Razones",
                "data" => $totalIncomeArrivedReasonsData,
                "center" => array(100, 80),
                "size" => 100,
                "showInLegend" => false,
                "dataLabels" => array("enabled" => false),

            ));
            $incomePeopleDataLodging = array(
                "people" => $people,
                "rooms" => $rooms,
                "genders" => array(
                    "man" => $genderMan,
                    "female" => $genderFemale,
                    "lgbti" => $genderLGBTI,
                    "others" => $genderOthers,

                )
            );

            foreach ($typeCountries as $key => $value) {
                $color = "";
                $data = array();
                foreach ($categoriesDataManager as $key => $category) {
                    $dateCompare = $category["dateCompare"];
                    $keyCompare = "dateCompare";
                    $searchResult = Util::searchInArray(array("haystack" => $typeCountriesDataManager, "needle" => $dateCompare, "keyCompare" => $keyCompare, 'all' => true));

                    $sumTotal = 0;
                    if (count($searchResult) == 0) {
                        $sumTotal = 0;
                    } else {
                        $dataResultsManager = $category["data"];
                        foreach ($dataResultsManager as $keyValues => $valueLodging) {
                            $people = $valueLodging["People"];
                            foreach ($people as $keyPeople => $valuePeople) {
                                $haystack = $valuePeople;
                                if ($haystack["people_nationality_text"] == $value) {
                                    $sumTotal++;
                                }
                            }
                        }

                    }

                    array_push($data, $sumTotal);
                }
                array_push($incomeCountriesDataLodging, array("type" => "column", "name" => $value, "data" => $data));
            }

            $dataManager = array(
                "incomePeopleDataLodging" => $incomePeopleDataLodging,
                "incomePeopleCountriesDataLodging" => array("series" => $incomeCountriesDataLodging, "view" => count($typeCountries) == 0 ? false : true),
                "incomeDataLodging" => $incomeDataLodging,
                "incomeTypesPaymentDataLodging" => array("series" => $incomeTypesPaymentDataLodging, "view" => count($typePayments) == 0 ? false : true),
                "incomeArrivedDataLodging" => array("series" => $incomeArrivedDataLodging, "view" => count($typeArrived) == 0 ? false : true),
                "incomeArrivedReasonsDataLodging" => array("series" => $incomeArrivedReasonsDataLodging, "view" => count($typeArrivedReasons) == 0 ? false : true),
                "categoriesDataManager" => $categoriesDataManager,
                "categories" => $categoriesReport,
                "typeArrived" => $typeArrived,
                "typeArrivedDataManager" => $typeArrivedDataManager,
                "typePayments" => $typePayments,
                "typePaymentsDataManager" => $typePaymentsDataManager,


            );
        }
        $result = array(
            "success" => $success,
            "successResults" => $successResults,
            "dateInitManager" => $dateInitManager,
            "dateEndManager" => $dateEndManager,
            "formatGroup" => $formatGroup,
            "managerCategories" => $managerCategories,
            "dataResults" => $dataResults,
            "dataManager" => $dataManager
        );
        return $result;
    }

    public function getResults($params)
    {
        $sort = 'asc';
        $field = 'entry_at';
        $query = DB::table($this->table);

        $business_id = $params["filters"]["business_id"];
        $dateInit = $params["filters"]["dateInit"];
        $dateEnd = $params["filters"]["dateEnd"];

        $formatGroup = $params["filters"]["formatGroup"];

        $selectString = "$this->table.id ,$this->table.arrived_made  ,$this->table.rooms_add_made,DATE_FORMAT($this->table.entry_at,'$formatGroup') entry_at_needle,$this->table.entry_at,DATE_FORMAT($this->table.output_at,'$formatGroup') output_at,$this->table.number_people,$this->table.adults,$this->table.children,$this->table.number_rooms,$this->table.total_value,$this->table.payment_made,$this->table.created_at,$this->table.updated_at,$this->table.deleted_at,$this->table.description,$this->table.business_id,$this->table.status,$this->table.status_delivery,$this->table.delivery_date
        ";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->where("business_id", $business_id);

        $query->where($field, '>=', $dateInit);
        $query->where($field, '<=', $dateEnd);
        $query->orderBy("entry_at", $sort);

        $result = $query->get()->toArray();


        return $result;
    }

    public function managerResults($params)
    {
        $resultsLodging = $this->getResults($params);
        $modelLBP = new LodgingByPayment();
        $modelLBPCC = new  LodgingByPaymentCreditCard();
        $modelLBA = new LodgingByArrived();
        $modelLABSN = new  LodgingArrivedBySocialNetworks();
        $modelP = new People();
        $modelLBC = new LodgingByCustomer();
        $modelLCAI = new LodgingCustomerAdditionalInformation();
        $modelLBCL = new  LodgingByCustomerLocation();
        $modelLBTOR = new  LodgingByTypeOfRoom();
        $modelBBLBP = new BusinessByLodgingByPrice;
        $business_id = $params["filters"]["business_id"];
        $modelLBR = new LodgingByReasons();

        foreach ($resultsLodging as $key => $row) {


            $lodging_id = $row->id;
            $payment_made = $row->payment_made;
            $arrived_made = $row->arrived_made;

            $setPush = json_decode(json_encode($row), true);
            $resultsLodging[$key] = $setPush;
            /* LodgingByPayment*/
            if ($payment_made == 1) {
                $lodgingByPayment = $modelLBP->getPayments(array("lodging_id" => $lodging_id));
                foreach ($lodgingByPayment as $keyLBP => $rowLBP) {
                    $lodging_by_payment_id = $rowLBP->lodging_by_payment_id;
                    $setPush = json_decode(json_encode($rowLBP), true);
                    $lodgingByPayment[$keyLBP] = $setPush;
                    if ($rowLBP->way_to_pay == $modelLBP::wayToPayCreditCards) {
                        $lodgingByPaymentCreditCard = $modelLBPCC->getPaymentsOfCreditCards(array("lodging_by_payment_id" => $lodging_by_payment_id));
                        $lodgingByPayment[$keyLBP]["LodgingByPaymentCreditCard"] = $lodgingByPaymentCreditCard;
                    }
                }
                $resultsLodging[$key]["LodgingByPayment"] = $lodgingByPayment;
            }
            /* SOCIAL NETWORKS*/
            if ($arrived_made == 1) {
                $dataCurrent = array();
                $dataArrived = $modelLBA->getArrived(array("lodging_id" => $lodging_id));
                $lodging_by_arrived_id = $dataArrived->lodging_by_arrived_id;

                $dataCurrent = array(
                    "lodging_by_arrived_id" => $dataArrived->lodging_by_arrived_id,
                    "lodging_id" => $dataArrived->lodging_id,
                    "way_to_contact" => $dataArrived->way_to_contact,
                    "way_to_contact_text" => $dataArrived->way_to_contact_text,

                );

                if ($dataArrived->way_to_contact == $modelLBA::wayToContactNetworkSocial) {
                    $lodgingArrivedBySocialNetworks = $modelLABSN->getSocialNetworksOfLodgingArrived(array("lodging_by_arrived_id" => $lodging_by_arrived_id));
                    $dataCurrent["LodgingArrivedBySocialNetworks"] = $lodgingArrivedBySocialNetworks;
                }

                $resultsLodging[$key]["LodgingByArrived"] = $dataCurrent;

                $LodgingByReasons = $modelLBR->getReasonByArrived(array("lodging_id" => $lodging_id));
                $resultsLodging[$key]["LodgingByReasons"] = array(
                    "lodging_by_reasons_id" => $LodgingByReasons->lodging_by_reasons_id,
                    "lodging_id" => $LodgingByReasons->lodging_id,
                    "reason" => $LodgingByReasons->reason_text,
                );
            }
            /*People*/
            $customersData = $modelLBC->getLodgingCustomers(array("lodging_id" => $lodging_id));
            $People = array();
            foreach ($customersData as $keyC => $rowC) {
                $last_name = $rowC->last_name;
                $name = $rowC->name;
                $type_document = $rowC->type_document;
                $document_number = $rowC->document_number;
                $age = $rowC->age;
                $gender = $rowC->gender;
                $people_id = $rowC->people_id;
                $has_information_additional = $rowC->has_information_additional;
                $lodging_by_customer_id = $rowC->lodging_by_customer_id;
                $setPushData = array(
                    "people_id" => $people_id,
                    "last_name" => $last_name,
                    "name" => $name,
                    "type_document" => $type_document,
                    "document_number" => $document_number,
                    "age" => $age,
                    "gender" => $gender,
                    //LodgingByCustomer
                    "lodging_by_customer_id" => $lodging_by_customer_id,
                    "main" => $rowC->main,
                    "has_information_additional" => $rowC->has_information_additional,
                    "people_nationality_id" => $rowC->people_nationality_id,
                    "people_nationality_text" => $rowC->people_nationality_text,
                    "people_profession_id" => $rowC->people_profession_id,
                    "people_profession_text" => $rowC->people_profession_text


                );

                if ($has_information_additional == 1) {


                    $lodgingCustomerAdditionalInformation = $modelLCAI->getLodgingCustomerInformation(array(
                        "lodging_by_customer_id" => $lodging_by_customer_id));

                    $setPushData["phone"] = $lodgingCustomerAdditionalInformation->phone;
                    $setPushData["mobile"] = $lodgingCustomerAdditionalInformation->mobile;
                    $setPushData["mail"] = $lodgingCustomerAdditionalInformation->mail;
                    $setPushData["information_mail_id"] = $lodgingCustomerAdditionalInformation->information_mail_id;
                    $setPushData["postal_code"] = $lodgingCustomerAdditionalInformation->postal_code;
                    $setPushData["lodging_customer_additional_information_id"] = $lodgingCustomerAdditionalInformation->lodging_customer_additional_information_id;
                    $lodgingByCustomerLocation = $modelLBCL->getLodgingCustomerLocation(array(
                        "lodging_by_customer_id" => $lodging_by_customer_id));
                    $setPushData["lodging_by_customer_location"] = array(
                        "information_address_location_current" => $lodgingByCustomerLocation->information_address_id,
                        "lodging_by_customer_location_id" => $lodgingByCustomerLocation->lodging_by_customer_location_id,
                        "country_code_id" => $lodgingByCustomerLocation->country_code_id,
                        "administrative_area_level_2" => $lodgingByCustomerLocation->administrative_area_level_2,
                        "administrative_area_level_1" => $lodgingByCustomerLocation->administrative_area_level_1,
                        "administrative_area_level_3" => $lodgingByCustomerLocation->administrative_area_level_3,
                        "options_map" => $lodgingByCustomerLocation->options_map,
                        "lodging_by_customer_id" => $lodgingByCustomerLocation->lodging_by_customer_id,


                    );
                }
                array_push($People, $setPushData);

            }
            $resultsLodging[$key]["People"] = $People;

            /*Rooms*/
            $LodgingByTypeOfRoom = $modelLBTOR->getRooms(array("lodging_id" => $lodging_id));
            $resultsLodging[$key]["LodgingByTypeOfRoom"] = $LodgingByTypeOfRoom;

            $lodgingTypeOfRoomByPriceData = $modelBBLBP->getRoomsDataByBusiness(array("business_id" => $business_id));
            $resultsLodging[$key]["lodgingTypeOfRoomByPriceData"] = $lodgingTypeOfRoomByPriceData;


        }

        return $resultsLodging;
    }

}
