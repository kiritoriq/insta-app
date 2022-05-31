<?php

namespace App\Modules\Home\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
        // $section = DB::table('section')
        //         ->select('id', 'section', 'order')
        //         ->where('is_active', 1)
        //         ->get();
        
        // $parent_menu = DB::table('menu')
        //             ->select('id','is_section','title','bullet','icon','has_submenu','page')
        //             ->where('parent_id', '=', 0)
        //             ->where('is_active', '=', 1)
        //             ->orderBy('order', 'asc')
        //             ->get()->toArray();
        // foreach($parent_menu as $key => $item) {
        //     $parent_menu[$key] = array();
        //     if($item->has_submenu == 1) {
        //         foreach($item as $index => $val) {
        //             $parent_menu[$key][$index] = $val;
        //         }
        //         $parent_menu[$key]['submenu'] = array();
        //         $submenu = DB::table('menu')->where('parent_id', '=', $item->id)->orderBy('order', 'asc')->get();
        //         foreach($submenu as $row => $value) {
        //             $parent_menu[$key]['submenu'][$row]['title'] = $value->title;
        //             $parent_menu[$key]['submenu'][$row]['bullet'] = $value->title;
        //             $parent_menu[$key]['submenu'][$row]['page'] = $value->page;
        //             $parent_menu[$key]['submenu'][$row]['icon'] = $value->icon;
        //         }
        //     } else {
        //         if($item->is_section == 1) {
        //             $parent_menu[$key]['section'] = $item->title;
        //             // $arrMenu['section'] = $item->title; 
        //         }
        //         foreach($item as $index => $val) {
        //             $parent_menu[$key][$index] = $val;
        //         }
        //     }
        // }
        // dd($parent_menu);
        return view("Home::index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    public function getPageAduan(Request $request) {
        // dd($request);
        return view('Home::modal_grafik');
    }
}
