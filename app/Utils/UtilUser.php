<?php

namespace App\Utils;


use App\Models\Customer;
use App\Models\CustomerByInformation;
use App\Models\CustomerByProfile;
use App\Models\InformationPhone;
use App\Models\InformationPhoneType;
use App\Models\People;
use App\Models\Role;
use App\Models\RucType;
use App\Models\UsersHasRoles;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Models\PeopleTypeIdentification;
use App\Models\PeopleGender;
use App\Rules\DocumentIdentification;

use Hash;
use Redirect;
use Auth;

class UtilUser
{
    const TYPE_SAVE_NORMAL = 1;
    const TYPE_SAVE_BUSINESS = 2;
    const TYPE_SAVE_CUSTOMER = 3;
    const TYPE_SAVE_CUSTOMER_APP = 7;

    const TYPE_SAVE_CUSTOMER_CHECKOUT = 4;
    const TYPE_SAVE_CUSTOMER_FACEBOOK = 5;
    const TYPE_SAVE_CUSTOMER_GOOGLE = 6;

    const PROVIDER_FACEBOOK = 'facebook';
    const PROVIDER_GOOGLE = 'google';
    const PROVIDER_OWNER_SERVER = 'server';
    use RegistersUsers;

// guard() RegistersUsers
//registered() RegistersUsers
    public function register(Request $request)//overwrite RegistersUsers
    {
        return $this->saveUser(array(
            'typeSave' => UtilUser::TYPE_SAVE_BUSINESS,
            'request' => $request
        ));

    }

    public function getDataEmployerBusiness()
    {
        $url = '';
        if (env('managerBusinessFrontendType') == RouteServiceProvider::TYPE_EAT_PURA_BUSINESS) {
            $url = route('homeEatPura', app()->getLocale());

        } else {

            $url = route('homeEatPura', app()->getLocale());


        }

        return $url;
    }

    public function getUrlUser($user)//URL-INIT 1
    {
        $user = Auth::user();
        $url = $this->getUrlUserLogin($user);


        return $url;
    }

    public function getRouteHome()//URL-INIT 1
    {
        $user = Auth::user();
        $url = $this->getUrlUserLogin($user);


        return $url;
    }

    public function getUrlUserLogout($user)
    {
        $urlRoot = app()->getLocale();
        $urlNext = (!env('allowAllInOne') ? env('pageInitLogout') : env('pageInitLogoutNotAllInOne'));

        if (env('allowRoutes')) {
            $urlNext = '/';
        }

        if (env('managerBusinessFrontendType') == RouteServiceProvider::TYPE_EAT_PURA_BUSINESS) {
            $urlNext = 'es' . RouteServiceProvider::HOME_INIT_LOGOUT_EAT_PURA;

        } else {
            $routeCurrent = route('homeIndexFrontendWeb', "es");
            $urlManager = $routeCurrent;
            $resultUrl = "";
            if (preg_match("#/(en|es|ki)/.*$#", $urlManager, $matches)) {
                $resultUrl = $matches[0];
            }
            $urlNext = $resultUrl;

        }
        return $urlNext;
    }

