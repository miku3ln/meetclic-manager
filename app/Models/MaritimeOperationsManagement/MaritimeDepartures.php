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
use Illuminate\Support\Facades\Auth;
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

    public function saveMaritimeDepartureApi($params)//API EMBARQUE Y ZARPE
    {
        DB::beginTransaction();
        try {
            $attributesPost = $params;
            $departureData = $attributesPost["MaritimeDepartures"];
            $customers = $attributesPost["Customers"];

            $departure = new MaritimeDepartures();
            $departure->business_id = $departureData["business_id"];
            $user_id = -1;

            if (isset($departureData["user_id"])) {
                $user_id = $departureData["user_id"];
            } else {
                $user = Auth::user();
                if ($user) {
                    $user_id = $user->id;
                }
            }
            $departure->user_id = $user_id;
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
                    $customerId = $customerResult['data']['id'];
                }
                // 7. Registrar en MaritimeDeparturesCustomers
                $departureCustomer = new MaritimeDeparturesCustomers();
                $departureCustomer->maritime_departures_id = $departure->id;
                $departureCustomer->type = $customerData['type'];
                $departureCustomer->age = $customerData['age'];
                $departureCustomer->customer_id = $customerId;
                $departureCustomer->save();
            }


            DB::commit();

            return [
                'success' => true,
                'message' => 'Registrados con Exito.',
                'data' => []
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


        $ageInput = isset($data['age']) && $data['age'] !== '' ? (int)$data['age'] : null;
        $birthdateInput = isset($data['birthdate']) && !empty($data['birthdate'])
            ? Carbon::parse($data['birthdate'])
            : null;

// ✅ Regla: si hay birthdate, calcular age (no dejar 0)
// ✅ Si no hay birthdate pero hay age, calcular birthdate
        if ($birthdateInput) {
            $birthdate = $birthdateInput->copy();
            $age = $birthdate->age; // edad real basada en hoy
        } elseif ($ageInput !== null) {
            $age = max(0, $ageInput);

            // Calcula una fecha aproximada de nacimiento:
            // (mismo día/mes de hoy, pero restando años)
            $birthdate = Carbon::now()->subYears($age);
        } else {
            $age = 0;
            $birthdate = Carbon::now();
        }

        $attributes = [
            'last_name' => $data["last_name"] ?? null,
            'name' => $data["name"] ?? null,
            'type_document' => $data["people_type_identification_id"] ?? PeopleTypeIdentification::TYPE_IDENTIFICATION_OTHERS,
            'document_number' => $data["document_number"] ?? null,

            // ✅ birthdate final calculado/normalizado
            'birthdate' => $birthdate->format('Y-m-d'),

            // ✅ age final calculado/normalizado (nunca 0 si venía birthdate)
            'age' => $age,

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
    public function getDeparturesCustomersResumeByType(array $params): array
    {
        $businessId = (int)($params['business_id'] ?? 0);
        $from = $params['date_from'] ?? null; // '2026-01-01 00:00:00'
        $to   = $params['date_to']   ?? null; // '2026-01-31 23:59:59'

        if ($businessId <= 0 || empty($from) || empty($to)) {
            return [];
        }
$select="
        b.title as companyName,
        b.id as companyId,

        md.created_at,
        mdc.id row_manager_id,
        mdc.age as passenger_age,
        CASE mdc.type
            WHEN 'INFANT' THEN 'Bebé'
            WHEN 'CHILD'  THEN 'Niño / Niña'
            WHEN 'ADULT'  THEN 'Adulto'
            WHEN 'SENIOR' THEN 'Adulto mayor'
            ELSE 'No definido'
        END as type
    ";
        // ✅ 1 sola consulta, agrupada, usando created_at de maritime_departures
        $rows  = DB::table('maritime_departures as md')
            ->join('business as b', 'b.id', '=', 'md.business_id')
            ->join('maritime_departures_customers as mdc', 'mdc.maritime_departures_id', '=', 'md.id')
            ->where('md.business_id', $businessId)
            ->whereBetween('md.created_at', [$from, $to])
            ->whereNotNull('mdc.type')
            ->selectRaw($select)
            ->get()
            ->toArray();

        return $rows;
    }
    public function getByDetailsMaritime($params)
    {
        $departureId = $params["departureId"];

        return DB::table('maritime_departures_customers as mdc')
            ->join('maritime_departures as md', 'md.id', '=', 'mdc.maritime_departures_id')
            ->join('customer as c', 'c.id', '=', 'mdc.customer_id')
            ->join('people as p', 'p.id', '=', 'c.people_id')
            ->leftJoin('business as b', 'b.id', '=', 'md.business_id')
            ->where('mdc.maritime_departures_id', $departureId)
            ->select([
                // pivot
                'mdc.id as pivot_id',
                'mdc.type as passenger_type',
                'mdc.age as passenger_age',
                'mdc.customer_id',

                // departure
                'md.id as maritime_departure_id',
                'md.arrival_time',
                'md.responsible_name',
                'md.status as departure_status',

                // business
                'b.id as business_id',
                'b.title as business_title',

                // people
                'p.id as people_id',
                'p.name as people_name',
                'p.last_name as people_last_name',
                'p.birthdate',
                'p.gender',
            ])
            ->orderBy('mdc.id', 'asc')
            ->get()->toArray();
    }

    public function getAdmin($params)
    {
        $sort = 'asc';
        $field = $this->table . '.id'; // default seguro

        $query = DB::table($this->table)
            ->join('business as b', 'b.id', '=', $this->table . '.business_id')
            ->leftJoin('business_subcategories as sc', 'sc.id', '=', 'b.business_subcategories_id')
            ->leftJoin('business_categories as c', 'c.id', '=', 'sc.business_categories_id');

        // Sort
        if (isset($params['sort']) && is_array($params['sort']) && count($params['sort']) > 0) {
            $column = array_keys($params['sort']);
            $field = $column[0];

            // ✅ Seguridad: si viene sin prefijo, asumimos tabla principal
            if (strpos($field, '.') === false) {
                $field = $this->table . '.' . $field;
            }

            $sort = strtolower($params['sort'][$column[0]]) === 'desc' ? 'desc' : 'asc';
        }

        $page = isset($params['current']) ? (int)$params['current'] : 1;
        $perpage = isset($params['rowCount']) ? (int)$params['rowCount'] : 10;

        // ✅ SELECT: tabla principal + business + categoría/subcategoría
        $selectString = "
        {$this->table}.id,
        {$this->table}.business_id,
        {$this->table}.user_id,
        {$this->table}.arrival_time,
        {$this->table}.created_at,
        {$this->table}.responsible_name,

  CASE {$this->table}.status
    WHEN 'DRAFT' THEN 'En navegación'
    WHEN 'CONFIRMED' THEN 'Confirmado'
    WHEN 'CANCELLED' THEN 'Cancelado'
    ELSE {$this->table}.status
  END AS status,
        b.title as business_title,
        b.document as business_document,
        b.email as business_email,

        sc.name as business_subcategory,
        c.name as business_category
    ";

        $query->select(DB::raw($selectString));

        // Search
        if (!empty($params['searchPhrase'])) {
            $likeSet = trim($params['searchPhrase']);

            $query->where(function ($q) use ($likeSet) {
                $q->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%')
                    ->orWhere($this->table . '.status', 'like', '%' . $likeSet . '%')
                    ->orWhere($this->table . '.arrival_time', 'like', '%' . $likeSet . '%')

                    // ✅ búsqueda por negocio
                    ->orWhere('b.title', 'like', '%' . $likeSet . '%')
                    ->orWhere('b.document', 'like', '%' . $likeSet . '%')
                    ->orWhere('b.email', 'like', '%' . $likeSet . '%')

                    // ✅ búsqueda por categoría/subcategoría
                    ->orWhere('sc.title', 'like', '%' . $likeSet . '%')
                    ->orWhere('c.title', 'like', '%' . $likeSet . '%');
            });
        }

        // ✅ count eficiente
        $recordsTotal = (clone $query)->count();

        // Sort final
        $query->orderBy($field, $sort);

        // Pagination
        $pages = 1;
        if ($perpage > 0) {
            $pages = (int)ceil($recordsTotal / $perpage);
            $page = max($page, 1);
            $page = min($page, $pages);
            $offset = ($page - 1) * $perpage;

            $query->offset((int)$offset)->limit((int)$perpage);
        }

        $data = $query->get()->toArray();

        return [
            'total' => $recordsTotal,
            'rows' => $data,
            'current' => $page,
            'rowCount' => $perpage,
        ];
    }


}
