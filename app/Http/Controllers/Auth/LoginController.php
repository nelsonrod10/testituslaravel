<?php

namespace App\Http\Controllers\Auth;

use App\Reqresin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Se especifica el guard a utilizar para reqres.in
    */
    protected function guard()
    {
        return Auth::guard('reqres');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        $responseReqRes = $this->sendReqResRequest($request);
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request,$responseReqRes);
    }

    /**
     * Verificación de la existencia del usuario en reqres.in
     */
    private function sendReqResRequest($request){
        $failedMessage=[];
        
        $response = Http::post('https://reqres.in/api/login',[
            'Content-Type'  => 'x-www-form-urlencoded',
            'email'     => $request[$this->username()],
            'password'  => $request['password']
        ]);

        if($response->status() === 200){
            Reqresin::firstOrCreate(
                ['email' => $request[$this->username()]],
                ['password' => Hash::make($request['password'])] 
            );
        }else{
            /**
            * Se obtiene el mensaje de error de reqres.in
            */
            $failedMessage = json_decode($response->body(),true);
            return $failedMessage['error'];
        }

        return ;
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request,$messageReqRes)
    {
        /**
        * Se agrega el mensaje personalizado
        */
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
            'reqres'          =>  $messageReqRes
        ]);
    }

}