    public function getUrlUserLogin($user)//URL-INIT
    {
        $urlRoot = app()->getLocale();
        $managerBusinessFrontendType = env('managerBusinessFrontendType');


        $url = '';
        $caseType = -1;
        $optionsConfiguration = [
            "url" => null,
            "type" => null,

        ];
        if ($user) {
            $caseType = 2;
            $optionsConfiguration["type"] = $caseType;
            if ($managerBusinessFrontendType != null) {
                $caseType = 3;
                $optionsConfiguration["type"] = $caseType;

                if ($managerBusinessFrontendType == RouteServiceProvider::TYPE_EAT_PURA_BUSINESS) {
                    $url = '/es' . RouteServiceProvider::HOME_INIT_LOGIN_EAT_PURA;
                    $caseType = 4;


                } else {

                    $routeCurrent = route('profileAccount', "es");
                    $urlManager = $routeCurrent;
                    $resultUrl = "";
                    if (preg_match("#/(en|es|ki)/.*$#", $urlManager, $matches)) {
                        $resultUrl = $matches[0];
                    }
                    $url = $resultUrl;
                    $caseType = 5;


                }


            } else {
                $caseType = 6;

                $modelBBE = new \App\Models\BusinessByEmployeeProfile();
                $dataFirstBusiness = $modelBBE->getUserEmployerInformation([
                    'user_id' => $user->id
                ]);
                if ($dataFirstBusiness) {
                    $caseType = 7;

                    $businessId = $dataFirstBusiness->id;
                    $url = "/managerBusiness/" . $businessId . "/managerDashboard";

                } else {
                    $caseType = 8;

                    $url = "/";

                }


            }
        } else {
            $caseType = 9;

            $url = '/es' . RouteServiceProvider::HOME_INIT_LOGIN_MEETCLIC;

        }
        $optionsConfiguration["url"] = $url;
        $optionsConfiguration["type"] = $caseType;


        return $url;
    }

