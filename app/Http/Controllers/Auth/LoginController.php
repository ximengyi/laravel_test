<?php

namespace App\Http\Controllers\Auth;



use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Tools\ResponseFormatHelper;


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

    use AuthenticatesUsers,ResponseFormatHelper;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    public $maxAttempts = 100; //最大尝试登陆次数
    public $decayMinutes =1; //1分钟

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.


        if ($this->hasTooManyLoginAttempts($request)) {

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

        return $this->sendFailedLoginResponse($request);
    }



    /**
     * 登录成功返回用户信息
     * @param Request $request
     *
     * @return user_info
     */

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        $userInfo = $this->guard()->user();
        return $this->success($userInfo);

    }

    /**
     * 登陆失败返回
     * @param Request $request
     */

    protected function sendFailedLoginResponse(Request $request)
    {
       return $this->renderErrcodeJson('login_err');
    }



    /**
     * 退出登录
     * @param Request $request
     */
    protected function loggedOut(Request $request)
    {
        return $this->success('已退出登录');

    }

}
