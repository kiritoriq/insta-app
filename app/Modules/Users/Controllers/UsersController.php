<?php

namespace App\Modules\Users\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use App\Models\Roles;
use App\Models\UsersRoles;


class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::with(['roles.role'])->orderBy('id', 'asc')->get();
        return view("Users::index",['users' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCreate()
    {
        $role = Roles::orderBy('id', 'asc')->get();
        return view('Users::create', ['roles' => $role]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|confirmed',
            'role' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json(['status' => 'failed', 'errors' => $validator->errors(), 'msg' => 'Gagal register, silahkan coba lagi', 'item' => '']);
        } else {
            $response['status'] = 'failed';
            $response['msg'] = 'Tidak berhasil simpan';
            DB::beginTransaction();
            try {
                $userID = User::insertGetId([
                    'username' => $request->username,
                    'password' => Hash::make($request->password),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

                if($userID) {
                    if(is_array($request->role)) {
                        foreach($request->role as $role) {
                            UsersRoles::create([
                                'user_id' => $userID,
                                'role_id' => $role
                            ]);
                        }
                    } else {
                        UsersRoles::create([
                            'user_id' => $userID,
                            'role_id' => $request->role
                        ]);
                    }
                }

                DB::commit();
                $response['status'] = 'success';
                $response['msg'] = 'Data berhasil disimpan';

            } catch(\Exception $e) {
                DB::rollback();
                $response['msg'] = $e->getMessage();
            }
            return response()->json($response);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getEdit($id)
    {
        $role = Roles::orderBy('id', 'asc')->get();
        $data = User::with(['roles.role'])->where('id', '=', $id)->first();
        // dd($data->roles[0]->role_id);
        return view('Users::edit', ['data' => $data, 'roles' => $role]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postEdit(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'role' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json(['status' => 'failed', 'errors' => $validator->errors(), 'msg' => 'Gagal edit data, silahkan coba lagi', 'item' => '']);
        } else {
            $response['status'] = 'failed';
            $response['msg'] = 'Tidak berhasil simpan';
            DB::beginTransaction();
            try {
                if($request->has('password')) {
                    $user = User::where('id', '=', $request->id)
                            ->update([
                                'username' => $request->username,
                                'password' => Hash::make($request->password),
                                'updated_at' => date('Y-m-d H:i:s')
                            ]);
                } else {
                    $user = User::where('id', '=', $request->id)
                            ->update([
                                'username' => $request->username,
                                'updated_at' => date('Y-m-d H:i:s')
                            ]);
                }

                if($user) {
                    $deleteRoles = UsersRoles::where('user_id', '=', $request->id)->delete();
                    if(is_array($request->role)) {
                        foreach($request->role as $role) {
                            UsersRoles::create([
                                'user_id' => $request->id,
                                'role_id' => $role
                            ]);
                        }
                    } else {
                        UsersRoles::create([
                            'user_id' => $request->id,
                            'role_id' => $request->role
                        ]);
                    }
                }

                DB::commit();
                $response['status'] = 'success';
                $response['msg'] = 'Data berhasil disimpan';

            } catch(\Exception $e) {
                DB::rollback();
                $response['msg'] = $e->getMessage();
            }
            return response()->json($response);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postDelete(Request $request)
    {
        $response['status'] = "error";
        $response['msg'] = "Gagal menghapus data";
        DB::beginTransaction();
        try {
            $user = DB::table('users')->where('id', '=', $request->id)->delete();
            if($user) {
                DB::table('users_roles')->where('user_id', '=', $request->id)->delete();
            }
            
            DB::commit();
            $response['status'] = "success";
            $response['msg'] = "Data Berhasil dihapus";
        } catch(\Exception $error) {
            DB::rollBack();
            $response['error_msg'] = $error->getMessage();
        }
        return response()->json($response);
    }
}
