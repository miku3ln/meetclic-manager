<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use URL;

class CustomerByProfile extends ModelManager
{

    protected $table = 'customer_by_profile';

    protected $fillable = array(
        "customer_id",//*
        "user_id",//*

    );
    public $attributesData = array(
        "customer_id",//*
        "user_id",//*

    );
    public $timestamps = false;

    public static function getRulesModel()
    {
        $rules = [
            "customer_id" => 'required',
            "user_id" => 'required',
        ];
        return $rules;
    }

    public function getMenuTopRight($params)
    {
        $user = $params['user'];

        $userProfileMenu = '';
        if ($user) {
            $profileConfig = $params['profileConfig'];
            $roles = $user->roles;
            $modelFrontendManager = new  \App\Models\FrontendManagerData;
            $menuCurrentItemsManagement = [

                [
                    'actionName' => 'myProfile',
                    'routeName' => 'myProfile',
                    'icon' => 'remixicon-account-circle-line',
                    'text' => __('frontend.account.menu.profile'),
                    'url' => route('myProfile', app()->getLocale()),
                    'allowManager' => env("allowMenuTopProfile"),
                    'active' => false,
                ],
                [
                    'actionName' => 'business',
                    'routeName' => 'business',
                    'icon' => 'fa fa-building',
                    'text' => __('frontend.account.menu.my-business'),
                    'url' => route('business', app()->getLocale()),
                    'allowManager' => env("allowMenuTopMyBusiness"),
                    'active' => false,
                ], [
                    'actionName' => 'listingsQueen',
                    'routeName' => 'listingsQueen',
                    'icon' => 'fas fa-briefcase',
                    'text' => __('frontend.account.menu.my-queens'),
                    'url' => route('listingsQueen', app()->getLocale()),
                    'allowManager' => env("allowMenuTopMyBusinessFriends"),
                    'active' => false,
                ], [
                    'actionName' => 'reviewsTo',
                    'routeName' => 'reviewsTo',
                    'icon' => 'fas fa-address-card',
                    'text' => __('frontend.account.menu.reviews'),
                    'url' => route('reviewsTo', app()->getLocale()),
                    'allowManager' => env("allowMenuTopMyBusinessSuggestion"),
                    'active' => false,
                ],
            ];


            $menuCurrentItemsCurrent = [];
            if ($user) {
                if ($user->id != 1) {
                    foreach ($menuCurrentItemsManagement as $key => $menu) {

                        $actionMenuCurrent = $menu['actionName'];
                        $actionAllowConfig = $modelFrontendManager->getAllowAction([
                            'roles' => $roles,
                            'needle' => $actionMenuCurrent,
                            'keyCompare' => 'link',
                        ]);
                        if ($actionAllowConfig) {
                            $menuCurrentItemsCurrent[] = $menu;
                        }
                    }
                } else {
                    $menuCurrentItemsCurrent = $menuCurrentItemsManagement;
                }
            }

            $resourcePathServer = $params['resourcePathServer'];

            $urlCurrentImage = URL::asset($profileConfig['data']['user']['urlAvatar']);
            $userProfileMenu = ' <div class="header-user-menu">';
            $userProfileMenu .= '      <div class="header-user-name">';
            $userProfileMenu .= '          <span>';
            $userProfileMenu .= '             <img src="' . $urlCurrentImage . '"';
            $userProfileMenu .= '                    alt="' . $profileConfig['data']['user']->name . '" >';
            $userProfileMenu .= '          </span>';
            $userProfileMenu .= __('frontend.greeting.hi') . ',' . $profileConfig['data']['user']->name;

            $userProfileMenu .= '      </div>';
            $pointsManagement = '';
            if (env('allowMenuTopPoints')) {
                $pointsManagement = '         <li class="menu-top__li-points"><span
                            class="badge badge--size-large badge--bee-points">' . $profileConfig['data']['user']['gaming']['bee'] . '</span>
                        ' . env('namePointsOne') . ' <i class="fa  fa-star-o"></i></li>';
            }
            if (env('allowViewPointsTwo')) {
                $pointsManagement .= '         <li class="menu-top__li-points"><span
                            class="badge badge--size-large badge--bee-points">' . $profileConfig['data']['user']['gaming']['queen'] . '</span>
                        ' . env('namePointsTwo') . ' <i class="fa  fa-trophy"></i></li>';
            }
            $liGamification = $pointsManagement;
            $menuConfig = '<ul>';
            $menuConfig .= $liGamification;

            foreach ($menuCurrentItemsCurrent as $key => $menu) {
                if ($menu["allowManager"]) {

                    $menuConfig .= '<li>';

                    $menuConfig .= '<a href="' . $menu['url'] . '" class="dropdown-item notify-item">';

                    $menuConfig .= $menu['text'];
                    $menuConfig .= ' </a>';
                    $menuConfig .= '</li>';
                }


            }

            $liCloseAccount = '<li>';
            $liCloseAccount .= '  <a href="' . route('logout', app()->getLocale()) . '">';
            $liCloseAccount .= ' ' . __('frontend.buttons.logout');
            $liCloseAccount .= '  </a>';
            $liCloseAccount .= '</li>';
            $menuConfig .= $liCloseAccount;

            $menuConfig .= '</ul>';
            $userProfileMenu .= $menuConfig;
            $userProfileMenu .= '</div>';
        } else {

        }
        $result = $userProfileMenu;
        return $result;

    }

