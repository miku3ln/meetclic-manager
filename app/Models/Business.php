<?php

namespace App\Models;

use App\Models\Gamification\GamificationCountryReference;
use App\Utils\Util;

use Illuminate\Support\Facades\DB;
use Auth;


class Business extends ModelManager
{
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';
    const BUSINESS_MAIN_ID = 1;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'business';

    protected $fillable = array(
        "description",
        "title",//*
        "email",//*
        "page_url",
        "phone_value",//*
        "street_1",//*
        "street_2",
        "street_lat",//*
        "street_lng",//*
        "user_id",//*
        "options_map",

        "business_subcategories_id",//*
        "status",
        "qualification",
        "source",
        "business_id", "id",
        'has_document', 'has_about',
        'business_name',
        'keep_accounting',
        'type_ruc_id',
        'allow_cash_and_banks',
        'entity_plans_id',
        'entity_position_fiscal_id',
        'document',

    );
    public $attributesData = array(
        "description",
        "title",//*
        "email",//*
        "page_url",
        "phone_value",//*
        "street_1",//*
        "street_2",
        "street_lat",//*
        "street_lng",//*
        "user_id",//*
        "business_subcategories_id",//*
        "status",
        "qualification",
        "source",
        "options_map",
        'has_document', 'has_about',
        'business_name',
        'keep_accounting',
        'type_ruc_id',
        'allow_cash_and_banks',
        'entity_plans_id',
        'entity_position_fiscal_id',
        'document',
    );
    public $timestamps = false;


    public static function getRulesModel($params)
    {
        $rules = [
            "title" => "required|unique:business,title",
            "email" => "required",
            "phone_value" => "required",
            "street_1" => "required",
            "street_2" => "required",
            "street_lat" => "required",
            "street_lng" => "required",
            "user_id" => "required",
            "business_subcategories_id" => "required",
            "status" => "required",
            "qualification" => "required",
            "source" => "required",
            "has_document" => "required",
            "has_about" => "required",
            /*
                       "business_name" => "",
                        "keep_accounting" => "required",
                        "type_ruc_id" => "required",
                        "allow_cash_and_banks" => "required",
                        "entity_plans_id" => "required",
                        "entity_position_fiscal_id" => "required",
                        "document" => "required",

            */
        ];


        if (isset($params['id'])) {
            $rules['title'] = 'required|unique:business,title,' . $params['id'] . ',id';
        }
        return $rules;
    }

    public function amenities()
    {
        $parentKeyCurrent = 'business_id';
        $childrenKeyCurrent = 'business_amenities_id';
        $childrenClass = BusinessAmenities::class;
        $childrenTable = 'business_by_amenities';
        return $this->belongsToMany($childrenClass, $childrenTable, $parentKeyCurrent, $childrenKeyCurrent);
    }

    public
    function getActionsManager()
    {
        $model_entity = $this->getUpperCaseTable($this->table);
        $action_get_form = $model_entity . "'\'" . $model_entity . "Controller" . "@getForm" . $model_entity;
        $action_get_form = str_replace("'", "", $action_get_form);
        $action_save = $model_entity . "'\'" . $model_entity . "Controller" . "@postSave";
        $action_save = str_replace("'", "", $action_save);
        $action_load = $model_entity . "'\'" . $model_entity . "Controller" . "@getList" . $model_entity;
        $action_load = str_replace("'", "", $action_load);
        $model_entity = $this->getCamelCase();
        return [
            "action_get_form" => $action_get_form,
            "action_save_" . $model_entity => $action_save,
            "action_load_" . $model_entity . "s" => $action_load];
    }

    public
    function getUpperCaseTable($name_change)
    {
        $table = $name_change;
        $arrayNames = explode("_", $table);
        $model_entity = "";
        foreach ($arrayNames as $name) {
            // your code
            $model_entity .= ucfirst($name);
        }

        return $model_entity;
    }

    public
    function getCamelCase()
    {

        return lcfirst($this->getUpperCaseTable($this->table));
    }

    public
    function findAllByAttributes($attributes = array(), $values = array(), $columns = array('*'))
    {
        $response = DB::table($this->table)
            ->select($columns);
        if (!is_array($attributes) || !is_array($values)) {
            throw new Exception('$attributes and $values should be array.');
        }
        if (count($attributes) < 1 || count($values) < 1) {
            throw new Exception('$attributes and $values can not be empty.');
        }
        if (count($attributes) != count($values)) {
            throw new Exception('$attributes and $values must have the same length.');
        }
        foreach ($attributes as $key => $attribute) {
            $response->where($attribute, "=", $values[$key]);
        }
        return $response->get();
    }


    public
    function getBusinessByUser($params)
    {
        $select = "*";
        $user_id = $params["user_id"];
        $query = Business::query()->select($select);
        $query->where("user_id", '=', $user_id);

        $data = $query->get()->toArray();

        return $data;
    }

    public
    function getBusinessInformation($params)
    {
        $selectString = "business.id,business.options_map,business.description,business.title,business.email,business.page_url,business.phone_value,business.street_1,business.street_2,business.street_lat,business.street_lng,business.user_id,business.business_subcategories_id,business.status,business.qualification,business.source
        ,countries.name countries
        ,zones.name zone,zones.id zone_id
        ,cities.name city,cities.id city_id
 ,provinces.name province,provinces.id province_id
        ,business_subcategories.name business_subcategories
        ,business_categories.name business_categories
        ,business.business_name,business.keep_accounting,business.type_ruc_id,business.allow_cash_and_banks,business.entity_plans_id,business.entity_position_fiscal_id,business.document
        ";
        $id = $params['filters']["business_id"];
        $select = DB::raw($selectString);
        $query = DB::table($this->table);
        $query->select($select);
        $query->where("business.id", '=', $id);

        $query->leftJoin('business_location', function ($query)
        use (
            $selectString

        ) {
            $query->on('business_location.business_id', '=', 'business.id');
            $query->join('zones', "business_location.zones_id", '=', 'zones.id');
            $query->join('cities', "zones.city_id", '=', 'cities.id');
            $query->join('provinces', "cities.province_id", '=', 'provinces.id');
            $query->join('countries', "provinces.country_id", '=', 'countries.id');

        });
        $query->join('business_subcategories', "$this->table.business_subcategories_id", '=', 'business_subcategories.id');
        $query->join('business_categories', "business_subcategories.business_categories_id", '=', 'business_categories.id');
        $data = $query->first();

        return $data;
    }

    public
    function getBusinessByIdManager($params)
    {
        $selectString = "business.id,business.options_map,business.description,business.title,business.email,business.page_url,business.phone_value,business.street_1,business.street_2,business.street_lat,business.street_lng,business.user_id,business.business_subcategories_id,business.status,business.qualification,business.source
        ,countries.name countries,
        countries.id countries_id

                ,zones.name zone,zones.id zone_id
        ,cities.name city,cities.id city_id
 ,provinces.name province,provinces.id province_id
        ,business_subcategories.name business_subcategories
        ,business_categories.name business_categories";
        $id = $params["id"];
        $select = DB::raw($selectString);
        $query = DB::table($this->table);
        $query->select($select);
        $query->where("business.id", '=', $id);
        $query->leftJoin('business_location', function ($query)
        use (
            $selectString

        ) {
            $query->on('business_location.business_id', '=', 'business.id');
            $query->join('zones', "business_location.zones_id", '=', 'zones.id');
            $query->join('cities', "zones.city_id", '=', 'cities.id');
            $query->join('provinces', "cities.province_id", '=', 'provinces.id');
            $query->join('countries', "provinces.country_id", '=', 'countries.id');

        });
        $query->join('business_subcategories', "$this->table.business_subcategories_id", '=', 'business_subcategories.id');
        $query->join('business_categories', "business_subcategories.business_categories_id", '=', 'business_categories.id');
        $user = Auth::user();
        $user_id = $user->id;
        $role = new Role();
        $hasRolesUser = new UsersHasRoles();
        $user = Auth::user();
        $roles = $hasRolesUser->getRolesUser($user->id);
        $managerOwner = false;
        $managerOwnerReceptionist = false;
        $allowManagerData = false;
        foreach ($roles as $role) {
            if ($role->role_id == Role::ROL_RECEPTIONIST) {
                $managerOwnerReceptionist = true;
            } else if ($role->role_id == Role::ROL_SUPERADMIN) {
                $managerOwner = true;
            } else if ($role->role_id == Role::ROL_BUSINESS) {
                $managerOwner = true;
                $allowManagerData = true;
            }
        }


        $allowWorker = false;
        $businessProfile = new BusinessByEmployeeProfile();
        $resultBusiness = $businessProfile->getUserBusiness(
            array(
                'user_id' => $user_id
            )
        );
        $owner_user_id = null;
        if ($resultBusiness) {

            if ($resultBusiness->business_id == $id) {
                $owner_user_id = $resultBusiness->owner_user_id;
            }
        }
        if ($owner_user_id) {
            $user_id = $owner_user_id;
        }

        $query->where("business.user_id", '=', $user_id);
        $data = $query->get()->toArray();

        return $data;
    }

