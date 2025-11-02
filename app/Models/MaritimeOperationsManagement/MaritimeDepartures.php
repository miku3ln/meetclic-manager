<?php

namespace App\Models\MaritimeOperationsManagement;

use App\Models\Customer;
use App\Models\CustomerByInformation as CustomerByInformation;
use App\Models\InformationAddress as InformationAddress;
use App\Models\InformationPhone as InformationPhone;
use App\Models\ModelManager;

use App\Models\People as People;
use App\Models\PeopleNationality;
use App\Models\PeopleProfession;
use App\Models\PeopleTypeIdentification;
use App\Models\RucType;
use App\Utils\Util;
use Illuminate\Support\Facades\DB;

class MaritimeDepartures extends ModelManager
{


    const STATUS_DRAFT = 'DRAFT';
    const STATUS_CONFIRMED = 'CONFIRMED';
    const STATUS_DEPARTED = 'DEPARTED';
    const STATUS_CANCELLED = 'CANCELLED';
    public function customers()
    {
        return $this->hasMany(MaritimeDeparturesCustomers::class, 'maritime_departures_id');
    }
    protected $table = 'maritime_departures';
    protected $modelNameEntity = 'MaritimeDepartures';

    protected $fillable = array('business_id', "user_id", 'arrival_time', 'responsible_name', "status", "user_management_id");

    public $timestamps = true;

    public static function getRulesModel()
    {
        $rules = [
            "business_id" => "required",
            "user_id" => "required",
            "arrival_time" => "required",
            "responsible_name" => "required",
            "status" => "required"

        ];
        return $rules;
    }

