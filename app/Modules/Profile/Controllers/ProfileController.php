<?php

namespace App\Modules\Profile\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Models\UsersConnection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
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
        $posts = Post::with('postImages', 'postLikes', 'postComments.user')
            ->where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->get();
        $suggestions = User::where('is_active', 1)
            ->whereNotIn('id', [Auth::user()->id])
            ->take(10)
            ->get();

        return view("Profile::index", [
            'posts' => $posts,
            'suggestions' => $suggestions
        ]);
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
        $id = decrypt($id);
        $user = User::with('role', 'posts', 'connections')
            ->where('id', $id)
            ->first();
        
        $posts = Post::with('postImages', 'postLikes', 'postComments.user')
            ->where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view("Profile::show", [
            'user' => $user,
            'posts' => $posts,
        ]);
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

    public function profileFollow($relation_id)
    {
        $relation_id = decrypt($relation_id);
        $response = array(
            'status' => 'failed',
            'msg' => 'An error occured!'
        );

        DB::beginTransaction();
        try {
            UsersConnection::create([
                'user_id' => Auth::user()->id,
                'relation_id' => $relation_id,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            
            DB::commit();
            $arr_con = array();
            foreach(Auth::user()->connections as $index => $con) {
                array_push($arr_con, $con->relation_id);
            }
            Session::put('connections', $arr_con);
            $response['status'] = 'success';
            $response['msg'] = 'You have follow this person!';
        } catch(\Exception $e) {
            DB::rollBack();
            $response['error'] = $e->getMessage();
        }

        return response()->json($response);
    }
}