    public
    function getManagerBusinessData($id)//BUSINESS-MANAGER-PROCESS-MENU
    {
        $modelBBS = new BusinessBySchedule;
        $modelPN = new PeopleNationality();
        $modelPP = new PeopleProfession();
        $user = Auth::user();
        $roles = $user->roles->pluck('id')->toArray();

        $business = $this->getBusinessByIdManager(array("id" => $id));
        $schedules = array();
        $success = false;
        $gamificationCountryReferenceData = [];
        if (count($business) > 0) {
            $dataBusiness = $business[0];
            $business_id = $dataBusiness->id;

            $schedules = $modelBBS->getStructureSchedulesBusiness(array("business_id" => $business_id));
            $success = true;

            $gamificationCountryReferenceData = GamificationCountryReference::findActiveByCountryId($dataBusiness->countries_id);
        }
        $peopleNationalityData = $modelPN->getDataListAll();
        $peopleProfessionData = $modelPP->getDataListAll();
        $dateCurrentData = array("format" => Util::DateCurrent('America/Guayaquil'), "not-format" => Util::DateCurrent('America/Guayaquil', "H:i:s d/m/Y"));


        return array(
            "business" => $business,
            "success" => $success,
            "schedules" => $schedules,
            "peopleNationalityData" => $peopleNationalityData,
            "peopleProfessionData" => $peopleProfessionData,
            "dateCurrentData" => $dateCurrentData,
            "gamificationCountryReferenceData" => $gamificationCountryReferenceData,
            'user' => $user,
            "userData" => [
                'model' => $user,
                'roles' => $roles
            ]

        );
    }


    public
    function getAllBusiness($params = array())
    {
        $select = "*";

        $query = Business::query()->select($select);
        $query->where("status", '=', self::STATUS_ACTIVE);

        $data = $query->get()->toArray();

        return $data;
    }

    public
    function getBusinessById($params = array())
    {
        $select = "*";
        $id = $params["id"];
        $query = Business::query()->select($select);
        $query->where("status", '=', self::STATUS_ACTIVE);
        $query->where("id", '=', $id);

        $data = $query->get()->toArray();

        return $data;
    }

