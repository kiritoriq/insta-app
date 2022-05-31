<?php

namespace App\Modules\Roles\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Roles;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RolesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Roles::orderBy('created_at', 'asc')->get();
        return view("Roles::index", ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Roles::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_role' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'type' => 'validate',
                'error' => ucwords(implode(', ', str_replace('field is required.', 'Tidak Boleh Kosong', str_replace('The ', '', $validator->errors()->all()))))
            ]);
        }

        $response = array(
            'status' => 'failed',
            'msg' => 'Terjadi Kesalahan!'
        );

        DB::beginTransaction();
        try {
            Roles::create([
                'roles' => $request->nama_role,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            DB::commit();
            $response = array(
                'status' => 'success',
                'msg' => 'Data berhasil disimpan!'
            );
        } catch(\Exception $e) {
            DB::rollBack();
            $response['error'] = $e->getMessage();
        }

        return response()->json($response);
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
        $role = Roles::where('id', $id)->first();
        return view('Roles::edit', ['id' => $id, 'role' => $role]);
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
        $validator = Validator::make($request->all(), [
            'nama_role' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'type' => 'validate',
                'error' => ucwords(implode(', ', str_replace('field is required.', 'Tidak Boleh Kosong', str_replace('The ', '', $validator->errors()->all()))))
            ]);
        }

        $response = array(
            'status' => 'failed',
            'msg' => 'Terjadi Kesalahan!'
        );

        DB::beginTransaction();
        try {
            Roles::where('id', $id)->update([
                'roles' => $request->nama_role,
                'is_active' => 1,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            DB::commit();
            $response = array(
                'status' => 'success',
                'msg' => 'Data berhasil disimpan!'
            );
        } catch(\Exception $e) {
            DB::rollBack();
            $response['error'] = $e->getMessage();
        }

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Roles::where('id', $id);

        $response = array(
            'status' => 'failed',
            'msg' => 'Gagal menghapus! Terjadi Kesalahan'
        );

        if($role->delete()) {
            $response = array(
                'status' => 'success',
                'msg' => 'Data Berhasil dihapus'
            );
        }

        return response()->json($response);
    }
}