    public function getProfileUser($params = [])
    {

        $user = $params['user'];
        $result = $this->getDataProfile(
            ['user' => $user]
        );
        return $result;

    }

    public function getDataProfileUser($params)
    {

        $dataManager = [];

        $dataInformationPhone = [];
        $dataInformationAddress = [];
        $dataInformationSocialNetwork = [];
        $dataUsersByAboutUs = [];
        $rolesCurrent = [];
        $rolesCurrentObject = [];
        $gaming = [];
        $successProfile = false;
        $user_id = $params['filters']['user_id'];
        $success = true;
        $rolesCurrent = [];
        $rolesCurrentObject = [];
        $user = [];
        $dataManager = [];
        $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
        $themePath = $resourcePathServer . 'templates/cityBookHtml/';
        $urlAvatar = $themePath . 'images/avatar/avatar-bg.png';
        $avatarManager = false;
        $data = [];
        $isAdmin = $user_id == 1;
        $typeRole = $user_id == 1 ? 'god' : 'customer';
        $isNotLogin = isset($params['isLogin']) && $params['isLogin'] == false;
        $providerCurrent = null;
        $avatar = null;
        $userAllow = false;
        if (!$isNotLogin) {
            $tableCurrent = 'users';
            $selectString = "$tableCurrent.id,$tableCurrent.email,$tableCurrent.name,$tableCurrent.username,$tableCurrent.provider_id,$tableCurrent.provider,$tableCurrent.avatar ";
            $select = DB::raw($selectString);
            $query = DB::table($tableCurrent);
            $query->select($select);
            $query->where($tableCurrent . '.id', '=', $user_id);
            $user = $query->first();
            if ($user) {
                $providerCurrent = $user->provider;
                $avatar = $user->avatar;

                $userAllow = true;
            }


        }

        if ($providerCurrent == 'server' || $providerCurrent == null) {

            if (!$avatar) {
                $urlAvatar = $themePath . 'images/avatar/avatar-bg.png';
            } else {
                $avatarManager = true;
                $urlAvatar = $resourcePathServer . $avatar;
            }
        } else {
            if (!$avatar) {
                $urlAvatar = $themePath . 'images/avatar/avatar-bg.png';
            } else {
                $urlAvatar = $resourcePathServer . $avatar;
                $avatarManager = true;
            }
        }
        $selectString = "$this->table.id,$this->table.customer_id,$this->table.user_id,$this->table.id customer_by_profile_id
                ,users.email
                ,people.last_name last_name,people.name first_name,DATE_FORMAT(people.birthdate,'%Y-%m-%d') birthdate,people.gender,people.id people_id
                ,customer.identification_document identification ,customer.id customer_id,customer.business_name,customer.business_reason,customer.ruc_type_id
               ,customer_by_information.id customer_by_information_id,customer_by_information.people_nationality_id,customer_by_information.people_profession_id
                ,ruc_type.name ruc_type
                ,people_type_identification.name people_type_identification,people_type_identification.id people_type_identification_id
                ,people_nationality.name people_nationality,people_nationality.id people_nationality_id
                 ,people_profession.name people_profession,people_profession.id people_profession_id
,customer_profile_by_location.zones_id,customer_profile_by_location.id customer_profile_by_location_id
,zones.name zones
,cities.name cities,cities.id cities_id
,provinces.name provinces,provinces.id provinces_id
,countries.name countries,countries.id countries_id,countries.phone_code


                 ";
        $select = DB::raw($selectString);
        $query = DB::table($this->table);
        $query->select($select);
        $query->join('users', 'users.id', '=', $this->table . '.user_id');
        $query->join('customer', 'customer.id', '=', $this->table . '.customer_id');
        $query->join('customer_by_information', 'customer_by_information.id', '=', 'customer.id');
        $query->join('people_nationality', 'people_nationality.id', '=', 'customer_by_information.people_nationality_id');
        $query->join('people_profession', 'people_profession.id', '=', 'customer_by_information.people_profession_id');
        $query->join('ruc_type', 'ruc_type.id', '=', 'customer.ruc_type_id');
        $query->join('people_type_identification', 'people_type_identification.id', '=', 'customer.people_type_identification_id');
        $query->join('people', 'people.id', '=', 'customer.people_id');
        $query->leftJoin('customer_profile_by_location', $this->table . '.id', '=', 'customer_profile_by_location.customer_by_profile_id');
        $query->leftJoin('zones', 'zones.id', '=', 'customer_profile_by_location.zones_id');
        $query->leftJoin('cities', 'cities.id', '=', 'zones.city_id');
        $query->leftJoin('provinces', 'provinces.id', '=', 'cities.province_id');
        $query->leftJoin('countries', 'countries.id', '=', 'provinces.country_id');
        $query->where($this->table . '.user_id', '=', $user_id);
        $data = $query->first();

        $dataInformationPhone = [];
        $dataInformationSocialNetwork = [];
        $dataUsersByAboutUs = [];
        $dataInformationAddress = [];
        $dataCustomerProfileByLocation = [];
        if ($data != false) {
            $successProfile = true;
            $modelManager = new \App\Models\InformationPhone();
            $entity_id = $data->customer_id;
            $resultCurrentData = $modelManager->getInformation([
                'filters' => [
                    'state' => $modelManager::STATE_ACTIVE,
                    'main' => $modelManager::MAIN,
                    'entity_type' => $modelManager::ENTITY_TYPE_CUSTOMER,
                    'information_phone_operator_id' => \App\Models\InformationPhoneOperator::OPERATOR_NOT_SPECIFIC_ID,
                    'information_phone_type_id' => \App\Models\InformationPhoneType::TYPE_WORKFORCE_ID,
                    'entity_id' => $entity_id,

                ]
            ]);
            if ($resultCurrentData != false) {
                $dataInformationPhone = $resultCurrentData;
            }

            $modelManager = new \App\Models\InformationSocialNetwork();
            $entity_id = $data->customer_id;
            $resultCurrentData = $modelManager->getInformation([
                'filters' => [
                    'state' => $modelManager::STATE_ACTIVE,
                    'main' => $modelManager::MAIN,
                    'entity_type' => $modelManager::ENTITY_TYPE_CUSTOMER,
                    'information_social_network_type_id' => \App\Models\InformationSocialNetworkType::TYPE_FACEBOOK_ID,
                    'entity_id' => $entity_id,
                ]
            ]);
            if ($resultCurrentData != false) {
                $dataInformationSocialNetwork['one'] = $resultCurrentData;
            }
            $modelManager = new \App\Models\InformationSocialNetwork();
            $entity_id = $data->customer_id;
            $resultCurrentData = $modelManager->getInformation([
                'filters' => [
                    'state' => $modelManager::STATE_ACTIVE,
                    'main' => $modelManager::MAIN,
                    'entity_type' => $modelManager::ENTITY_TYPE_CUSTOMER,
                    'information_social_network_type_id' => \App\Models\InformationSocialNetworkType::TYPE_INSTAGRAM_ID,
                    'entity_id' => $entity_id,
                ]
            ]);
            if ($resultCurrentData != false) {
                $dataInformationSocialNetwork['two'] = $resultCurrentData;
            }
            $resultCurrentData = $modelManager->getInformation([
                'filters' => [
                    'state' => $modelManager::STATE_ACTIVE,
                    'main' => $modelManager::MAIN,
                    'entity_type' => $modelManager::ENTITY_TYPE_CUSTOMER,
                    'information_social_network_type_id' => \App\Models\InformationSocialNetworkType::TYPE_TWITTER_ID,
                    'entity_id' => $entity_id,
                ]
            ]);
            if ($resultCurrentData != false) {
                $dataInformationSocialNetwork['three'] = $resultCurrentData;
            }
            $resultCurrentData = $modelManager->getInformation([
                'filters' => [
                    'state' => $modelManager::STATE_ACTIVE,
                    'main' => $modelManager::MAIN,
                    'entity_type' => $modelManager::ENTITY_TYPE_CUSTOMER,
                    'information_social_network_type_id' => \App\Models\InformationSocialNetworkType::TYPE_LINKEDIN_ID,
                    'entity_id' => $entity_id,
                ]
            ]);
            if ($resultCurrentData != false) {
                $dataInformationSocialNetwork['four'] = $resultCurrentData;
            }
            $resultCurrentData = $modelManager->getInformation([
                'filters' => [
                    'state' => $modelManager::STATE_ACTIVE,
                    'main' => $modelManager::MAIN,
                    'entity_type' => $modelManager::ENTITY_TYPE_CUSTOMER,
                    'information_social_network_type_id' => \App\Models\InformationSocialNetworkType::TYPE_YOUTUBE_ID,
                    'entity_id' => $entity_id,
                ]
            ]);
            if ($resultCurrentData != false) {
                $dataInformationSocialNetwork['five'] = $resultCurrentData;
            }
            $resultCurrentData = $modelManager->getInformation([
                'filters' => [
                    'state' => $modelManager::STATE_ACTIVE,
                    'main' => $modelManager::MAIN,
                    'entity_type' => $modelManager::ENTITY_TYPE_CUSTOMER,
                    'information_social_network_type_id' => \App\Models\InformationSocialNetworkType::TYPE_TIKTOK_ID,
                    'entity_id' => $entity_id,
                ]
            ]);
            if ($resultCurrentData != false) {
                $dataInformationSocialNetwork['six'] = $resultCurrentData;
            }
            $modelManager = new \App\Models\InformationAddress();
            $resultCurrentData = $modelManager->getInformation([
                'filters' => [
                    'state' => $modelManager::STATE_ACTIVE,
                    'main' => $modelManager::MAIN,
                    'entity_type' => $modelManager::ENTITY_TYPE_CUSTOMER,
                    'information_address_type_id' => \App\Models\InformationAddressType::TYPE_HOME,
                    'entity_id' => $entity_id,
                ]
            ]);
            if ($resultCurrentData != false) {
                $dataInformationAddress = $resultCurrentData;
            }

            $modelManager = new \App\Models\UsersByAboutUs();
            $resultCurrentData = $modelManager->getInformation([
                'filters' => [
                    'users_id' => $user_id,

                ]
            ]);
            if ($resultCurrentData != false) {
                $dataUsersByAboutUs = $resultCurrentData;
            }


            $modelMovement = new \App\Models\AccountGamification();
            $resultAllow = $modelMovement->getAllowAddMovementRegisterUser([
                'filters' => [
                    'user_id' => $user_id
                ]
            ]);

            if ($resultAllow) {
                $gaming = [
                    'success' => true,
                    'id' => $resultAllow->id,
                    'bee' => $resultAllow->balance_available_bee,
                    'queen' => $resultAllow->balance_available_queen,
                ];
            } else {
                $gaming = [
                    'success' => false,
                    'bee' => 0,
                    'queen' => 0,
                ];
            }


        } else {
            $success = false;
            if ($userAllow) {
                $success = true;

            }
        }


        $dataManager['Profile'] = $data;
        $dataManager['InformationPhone'] = $dataInformationPhone;
        $dataManager['InformationAddress'] = $dataInformationAddress;
        $dataManager['InformationSocialNetwork'] = $dataInformationSocialNetwork;
        $dataManager['UsersByAboutUs'] = $dataUsersByAboutUs;
        $dataManager['typeRole'] = $typeRole;
        $dataManager['roles'] = $rolesCurrent;
        $dataManager['rolesObject'] = $rolesCurrentObject;
        $dataManager['user'] = (array)$user;
        $dataManager['isAdmin'] = $isAdmin;
        $dataManager['user']['urlAvatar'] = $urlAvatar;
        $dataManager['user']['avatarManager'] = $avatarManager;
        $dataManager['user']['gaming'] = $gaming;
        $result = [
            'success' => $success,
            'successProfile' => $successProfile,
            'data' => $dataManager
        ];

        return $result;

    }