    public static function rulesType($params)
    {
        $data = isset($params['data']) ? $params['data'] : [];
        $typeSave = $params['typeSave'];
        $rules =
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'min:8'],
            ];
        if ($typeSave == self::TYPE_SAVE_CUSTOMER) {
            $rules =
                [
                    //CUSTOMER
                    'identification_document' => ['required', 'string', 'max:45', 'unique:customer', new DocumentIdentification($data)],
                    "people_type_identification_id" => ["required", "numeric"],
                    //PEOPLE
                    'last_name' => ['required', 'string', 'max:100'],
                    'birthdate' => ['required'],
                    'gender' => ['required', 'numeric'],
                    //USER
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password' => ['required', 'min:8'],
                    'mobile' => ['required'],

                ];

        } else if ($typeSave == self::TYPE_SAVE_CUSTOMER_CHECKOUT) {
            $rules =
                [
                    //CUSTOMER
                    'identification_document' => ['required', 'string', 'max:45', 'unique:customer', new DocumentIdentification($data)],
                    "people_type_identification_id" => ["required", "numeric"],
                    //PEOPLE
                    'last_name' => ['required', 'string', 'max:100'],
                    'birthdate' => ['required'],
                    'gender' => ['required', 'numeric'],
                    //USER
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password' => ['required', 'min:8'],
                ];

        } else if ($typeSave == self::TYPE_SAVE_CUSTOMER_APP) {
            $rules =
                [
                    //CUSTOMER
                    'identification_document' => ['required', 'string', 'max:45', 'unique:customer', new DocumentIdentification($data)],
                    "people_type_identification_id" => ["required", "numeric"],
                    //PEOPLE
                    'last_name' => ['required', 'string', 'max:100'],
                    'birthdate' => ['required'],
                    'gender' => ['required', 'numeric'],
                    //USER
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password' => ['required', 'min:8'],
                ];

        }

        return $rules;
    }

    public function saveCustomer($params)
    {

        $dataPost = $params['dataPost'];
        $success = false;
        $msj = "";
        $result = array();
        $errors = array();
        $data = array();


        try {

            $typeSave = $params['typeSave'];
            $age = 0;
            $attributesSet = array(
                'last_name' => $dataPost['last_name'],
                'name' => $dataPost['name'],
                'birthdate' => $dataPost['birthdate'],
                'age' => $age,
                'gender' => $dataPost['gender'],

            );

            $validateResult = People::validateModel($attributesSet);
            $success = $validateResult["success"];

            if ($success) {
                $model = new People();
                $model->fill($attributesSet);
                $model->save();
                $data['People'] = $attributesSet;
                $people_id = $model->id;
                $data['People']['id'] = $people_id;

                $modelC = new Customer();
                $attributesSet = array(
                    "identification_document" => $dataPost["identification_document"],
                    "people_type_identification_id" => $dataPost["people_type_identification_id"],
                    "people_id" => $people_id,
                    "business_name" => isset($dataPost["business_name"]) ? $dataPost["business_name"] : "",
                    "business_reason" => isset($dataPost["business_reason"]) ? $dataPost["business_reason"] : "",
                    "ruc_type_id" => isset($dataPost["ruc_type_id"]) ? $dataPost["ruc_type_id"] : RucType::RUC_TYPE_ANY,
                );

                $validateResult = Customer::validateModel($attributesSet);
                $success = $validateResult["success"];
                if ($success) {
                    $modelC->fill($attributesSet);
                    $modelC->save();
                    $data['Customer'] = $attributesSet;
                    $customer_id = $modelC->id;
                    $data['Customer']['id'] = $customer_id;
                    $people_nationality_id = isset($dataPost["people_nationality_id"]) ? $dataPost["people_nationality_id"] : \App\Models\PeopleNationality::TYPE_ANYONE;
                    $people_profession_id = isset($dataPost["people_profession_id"]) ? $dataPost["people_profession_id"] : \App\Models\PeopleProfession::TYPE_ANYONE;
                    $attributesSet = array(
                        "customer_id" => $customer_id,
                        "people_nationality_id" => $people_nationality_id,
                        "people_profession_id" => $people_profession_id,
                    );
                    $validateResult = CustomerByInformation::validateModel($attributesSet);
                    $success = $validateResult["success"];
                    if (!$success) {
                        $success = false;
                        $msj = "Problemas al guardar Informacion .";
                        $errors = $validateResult["errors"];
                        $data['CustomerByInformation']['errors'] = $errors;
                        throw new \Exception($msj);
                    } else {
                        $modelCBI = new CustomerByInformation();
                        $modelCBI->fill($attributesSet);
                        $modelCBI->save();
                        $data['CustomerByInformation'] = $attributesSet;
                        $data['CustomerByInformation']['id'] = $modelCBI->id;
                    }
                    if (isset($dataPost["mobile"])) {
                        $attributesSet = array(
                            "value" => $dataPost["mobile"],
                            "entity_id" => $customer_id,
                            "main" => 1,
                            "entity_type" => 0,
                            "information_phone_operator_id" => \App\Models\InformationPhoneOperator::OPERATOR_NOT_SPECIFIC_ID,//anyone
                            "information_phone_type_id" => \App\Models\InformationPhoneType::TYPE_WORKFORCE_ID,//personal
                            "state" => 'ACTIVE',

                        );
                        $validateResult = InformationPhone::validateModel(array(
                            'inputs' => $attributesSet,
                            'rules' => InformationPhone::getRulesModel(),
                        ));
                        $success = $validateResult["success"];
                        if (!$success) {
                            $success = false;
                            $msj = "Problemas al guardar Informacion Phone .";
                            $errors = $validateResult["errors"];
                            $data['InformationPhone']['errors'] = $errors;
                            throw new \Exception($msj);
                        } else {
                            $modelIP = new InformationPhone();
                            $modelIP->fill($attributesSet);
                            $modelIP->save();
                            $data['InformationPhone'] = $attributesSet;
                            $data['InformationPhone']['id'] = $modelIP->id;
                        }
                    }

                } else {
                    if ($validateResult["success"]) {
                        $data['Customer']["errors"] = $validateResult["errors"];
                    }
                }
            } else {
                $success = false;
                $msj = "Problemas al guardar People .";
                $errors = $validateResult["errors"];
                throw new \Exception($msj);

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


    public function saveUserTypes($params)
    {

        DB::beginTransaction();
        $success = false;
        $typeSave = $params['typeSave'];
        $dataPost = $params['data'];
        $msj = '';
        $errors = '';
        $request = isset($params['request']) ? $params['request'] : null;
        $paramsSave = array(
            'data' => $dataPost,
            'typeSave' => $typeSave
        );
        $result = null;
        if ($typeSave == UtilUser::TYPE_SAVE_NORMAL) {

            if ($this->create($dataPost)) {
                $result = redirect()->route('login', app()->getLocale())
                    ->with(['success' => 'Congratulations! your account is registered.']);
                DB::commit();
                return $result;
            } else {
                DB::rollBack();

            }
        } else if ($typeSave == UtilUser::TYPE_SAVE_BUSINESS) {

            $user = $this->create($dataPost);
            if ($user) {
                event(new Registered($user));
                $this->guard()->login($user);
                $this->registered($request, $user);
                $role = new Role();
                $hasRolesUser = new UsersHasRoles();
                $role_id = Role::ROL_BUSINESS;
                UsersHasRoles::create([
                    'user_id' => $user->id,
                    'role_id' => $role_id,
                ]);
                $roles = $hasRolesUser->getRolesUser($user->id);
                $redirectTo = $this->getUrlUser($user);
                $result = Redirect::to($redirectTo);
                DB::commit();
                return $result;
            } else {
                $result = Redirect::to('registerBusiness');
                DB::rollBack();
                return $result;
            }

        } else if ($typeSave == UtilUser::TYPE_SAVE_CUSTOMER) {//CMS-TEMPLATE-USER-REGISTER
            $resultSaveCustomer = UtilUser::saveCustomer(array(
                'dataPost' => $dataPost,
                "typeSave" => $typeSave
            ));
            $successCustomer = $resultSaveCustomer['success'] ? 1 : 0;
            $typeManagerMsj = $resultSaveCustomer['success'] ? '' : 'msj';
            if ($successCustomer == 1) {
                $success = true;
                $user = $this->create($dataPost);
                $user_id = $user->id;
                event(new Registered($user));
                $this->guard()->login($user);
                $this->registered($request, $user);
                $role_id = Role::ROL_CUSTOMER;
                UsersHasRoles::create([
                    'user_id' => $user->id,
                    'role_id' => $role_id,
                ]);
                $customerData = $resultSaveCustomer['data']['Customer'];
                $attributesSet = array(
                    "customer_id" => $customerData['id'],
                    "user_id" => $user_id,
                );
                $validateResult = CustomerByProfile::validateModel($attributesSet);
                $success = $validateResult["success"];
                if (!$success) {
                    $msj = "Problemas al guardar Usuario y Perfil .";
                    $errors = $validateResult["errors"];

                } else {
                    $modelCBP = new CustomerByProfile();
                    $modelCBP->fill($attributesSet);
                    $modelCBP->save();

                    $modelMovement = new \App\Models\AccountGamification();
                    $managerUser = $modelMovement->managerUserRegister(
                        ['filters' => [
                            'user_id' => $user_id
                        ]]
                    );
                    $success = $managerUser['success'];
                    $msj = $managerUser['msj'];
                    $redirectTo = $this->getUrlUser($user);

                }

            } else {
                $redirectTo = 'register';
                $success = false;

            }

            if (!$success) {
                DB::rollBack();
                return Redirect::to($redirectTo)->with('success', $success)->with('msj', $msj);

            } else {
                DB::commit();
                return Redirect::to($redirectTo);

            }

            return Redirect::to($redirectTo)->with('msg', $msj);


        } else if ($typeSave == UtilUser::TYPE_SAVE_CUSTOMER_CHECKOUT) {
            $data = [];

            $resultSaveCustomer = UtilUser::saveCustomer(array(
                'dataPost' => $dataPost,
                "typeSave" => $typeSave
            ));
            $successCustomer = $resultSaveCustomer['success'] ? 1 : 0;

            $msj = $resultSaveCustomer['msj'];
            $errors = $resultSaveCustomer['errors'];
            $success = $successCustomer == 1 ? true : false;
            if ($success) {
                $user = $this->create($dataPost);
                $user_id = $user->id;
                event(new Registered($user));
                $this->guard()->login($user);
                $role_id = Role::ROL_CUSTOMER;
                UsersHasRoles::create([
                    'user_id' => $user->id,
                    'role_id' => $role_id,
                ]);
                $customerData = $resultSaveCustomer['data']['Customer'];
                $attributesSet = array(
                    "customer_id" => $customerData['id'],
                    "user_id" => $user_id,
                );
                $validateResult = CustomerByProfile::validateModel($attributesSet);
                $customerByProfile = null;
                $success = $validateResult["success"];
                if (!$success) {
                    $success = false;
                    $msj = "Problemas al guardar Usuario y Perfil .";
                    $errors = $validateResult["errors"];
                } else {
                    $modelCBP = new CustomerByProfile();
                    $modelCBP->fill($attributesSet);
                    $allowSave=  $modelCBP->save();
                    $attributesSet["id"]=$modelCBP->id;
                    $customerByProfile =$attributesSet;
                }
                $data['Customer'] = $customerData;
                $data['User'] = $user;
                $data['CustomerByProfile'] = $customerByProfile;

                $result = [
                    'success' => $success,
                    'data' => $data,
                    'errors' => $errors,
                    'msj' => $msj
                ];

            } else {
                $result = [
                    'success' => $success,
                    'data' => $data,
                    'errors' => $errors,
                    'msj' => $msj
                ];
            }

            if (!$success) {
                DB::rollBack();
            } else {
                DB::commit();
            }


            return $result;
        } else if ($typeSave == UtilUser::TYPE_SAVE_CUSTOMER_APP) {
            $data = [];
            $resultSaveCustomer = UtilUser::saveCustomer(array(
                'dataPost' => $dataPost,
                "typeSave" => $typeSave
            ));
            $successCustomer = $resultSaveCustomer['success'] ? 1 : 0;
            $msj = $resultSaveCustomer['msj'];
            $errors = $resultSaveCustomer['errors'];
            $success = $successCustomer == 1 ? true : false;
            if ($success) {
                $user = $this->create($dataPost);
                $user_id = $user->id;
                event(new Registered($user));
                $this->guard()->login($user);
                $role_id = Role::ROL_CUSTOMER;
                UsersHasRoles::create([
                    'user_id' => $user->id,
                    'role_id' => $role_id,
                ]);
                $customerData = $resultSaveCustomer['data']['Customer'];
                $attributesSet = array(
                    "customer_id" => $customerData['id'],
                    "user_id" => $user_id,
                );
                $validateResult = CustomerByProfile::validateModel($attributesSet);
                $customerByProfile = null;
                $success = $validateResult["success"];
                if (!$success) {
                    $success = false;
                    $msj = "Problemas al guardar Usuario y Perfil .";
                    $errors = $validateResult["errors"];

                } else {
                    $modelCBP = new CustomerByProfile();
                    $modelCBP->fill($attributesSet);
                  $allowSave=  $modelCBP->save();
                    $attributesSet["id"]=$modelCBP->id;
                    $customerByProfile =$attributesSet;

                }
                $data['Customer'] = $customerData;
                $data['User'] = $user;
                $data['CustomerByProfile'] = $customerByProfile;
                $data['CustomerByProfile']["errors"] =  $validateResult["errors"];
                $data['CustomerByProfile']["msj"] =  $msj;

                $result = [
                    'success' => $success,
                    'data' => $data,
                    'errors' => $errors,
                    'msj' => $msj
                ];

            } else {
                $result = [
                    'success' => $success,
                    'data' => $data,
                    'errors' => $errors,
                    'msj' => $msj
                ];
            }

            if (!$success) {
                DB::rollBack();
            } else {
                DB::commit();
            }


            return $result;
        }


    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'provider' => self::PROVIDER_OWNER_SERVER
        ]);
    }

    protected function createAppUser(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'provider' => self::PROVIDER_OWNER_SERVER
        ]);
    }

    public function saveUserApp($params)
    {
        $request = $params['request'];
        $typeSave = $params['typeSave'];
        $dataPost = $request;
        $paramsSave = array(
            'data' => $dataPost,
            'typeSave' => $typeSave,
            'request' => $request
        );
        $result = [];

        $validation = $this->validator($paramsSave);

        if ($validation->fails()) {
            $errors = $validation->errors()->all();

            $errorsObject = $validation->errors();
            $errorsFields = [];
            $messageTotal = "";
            foreach ($errorsObject->messages() as $error => $value) {

                $errorsFields[$error] = $value;
                $messageTotal .= $value[0];
            }
            $result = [
                'success' => false,
                'data' => [
                    'errors' => $errorsFields,
                ],

                'message' => "Error de Datos de Entrada"
            ];

        } else {
            $result = $this->saveUserTypes($paramsSave);
        }

        return $result;
    }

    public function saveUser($params)
    {
        $request = $params['request'];
        $typeSave = $params['typeSave'];
        $dataPost = $request->all();
        $paramsSave = array(
            'data' => $dataPost,
            'typeSave' => $typeSave,
            'request' => $request
        );
        $validation = $this->validator($paramsSave);
        if ($validation->fails()) {
            $url = app()->getLocale() . '/register';
            return redirect($url)
                ->withErrors($validation)
                ->withInput();
        }
        $result = $this->saveUserTypes($paramsSave);
        return $result;
    }

    protected function validator($params)
    {

        $data = $params['data'];
        $rules = UtilUser::rulesType($params);
        $rulesValidation = Validator::make($data, $rules);
        app()->setLocale('es');
        return $rulesValidation;
    }

