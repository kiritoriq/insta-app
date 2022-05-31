<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8'
        ]);
    }

    public function register(Request $request) {
        $validator = $this->validator($request->all());

        if($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'type' => 'validate',
                'error' => ucwords(implode(', ', $validator->errors()->all()))
            ]);
        }

        $rules = ['captcha' => 'required|captcha'];
        $cek_captcha = Validator::make($request->all(), $rules);
        if ($cek_captcha->fails()) {
            $response = array(
                'status' => 'failed',
                'type' => 'captcha',
                'error' => 'Captcha Failed!',
            );
            
            return response()->json($response);
        }

        $response = array(
            'status' => 'failed',
            'msg' => 'An error occured!'
        );

        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->role_id = 3;
        $user->dob = date('Y-m-d', strtotime($request->date_of_birth));
        $user->gender = $request->gender;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->is_active = 1;
        
        try {
            $user->save();

            $response['status'] = 'success';
            $response['msg'] = 'Register complete!';
        } catch(\Exception $e) {
            $response['error'] = $e->getMessage();
        }

        return response()->json($response);
    }
}