    public function saveMaritimeDepartureApi($params)
    {
        DB::beginTransaction();
        try {
            $attributesPost = $params;
            $departureData = $attributesPost["MaritimeDepartures"];
            $customers = $attributesPost["Customers"];

            $departure = new MaritimeDepartures();
            $departure->business_id = $departureData["business_id"];
            $departure->user_id = $departureData["user_id"];
            //$departure->user_management_id = $departureData["user_management_id"];
            $departure->arrival_time = $departureData["arrival_time"];
            $departure->responsible_name = $departureData["responsible_name"];
            $departure->status = MaritimeDepartures::STATUS_DRAFT;
            $departure->save();

            foreach ($customers as $customerData) {

                // 1. Buscar si existe Customer por document_number
                $existingCustomer = Customer::where('identification_document', $customerData['document_number'])->first();
                $customerId = null;
                $peopleId = null;
                if ($existingCustomer) {
                    $customerId = $existingCustomer->id;
                    $peopleId = $existingCustomer->people_id;
                } else {

                    // 2. Actualizar/Crear la Persona (People)
                    $customerData['people_id'] = $peopleId; // Inyectamos el ID si ya existe
                    $peopleResult = $this->saveOrUpdatePerson($customerData);
                    if (!$peopleResult['success']) throw new \Exception($peopleResult['msj']);

                    // 3. Actualizar/Crear el Customer
                    $customerData['customer_id'] = $customerId; // Inyectamos el ID si ya existe
                    $customerResult = $this->saveOrUpdateCustomer($customerData, $peopleResult['data']['id']);
                    if (!$customerResult['success']) throw new \Exception($customerResult['msj']);

                    // 4. Información Adicional del Customer
                    $customerInfoResult = $this->saveOrUpdateCustomerInformation($customerData, $customerResult['data']['id']);
                    if (!$customerInfoResult['success']) throw new \Exception($customerInfoResult['msj']);

                    // 5. Dirección si aplica
                    if (isset($customerData['information_address_id'])) {
                        $addressResult = $this->saveOrUpdateAddress($customerData, $customerResult['data']['id']);
                        if (!$addressResult['success']) throw new \Exception($addressResult['msj']);
                    }

                    // 6. Teléfono si aplica
                    if (isset($customerData['information_phone_id'])) {
                        $phoneResult = $this->saveOrUpdatePhone($customerData, $customerResult['data']['id']);
                        if (!$phoneResult['success']) throw new \Exception($phoneResult['msj']);
                    }
                    $customerId= $customerResult['data']['id'];
                }
                // 7. Registrar en MaritimeDeparturesCustomers
                $departureCustomer = new MaritimeDeparturesCustomers();
                $departureCustomer->maritime_departures_id = $departure->id;
                $departureCustomer->type = $customerData['type'];
                $departureCustomer->age = $customerData['age'];
                $departureCustomer->customer_id =$customerId;
                $departureCustomer->save();
            }


            DB::commit();

            return [
                'success' => true,
                'message' => 'Registrados con Exito.',
                'data' =>[]
            ];

        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => $e->getMessage(),
                'errors' => []
            ];
        }
    }

    private function saveOrUpdatePerson($data)
    {
        $person = (isset($data['people_id']) && $data['people_id'] != 'null' && $data['people_id'] != '-1')
            ? People::find($data['people_id'])
            : new People();

        $attributes = [
            'last_name' => $data["last_name"],
            'name' => $data["name"],
            'type_document' => $data["people_type_identification_id"] ?? PeopleTypeIdentification::TYPE_IDENTIFICATION_OTHERS,
            'document_number' => $data["document_number"],
            'birthdate' => isset($data["birthdate"]) && !empty($data["birthdate"])
                ? \Carbon\Carbon::parse($data["birthdate"])->format('Y-m-d')
                : \Carbon\Carbon::now()->format('Y-m-d'),
            'age' => $data["age"] ?? 0,
            'gender' => $data["gender"] ?? 3,
        ];

        return $this->validateAndSaveModel($person, $attributes, 'Persona');
    }

    private function saveOrUpdateCustomer($data, $peopleId)
    {
        $customer = (isset($data['customer_id']) && $data['customer_id'] != 'null' && $data['customer_id'] != '-1')
            ? Customer::find($data['customer_id'])
            : new Customer();

        $attributes = [
            'identification_document' => $data["document_number"],
            'people_type_identification_id' => $data["people_type_identification_id"] ?? PeopleTypeIdentification::TYPE_IDENTIFICATION_OTHERS,
            'people_id' => $peopleId,
            'business_name' => $data["business_name"] ?? "",
            'business_reason' => $data["business_reason"] ?? "",
            'ruc_type_id' => $data["ruc_type_id"] ?? RucType::RUC_TYPE_ANY,
        ];

        return $this->validateAndSaveModel($customer, $attributes, 'Cliente');
    }

    private function saveOrUpdateCustomerInformation($data, $customerId)
    {
        $customerInfo = (isset($data['customer_by_information_id']) && $data['customer_by_information_id'] != 'null' && $data['customer_by_information_id'] != '-1')
            ? CustomerByInformation::find($data['customer_by_information_id'])
            : new CustomerByInformation();

        $attributes = [
            'customer_id' => $customerId,
            'people_nationality_id' => $data["people_nationality_id"] ?? PeopleNationality::TYPE_ANYONE,
            'people_profession_id' => $data["people_profession_id"] ?? PeopleProfession::TYPE_ANYONE,
        ];

        return $this->validateAndSaveModel($customerInfo, $attributes, 'Información Adicional');
    }

    private function saveOrUpdateAddress($data, $entityId)
    {
        $address = (isset($data['information_address_id']) && $data['information_address_id'] != 'null' && $data['information_address_id'] != '-1')
            ? InformationAddress::find($data['information_address_id'])
            : new InformationAddress();

        $location = json_decode($data['information_address_location_current'], true);

        $attributes = [
            'country_code_id' => $location['country_code_id'],
            'administrative_area_level_1' => $location['administrative_area_level_1'],
            'administrative_area_level_2' => $location['administrative_area_level_2'],
            'administrative_area_level_3' => $location['administrative_area_level_3'],
            'state' => 'ACTIVE',
            'entity_id' => $entityId,
            'entity_type' => Util::INFORMATION_CUSTOMER_TYPE,
            'main' => 1,
        ];

        return $this->validateAndSaveModel($address, $attributes, 'Dirección');
    }

    private function saveOrUpdatePhone($data, $entityId)
    {
        $phone = (isset($data['information_phone_id']) && $data['information_phone_id'] != 'null' && $data['information_phone_id'] != '-1')
            ? InformationPhone::find($data['information_phone_id'])
            : new InformationPhone();

        $attributes = [
            'value' => $data['information_phone_value'],
            'information_phone_type_id' => $data['information_phone_type_id']['id'],
            'information_phone_operator_id' => $data['information_phone_operator_id']['id'],
            'entity_id' => $entityId,
            'entity_type' => Util::INFORMATION_CUSTOMER_TYPE,
            'main' => 1,
            'state' => InformationPhone::STATE_ACTIVE,
        ];

        return $this->validateAndSaveModel($phone, $attributes, 'Teléfono');
    }

    private function validateAndSaveModel($model, $attributes, $entityName)
    {
        $validation = $model::validateModel($attributes);
        if (!$validation['success']) {
            return [
                'success' => false,
                'msj' => "Problemas al guardar $entityName.",
                'errors' => $validation['errors'],
                'data' => []
            ];
        }
        $model->fill($attributes);
        $model->save();
        $attributes['id'] = $model->id;

        return [
            'success' => true,
            'msj' => '',
            'errors' => [],
            'data' => $attributes
        ];
    }

    private function rollbackWithError($response)
    {
        DB::rollBack();
        return $response;
    }

}