    public function getDataProfile($params)
    {

        $success = false;
        $dataManager = [];
        $successProfile = false;
        $user = $params['user'];
        if ($user) {
            $success = true;
            $user_id = $user->id;
            $rolesCurrent = $user->roles->toArray();
            $rolesCurrentObject = $user->roles;
            $dataManager = [];
            $data = [];
            $isAdmin = $user_id == 1;
            $typeRole = $user_id == 1 ? 'god' : 'customer';
            $selectString = "$this->table.id,$this->table.customer_id,$this->table.user_id,$this->table.id customer_by_profile_id
                ,users.email
                ,people.last_name last_name,people.name first_name,DATE_FORMAT(people.birthdate,'%Y-%m-%d') birthdate,people.gender,people.id people_id
                ,customer.identification_document identification ,customer.id customer_id,customer.business_name,customer.business_reason,customer.ruc_type_id
               ,customer_by_information.id customer_by_information_id,customer_by_information.people_nationality_id,customer_by_information.people_profession_id
                ,ruc_type.name ruc_type
                ,people_type_identification.name people_type_identification,people_type_identification.id people_type_identification_id
                ,people_nationality.name people_nationality,people_nationality.id people_nationality_id
                 ,people_profession.name people_profession,people_profession.id people_profession_id
,customer_profile_by_location.zones_id,customer_profile_by_location.id customer_profile_by_location_id
,zones.name zones
,cities.name cities,cities.id cities_id
,provinces.name provinces,provinces.id provinces_id
,countries.name countries,countries.id countries_id


                 ";
            $select = DB::raw($selectString);
            $query = DB::table($this->table);
            $query->select($select);
            $query->join('users', 'users.id', '=', $this->table . '.user_id');
            $query->join('customer', 'customer.id', '=', $this->table . '.customer_id');
            $query->join('customer_by_information', 'customer_by_information.id', '=', 'customer.id');
            $query->join('people_nationality', 'people_nationality.id', '=', 'customer_by_information.people_nationality_id');
            $query->join('people_profession', 'people_profession.id', '=', 'customer_by_information.people_profession_id');
            $query->join('ruc_type', 'ruc_type.id', '=', 'customer.ruc_type_id');
            $query->join('people_type_identification', 'people_type_identification.id', '=', 'customer.people_type_identification_id');
            $query->join('people', 'people.id', '=', 'customer.people_id');
            $query->leftJoin('customer_profile_by_location', $this->table . '.id', '=', 'customer_profile_by_location.customer_by_profile_id');
            $query->leftJoin('zones', 'zones.id', '=', 'customer_profile_by_location.zones_id');
            $query->leftJoin('cities', 'cities.id', '=', 'zones.city_id');
            $query->leftJoin('provinces', 'provinces.id', '=', 'cities.province_id');
            $query->leftJoin('countries', 'countries.id', '=', 'provinces.country_id');
            $query->where($this->table . '.user_id', '=', $user_id);
            $data = $query->first();
            $dataInformationPhone = [];
            $dataInformationSocialNetwork = [];
            $dataUsersByAboutUs = [];
            $dataInformationAddress = [];
            $dataCustomerProfileByLocation = [];
            if ($data != false) {//CMS-TEMPLATE-MY-PROFILE-DATA
                $successProfile = true;
                $modelManager = new \App\Models\InformationPhone();
                $entity_id = $data->customer_id;
                $resultCurrentData = $modelManager->getInformation([
                    'filters' => [
                        'state' => $modelManager::STATE_ACTIVE,
                        'main' => $modelManager::MAIN,
                        'entity_type' => $modelManager::ENTITY_TYPE_CUSTOMER,
                        'information_phone_operator_id' => \App\Models\InformationPhoneOperator::OPERATOR_NOT_SPECIFIC_ID,
                        'information_phone_type_id' => \App\Models\InformationPhoneType::TYPE_WORKFORCE_ID,
                        'entity_id' => $entity_id,

                    ]
                ]);
                if ($resultCurrentData != false) {

                    $dataInformationPhone = $resultCurrentData;
                }

                $modelManager = new \App\Models\InformationSocialNetwork();
                $entity_id = $data->customer_id;
                $resultCurrentData = $modelManager->getInformation([
                    'filters' => [
                        'state' => $modelManager::STATE_ACTIVE,
                        'main' => $modelManager::MAIN,
                        'entity_type' => $modelManager::ENTITY_TYPE_CUSTOMER,
                        'information_social_network_type_id' => \App\Models\InformationSocialNetworkType::TYPE_FACEBOOK_ID,
                        'entity_id' => $entity_id,
                    ]
                ]);
                if ($resultCurrentData != false) {
                    $dataInformationSocialNetwork['one'] = $resultCurrentData;
                }
                $modelManager = new \App\Models\InformationSocialNetwork();
                $entity_id = $data->customer_id;
                $entity_id = $data->customer_id;

                $resultCurrentData = $modelManager->getInformation([
                    'filters' => [
                        'state' => $modelManager::STATE_ACTIVE,
                        'main' => $modelManager::MAIN,
                        'entity_type' => $modelManager::ENTITY_TYPE_CUSTOMER,
                        'information_social_network_type_id' => \App\Models\InformationSocialNetworkType::TYPE_INSTAGRAM_ID,
                        'entity_id' => $entity_id,
                    ]
                ]);
                if ($resultCurrentData != false) {
                    $dataInformationSocialNetwork['two'] = $resultCurrentData;
                }


                $resultCurrentData = $modelManager->getInformation([
                    'filters' => [
                        'state' => $modelManager::STATE_ACTIVE,
                        'main' => $modelManager::MAIN,
                        'entity_type' => $modelManager::ENTITY_TYPE_CUSTOMER,
                        'information_social_network_type_id' => \App\Models\InformationSocialNetworkType::TYPE_TWITTER_ID,
                        'entity_id' => $entity_id,
                    ]
                ]);
                if ($resultCurrentData != false) {
                    $dataInformationSocialNetwork['three'] = $resultCurrentData;
                }
                $resultCurrentData = $modelManager->getInformation([
                    'filters' => [
                        'state' => $modelManager::STATE_ACTIVE,
                        'main' => $modelManager::MAIN,
                        'entity_type' => $modelManager::ENTITY_TYPE_CUSTOMER,
                        'information_social_network_type_id' => \App\Models\InformationSocialNetworkType::TYPE_LINKEDIN_ID,
                        'entity_id' => $entity_id,
                    ]
                ]);
                if ($resultCurrentData != false) {
                    $dataInformationSocialNetwork['four'] = $resultCurrentData;
                }
                $resultCurrentData = $modelManager->getInformation([
                    'filters' => [
                        'state' => $modelManager::STATE_ACTIVE,
                        'main' => $modelManager::MAIN,
                        'entity_type' => $modelManager::ENTITY_TYPE_CUSTOMER,
                        'information_social_network_type_id' => \App\Models\InformationSocialNetworkType::TYPE_YOUTUBE_ID,
                        'entity_id' => $entity_id,
                    ]
                ]);
                if ($resultCurrentData != false) {
                    $dataInformationSocialNetwork['five'] = $resultCurrentData;
                }
                $resultCurrentData = $modelManager->getInformation([
                    'filters' => [
                        'state' => $modelManager::STATE_ACTIVE,
                        'main' => $modelManager::MAIN,
                        'entity_type' => $modelManager::ENTITY_TYPE_CUSTOMER,
                        'information_social_network_type_id' => \App\Models\InformationSocialNetworkType::TYPE_TIKTOK_ID,
                        'entity_id' => $entity_id,
                    ]
                ]);
                if ($resultCurrentData != false) {
                    $dataInformationSocialNetwork['six'] = $resultCurrentData;
                }
                $modelManager = new \App\Models\InformationAddress();
                $resultCurrentData = $modelManager->getInformation([
                    'filters' => [
                        'state' => $modelManager::STATE_ACTIVE,
                        'main' => $modelManager::MAIN,
                        'entity_type' => $modelManager::ENTITY_TYPE_CUSTOMER,
                        'information_address_type_id' => \App\Models\InformationAddressType::TYPE_HOME,
                        'entity_id' => $entity_id,
                    ]
                ]);
                if ($resultCurrentData != false) {
                    $dataInformationAddress = $resultCurrentData;
                }


            }

            $modelManager = new \App\Models\UsersByAboutUs();
            $resultCurrentData = $modelManager->getInformation([
                'filters' => [
                    'users_id' => $user_id,

                ]
            ]);
            if ($resultCurrentData != false) {
                $dataUsersByAboutUs = $resultCurrentData;
            }


            $dataManager['Profile'] = $data;
            $dataManager['InformationPhone'] = $dataInformationPhone;
            $dataManager['InformationAddress'] = $dataInformationAddress;
            $dataManager['InformationSocialNetwork'] = $dataInformationSocialNetwork;
            $dataManager['UsersByAboutUs'] = $dataUsersByAboutUs;


            $dataManager['typeRole'] = $typeRole;
            $dataManager['roles'] = $rolesCurrent;
            $dataManager['rolesObject'] = $rolesCurrentObject;

            $dataManager['user'] = $user;
            $dataManager['isAdmin'] = $isAdmin;

            $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
            $themePath = $resourcePathServer . 'templates/cityBookHtml/';
            $urlAvatar = $themePath . 'images/avatar/avatar-bg.png';
            $providerCurrent = Auth::user()->provider;
            $avatar = Auth::user()->avatar;

            $modelMovement = new \App\Models\AccountGamification();
            $resultAllow = $modelMovement->getAllowAddMovementRegisterUser([
                'filters' => [
                    'user_id' => $user_id
                ]
            ]);
            $gaming = [];
            if ($resultAllow) {
                $gaming = [
                    'success' => true,
                    'id' => $resultAllow->id,
                    'bee' => $resultAllow->balance_available_bee,
                    'queen' => $resultAllow->balance_available_queen,
                ];
            } else {
                $gaming = [
                    'success' => false,
                    'bee' => 80000,
                    'queen' => 150000000,
                ];
            }
            $avatarManager = false;
            if ($providerCurrent == 'server' || $providerCurrent == null) {
                if (!$avatar) {
                    $urlAvatar = $themePath . 'images/avatar/avatar-bg.png';
                } else {
                    $avatarManager = true;
                    $urlAvatar = $resourcePathServer . $avatar;
                }
            } else {
                if (!$avatar) {
                    $urlAvatar = $themePath . 'images/avatar/avatar-bg.png';
                } else {
                    $urlAvatar = $resourcePathServer . $avatar;
                    $avatarManager = true;
                }
            }
            $dataManager['user']['urlAvatar'] = $urlAvatar;
            $dataManager['user']['avatarManager'] = $avatarManager;

            $dataManager['user']['gaming'] = $gaming;

        }
        $result = [
            'success' => $success,
            'successProfile' => $successProfile,
            'data' => $dataManager
        ];

        return $result;
    }

