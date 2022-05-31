<?php

namespace App\Modules\Menu\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Roles;
use App\Modules\Menu\Models\MenuModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MenuModels::where('is_active', 1)->orderBy('parent_id', 'asc')->orderBy('is_section', 'asc')->orderBy('order', 'asc')->get();
        return view("Menu::index", ['menus' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = Roles::where('is_active', '=', 1)->get();
        return view('Menu::create', ['roles' => $role]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        if($request->is_section == 'true') {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                // 'bullet' => 'required',
                'is_active' => 'required',
                'order' => 'required'
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                // 'bullet' => 'required',
                'icon' => 'required',
                'is_active' => 'required',
                'order' => 'required'
            ]);
        }

        $response = array(
            'status' => 'failed',
            'msg' => 'Terjadi Kesalahan'
        );

        if($validator->fails()) {
            return response()->json(['status' => 'validate', 'error' => ucwords(implode(', ', str_replace('field is required.', 'Tidak Boleh Kosong', str_replace('The ', '', $validator->errors()->all()))))]);
        } else {
            DB::beginTransaction();
            try {
                if($request->has('is_section') && $request->is_section == 'true') {
                    $insertMenu = Menu::create([
                        'title' => $request->title,
                        'bullet' => ($request->bullet!="")?$request->bullet:null,
                        'is_section' => 1,
                        'has_submenu' => 0,
                        'parent_id' => 0,
                        'icon' => 'default icon',
                        'page' => null,
                        'order' => $request->order,
                        'is_active' => ($request->is_active=='true')?1:0,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                    $menuName = strtolower(str_replace(" ", "", $request->title));
                    $permission_id = array();
                    $show_id = DB::table('permission')->insertGetId([
                                    'permission_name' => 'section-'.$menuName.'-show',
                                    'description' => 'Permission to show '.$menuName.' section',
                                    'is_active' => 1,
                                    'created_at' => date('Y-m-d H:i:s')
                                ]);
                    array_push($permission_id, $show_id);
    
                    if($request->has('roles')) {
                        foreach($request->roles as $key => $role) {
                            foreach($permission_id as $permission) {
                                DB::table('role_permission')->insert([
                                    'role_id' => $role,
                                    'permission_id' => $permission,
                                    'created_at' => date('Y-m-d H:i:s')
                                ]);
                            }
                        }
                    }
                } else {
                    $insertMenu = Menu::create([
                        'title' => $request->title,
                        'bullet' => ($request->bullet!="")?$request->bullet:null,
                        'is_section' => (($request->has('is_section'))?1:0),
                        'has_submenu' => (($request->has('is_root'))?1:0),
                        'parent_id' => (($request->has('is_root'))?0:$request->parent_id),
                        'icon' => $request->icon,
                        'page' => $request->page,
                        'order' => $request->order,
                        'is_active' => ($request->is_active=='true')?1:0,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                    $menuName = strtolower(str_replace(" ", "", $request->title));
                    $permission_id = array();
                    $show_id = DB::table('permission')->insertGetId([
                                    'permission_name' => 'menu-'.$menuName.'-show',
                                    'description' => 'Permission to show '.$menuName.' menu',
                                    'is_active' => 1,
                                    'created_at' => date('Y-m-d H:i:s')
                                ]);
                    array_push($permission_id, $show_id);
                    if($request->has('action')) {
                        foreach($request->action as $key => $action) {
                            $action_id = DB::table('permission')->insertGetId([
                                'permission_name' => 'menu-'.$menuName.'-'.$action,
                                'description' => 'Permission to '.$action.' in '.$menuName.' menu',
                                'is_active' => 1,
                                'created_at' => date('Y-m-d H:i:s')
                            ]);
                            array_push($permission_id, $action_id);
                        }
                    }
    
                    if($request->has('roles')) {
                        foreach($request->roles as $key => $role) {
                            foreach($permission_id as $permission) {
                                DB::table('role_permission')->insert([
                                    'role_id' => $role,
                                    'permission_id' => $permission,
                                    'created_at' => date('Y-m-d H:i:s')
                                ]);
                            }
                        }
                    }
                }

                // Auto Create Module L5 Modular
                // if($request->page != null or $request->page != '') {
                //     $moduleName = str_replace(" ", "", $request->title);
                //     Artisan::call('make:module '.$moduleName);
                // }
                DB::commit();
                $response['status'] = 'success';
                $response['msg'] = 'Data Berhasil Disimpan';
            } catch(\Exception $e) {
                DB::rollBack();
                $response['error'] = $e->getMessage();
                $response['msg'] = 'Terjadi kesalahan, data gagal disimpan';
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
