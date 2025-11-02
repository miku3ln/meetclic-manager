<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\MyBaseController;
use App\Models\User;
use Auth;
use Hash;

use Illuminate\Support\Facades\Request;
use Lang;
use League\Flysystem\Exception;
use Mail;
use Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class UserController extends MyBaseController
{

    public function getIndex()
    {
        $this->layout->content = View::make('user.index', [
        ]);
    }

    public function getListUsers()
    {
        $data =Request::all();
        $query = User::query()->select('users.*');
        $recordsTotal = $query->get()->count();
        $datatable = !empty($data['datatable']) ? $data['datatable'] : [];
        $datatable = array_merge(['pagination' => [], 'sort' => [], 'query' => []], $datatable);
        $sort = !empty($datatable['sort']['sort']) ? $datatable['sort']['sort'] : 'asc';
        $field = !empty($datatable['sort']['field']) ? $datatable['sort']['field'] : 'name';
        $page = !empty($datatable['pagination']['page']) ? (int)$datatable['pagination']['page'] : 1;
        $perpage = !empty($datatable['pagination']['perpage']) ? (int)$datatable['pagination']['perpage'] : -1;

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
        $data = $query->get()->toArray();
        //get roles
        foreach ($data as $key => $value) {
            $user = User::find($value['id']);
            $roles = implode(', ', $user->roles->pluck('name')->toArray());
            $data[$key]['roles'] = $roles;
        }
        $meta = [
            'page' => $page,
            'pages' => $pages,
            'perpage' => $perpage,
            'total' => $total,
        ];
        $sort = [
            'sort' => $sort,
            'field' => $field,
        ];
        $result = array(
            'meta' => $meta + $sort,
            'data' => $data
        );
        return Response::json(
            $result
        );
    }

    public function getFormUser($id = null)
    {
        $method = 'POST';
        $user = (isset($id) && $id != 1) ? User::find($id) : new User();
        $user->password = null;
        $roles = $id ? json_encode($user->roles->pluck('name', 'id')->toArray()) : null;
        $view = View::make('user.loads._form', [
            'method' => $method,
            'user' => $user,
            'roles' => $roles
        ])->render();
        return Response::json(array(
            'html' => $view
        ));
    }

    public function postSave()
    {
        DB::beginTransaction();
        try {
            $data = Request::all();
            if ($data['user_id'] == '') { //Create
                $user = new User();
                $user->status = 'ACTIVE';
                $user->password = Hash::make(trim($data['password']));
            } else { //Update
                $user = User::find($data['user_id']);
                if (isset($data['status'])) {
                    $user->status = $data['status'];
                }
                if (isset($data['password']) && !empty(trim($data['password']))) {
                    $user->password = Hash::make(trim($data['password']));
                }
            }
            $user->name = trim($data['name']);
            $user->email = trim($data['email']);
            $user->username = trim($data['username']);
            $user->save();
            $user->roles()->sync(explode(',', $data['roles_id']));
            DB::commit();
            return Response::json(true);
        } catch (Exception $e) {
            DB::rollback();
            return Response::json(false);
        }
    }

    public function postIsEmailUnique()
    {
        $validation = Validator::make(Request::all(), ['email' => 'unique:users,email,' . Request::input('id')]);
        return Response::json($validation->passes() ? true : false);
    }

    public function postIsUsernameUnique()
    {
        $validation = Validator::make(Request::all(), ['username' => 'unique:users,username,' . Request::input('id')]);
        return Response::json($validation->passes() ? true : false);
    }

    public function postCheckPasswordOld()
    {

        $user = User::find(Request::input('id'));
        return Response::json(Hash::check(Request::input('password_old'), $user->password));
    }

    /*https://stackoverflow.com/questions/22405762/laravel-update-model-with-unique-validation-rule-for-attribute*/
    public function uniqueUserName()
    {
        $inputPost = Request::all();

        $user_id = Request::input('id');
        $validations = $user_id ? 'unique:users,username,' . $user_id : 'unique:users,username';
        $inputsValidations = $user_id ? array(
            "username" => $inputPost['username'],
            "id" => $inputPost['id'],

        ) : array(
            "username" => $inputPost['username']
        );

        $validation = Validator::make($inputsValidations, ['username' => $validations]);
        return Response::json($validation->passes() ? true : false);
    }

    public function uniqueUserEmail()
    {
        $inputPost = Request::all();

        $user_id = Request::input('id');
        $validations = $user_id ? 'unique:users,email,' . $user_id : 'unique:users,email';
        $inputsValidations = $user_id ? array(
            "email" => $inputPost['email'],
            "id" => $inputPost['id'],

        ) : array(
            "email" => $inputPost['email']
        );
        $validation = Validator::make($inputsValidations, ['email' => $validations]);
        return Response::json($validation->passes() ? true : false);
    }

    public function equalsUserPassword()
    {
        $inputPost = Request::all();
        $user_id = $inputPost['id'];
        $password_old = $inputPost['password_old'];
        $user = User::find($user_id);
        return Response::json(Hash::check($password_old, $user->password));
    }

    public function equalsUserChangePassword()
    {
        $user = Auth::user();
        $inputPost = Request::all();
        $password_old = $inputPost['password_old'];
        return Response::json(Hash::check($password_old, $user->password));
    }
    public function userSaveChangePassword ()
    {
        $attributesPost = Request::all();
        $model = new User();
        $result = $model->saveUserSaveChangePassword(array("attributesPost"=>$attributesPost));
        return Response::json($result);
    }
    public function getListUsersRoutes ()
    {
        $attributesPost = Request::all();
        $model = new User();
        $result = $model->getListUsersRoutes($attributesPost);
        return Response::json($result);
    }
}
