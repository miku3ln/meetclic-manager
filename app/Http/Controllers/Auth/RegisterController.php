<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Utils\UtilUser;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PeopleTypeIdentification;
use App\Models\PeopleGender;
use App\Utils\Util;
use Illuminate\Support\Facades\App;

class RegisterController extends Controller
{


    protected $redirectTo = 'dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    //OVERWRITE
    public function showRegistrationFormCustomer(Request $request)
    {
        $util=new Util();
        $util->setLanguage($request);
        $genderData = PeopleGender::getAllGenders();
        $identificationData = PeopleTypeIdentification::getAllIdentification();
        $managerUtil = [
            'configPartial' => [
                'genderData' => $genderData,
                'identificationData' => $identificationData,

            ]
        ];
        return view('auth.customer.register', $managerUtil);
    }

    public function showRegistrationFormBusiness()
    {
        return view('auth.register');
    }

    public function registerCustomer(Request $request)//CMS-TEMPLATE-USER-REGISTER
    {
        $managerSave = new UtilUser();

        $result = $managerSave->saveUser(array(
            'typeSave' => UtilUser::TYPE_SAVE_CUSTOMER,
            'request' => $request
        ));
        return $result;

    }

    public function registerBusiness(Request $request)
    {
        $dataPost = $request->all();
        return $this->saveUser(array(
            'typeSave' => UtilUser::TYPE_SAVE_BUSINESS,
            'request' => $request
        ));

    }
    public function verifyRegister($id, $hash, Request $request)
    {

        if (! $request->hasValidSignature()) {
            abort(403, 'Link inválido o expirado');
        }
        $user = User::findOrFail($id);
        if (! hash_equals((string) $hash, sha1($user->email))) {
            abort(403);
        }

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            $user->is_active = 1;
            $user->save();
        }
        $lang = App::getLocale();

        return redirect()->to(url('/' . $lang . '/login'))
            ->with('status', 'Correo verificado con éxito. Ya puedes iniciar sesión.');

    }


}
