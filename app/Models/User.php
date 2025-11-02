<?php

namespace App\Models;

use Illuminate\Support\Facades\Validator;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Hash;
use Auth;
use DB;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;

    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';
    const PROVIDER_FACEBOOK = 'facebook';
    const PROVIDER_GOOGLE = 'google';
    const PROVIDER_OWNER_SERVER = 'owner';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'status',
        'provider_id',
        'provider',
        'api_token',
        'user_id',
        'api_token',
        'avatar',

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_has_roles', 'user_id', 'role_id');
    }

    public function managerFacebook($input)
    {

        $user = static::where('provider', self::PROVIDER_FACEBOOK)
            ->where('provider_id', $input['provider_id'])->first();

        if (!$user) {
            return static::create($input);
        }

        return $user;
    }

    public function managerGoogle($input)
    {
        $user = static::where('provider', self::PROVIDER_GOOGLE)
            ->where('provider_id', $input['provider_id'])->first();
        if (is_null($user)) {
            return static::create($input);
        }
        return $user;
    }

    public static function getRulesModel($user_id = null)
    {
        $rules = [
            "name" => 'required',
            "username" => 'required|unique:users,username',
            "email" => 'required|unique:users,email',
            "password" => 'required',
        ];
        if ($user_id) {
            $rules = [
                "name" => 'required',
                "username" => 'required|unique:users,username,' . $user_id,
                "email" => 'required|unique:users,email,' . $user_id,
                "password" => 'required',
            ];
        }

        return $rules;
    }


    public static function validateModel($modelAttributes)
    {
        $user_id = isset($modelAttributes['id']) ? $modelAttributes['id'] : null;

        $rules = self::getRulesModel($user_id);
        $validation = Validator::make($modelAttributes, $rules);
        $success = $validation->passes();
        $errors = [];
        if (!$success) {
            $errors = $validation->errors()->all();
        }
        $result = array("success" => $success, "errors" => $errors);
        return $result;
    }

    public function saveData($params)
    {
        $attributesPost = $params;
        $model = new User();

        $password = Hash::make(trim($attributesPost["User"]["password"]));
        $status = $attributesPost["User"]["status"];
        $changePassword = false;
        if (isset($attributesPost["User"]["id"]) && $attributesPost["User"]["id"] != "null" && $attributesPost["User"]["id"] != "-1") {
            $model = User::find($attributesPost["User"]['id']);
            if (isset($attributesPost["User"]['change_password']) && $attributesPost["User"]['change_password'] == true) {
                $changePassword = true;
            }
            $createUpdate = false;
        } else {
            $createUpdate = true;
        }
        $isEqualsPassword = true;
        if ($changePassword && !$createUpdate) {
            $password_old = $attributesPost["User"]['password_old'];
            $isEqualsPassword = Hash::check($password_old, $model->password);
            $password = Hash::make(trim($attributesPost["User"]["password_new"]));
        } else if ($changePassword == false && $createUpdate) {

            $password = Hash::make(trim($attributesPost["User"]["password"]));
        } else if ($changePassword == false && !$createUpdate) {

            $password = $model->password;
        }
        $validateResult = array();
        $attributesSet = array();
        if ($isEqualsPassword) {
            $postData = $attributesPost["User"];
            $attributesSet = array(
                "name" => $postData["name"],
                "email" => $postData["email"],
                "username" => isset($postData["username"]) ? $postData["username"] : "",
                "password" => $password,
                "status" => $status,
                "provider_id" => isset($postData["provider_id"]) ? $postData["provider_id"] : "",
                "provider" => isset($postData["provider"]) ? $postData["provider"] : "",


            );
            if (!$createUpdate) {
                $attributesSet['id'] = $attributesPost["User"]['id'];
            }


            $validateResult = self::validateModel($attributesSet);
            $success = $validateResult["success"];
            if ($success) {
                $model->fill($attributesSet);
                $model->save();
                $user_id = $model->id;
                $attributesSet['user_id'] = $user_id;

                if (isset($attributesPost["User"]['roles_id_data'])) {
                    $attributesSet['roles_id_data'] = $attributesPost["User"]['roles_id_data'];
                    $model->roles()->sync(explode(',', $attributesPost["User"]['roles_id_data']));
                }
            }
        } else {

            $validateResult = array("success" => false, "errors" => array('password_old' => 'No coincide con la contrasenia anterior.'));
        }
        $result = array(
            'validateResult' => $validateResult,
            'model' => $attributesSet
        );
        return $result;

    }

    public function saveUserSaveChangePassword($params)
    {
        $attributesPost = $params['attributesPost'];

        $user = Auth::user();
        $user_id = $user->id;
        $password = Hash::make(trim($attributesPost["User"]["password_old"]));
        $changePassword = false;
        $status = $user->status;
        $model = $user;
        $success = false;
        $success_message = 'No se actualizo la contraseña.';
        if (isset($attributesPost["User"]['change_password']) && $attributesPost["User"]['change_password'] == true) {
            $changePassword = true;
        }
        $createUpdate = false;
        $isEqualsPassword = true;
        if ($changePassword && !$createUpdate) {
            $password_old = $attributesPost["User"]['password_old'];
            $isEqualsPassword = Hash::check($password_old, $model->password);
            $password = Hash::make(trim($attributesPost["User"]["password_new"]));
        } else if ($changePassword == false && $createUpdate) {
            $password = Hash::make(trim($attributesPost["User"]["password"]));
        }

        $validateResult = array();
        $attributesSet = array();
        if ($isEqualsPassword) {
            $postData = $attributesPost["User"];
            $username = isset($postData["username"]) ? $postData["username"] : ($user_id == 1 ? 'isGodSystem' : $user->username);
            $attributesSet = array(
                "name" => isset($postData["name"]) ? $postData["name"] : $user->name,
                "email" => isset($postData["email"]) ? $postData["email"] : $user->email,
                "username" => $username,
                "password" => $password,
                "status" => $status,
                "provider_id" => isset($postData["provider_id"]) ? $postData["provider_id"] : $user->provider_id,
                "provider" => isset($postData["provider"]) ? $postData["provider"] : $user->provider,

            );

            $attributesSet['id'] = $user_id;
            $validateResult = self::validateModel($attributesSet);
            $success = $validateResult["success"];
            if ($success) {
                $model->fill($attributesSet);
                $model->save();
                $user_id = $model->id;
                $attributesSet['user_id'] = $user_id;
                $success_message = 'Se actualizo la contraseña.';

            }
        } else {
            $validateResult = array("success" => false, "errors" => array('password_old' => 'No coincide con la contrasenia anterior.'));
        }
        $result = array(
            'data' => $validateResult,
            'model' => $attributesSet,
            'success' => $success,
            'message' => $success_message
        );
        return $result;

    }

    public function getListUsersRoutes($params)
    {


        $query = DB::table($this->table);
        $selectString = "$this->table.id,CONCAT(people.last_name,' ',people.name,' - ',$this->table.email) as text,$this->table.name full_name,$this->table.email
        ,people.name first_name,people.last_name last_name
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
,countries.name countries,countries.id countries_id";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('customer_by_profile',$this->table . '.id','=','customer_by_profile.user_id');
        $query->join('customer', 'customer_by_profile.customer_id','=','customer.id');
        $query->join('customer_by_information', 'customer_by_information.id', '=', 'customer.id');
        $query->join('people_nationality', 'people_nationality.id', '=', 'customer_by_information.people_nationality_id');
        $query->join('people_profession', 'people_profession.id', '=', 'customer_by_information.people_profession_id');
        $query->join('ruc_type', 'ruc_type.id', '=', 'customer.ruc_type_id');
        $query->join('people_type_identification', 'people_type_identification.id', '=', 'customer.people_type_identification_id');
        $query->join('people', 'people.id', '=', 'customer.people_id');
        $query->leftJoin('customer_profile_by_location',  'customer_by_profile.id', '=', 'customer_profile_by_location.customer_by_profile_id');
        $query->leftJoin('zones', 'zones.id', '=', 'customer_profile_by_location.zones_id');
        $query->leftJoin('cities', 'cities.id', '=', 'zones.city_id');
        $query->leftJoin('provinces', 'provinces.id', '=', 'cities.province_id');
        $query->leftJoin('countries', 'countries.id', '=', 'provinces.country_id');
        $likeSet = isset($params["filters"]['search_value']["term"]) ? $params["filters"]['search_value']["term"] : null;
        if ($likeSet) {

            $query->where(function ($query) use ($likeSet
            ) {
                $query->where($this->table . '.name', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.email', 'like', '%' . $likeSet . '%');
                $query->orWhere( 'customer.identification_document', 'like', '%' . $likeSet . '%');

                $query->orWhere($this->table . '.username', 'like', '%' . $likeSet . '%');

            });
        }

        $query->limit(10)->orderBy('people.last_name', 'asc');
        $result = $query->get()->toArray();
        return $result;
    }
}