    public function getDataProfilePatient($params)
    {

        $success = false;
        $dataManager = [];
        $successProfile = false;
        $user = $params['user'];
        if ($user) {
            $success = true;
            $user_id = $user->id;
            $role_id = Role::ROL_CUSTOMER;
            $rolesCurrent = $user->roles->toArray();
            $rolesCurrentObject = $user->roles;


            $dataManager = [];
            $data = [];
            $isAdmin = $user_id == 1;
            $typeRole = $user_id == 1 ? 'god' : 'customer';
            $selectString = "$this->table.id,$this->table.customer_id,$this->table.user_id,$this->table.id customer_by_profile_id
                ,users.email
                ,people.last_name last_name,people.name first_name,DATE_FORMAT(people.birthdate,'%Y-%m-%d') birthdate,people.gender,people.id people_id
                ,customer.identification_document identification ,customer.id customer_id,customer.business_name,customer.business_reason,customer.ruc_type_id
               ,customer_by_information.id customer_by_information_id,customer_by_information.people_nationality_id,customer_by_information.people_profession_id
                ,ruc_type.name ruc_type
                ,people_type_identification.name people_type_identification,people_type_identification.id people_type_identification_id
                ,people_nationality.name people_nationality,people_nationality.id people_nationality_id
                 ,people_profession.name people_profession,people_profession.id people_profession_id
,customer_profile_by_location.zones_id,customer_profile_by_location.id customer_profile_by_location_id
,zones.name zones
,cities.name cities,cities.id cities_id
,provinces.name provinces,provinces.id provinces_id
,countries.name countries,countries.id countries_id,countries.phone_code


                 ";
            $select = DB::raw($selectString);
            $query = DB::table($this->table);
            $query->select($select);
            $query->join('users', 'users.id', '=', $this->table . '.user_id');
            $query->join('customer', 'customer.id', '=', $this->table . '.customer_id');
            $query->join('customer_by_information', 'customer_by_information.id', '=', 'customer.id');
            $query->join('people_nationality', 'people_nationality.id', '=', 'customer_by_information.people_nationality_id');
            $query->join('people_profession', 'people_profession.id', '=', 'customer_by_information.people_profession_id');
            $query->join('ruc_type', 'ruc_type.id', '=', 'customer.ruc_type_id');
            $query->join('people_type_identification', 'people_type_identification.id', '=', 'customer.people_type_identification_id');
            $query->join('people', 'people.id', '=', 'customer.people_id');
            $query->leftJoin('customer_profile_by_location', $this->table . '.id', '=', 'customer_profile_by_location.customer_by_profile_id');
            $query->leftJoin('zones', 'zones.id', '=', 'customer_profile_by_location.zones_id');
            $query->leftJoin('cities', 'cities.id', '=', 'zones.city_id');
            $query->leftJoin('provinces', 'provinces.id', '=', 'cities.province_id');
            $query->leftJoin('countries', 'countries.id', '=', 'provinces.country_id');
            $query->where($this->table . '.user_id', '=', $user_id);
            $data = $query->first();
            $dataInformationPhone = [];
            $dataInformationSocialNetwork = [];
            $dataUsersByAboutUs = [];
            $dataInformationAddress = [];
            $dataCustomerProfileByLocation = [];
            if ($data != false) {
                $successProfile = true;
                $modelManager = new \App\Models\InformationPhone();
                $entity_id = $data->customer_id;
                $resultCurrentData = $modelManager->getInformation([
                    'filters' => [
                        'state' => $modelManager::STATE_ACTIVE,
                        'main' => $modelManager::MAIN,
                        'entity_type' => $modelManager::ENTITY_TYPE_CUSTOMER,
                        'information_phone_operator_id' => \App\Models\InformationPhoneOperator::OPERATOR_NOT_SPECIFIC_ID,
                        'information_phone_type_id' => \App\Models\InformationPhoneType::TYPE_WORKFORCE_ID,
                        'entity_id' => $entity_id,

                    ]
                ]);
                if ($resultCurrentData != false) {

                    $dataInformationPhone = $resultCurrentData;
                }

                $modelManager = new \App\Models\InformationSocialNetwork();
                $entity_id = $data->customer_id;
                $resultCurrentData = $modelManager->getInformation([
                    'filters' => [
                        'state' => $modelManager::STATE_ACTIVE,
                        'main' => $modelManager::MAIN,
                        'entity_type' => $modelManager::ENTITY_TYPE_CUSTOMER,
                        'information_social_network_type_id' => \App\Models\InformationSocialNetworkType::TYPE_FACEBOOK_ID,
                        'entity_id' => $entity_id,
                    ]
                ]);
                if ($resultCurrentData != false) {
                    $dataInformationSocialNetwork['one'] = $resultCurrentData;
                }
                $modelManager = new \App\Models\InformationSocialNetwork();
                $entity_id = $data->customer_id;
                $entity_id = $data->customer_id;

                $resultCurrentData = $modelManager->getInformation([
                    'filters' => [
                        'state' => $modelManager::STATE_ACTIVE,
                        'main' => $modelManager::MAIN,
                        'entity_type' => $modelManager::ENTITY_TYPE_CUSTOMER,
                        'information_social_network_type_id' => \App\Models\InformationSocialNetworkType::TYPE_TWITTER_ID,
                        'entity_id' => $entity_id,
                    ]
                ]);
                if ($resultCurrentData != false) {
                    $dataInformationSocialNetwork['two'] = $resultCurrentData;
                }

                $modelManager = new \App\Models\InformationAddress();
                $resultCurrentData = $modelManager->getInformation([
                    'filters' => [
                        'state' => $modelManager::STATE_ACTIVE,
                        'main' => $modelManager::MAIN,
                        'entity_type' => $modelManager::ENTITY_TYPE_CUSTOMER,
                        'information_address_type_id' => \App\Models\InformationAddressType::TYPE_HOME,
                        'entity_id' => $entity_id,
                    ]
                ]);
                if ($resultCurrentData != false) {
                    $dataInformationAddress = $resultCurrentData;
                }


            }

            $modelManager = new \App\Models\UsersByAboutUs();
            $resultCurrentData = $modelManager->getInformation([
                'filters' => [
                    'users_id' => $user_id,

                ]
            ]);
            if ($resultCurrentData != false) {
                $dataUsersByAboutUs = $resultCurrentData;
            }


            $dataManager['Profile'] = $data;
            $dataManager['InformationPhone'] = $dataInformationPhone;
            $dataManager['InformationAddress'] = $dataInformationAddress;
            $dataManager['InformationSocialNetwork'] = $dataInformationSocialNetwork;
            $dataManager['UsersByAboutUs'] = $dataUsersByAboutUs;


            $dataManager['typeRole'] = $typeRole;
            $dataManager['roles'] = $rolesCurrent;
            $dataManager['rolesObject'] = $rolesCurrentObject;

            $dataManager['user'] = $user;
            $dataManager['isAdmin'] = $isAdmin;

            $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
            $themePath = $resourcePathServer . 'templates/cityBookHtml/';
            $urlAvatar = $themePath . 'images/avatar/avatar-bg.png';
            $providerCurrent = Auth::user()->provider;
            $avatar = Auth::user()->avatar;

            $modelMovement = new \App\Models\AccountGamification();
            $resultAllow = $modelMovement->getAllowAddMovementRegisterUser([
                'filters' => [
                    'user_id' => $user_id
                ]
            ]);
            $gaming = [];
            if ($resultAllow) {
                $gaming = [
                    'success' => true,
                    'id' => $resultAllow->id,
                    'bee' => $resultAllow->balance_available_bee,
                    'queen' => $resultAllow->balance_available_queen,
                ];
            } else {
                $gaming = [
                    'success' => false,
                    'bee' => 80000,
                    'queen' => 150000000,
                ];
            }
            $avatarManager = false;
            if ($providerCurrent == 'server' || $providerCurrent == null) {
                if (!$avatar) {
                    $urlAvatar = $themePath . 'images/avatar/avatar-bg.png';
                } else {
                    $avatarManager = true;
                    $urlAvatar = $resourcePathServer . $avatar;
                }
            } else {
                if (!$avatar) {
                    $urlAvatar = $themePath . 'images/avatar/avatar-bg.png';
                } else {
                    $urlAvatar = $resourcePathServer . $avatar;
                    $avatarManager = true;
                }
            }
            $dataManager['user']['urlAvatar'] = $urlAvatar;
            $dataManager['user']['avatarManager'] = $avatarManager;

            $dataManager['user']['gaming'] = $gaming;

        }
        $result = [
            'success' => $success,
            'successProfile' => $successProfile,
            'data' => $dataManager
        ];

        return $result;
    }