    public
    function getBusinessDataAgent($params = array())
    {
        $information = $this->getBusinessById($params);
        /*
        |--------------------------------------------------------------------------
        | 1. BUSINESS
        |--------------------------------------------------------------------------
        | Información general de la empresa.
        |
        | Propósito:
        | - Identificar la empresa.
        | - Mostrar información al cliente.
        | - Configuración regional.
        | - Utilizado por todos los canales.
        |--------------------------------------------------------------------------
        */
        $business = null;
        if (count($information) > 0) {
            $business = $information[0];
        }

        $modelBBS = new BusinessBySchedule;
        $business_id = $params["id"];
        $scheduleDays = $modelBBS->getStructureSchedulesBusiness(array("business_id" => $business_id));

        $result = [
            "business" => $business,

            /*
            |--------------------------------------------------------------------------
            | 2. CONTACT
            |--------------------------------------------------------------------------
            | Información de contacto.
            |
            | Propósito:
            | - Responder preguntas.
            | - Compartir teléfonos.
            | - Compartir correos.
            |--------------------------------------------------------------------------
            */

            "contact" => [

                "email" => "alexalba@meetclic.com",

                "phone" => "0985339457",

                "mobile" => "0985339457",

                "whatsapp" => "593985339457",

                "website" => "https://www.meetclic.com",

                "allow_whatsapp_call" => true,

                "allow_phone_call" => true,

                "allow_email" => true

            ],

            /*
            |--------------------------------------------------------------------------
            | 3. LOCATION
            |--------------------------------------------------------------------------
            | Ubicación física.
            |
            | Propósito:
            | - Compartir dirección.
            | - Abrir Google Maps.
            |--------------------------------------------------------------------------
            */

            "location" => [

                "address" => [

                    "street_1" => "Piedrahita",

                    "street_2" => "Buenos Aires",

                    "reference" => "Frente al parque"

                ],

                "coordinates" => [

                    "lat" => 0.226204,

                    "lng" => -78.236500

                ],

                "country" => "Ecuador",

                "province" => "Imbabura",

                "city" => "Otavalo",

                "postal_code" => null

            ],

            /*
            |--------------------------------------------------------------------------
            | 4. SOCIAL NETWORKS
            |--------------------------------------------------------------------------
            | Redes sociales.
            |
            | Propósito:
            | Compartir redes cuando el cliente las solicite.
            |--------------------------------------------------------------------------
            */

            "social_networks" => [

                "facebook" => "https://facebook.com/meetclic",

                "instagram" => "https://instagram.com/meetclic",

                "tiktok" => "",

                "youtube" => "",

                "linkedin" => "",

                "x" => ""

            ],

            /*
            |--------------------------------------------------------------------------
            | 5. ASSISTANT
            |--------------------------------------------------------------------------
            | Configuración del asistente.
            |
            | Propósito:
            | Define la personalidad del agente.
            |--------------------------------------------------------------------------
            */

            "assistant" => [

                "enabled" => true,

                "name" => "MIA",

                "avatar" => null,

                "language" => "es",

                "tone" => "friendly", // friendly | formal | professional

                "personality" => "helpful",

                "show_emojis" => true,

                "show_typing" => false,

                "show_menu_on_start" => true,

                "allow_voice" => false,

                "allow_images" => false,

                "allow_documents" => false

            ],

            /*
            |--------------------------------------------------------------------------
            | 6. AI
            |--------------------------------------------------------------------------
            | Configuración de Inteligencia Artificial.
            |
            | Propósito:
            | Controlar el funcionamiento del proveedor IA.
            |--------------------------------------------------------------------------
            */

            "ai" => [

                "enabled" => true,

                "provider" => "OPENAI",

                "model" => "gpt-5.5",

                "temperature" => 0.3,

                "top_p" => 1,

                "max_tokens" => 1000,

                "presence_penalty" => 0,

                "frequency_penalty" => 0,

                "detect_language" => true,

                "translate_language" => false,

                "memory" => true,

                "knowledge_base" => true,

                "allow_outside_business" => false,

                "system_prompt" => "Eres el asistente virtual oficial de la empresa."

            ],

            /*
            |--------------------------------------------------------------------------
            | 7. CONVERSATION
            |--------------------------------------------------------------------------
            | Configuración general del chat.
            |
            | Propósito:
            | Controlar el ciclo de vida de una conversación.
            |--------------------------------------------------------------------------
            */

            "conversation" => [

                "save_history" => true,

                "conversation_timeout_minutes" => 30,

                "restart_after_finish" => true,

                "continue_last_conversation" => true,

                "max_context_messages" => 20,

                "simulate_typing" => false,

                "allow_multiple_sessions" => false,

                "log_all_messages" => true

            ],

            /*
            |--------------------------------------------------------------------------
            | 8. COMMANDS
            |--------------------------------------------------------------------------
            | Comandos globales.
            |
            | Propósito:
            | Funcionan desde cualquier flujo.
            |--------------------------------------------------------------------------
            */

            "commands" => [

                [
                    "code" => "MENU",
                    "keyword" => "menu",
                    "description" => "Mostrar menú principal",
                    "enabled" => true
                ],

                [
                    "code" => "START",
                    "keyword" => "inicio",
                    "description" => "Reiniciar conversación",
                    "enabled" => true
                ],

                [
                    "code" => "HELP",
                    "keyword" => "ayuda",
                    "description" => "Mostrar ayuda",
                    "enabled" => true
                ],

                [
                    "code" => "CANCEL",
                    "keyword" => "cancelar",
                    "description" => "Cancelar proceso actual",
                    "enabled" => true
                ],

                [
                    "code" => "ADVISOR",
                    "keyword" => "asesor",
                    "description" => "Hablar con un asesor",
                    "enabled" => true
                ],

                [
                    "code" => "EXIT",
                    "keyword" => "salir",
                    "description" => "Finalizar conversación",
                    "enabled" => true
                ]

            ],
            /*
    |--------------------------------------------------------------------------
    | 10. MODULES
    |--------------------------------------------------------------------------
    | Módulos habilitados para la empresa.
    |
    | Propósito:
    | Permite activar o desactivar funcionalidades sin modificar código.
    |--------------------------------------------------------------------------
    */

            "modules" => [

                "appointments" => true,
                "products" => false,
                "catalog" => false,
                "orders" => false,
                "payments" => false,
                "debts" => false,
                "invoices" => false,
                "crm" => false,
                "inventory" => false,
                "delivery" => false,
                "marketing" => false,
                "surveys" => false,
                "support" => true,
                "calendar" => true,
                "employees" => true

            ],

            /*
            |--------------------------------------------------------------------------
            | 11. APPOINTMENTS
            |--------------------------------------------------------------------------
            | Configuración del sistema de reservas.
            |--------------------------------------------------------------------------
            */

            "appointments" => [

                "enabled" => true,

                "require_login" => false,

                "require_payment" => false,

                "allow_cancel" => true,

                "allow_reschedule" => true,

                "allow_multiple" => true,

                "allow_waiting_list" => false,

                "automatic_confirmation" => true,

                "requires_professional" => true,

                "requires_service" => true,

                "requires_category" => true,

                "max_active_appointments" => 3,

                "minimum_hours_before_booking" => 1,

                "maximum_days_before_booking" => 90,

                "minimum_hours_cancel" => 2,

                "minimum_hours_reschedule" => 2,

                "appointment_duration_default" => 60,

                "send_confirmation" => true,

                "send_reminder" => true,

                "reminder_hours_before" => 24

            ],

            /*
            |--------------------------------------------------------------------------
            | 12. SERVICES
            |--------------------------------------------------------------------------
            | Configuración general de servicios.
            |--------------------------------------------------------------------------
            */

            "services" => [

                "enabled" => true,

                "allow_categories" => true,

                "allow_subcategories" => true,

                "allow_professionals" => true,

                "allow_price" => true,

                "allow_duration" => true,

                "allow_images" => true,

                "allow_description" => true,

                "allow_online_booking" => true,

                "show_price" => true,

                "show_duration" => true,

                "currency" => "USD",

                "categories" => [],

                "items" => []

            ],

            /*
            |--------------------------------------------------------------------------
            | 13. PROFESSIONALS
            |--------------------------------------------------------------------------
            | Configuración de empleados/profesionales.
            |--------------------------------------------------------------------------
            */

            "professionals" => [

                "enabled" => true,

                "allow_multiple_services" => true,

                "allow_custom_schedule" => true,

                "allow_breaks" => true,

                "allow_days_off" => true,

                "allow_color_calendar" => true,

                "allow_photo" => true,

                "allow_specialties" => true,

                "items" => []

            ],

            /*
            |--------------------------------------------------------------------------
            | 14. SCHEDULE
            |--------------------------------------------------------------------------
            | Configuración de agenda.
            |--------------------------------------------------------------------------
            */

            "schedule" => [

                "timezone" => "America/Guayaquil",

                "working_days" => $scheduleDays,

                "allow_multiple_blocks" => true,

                "slot_interval_minutes" => 30,

                "default_duration" => 60,

                "allow_overbooking" => false,

                "buffer_before_minutes" => 0,

                "buffer_after_minutes" => 0,

                "holidays" => [],

                "special_days" => [],

                "exceptions" => []

            ],

            /*
            |--------------------------------------------------------------------------
            | 15. CUSTOMER
            |--------------------------------------------------------------------------
            | Configuración de clientes.
            |
            | Cada campo puede ser:
            | visible
            | required
            | editable
            |--------------------------------------------------------------------------
            */
            "customer" => [

                "allow_registration" => true,

                "allow_guest" => true,

                "allow_update_information" => true,

                "fields" => [

                    [
                        "code" => "first_name",
                        "label" => "Nombre",
                        "type" => "text",
                        "visible" => true,
                        "required" => true,
                        "editable" => true,
                        "order" => 1
                    ],

                    [
                        "code" => "last_name",
                        "label" => "Apellidos",
                        "type" => "text",
                        "visible" => true,
                        "required" => false,
                        "editable" => true,
                        "order" => 2
                    ],

                    [
                        "code" => "phone",
                        "label" => "Celular",
                        "type" => "phone",
                        "visible" => true,
                        "required" => true,
                        "editable" => true,
                        "order" => 3
                    ],

                    [
                        "code" => "email",
                        "label" => "Correo",
                        "type" => "email",
                        "visible" => true,
                        "required" => false,
                        "editable" => true,
                        "order" => 4
                    ],

                    [
                        "code" => "document",
                        "label" => "Documento",
                        "type" => "text",
                        "visible" => true,
                        "required" => false,
                        "editable" => true,
                        "order" => 5
                    ],

                    [
                        "code" => "address",
                        "label" => "Dirección",
                        "type" => "text",
                        "visible" => false,
                        "required" => false,
                        "editable" => true,
                        "order" => 6
                    ],

                    [
                        "code" => "birthdate",
                        "label" => "Fecha nacimiento",
                        "type" => "date",
                        "visible" => false,
                        "required" => false,
                        "editable" => true,
                        "order" => 7
                    ],

                    [
                        "code" => "gender",
                        "label" => "Sexo",
                        "type" => "select",
                        "visible" => false,
                        "required" => false,
                        "editable" => true,
                        "order" => 8
                    ],

                    [
                        "code" => "company",
                        "label" => "Empresa",
                        "type" => "text",
                        "visible" => false,
                        "required" => false,
                        "editable" => true,
                        "order" => 9
                    ],

                    [
                        "code" => "notes",
                        "label" => "Observaciones",
                        "type" => "textarea",
                        "visible" => false,
                        "required" => false,
                        "editable" => true,
                        "order" => 10
                    ]

                ]

            ],

            /*
            |--------------------------------------------------------------------------
            | 16. PAYMENTS
            |--------------------------------------------------------------------------
            | Métodos de pago disponibles.
            |--------------------------------------------------------------------------
            */

            "payments" => [

                "enabled" => false,

                "allow_partial_payment" => false,

                "allow_full_payment" => true,

                "require_advance" => false,

                "methods" => [

                    [
                        "code" => "cash",
                        "name" => "Efectivo",
                        "enabled" => true
                    ],

                    [
                        "code" => "transfer",
                        "name" => "Transferencia",
                        "enabled" => false
                    ],

                    [
                        "code" => "credit_card",
                        "name" => "Tarjeta",
                        "enabled" => false
                    ],

                    [
                        "code" => "debit_card",
                        "name" => "Tarjeta Débito",
                        "enabled" => false
                    ],

                    [
                        "code" => "paypal",
                        "name" => "PayPal",
                        "enabled" => false
                    ],

                    [
                        "code" => "stripe",
                        "name" => "Stripe",
                        "enabled" => false
                    ],

                    [
                        "code" => "payphone",
                        "name" => "PayPhone",
                        "enabled" => false
                    ]

                ]

            ],

            /*
            |--------------------------------------------------------------------------
            | 17. AUTO_INFORMATION
            |--------------------------------------------------------------------------
            | Información que el asistente puede responder SIN IA.
            |--------------------------------------------------------------------------
            */

            "auto_information" => [

                "schedule" => true,

                "location" => true,

                "phones" => true,

                "email" => true,

                "website" => true,

                "social_networks" => true,

                "services" => true,

                "categories" => true,

                "products" => false,

                "promotions" => false,

                "faq" => true,

                "policies" => true,

                "payments" => true,

                "professionals" => true

            ],
            /*
    |--------------------------------------------------------------------------
    | 18. ESCALATION
    |--------------------------------------------------------------------------
    | Configuración para escalar la conversación a una persona.
    |
    | Propósito:
    | - Transferir conversación.
    | - Notificar empleados.
    | - Enviar correo.
    | - Enviar WhatsApp.
    |--------------------------------------------------------------------------
    */

            "escalation" => [

                "enabled" => true,

                "allow_human_transfer" => true,

                "automatic_transfer" => false,

                "max_ai_attempts" => 3,

                "business_hours_only" => true,

                "queue_enabled" => false,

                "notify_email" => true,

                "notify_whatsapp" => true,

                "notify_dashboard" => true,

                "default_department" => "Recepción",

                "default_employee" => null,

                "message_before_transfer" => "Un momento por favor, te comunicaré con un asesor.",

                "message_no_agents" => "En este momento no hay asesores disponibles."

            ],

            /*
            |--------------------------------------------------------------------------
            | 19. CHANNELS
            |--------------------------------------------------------------------------
            | Canales donde funciona el asistente.
            |--------------------------------------------------------------------------
            */

            "channels" => [

                [
                    "code" => "whatsapp",
                    "name" => "WhatsApp",
                    "enabled" => true,
                    "default" => true
                ],

                [
                    "code" => "webchat",
                    "name" => "Web Chat",
                    "enabled" => false,
                    "default" => false
                ],

                [
                    "code" => "facebook",
                    "name" => "Facebook",
                    "enabled" => false,
                    "default" => false
                ],

                [
                    "code" => "instagram",
                    "name" => "Instagram",
                    "enabled" => false,
                    "default" => false
                ],

                [
                    "code" => "telegram",
                    "name" => "Telegram",
                    "enabled" => false,
                    "default" => false
                ],

                [
                    "code" => "email",
                    "name" => "Correo",
                    "enabled" => false,
                    "default" => false
                ]

            ],

            /*
            |--------------------------------------------------------------------------
            | 20. SECURITY
            |--------------------------------------------------------------------------
            | Seguridad del asistente.
            |--------------------------------------------------------------------------
            */

            "security" => [

                "enabled" => true,

                "save_logs" => true,

                "save_conversations" => true,

                "session_timeout_minutes" => 30,

                "max_messages_per_minute" => 30,

                "verify_customer" => false,

                "verify_phone" => false,

                "verify_email" => false,

                "verify_document" => false,

                "allow_blocked_customers" => false,

                "allow_blacklist" => true,

                "allow_whitelist" => false

            ],

            /*
            |--------------------------------------------------------------------------
            | 21. MESSAGES
            |--------------------------------------------------------------------------
            | Mensajes automáticos del asistente.
            |--------------------------------------------------------------------------
            */

            "messages" => [

                "welcome" =>
                    "Hola 👋 Bienvenido. Soy el asistente virtual de la empresa. ¿Cómo puedo ayudarte?",

                "goodbye" =>
                    "Muchas gracias por comunicarte con nosotros. ¡Hasta pronto!",

                "outside_schedule" =>
                    "En este momento estamos fuera del horario de atención.",

                "error" =>
                    "Ocurrió un error. Intenta nuevamente.",

                "fallback" =>
                    "No entendí tu solicitud. Puedes escribir *menu* para ver las opciones.",

                "transfer" =>
                    "Voy a transferir tu conversación con un asesor.",

                "appointment_created" =>
                    "Tu reserva fue creada correctamente.",

                "appointment_updated" =>
                    "Tu reserva fue reprogramada correctamente.",

                "appointment_cancelled" =>
                    "Tu reserva fue cancelada correctamente.",

                "payment_received" =>
                    "Hemos recibido tu pago.",

                "no_results" =>
                    "No encontramos información.",

                "thanks" =>
                    "Gracias por preferirnos."

            ],

            /*
            |--------------------------------------------------------------------------
            | 22. NOTIFICATIONS
            |--------------------------------------------------------------------------
            | Notificaciones automáticas.
            |--------------------------------------------------------------------------
            */

            "notifications" => [

                "enabled" => true,

                "appointment_created" => true,

                "appointment_cancelled" => true,

                "appointment_reminder" => true,

                "payment_received" => true,

                "new_customer" => true,

                "survey" => false,

                "promotion" => false

            ],

            /*
            |--------------------------------------------------------------------------
            | 23. INTEGRATIONS
            |--------------------------------------------------------------------------
            | Integraciones externas.
            |--------------------------------------------------------------------------
            */

            "integrations" => [

                "google_calendar" => false,

                "outlook_calendar" => false,

                "google_meet" => false,

                "zoom" => false,

                "teams" => false,

                "crm" => false,

                "erp" => false,

                "webhooks" => true,

                "n8n" => true,

                "api" => true

            ],

            /*
            |--------------------------------------------------------------------------
            | 24. WORKFLOWS
            |--------------------------------------------------------------------------
            | Flujos disponibles.
            |
            | n8n utilizará este bloque para decidir qué workflow ejecutar.
            |--------------------------------------------------------------------------
            */

            "workflows" => [

                [
                    "code" => "appointment",
                    "name" => "Reservar cita",
                    "enabled" => true,
                    "requires_ai" => false,
                    "priority" => 1
                ],

                [
                    "code" => "information",
                    "name" => "Consultar información",
                    "enabled" => true,
                    "requires_ai" => false,
                    "priority" => 2
                ],

                [
                    "code" => "my_appointments",
                    "name" => "Mis reservas",
                    "enabled" => true,
                    "requires_ai" => false,
                    "priority" => 3
                ],

                [
                    "code" => "advisor",
                    "name" => "Hablar con asesor",
                    "enabled" => true,
                    "requires_ai" => false,
                    "priority" => 4
                ],

                [
                    "code" => "products",
                    "name" => "Productos",
                    "enabled" => true,
                    "requires_ai" => false,
                    "priority" => 5
                ],

                [
                    "code" => "promotions",
                    "name" => "Promociones",
                    "enabled" => false,
                    "requires_ai" => false,
                    "priority" => 6
                ],

                [
                    "code" => "payments",
                    "name" => "Pagos",
                    "enabled" => false,
                    "requires_ai" => false,
                    "priority" => 7
                ],

                [
                    "code" => "debts",
                    "name" => "Consultar deudas",
                    "enabled" => false,
                    "requires_ai" => false,
                    "priority" => 8
                ],

                [
                    "code" => "support",
                    "name" => "Soporte",
                    "enabled" => true,
                    "requires_ai" => true,
                    "priority" => 9
                ]

            ],

            /*
            |--------------------------------------------------------------------------
            | 25. PERMISSIONS
            |--------------------------------------------------------------------------
            | Acciones permitidas al asistente.
            |--------------------------------------------------------------------------
            */

            "permissions" => [

                "create_customer" => true,

                "update_customer" => true,

                "view_customer" => true,

                "create_appointment" => true,

                "update_appointment" => true,

                "cancel_appointment" => true,

                "view_schedule" => true,

                "view_services" => true,

                "view_products" => false,

                "view_payments" => false,

                "view_debts" => false,

                "transfer_conversation" => true,

                "send_notifications" => true

            ],

            /*
            |--------------------------------------------------------------------------
            | 9. MENU
            |--------------------------------------------------------------------------
            | Menú principal.
            |
            | Propósito:
            | n8n mostrará únicamente los elementos habilitados.
            |--------------------------------------------------------------------------
            */

            "menu" => [

                [
                    "code" => "APPOINTMENT",
                    "title" => "Reservar cita",
                    "description" => "Agendar una nueva cita.",
                    "icon" => "calendar",
                    "order" => 1,
                    "enabled" => true,
                    "workflow" => "appointment"
                ],

                [
                    "code" => "INFORMATION",
                    "title" => "Consultar información",
                    "description" => "Horarios, ubicación y servicios.",
                    "icon" => "info",
                    "order" => 2,
                    "enabled" => true,
                    "workflow" => "information"
                ],

                [
                    "code" => "MY_APPOINTMENTS",
                    "title" => "Mis reservas",
                    "description" => "Consultar reservas realizadas.",
                    "icon" => "event",
                    "order" => 3,
                    "enabled" => true,
                    "workflow" => "my_appointments"
                ],

                [
                    "code" => "PRODUCTS",
                    "title" => "Productos",
                    "description" => "Consultar catálogo.",
                    "icon" => "shopping_bag",
                    "order" => 4,
                    "enabled" => true,
                    "workflow" => "products"
                ],

                [
                    "code" => "PROMOTIONS",
                    "title" => "Promociones",
                    "description" => "Promociones vigentes.",
                    "icon" => "local_offer",
                    "order" => 5,
                    "enabled" => false,
                    "workflow" => "promotions"
                ],

                [
                    "code" => "DEBTS",
                    "title" => "Consultar deudas",
                    "description" => "Consultar deudas pendientes.",
                    "icon" => "payments",
                    "order" => 6,
                    "enabled" => false,
                    "workflow" => "debts"
                ],

                [
                    "code" => "INVOICES",
                    "title" => "Facturas",
                    "description" => "Consultar facturas.",
                    "icon" => "receipt",
                    "order" => 7,
                    "enabled" => false,
                    "workflow" => "invoices"
                ],

                [
                    "code" => "SURVEYS",
                    "title" => "Encuestas",
                    "description" => "Responder encuestas.",
                    "icon" => "poll",
                    "order" => 8,
                    "enabled" => false,
                    "workflow" => "surveys"
                ],

                [
                    "code" => "SUPPORT",
                    "title" => "Soporte",
                    "description" => "Solicitar ayuda.",
                    "icon" => "support_agent",
                    "order" => 9,
                    "enabled" => true,
                    "workflow" => "support"
                ],

                [
                    "code" => "ADVISOR",
                    "title" => "Hablar con un asesor",
                    "description" => "Transferir la conversación.",
                    "icon" => "person",
                    "order" => 10,
                    "enabled" => true,
                    "workflow" => "advisor"
                ]

            ]
        ];


        return $result;
    }