//FRONTEND
    const TYPE_PAYMENT_PAYPAL = 0;
    const TYPE_PAYMENT_CREDIT_CARDS = 1;
    const TYPE_PAYMENT_BANK_DEPOSIT = 2;
    const TYPE_PAYMENT_CASH = 3;
    const TYPE_PAYMENT_PAYMENT_AGAINST_DELIVERY = 4;

    public function managerUserCheckout($params)
    {
        $typePayment = $params['typePayment'];
        $dataCheckout = $params['dataCheckout'];
        $identification_document = isset($params['dataCheckout']->OrderBillingCustomer) ? $params['dataCheckout']->OrderBillingCustomer->document : uniqid();
        $name = '';
        $last_name = '';
        $people_type_identification_id = PeopleTypeIdentification::TYPE_OTHERS_ID;

        $gender = PeopleGender::GENDER_MALE_ID;
        $birthdate = date("Y-m-d");
        $mobile = '';
        $email = '';

        $password = $identification_document;
        $typeSave = UtilUser::TYPE_SAVE_CUSTOMER_CHECKOUT;
        $errors = [];
        $msj = '';
        $data = [];
        $success = false;
        if (self::TYPE_PAYMENT_PAYPAL == $typePayment) {
            $OrderBillingCustomer = $dataCheckout->OrderBillingCustomer;
            $User = $dataCheckout->User;

            $name = $OrderBillingCustomer->first_name;
            $last_name = $OrderBillingCustomer->last_name;
            $mobile = $OrderBillingCustomer->phone;
            $email = $User->email;
        } else if (self::TYPE_PAYMENT_CREDIT_CARDS == $typePayment) {

        } elseif (self::TYPE_PAYMENT_BANK_DEPOSIT == $typePayment) {

        } elseif (self::TYPE_PAYMENT_PAYMENT_AGAINST_DELIVERY == $typePayment) {

        }
        $userData = [
            'name' => $name,
            'last_name' => $last_name,
            'people_type_identification_id' => $people_type_identification_id,
            'identification_document' => $identification_document,
            'gender' => $gender,
            'birthdate' => $birthdate,
            'mobile' => $mobile,
            'email' => $email,
            'password' => $password,
        ];
        $rules = UtilUser::rulesType([
            'typeSave' => $typeSave
        ]);
        $resultValidate = $this->validateModel([
            'inputs' => $userData,
            'rules' => $rules,

        ]);

        $success = $resultValidate['success'];
        if ($success) {

            $paramsSave = array(
                'data' => $userData,
                'typeSave' => $typeSave,
            );
            $resultSaveUser = $this->saveUserTypes($paramsSave);
            $success = $resultSaveUser['success'];
            if ($success) {
                $data = $resultSaveUser['data'];
            } else {
                $msj = 'Usuario no Save';
                $errors = $resultSaveUser['errors'];
            }

        } else {
            $msj = 'Usuario Error';
            $errors = $resultValidate['errors'];
        }
        $result = [
            'success' => $success,
            'errors' => $errors,
            'data' => $data,
            'msj' => $msj

        ];

        return $result;
    }

    public static function validateModel($params)
    {
        $modelAttributes = $params['inputs'];
        $rules = $params['rules'];
        $validation = Validator::make($modelAttributes, $rules);
        $success = $validation->passes();
        $errors = [];
        if (!$success) {
            $errors = $validation->errors()->all();
        }
        $result = array("success" => $success, "errors" => $errors);
        return $result;
    }

    protected function createProvider(array $data, $typeProvider)
    {
        $user = null;
        $model = new User;

        if ($typeProvider == User::PROVIDER_FACEBOOK) {
            $user = $model->managerFacebook($data);
        } else if ($typeProvider == User::PROVIDER_GOOGLE) {
            $user = $model->managerGoogle($data);
        }

        return $user;
    }

    public function managerUserProvider($params)
    {
        $typeSave = $params['typeSave'];
        $dataPost = $params['data'];

        $typeProvider = $dataPost['provider'];
        $success = false;
        $msg = 'Nothing';
        $data = [];
        $user = null;
        if ($typeSave == UtilUser::TYPE_SAVE_CUSTOMER_FACEBOOK) {
            $user = $this->createProvider($dataPost, $typeProvider);
            if (!$user) {

                $success = false;
                $msg = 'Error al crear un usuario Facebook.';
                $data['errors'] = [
                    'typeError' => 0
                ];
            } else {
                $success = true;
            }

        } else if ($typeSave == UtilUser::TYPE_SAVE_CUSTOMER_GOOGLE) {
            $user = $this->createProvider($dataPost, $typeProvider);
            if (!$user) {
                $success = false;
                $msg = 'Error al crear un usuario Google.';
                $data['errors'] = [
                    'typeError' => 1
                ];
            } else {
                $success = true;
            }

        }

        if ($success) {
            $role_id = Role::ROL_CUSTOMER;
            $roleByUser = UsersHasRoles::where('user_id', $user->id)->first();
            if (!$roleByUser) {
                $modelRole = new UsersHasRoles();
                $modelRole->fill([
                    'user_id' => $user->id,
                    'role_id' => $role_id,
                ]);
                $success = $modelRole->save();
            } else {
                $success = true;
            }

            if (!$success) {
                $success = false;
                $msg = 'Error al agregar un Role';
                $data['errors'] = [
                    'typeError' => 2
                ];
            } else {
                $data['user'] = $user;

            }
        }


        $result = [
            'success' => $success,
            'msg' => $msg,
            'data' => $data
        ];
        return $result;
    }

    public function getDataUserRBAC($user)
    {

        $rolesId = $user->roles->pluck('id')->toArray();
        $roleManager = new Role();
        $result = [
            'roles' => $user->roles,
            'actions' => $roleManager->getActionsByRoles(['rolesId' => $rolesId]),

        ];
        return $result;
    }

    public function allowActionByUser($params)
    {
        $user = $params['user'];
        $actionCurrent = $params['actionCurrent'];

        $getDataRBAC = $this->getDataUserRBAC($user);
        $allowAction = false;
        if ($user->id == 1) {
            $allowAction = true;
        } else {
            foreach ($getDataRBAC['actions'] as $key => $value) {
                if ($value->link == $actionCurrent) {
                    $allowAction = true;
                    break;
                }

            }
        }

        return $allowAction;
    }

}