    public function getSearchRole($params)
    {
        $haystack = $params['haystack'];
        $needle = $params['needle'];
        $success = false;
        $data = [];
        foreach ($haystack as $key => $row) {

            if ($row['id'] == $needle) {
                $success = true;
                $data = $row;
                break;
            }
        }
        $result = [
            'success' => $success,
            'data' => $data
        ];
        return $result;

    }

    public function getInformationProfile($params)
    {
        $dataManager = $params['manager'];
        $dataInformation = $dataManager['data'];

        $successProfile = $dataManager['successProfile'];

        $profile = $dataInformation['Profile'];
        $user = $dataInformation['user'];
        $contentData = 'Nos especializamos en realizar ,perfiles para poder mostrar en nuestro sistema la informacion del usuario,tanto como redes sociales,telefono celular,direccion.';
        $descriptionData = 'Nos especializamos en realizar ,perfiles para poder mostrar en nuestro sistema la informacion del usuario,tanto como redes sociales,telefono celular,direccion.';
        $resourcePathServer = $params["resourcePathServer"];

        $urlEmpty = '/images/cms/profile-empty.png';
        $source = URL($resourcePathServer . $urlEmpty);
        $nameCurrent = 'Tarjeta de Presentacion Meetclic.';
        $phoneCurrent = '+593985339457';
        $idCurrent = -1;
        if ($successProfile) {
            $nameCurrent = $user['name'];
            $idCurrent = $user['id'];
            $resourcePathServer = $params["resourcePathServer"];

            $source = URL($user['urlAvatar']);
            $nameCurrent = $profile->last_name . ' ' . $profile->first_name;
            $address = '';
            if ($dataInformation['InformationAddress']) {
                $address = $dataInformation['InformationAddress']->street_one . ' y ' . $dataInformation['InformationAddress']->street_one . ' ,' . $dataInformation['InformationAddress']->reference;
            }
            $networkSocial = '';
            $phone = '';
            if (count($dataInformation['InformationSocialNetwork']) > 0) {
                $networkSocial = ' Redes Sociales:';
                $socialResult = '';
                foreach ($dataInformation['InformationSocialNetwork'] as $key => $value) {
                    $socialResult .= $value->social_network_name . ':' . $value->information_social_network;
                }
                $networkSocial .= $socialResult;
            }
            if ($dataInformation['InformationPhone']) {
                $phone = ' Telefono:' . $profile->phone_code . $dataInformation['InformationPhone']->information_phone;
            }
            $phoneCurrent = $profile->phone_code . $dataInformation['InformationPhone']->information_phone;
            if ($dataInformation['UsersByAboutUs']) {
                $descriptionData = $nameCurrent . ' ,' . $dataInformation['UsersByAboutUs']->description . ' Direccion: ' . $address . $phone . $networkSocial;

            } else {
                $descriptionData = $nameCurrent . ' ,' . ' Direccion: ' . $address . $phone . $networkSocial;

            }
            $contentData = $descriptionData;

        }

        $result = [
            'descriptionData' => $descriptionData,
            'descriptionPreview' => $contentData,
            'source' => $source,
            'title' => $nameCurrent,
            'phone' => $phoneCurrent,
            'urlManager' => route('authorSingle', 'es') . '/' . $idCurrent,
            'urlManagerRoot' => route('authorSingle', 'es'),

            'successProfile' => $successProfile
        ];

        return $result;
    }
}