    public
    function getBusinessData($params = array())
    {
        $information = $this->getBusinessById($params);
        $modelB = new Business();

        $businessData = $modelB->getBusinessFrontend([
            'filters' => [
                'business_id' => $params["id"]
            ]
        ]);
        $modelBBS = new BusinessBySchedule;
        $modelBBP = new BusinessByPanorama;

        $business_id = $params["id"];
        $schedules = $modelBBS->getStructureSchedulesBusiness(array("business_id" => $business_id));
        $dataPanorama = $modelBBP->getDataPanoramaByBusiness(array("business_id" => $business_id));
        $result = array(
            "business" => $information,
            "businessData" => $businessData,

            "dataSchedules" => $schedules,
            "dataPanorama" => $dataPanorama

        );

        return $result;
    }

    public
    function getBusinessAdmin($params)
    {
        $sort = 'asc';
        $field = 'status';
        $query = DB::table($this->table);
        $allowFilters = ($params["filters"]["categories"]["keys"] == "" && $params["filters"]["categories"]["all"] == "false" && $params["filters"]["subcategories"]["keys"] == "") ? false : true;

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];

        }
        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $selectString = "$this->table.id,$this->table.description,$this->table.options_map,$this->table.title,$this->table.email,$this->table.page_url,$this->table.phone_value,$this->table.street_1,$this->table.street_2,$this->table.street_lat,$this->table.street_lng,$this->table.street_lat,$this->table.business_subcategories_id,$this->table.status,$this->table.qualification
        ,countries.name countries_name,countries.place_id countries_place_id,countries.id countries_id
                ,zones.name zone,zones.id zone_id
        ,cities.name city,cities.id city_id
 ,provinces.name province,provinces.id province_id

        ,business_subcategories.id business_subcategories_id,business_subcategories.name business_subcategories_name
         ,business_categories.id business_categories_id,business_categories.name business_categories_name";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->leftJoin('business_location', function ($query)
        use (
            $selectString

        ) {


            $query->on('business_location.business_id', '=', 'business.id');
            $query->join('zones', "business_location.zones_id", '=', 'zones.id');
            $query->join('cities', "zones.city_id", '=', 'cities.id');
            $query->join('provinces', "cities.province_id", '=', 'provinces.id');
            $query->join('countries', "provinces.country_id", '=', 'countries.id');
        });
        $query->join('business_subcategories', "$this->table.business_subcategories_id", '=', 'business_subcategories.id');
        $query->join('business_categories', "business_subcategories.business_categories_id", '=', 'business_categories.id');
        $allowCondition = false;
        $nameColumn = "";
        $dataIn = array();
        if ($allowFilters) {

            if ($params["filters"]["categories"]["keys"] != "") {//only categories
                $categoriesIn = explode(',', $params["filters"]["categories"]["keys"]);
                $dataIn = $categoriesIn;
                $allowCondition = true;
                $nameColumn = "business_categories.id";


            } else {//only subcategories

                if ($params["filters"]["subcategories"]["keys"] != "") {
                    $subCategoriesIn = explode(',', $params["filters"]["subcategories"]["keys"]);
                    $allowCondition = true;
                    $dataIn = $subCategoriesIn;
                    $nameColumn = "business_subcategories.id";

                }
            }

            if ($allowCondition) {
                $query->whereIn($nameColumn, $dataIn);
            }

        }
        $nameColumn = "business_categories.id";
        $query->whereIn($nameColumn, [1, 3]);
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = "%" . $searchValue . "%";
            $query->where("$this->table.description", 'like', $likeSet)
                ->orWhere("$this->table.title", 'like', $likeSet)
                ->orWhere("$this->table.email", 'like', $likeSet)
                ->orWhere("$this->table.page_url", 'like', $likeSet)
                ->orWhere("$this->table.phone_value", 'like', $likeSet)
                ->orWhere('countries.name', 'like', $likeSet)
                ->orWhere('business_subcategories.name', 'like', $likeSet);
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
        $result['paramsfilters'] = array(
            $nameColumn,
            $dataIn,
        );

        return $result;
    }

    public
    function getBusinessAdminData($params)
    {
        $result = $this->getBusinesssAdmin($params);

        return $result;

    }

    public function getDataManagerEmployer($params)
    {

        $sort = 'asc';
        $field = $this->table . '.title';
        $query = DB::table($this->table);
        $user = Auth::user();
        $user_id = $user->id;
        if (isset($params['sort']) && count($params['sort']) > 0) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];

        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $selectString = "$this->table.id ,$this->table.options_map,$this->table.description ,$this->table.title ,$this->table.email,$this->table.page_url,$this->table.phone_value,$this->table.street_1,$this->table.street_2,$this->table.street_lat,$this->table.street_lng,$this->table.user_id,$this->table.business_subcategories_id,$this->table.status,$this->table.qualification,$this->table.source
 ,business_subcategories.name business_subcategories
 ,business_categories.name business_categories,business_categories.id business_categories_id
 ,countries.name countries,countries.id countries_id
         ,zones.name zone,zones.id zones_id
        ,cities.name city,cities.id cities_id
 ,provinces.name province,provinces.id provinces_id
 ,business_location.id business_location_id
 ,business_disbursement.id business_disbursement_id,business_disbursement.bank_id,business_disbursement.account_number,business_disbursement.type_account";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->leftJoin('business_subcategories', $this->table . ".business_subcategories_id", '=', 'business_subcategories.id');
        $query->leftJoin('business_categories', "business_subcategories.business_categories_id", '=', 'business_categories.id');

        $query->join('business_by_employee_profile', "business_by_employee_profile.business_id", '=', $this->table . ".id");
        $query->leftJoin('business_location', function ($query)
        use (
            $selectString

        ) {
            $query->on('business_location.business_id', '=', 'business.id');

            $query->join('zones', "business_location.zones_id", '=', 'zones.id');

            $query->join('cities', "zones.city_id", '=', 'cities.id');
            $query->join('provinces', "cities.province_id", '=', 'provinces.id');
            $query->join('countries', "provinces.country_id", '=', 'countries.id');

        });

        $query->leftJoin('business_disbursement', function ($query)
        use (
            $user_id

        ) {
            $query->on('business_disbursement.business_id', '=', 'business.id');
        });
        if (isset($params['searchPhrase']) && $params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = "%" . $searchValue . "%";


            $query->where(function ($query) use (
                $likeSet
            ) {
                $query->where($this->table . '.description', 'like', $likeSet);
                $query->orWhere($this->table . '.title', 'like', $likeSet);
                $query->orWhere($this->table . '.email', 'like', $likeSet);
                $query->orWhere($this->table . '.page_url', 'like', $likeSet);
                $query->orWhere($this->table . '.phone_value', 'like', $likeSet);

            });

        }
        $query->where("business_by_employee_profile.user_id", "=", $user_id);


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

    public function getDataManager($params)
    {

        $sort = 'asc';
        $field = $this->table . '.title';
        $query = DB::table($this->table);
        $user = Auth::user();
        $user_id = $user->id;
        if (isset($params['sort']) && count($params['sort']) > 0) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];

        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $selectString = "$this->table.id ,$this->table.options_map,$this->table.description ,$this->table.title ,$this->table.email,$this->table.page_url,$this->table.phone_value,$this->table.street_1,$this->table.street_2,$this->table.street_lat,$this->table.street_lng,$this->table.user_id,$this->table.business_subcategories_id,$this->table.status,$this->table.qualification,$this->table.source
 ,business_subcategories.name business_subcategories
 ,business_categories.name business_categories,business_categories.id business_categories_id
 ,countries.name countries,countries.id countries_id
         ,zones.name zone,zones.id zones_id
        ,cities.name city,cities.id cities_id
 ,provinces.name province,provinces.id provinces_id
 ,business_location.id business_location_id
 ,business_disbursement.id business_disbursement_id,business_disbursement.bank_id,business_disbursement.account_number,business_disbursement.type_account";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->leftJoin('business_subcategories', $this->table . ".business_subcategories_id", '=', 'business_subcategories.id');
        $query->leftJoin('business_categories', "business_subcategories.business_categories_id", '=', 'business_categories.id');
        $query->leftJoin('business_location', function ($query)
        use (
            $selectString

        ) {
            $query->on('business_location.business_id', '=', 'business.id');
            $query->join('zones', "business_location.zones_id", '=', 'zones.id');
            $query->join('cities', "zones.city_id", '=', 'cities.id');
            $query->join('provinces', "cities.province_id", '=', 'provinces.id');
            $query->join('countries', "provinces.country_id", '=', 'countries.id');

        });

        $query->leftJoin('business_disbursement', function ($query)
        use (
            $user_id

        ) {
            $query->on('business_disbursement.business_id', '=', 'business.id');
        });
        if (isset($params['searchPhrase']) && $params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = "%" . $searchValue . "%";


            $query->where(function ($query) use (
                $likeSet
            ) {
                $query->where($this->table . '.description', 'like', $likeSet);
                $query->orWhere($this->table . '.title', 'like', $likeSet);
                $query->orWhere($this->table . '.email', 'like', $likeSet);
                $query->orWhere($this->table . '.page_url', 'like', $likeSet);
                $query->orWhere($this->table . '.phone_value', 'like', $likeSet);

            });

        }
        $query->where($this->table . ".user_id", "=", $user_id);
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

    public function getAdminEmployer($params)
    {
        $result = $this->getDataManagerEmployer($params);
        $modelAmenities = new BusinessAmenities();

        foreach ($result['rows'] as $key => $row) {

            $business_id = $row->id;
            $setPush = (array)$row;
            $result['rows'][$key] = $setPush;

            $amenities = $modelAmenities->getAmenitiesBusiness([
                'filters' => [
                    'business_id' => $business_id
                ]
            ]);
            $result['rows'][$key]['amenities'] = $amenities;


        }
        return $result;
    }

    public function getAdmin($params)
    {
        $result = $this->getDataManager($params);
        $modelAmenities = new BusinessAmenities();

        foreach ($result['rows'] as $key => $row) {

            $business_id = $row->id;
            $setPush = (array)$row;
            $result['rows'][$key] = $setPush;

            $amenities = $modelAmenities->getAmenitiesBusiness([
                'filters' => [
                    'business_id' => $business_id
                ]
            ]);
            $result['rows'][$key]['amenities'] = $amenities;


        }
        return $result;
    }

    public
    function saveData()
    {

    }

    public
    function getAllBusinessFrontend($params = array())
    {
        $selectString = "$this->table.id ,$this->table.description ,$this->table.title alt,$this->table.email,$this->table.page_url,$this->table.phone_value,$this->table.street_1,$this->table.street_2,$this->table.street_lat,$this->table.street_lng,$this->table.user_id,$this->table.business_subcategories_id,$this->table.status,$this->table.qualification,$this->table.source
 ,business_subcategories.name business_subcategories
 ,business_categories.name business_categories,business_categories.id business_categories_id
 ,countries.name countries,countries.id countries_id
         ,zones.name zone,zones.id zones_id
        ,cities.name city,cities.id cities_id
 ,provinces.name province,provinces.id provinces_id
 ";
        $select = DB::raw($selectString);
        $query = Business::query()->select($select);
        $query->join('business_subcategories', $this->table . ".business_subcategories_id", '=', 'business_subcategories.id');
        $query->join('business_categories', "business_subcategories.business_categories_id", '=', 'business_categories.id');
        $query->leftJoin('business_location', function ($query)
        use (
            $selectString

        ) {
            $query->on('business_location.business_id', '=', 'business.id');
            $query->join('zones', "business_location.zones_id", '=', 'zones.id');
            $query->join('cities', "zones.city_id", '=', 'cities.id');
            $query->join('provinces', "cities.province_id", '=', 'provinces.id');
            $query->join('countries', "provinces.country_id", '=', 'countries.id');

        });
        $query->where("$this->table.status", '=', self::STATUS_ACTIVE);

        $data = $query->get()->toArray();

        return $data;
    }

    public
    function saveDataFrontend($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        $data = array();
        DB::beginTransaction();
        try {
            $modelName = 'Business';
            $model = new Business();
            $createUpdate = true;
            $paramsModelBusiness = [

            ];
            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = Business::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
                $paramsModelBusiness = [
                    'id' => $attributesPost[$modelName]['id']
                ];
            }
            $informationSocialNetworkData = $attributesPost[$modelName];
            $attributesSet['description'] = isset($attributesPost[$modelName]['description']) ? $attributesPost[$modelName]['description'] : $model->description;
            $attributesSet['title'] = isset($attributesPost[$modelName]['title']) ? $attributesPost[$modelName]['title'] : $model->title;
            $attributesSet['page_url'] = isset($attributesPost[$modelName]['page_url']) ? $attributesPost[$modelName]['page_url'] : $model->page_url;
            $attributesSet['phone_value'] = isset($attributesPost[$modelName]['phone_value']) ? $attributesPost[$modelName]['phone_value'] : $model->phone_value;
            $attributesSet['email'] = isset($attributesPost[$modelName]['email']) ? $attributesPost[$modelName]['email'] : $model->email;
            $attributesSet['street_1'] = isset($attributesPost[$modelName]['street_1']) ? $attributesPost[$modelName]['street_1'] : $model->street_1;
            $attributesSet['street_2'] = isset($attributesPost[$modelName]['street_2']) ? $attributesPost[$modelName]['street_2'] : $model->street_2;
            $attributesSet['street_lng'] = isset($attributesPost[$modelName]['street_lng']) ? $attributesPost[$modelName]['street_lng'] : $model->street_lng;
            $attributesSet['street_lat'] = isset($attributesPost[$modelName]['street_lat']) ? $attributesPost[$modelName]['street_lat'] : $model->street_lat;
            $attributesSet['status'] = isset($attributesPost[$modelName]['status']) ? $attributesPost[$modelName]['status'] : $model->status;
            $attributesSet['countries_id'] = isset($attributesPost[$modelName]['countries_id']) ? $attributesPost[$modelName]['countries_id'] : $model->countries_id;
            $attributesSet['qualification'] = isset($attributesPost[$modelName]['qualification']) ? $attributesPost[$modelName]['qualification'] : $model->qualification;
            $attributesSet['options_map'] = isset($attributesPost[$modelName]['options_map']) ? $attributesPost[$modelName]['options_map'] : $model->options_map;
            $attributesSet['status'] = isset($attributesPost[$modelName]['status']) ? $attributesPost[$modelName]['status'] : $model->status;
            $attributesSet['source'] = isset($attributesPost[$modelName]['source']) ? $attributesPost[$modelName]['source'] : ($model->source == '' ? 'not-source' : $model->source);
            $attributesSet['user_id'] = isset($attributesPost[$modelName]['user_id']) ? $attributesPost[$modelName]['user_id'] : $model->user_id;
            $attributesSet['business_subcategories_id'] = isset($attributesPost[$modelName]['business_subcategories_id']) ? $attributesPost[$modelName]['business_subcategories_id'] : $model->business_subcategories_id;
            $attributesSet['has_document'] = isset($attributesPost[$modelName]['has_document']) ? $attributesPost[$modelName]['has_document'] : $model->has_document;
            $attributesSet['has_about'] = isset($attributesPost[$modelName]['has_about']) ? $attributesPost[$modelName]['has_about'] : $model->has_about;

            $paramsValidate = array(
                'inputs' => $attributesSet,
                'rules' => self::getRulesModel(
                    $paramsModelBusiness
                ),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            if ($success) {

                $model->fill($attributesSet);
                $success = $model->save();
            } else {
                $success = false;
                $msj = "Problemas al guardar  Business.";
                $errors = $validateResult["errors"];
            }
            if (!$success) {
                DB::rollBack();

            } else {
                $modelTCU = new TemplateContactUs();
                $business_id = $informationSocialNetworkData['id'];
                $template_information_id = $informationSocialNetworkData['template_information_id'];

                $data = $modelTCU->getContactUsData([
                    'filters' => [
                        'business_id' => $business_id,
                        'template_information_id' => $template_information_id,

                    ]

                ]);
                $data['business_id'] = $business_id;
                $data['model_id'] = $template_information_id;

                DB::commit();
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
                "errors" => $errors
            );
            return ($result);
        }
    }

    public
    function getBusinessFrontend($params = array())
    {
        $business_id = $params['filters']['business_id'];
        $selectString = "$this->table.id ,$this->table.options_map,$this->table.description ,$this->table.title alt,$this->table.title,$this->table.email,$this->table.page_url,$this->table.phone_value,$this->table.street_1,$this->table.street_2,$this->table.street_lat,$this->table.street_lng,$this->table.user_id,$this->table.business_subcategories_id,$this->table.status,$this->table.qualification,$this->table.source
 ,business_subcategories.name business_subcategories
 ,business_categories.name business_categories,business_categories.id business_categories_id
 ,countries.name countries,countries.id countries_id,countries.phone_code
         ,zones.name zone,zones.id zones_id
        ,cities.name city,cities.id cities_id
 ,provinces.name province,provinces.id provinces_id

 ";
        $select = DB::raw($selectString);
        $query = Business::query()->select($select);
        $query->join('business_subcategories', $this->table . ".business_subcategories_id", '=', 'business_subcategories.id');
        $query->join('business_categories', "business_subcategories.business_categories_id", '=', 'business_categories.id');

        $query->leftJoin('business_location', function ($query)
        use (
            $selectString

        ) {

            $query->on('business_location.business_id', '=', 'business.id');
            $query->join('zones', "business_location.zones_id", '=', 'zones.id');
            $query->join('cities', "zones.city_id", '=', 'cities.id');
            $query->join('provinces', "cities.province_id", '=', 'provinces.id');
            $query->join('countries', "provinces.country_id", '=', 'countries.id');

        });
        $query->where("$this->table.status", '=', self::STATUS_ACTIVE);
        $query->where("$this->table.id", '=', $business_id);
        $data = $query->first();

        return $data;
    }

    public function getData($params)
    {
        $sort = 'asc';
        $field = $this->table . '.title';
        $query = DB::table($this->table);
        $user = Auth::user();

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];

        }
        if ($user) {
            $user_id = $user->id;
        }
        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $managerQuery = $this->getManagerConfigBee(
            [
                'query' => $query,
                'params' => $params
            ]
        );
        $query = $managerQuery['query'];
        if (isset($params['searchPhrase']) && $params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = "%" . $searchValue . "%";
            $query->where(function ($query) use (
                $likeSet
            ) {
                $query->where($this->table . '.description', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.title', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.email', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.phone_value', 'like', '%' . $likeSet . '%');
            });

        }
        $query->where($this->table . '.status', '=', Patient::STATUS_ACTIVE);
        $category_id = isset($params['filters']['category_id']) ? (($params['filters']['category_id'] != '' && $params['filters']['category_id']) ? $params['filters']['category_id'] : null) : null;
        if ($category_id) {
            $query->where("business_categories.id", "=", $category_id);
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

    public function getPopularListBee($params)
    {
        $result = $this->getData($params);
        return $result;
    }

    public function getAdminBee($params)
    {
        $result = $this->getData($params);
        return $result;
    }

    public function getDetailsBee($params)
    {
        $sort = 'asc';
        $field = $this->table . '.title';
        $query = DB::table($this->table);
        $user = Auth::user();
        $businessId = $params['filters']['business_id'];

        if ($user) {
            $user_id = $user->id;
        }
        $managerQuery = $this->getManagerConfigBee(
            [
                'query' => $query,
                'params' => $params
            ]
        );

        $query = $managerQuery['query'];
        $query->where($this->table . '.id', "=", $businessId);
        $query->orWhere($this->table . '.title', "=", $businessId);
        $query->orderBy($field, $sort);
        $data = $query->get()->first();

        $result = $data;
        return $result;
    }

    public function getManagerConfigBee($params)
    {

        $query = $params['query'];
        $getSelectBeeString = "$this->table.id ,$this->table.has_document,$this->table.has_about,$this->table.options_map,$this->table.description ,$this->table.title ,$this->table.email,$this->table.page_url,$this->table.phone_value,$this->table.street_1,$this->table.street_2,$this->table.street_lat,$this->table.street_lng,$this->table.user_id,$this->table.business_subcategories_id,$this->table.status,$this->table.qualification,$this->table.source
 ,business_subcategories.name business_subcategories
 ,business_categories.name business_categories,business_categories.id business_categories_id
 ,countries.name countries,countries.phone_code countries_phone_code,countries.place_id countries_place_id,countries.iso_codes countries_iso_codes
 ,users.name user_name,users.username,users.email user_email,users.avatar,users.provider ,users.provider_id
,countries.id countries_id
         ,zones.name zone,zones.id zones_id
        ,cities.name city,cities.id cities_id
 ,provinces.name province,provinces.id provinces_id

 ";

        $select = DB::raw($getSelectBeeString);
        $query->select($select);
        $query->join('business_subcategories', $this->table . ".business_subcategories_id", '=', 'business_subcategories.id');
        $query->join('business_categories', "business_subcategories.business_categories_id", '=', 'business_categories.id');
        $query->leftJoin('business_location', function ($query)
        use (
            $getSelectBeeString

        ) {
            $query->on('business_location.business_id', '=', 'business.id');
            $query->join('zones', "business_location.zones_id", '=', 'zones.id');
            $query->join('cities', "zones.city_id", '=', 'cities.id');
            $query->join('provinces', "cities.province_id", '=', 'provinces.id');
            $query->join('countries', "provinces.country_id", '=', 'countries.id');

        });
        $query->join('users', $this->table . ".user_id", '=', 'users.id');

        $query = $params['query'];
        return [
            'getSelectBeeString' => $getSelectBeeString,
            'query' => $query
        ];
    }

    public function getCountBusinessByCategory($params)
    {

        $business_categories_id = $params['filters']['business_categories_id'];
        $query = DB::table($this->table);
        $selectString = "business_subcategories.id";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->where($this->table . '.status', '=', 'ACTIVE');
        $query->join('business_subcategories', "$this->table.business_subcategories_id", '=', 'business_subcategories.id');
        $query->join('business_categories', "business_subcategories.business_categories_id", '=', 'business_categories.id');
        $query->where('business_categories.id', '=', $business_categories_id);
        $result = $query->get()->count();
        return $result;

    }

    public
    function getManagementBusinessEvents($params)
    {
        $sort = 'asc';
        $field = 'status';
        $query = DB::table($this->table);
        $business_id = $params['filters']['business_id'];
        $events_trails_project_id = $params['filters']['events_trails_project_id'];


        $selectString = "$this->table.id,$this->table.description,$this->table.options_map,$this->table.title,$this->table.email,$this->table.page_url,$this->table.phone_value,$this->table.street_1,$this->table.street_2,$this->table.street_lat,$this->table.street_lng,$this->table.street_lat,$this->table.business_subcategories_id,$this->table.status,$this->table.qualification
        ,countries.name countries_name,countries.place_id countries_place_id,countries.id countries_id
                ,zones.name zone,zones.id zone_id
        ,cities.name city,cities.id city_id
 ,provinces.name province,provinces.id province_id

        ,business_subcategories.id business_subcategories_id,business_subcategories.name business_subcategories_name
         ,business_categories.id business_categories_id,business_categories.name business_categories_name ,$this->table.title text";

        $select = DB::raw($selectString);
        $query->select($select);

        $query->leftJoin('business_location', function ($query)
        use (
            $selectString

        ) {


            $query->on('business_location.business_id', '=', 'business.id');
            $query->join('zones', "business_location.zones_id", '=', 'zones.id');
            $query->join('cities', "zones.city_id", '=', 'cities.id');
            $query->join('provinces', "cities.province_id", '=', 'provinces.id');
            $query->join('countries', "provinces.country_id", '=', 'countries.id');
        });
        $query->join('business_subcategories', "$this->table.business_subcategories_id", '=', 'business_subcategories.id');
        $query->join('business_categories', "business_subcategories.business_categories_id", '=', 'business_categories.id');


        $query->whereNotIn("$this->table.id", [$business_id]);
        if (isset($params['filters']['search_value']['term'])) {

            $searchValue = $params['filters']['search_value']['term'];
            $likeSet = $searchValue;

            $query->where(function ($query) use (
                $likeSet
            ) {

                $query
                    ->where("business.title", 'like', '%' . $likeSet . '%')
                    ->orWhere("business.email", 'like', '%' . $likeSet . '%')
                    ->orWhere("business.phone_value", 'like', '%' . $likeSet . '%')
                    ->orWhere('countries.name', 'like', '%' . $likeSet . '%')
                    ->orWhere('business_subcategories.name', 'like', '%' . $likeSet . '%');
            });
        }
        $query->orderBy($field, $sort);

        $result = $query->get()->toArray();


        return $result;
    }

    public function getEntityManager($params)
    {
        $businessId = $params["businessId"];
        $query = DB::table($this->table);
        $getSelectBeeString = "$this->table.id ,$this->table.has_document,$this->table.has_about,$this->table.options_map,$this->table.description ,$this->table.title ,$this->table.email,$this->table.page_url,$this->table.phone_value,$this->table.street_1,$this->table.street_2,$this->table.street_lat,$this->table.street_lng,$this->table.user_id,$this->table.business_subcategories_id,$this->table.status,$this->table.qualification,$this->table.source
 ,$this->table.document  documento,$this->table.title  razon_comercial,$this->table.entity_position_fiscal_id  entidad_posicion_fiscal_id,$this->table.business_name razon_social,$this->table.keep_accounting,$this->table.type_ruc_id,$this->table.allow_cash_and_banks,$this->table.entity_plans_id
        ,ep.name plane_name

 ,business_subcategories.name business_subcategories
 ,business_categories.name business_categories,business_categories.id business_categories_id
 ,countries.name countries,countries.phone_code countries_phone_code,countries.place_id countries_place_id,countries.iso_codes countries_iso_codes
 ,users.name user_name,users.username,users.email user_email,users.avatar,users.provider ,users.provider_id
,countries.id countries_id
         ,zones.name zone,zones.id zones_id
        ,cities.name city,cities.id cities_id
 ,provinces.name province,provinces.id provinces_id
,$this->table.description descripcion
 ";

        $select = DB::raw($getSelectBeeString);
        $query->select($select);
        $query->join('business_subcategories', $this->table . ".business_subcategories_id", '=', 'business_subcategories.id');
        $query->join('business_categories', "business_subcategories.business_categories_id", '=', 'business_categories.id');
        $query->join('users', $this->table . ".user_id", '=', 'users.id');
        $query->join('entity_plans', $this->table . ".entity_plans_id", '=', 'entity_plans.id');

        $query->leftJoin('business_location', function ($query)
        use (
            $getSelectBeeString

        ) {
            $query->on('business_location.business_id', '=', 'business.id');
            $query->join('zones', "business_location.zones_id", '=', 'zones.id');
            $query->join('cities', "zones.city_id", '=', 'cities.id');
            $query->join('provinces', "cities.province_id", '=', 'provinces.id');
            $query->join('countries', "provinces.country_id", '=', 'countries.id');

        });
        $query->join('entity_plans as ep', $this->table . ".entity_plans_id", '=', 'entity_plans.id');

        $query->where('business.id', '=', $businessId);

        $result = $query->first();


        return $result;
    }
}
