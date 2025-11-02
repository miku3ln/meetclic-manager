<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Events\Verified;



class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/homeVerification';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
    public function verify(Request $request)
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login')->with('status', 'Ya habías verificado tu correo.');
        }

        // Verifica que el ID y hash coincidan con el usuario autenticado
        if (!hash_equals((string) $request->route('id'), (string) $user->getKey()) ||
            !hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            abort(403, 'El enlace no es válido.');
        }

        // Marcar como verificado
        if ($user->markEmailAsVerified()) {
            $user->is_active = 1;
            $user->save();
            event(new Verified($user)); // <- Aquí Laravel dispara el evento
        }

        return redirect()->route('login')->with('status', 'Correo verificado con éxito. Ya puedes iniciar sesión.');
    }
    public function verifyApp(Request $request)
    {
        $id = $request->route('id');
        $hash = $request->route('hash');

        $user = \App\Models\User::findOrFail($id);

        // Validar que el hash del correo coincida
        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return response()->json([
                'success' => false,
                'message' => 'El enlace no es válido.',
            ], 403);
        }

        // Ya verificado antes
        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'success' => true,
                'message' => 'Tu correo ya está verificado.',
            ]);
        }

        // Verificar correo y activar usuario
        $user->markEmailAsVerified();
        $user->is_active = 1;
        $user->save();

        event(new \Illuminate\Auth\Events\Verified($user));

        return response()->json([
            'success' => true,
            'message' => 'Correo verificado y cuenta activada correctamente.',
        ]);
    }
}
