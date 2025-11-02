<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Socialite;
use Exception;
use App\Utils\UtilUser;
use Hash;
use Auth;



class FacebookController extends Controller
{
    protected $redirectTo = '/homeFacebook';
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleFacebookCallback(Request $request)
    {
        $providerName = 'facebook';

        $providerSet = UtilUser::PROVIDER_FACEBOOK;
        $typeSave = UtilUser::TYPE_SAVE_CUSTOMER_FACEBOOK;
        $provider = null;
        if (Input::has('code')) {
            /*       session()->put('state', Input::has('state'));
                   session()->put('code', Input::has('code'));*/
            $provider = Socialite::driver($providerName)->stateless()->user();

        } else {
            $provider = Socialite::driver($providerName)->user();
        }


        DB::beginTransaction();
        try {

            $create = [];
            $user_id = $provider->getId();
            $name = $provider->getName();
            $email = $provider->getEmail();
            $username = $provider->getNickname();
            $avatar = $provider->getAvatar();
            $provider_id = $user_id;
            $create['name'] = $name;
            $create['username'] = $username;
            $create['status'] = 'ACTIVE';
            $create['provider'] = $providerSet;
            $create['user_id'] = $user_id;
            $create['avatar'] = $avatar;

            $create['email'] = $email;
            $create['provider_id'] = $provider_id;
            $password = Hash::make(trim($user_id));
            $create['password'] = $password;
            $managerSave = new UtilUser();
            $result = $managerSave->managerUserProvider(array(
                'typeSave' => $typeSave,
                'data' => $create
            ));
            $success = $result['success'];
            if (!$success) {
                DB::rollBack();
                return $this->sendFailedResponse($result['msg']);

            } else {
                DB::commit();
                $userCurrent = $result['data']['user'];
                $this->initSession($userCurrent, $request);
                return $this->sendSuccessResponse(1);
            }
        } catch (Exception $e) {
            return $this->sendFailedResponse($e->getMessage());
        }

    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function redirectTest(Request $request)
    {
        DB::beginTransaction();
        try {

            $create = [];
            $user_id = 1234;
            $name = 'facebook';
            $email = 'username';
            $username = 'username';
            $provider_id = $user_id;
            $provider = UtilUser::PROVIDER_FACEBOOK;
            $typeSave = UtilUser::TYPE_SAVE_CUSTOMER_FACEBOOK;
            $create['name'] = $name;
            $create['username'] = $username;
            $create['status'] = 'ACTIVE';
            $create['provider'] = $provider;
            $create['user_id'] = $user_id;
            $create['email'] = $email;
            $create['provider_id'] = $provider_id;
            $password = Hash::make(trim($user_id));
            $create['password'] = $password;
            $managerSave = new UtilUser();
            $result = $managerSave->managerUserProvider(array(
                'typeSave' => $typeSave,
                'data' => $create
            ));

            $success = $result['success'];


            if (!$success) {
                DB::rollBack();

                return $this->sendFailedResponse($result['msg']);

            } else {
                DB::commit();
                $userCurrent = $result['data']['user'];

                $this->initSession($userCurrent, $request);
                return $this->sendSuccessResponse(1);
            }
        } catch (Exception $e) {
            return $this->sendFailedResponse($e->getMessage());
        }


    }

    protected function sendFailedResponse($msg = null)
    {
        return redirect()->route('login', ['language' => 'es', 'error' => $msg])
            ->withErrors(['msg' => $msg ?: 'Unable to login, try with another provider to login.']);
    }

    /**
     * Create a new controller instance.
     *
     * @param Request $request
     * @return void
     */
    public function handleGoogleCallback(Request $request)
    {
        $providerName = 'google';
        $providerSet = UtilUser::PROVIDER_GOOGLE;
        $typeSave = UtilUser::TYPE_SAVE_CUSTOMER_GOOGLE;
        $provider = null;

        if (Input::has('code')) {
            /*  session()->put('state', Input::has('state'));
              session()->put('code', Input::has('code'));*/
            $provider = Socialite::driver($providerName)->stateless()->user();
        } else {
            $provider = Socialite::driver($providerName)->user();
        }

        DB::beginTransaction();
        try {

            $create = [];
            $user_id = $provider->getId();
            $name = $provider->getName();
            $email = $provider->getEmail();
            $username = $provider->getNickname();
            $avatar = $provider->getAvatar();
            $provider_id = $user_id;
            $create['name'] = $name;
            $create['username'] = $username;
            $create['status'] = 'ACTIVE';
            $create['provider'] = $providerSet;
            $create['user_id'] = $user_id;
            $create['email'] = $email;
            $create['avatar'] = $avatar;


            $create['provider_id'] = $provider_id;
            $password = Hash::make(trim($user_id));
            $create['password'] = $password;
            $managerSave = new UtilUser();
            $result = $managerSave->managerUserProvider(array(
                'typeSave' => $typeSave,
                'data' => $create
            ));
            $success = $result['success'];
            if (!$success) {
                DB::rollBack();

                return $this->sendFailedResponse($result['msg']);

            } else {
                DB::commit();
                $userCurrent = $result['data']['user'];
                $this->initSession($userCurrent, $request);

                return $this->sendSuccessResponse(1);
            }
        } catch (Exception $e) {
            return $this->sendFailedResponse($e->getMessage());
        }

    }

    protected function sendSuccessResponse($error)
    {
        $user = Auth::user();
        if ($user->id != 1) {
            $user_id = $user->id;
            $modelUtil = new UtilUser();
            $redirectPage = $modelUtil->getUrlUser($user);
            $modelMovement = new \App\Models\AccountGamification();
            $managerUser = $modelMovement->managerUserRegister(
                ['filters' => [
                    'user_id' => $user_id
                ]]
            );


            return redirect()->to($redirectPage);
        }
    }

    protected function verifySession($request, $type)
    {

        /*    if (\Request::input('error') == 'access_denied') {
                return redirect('login');
            }

            if (strpos($request->path(), 'linkedin') !== false) {
                $user = Socialite::driver('linkedin')->user();
            } else {
                $user = Socialite::driver('google')->user();
            }

            $state = $request->get('state');
            $request->session()->put('state', $state);

            if (\Auth::check() == false) {
                session()->regenerate();
            }*/
    }

    protected function initSession($user, Request $request)
    {
        /*        event(new Registered($user));
                $this->guard()->login($user);
                $this->registered($request, $user);
                $this->clearLoginAttempts($request);
                $authenticated = $this->authenticated($request, $this->guard()->user());*/
        event(new Registered($user));
        $this->guard()->login($user);
        /* $this->registered($request, $user);*/

    }
}
