<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Utilities\ProxyRequest;
use Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

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
    protected $table = 'users';
    protected $proxy;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProxyRequest $proxy, User $user)
    {
        $this->model = $user;
        $this->proxy = $proxy;
        $this->middleware('guest')->except('logout');
    }

    public function login_action(Request $request)
    {
        $response = array(
            'status' => 'failed', 'errors' => 'login', 'msg' => 'Failed to login. check your identity first', 'item' => '',
        );

        $rules = array(
            'username' => 'required|string',
            'password' => 'required|string|min:6',
        );

        $messages = array(
            'username.required' => 'Username cannot be empty.',
            'password.required' => 'Password cannot be empty.',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        $loginType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $login = [
            $loginType => $request->username,
            'password' => $request->password,
        ];

        $rules = ['captcha' => 'required|captcha'];
        $cek_captcha = Validator::make($request->all(), $rules);
        if ($cek_captcha->fails()) {
            $response = array(
                'status' => 'failed',
                'type' => 'captcha',
                'msg' => 'Kode Captcha Salah',
            );
        }

        if ($validator->fails()) {
            return response()->json(['status' => 'failed', 'errors' => $validator->errors(), 'msg' => 'Login failed. Please check your email and password', 'item' => '']);
        }

        if (Auth::attempt($login)) {
            Session::put('name', Auth::user()->username);
            Session::put('user_id', Auth::user()->id);
            Session::put('role_id', Auth::user()->role_id);
            $arr_con = array();
            foreach(Auth::user()->connections as $index => $con) {
                array_push($arr_con, $con->relation_id);
            }
            Session::put('connections', $arr_con);
            return response()->json([
                'status' => 'success',
                'msg' => 'Login success. Welcome ' . Auth::user()->name
            ]);
        } else {
            $response = array(
                'status' => 'failed', 'errors' => 'login', 'msg' => 'Oops, email or password is wrong', 'item' => '',
            );
        }

        return response()->json($response);
    }

    public function recaptcha()
    {
        return captcha_src('default');
    }

    public function auth(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', request('username'))->first();

        abort_unless($user, 404, 'This username does not exists.');
        abort_unless(
            \Hash::check(request('password'), $user->password),
            403,
            'This password does not exists.'
        );

        $resp = $this->proxy
            ->grantPasswordToken(request('username'), request('password'));

        return response([
            'user' => $user,
            'token' => [
                'access_token' => $resp->access_token,
                'refresh_token' => $resp->refresh_token,
                'expiresIn' => $resp->expires_in,
                'token_type' => $resp->token_type,
            ],
            'message' => 'You have been logged in',
        ], 200);
    }

    public function register()
    {
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'serial' => 'nullable',
            'phone' => 'required|string|max:15|min:10',
        ]);

        $user = User::create([
            'id' => $this->model->genId() . request('phone'),
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
            'serial' => $this->model->generateSerial(),
            'phone' => request('phone'),
        ]);

        $resp = $this->proxy->grantPasswordToken(
            $user->email,
            request('password')
        );

        return response([
            'token' => $resp->access_token,
            'expiresIn' => $resp->expires_in,
            'message' => 'Your account has been created',
        ], 201);
    }

    public function refreshToken()
    {
        $resp = $this->proxy->refreshAccessToken();

        return response([
            'token' => $resp->access_token,
            'expiresIn' => $resp->expires_in,
            'message' => 'Token has been refreshed.',
        ], 200);
    }

    public function logout(Request $request)
    {
        // DB::table('user_login')->where('user', Auth::user()->id)->delete();
        $this->guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('login')
            ->withSuccess('Terimakasih, selamat datang kembali!');
    }

    public function logout_api()
    {
        $token = request()->user()->token();
        $token->delete();

        cookie()->queue(cookie()->forget('refresh_token'));

        return response([
            'message' => 'You have been successfully logged out',
        ], 200);
    }
}
