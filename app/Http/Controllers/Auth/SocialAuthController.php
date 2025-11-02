<?php


namespace App\Http\Controllers\Auth;


use Illuminate\Http\Request;
use Socialite;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Contracts\Provider;
use App\User;
use Exception;
use Auth;
use App\Models\Role;

class SocialAuthController extends Controller
{

    protected $redirectTo = '/homeSocial';

    public function callback($provider)
    {

        $user = $this->createOrGetUser(Socialite::driver($provider));

        auth()->login($user);

        $redirectTo = "/homeSocial";
    /*    if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }
        $role = new Role();
        $redirectTo = $role->getUrlCurrentUser();*/

        return redirect()->to($redirectTo);
    }

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    private function createOrGetUser(Provider $provider)
    {

        $providerUser = $provider->user();

        $providerName = class_basename($provider);

        $user = User::whereProvider($providerName)
            ->whereProviderId($providerUser->getId())
            ->first();

        if (!$user) {
            $user = User::create([
                'email' => $providerUser->getEmail(),
                'name' => $providerUser->getName(),
                'provider_id' => $providerUser->getId(),
                'provider' => $providerName
            ]);
        }

        return $user;
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }
}
