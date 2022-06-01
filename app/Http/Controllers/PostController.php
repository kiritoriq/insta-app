<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostComments;
use App\Models\PostImages;
use App\Models\PostLikes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function all()
    {
        //
    }

    public function postByUser($user_id)
    {
        //
    }

    public function post(Request $request)
    {
        $response = array(
            'status' => 'failed',
            'msg' => 'An error occured!'
        );

        DB::beginTransaction();
        try {
            $post_id = Post::insertGetId([
                'user_id' => Auth::user()->id,
                'caption' => $request->post_caption,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            if($request->has('images')) {
                $mode = 0777;
                $recursive = true;
                $destinationPath = public_path() . '/media/upload/' . Auth::user()->id;
                if(! is_dir($destinationPath)) {
                    $destinationPath = str_replace("\\", '/', $destinationPath);
                    mkdir($destinationPath, $mode, $recursive);
                }
                $doks = $request->file('images');
                $tipeFile = $doks->getClientOriginalExtension();
                $ctime = mktime(date('H'), date('i'), date('s'), date('m'), date('d'), date('Y'));
                $fileName = Str::random(7) . '_' . $ctime . '.' . $tipeFile;
                $upload = $doks->move($destinationPath, $fileName);
                if($upload) {
                    PostImages::create([
                        'post_id' => $post_id,
                        'images' =>  'media/upload/' . Auth::user()->id . '/' . $fileName,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }

            DB::commit();
            $response['status'] = 'success';
            $response['msg'] = 'Post has successfully posted!';
        } catch(\Exception $e) {
            DB::rollBack();
            $response['error'] = $e->getMessage();
        }

        return response()->json($response);
    }

    public function edit($post_id)
    {
        //
    }

    public function update(Request $request)
    {
        //
    }

    public function destroy($post_id)
    {
        //
    }

    public function postComment($post_id, Request $request)
    {
        $response = array(
            'status' => 'failed',
            'msg' => 'An error occured!'
        );

        DB::beginTransaction();
        try {
            PostComments::create([
                'post_id' => $post_id,
                'user_id' => Auth::user()->id,
                'comment' => $request->comment_caption,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            DB::commit();
            $response['status'] = 'success';
            $response['msg'] = 'Comment has successfully posted!';
        } catch(\Exception $e) {
            DB::rollBack();
            $response['error'] = $e->getMessage();
        }

        return response()->json($response);
    }

    public function postLike($post_id, Request $request)
    {
        $response = array(
            'status' => 'failed',
            'msg' => 'An error occured!'
        );

        DB::beginTransaction();
        try {
            $check_post = PostLikes::where('user_id', Auth::user()->id)
                ->where('post_id', $post_id)
                ->get();
            if(count($check_post) > 0) {
                PostLikes::where('user_id', Auth::user()->id)
                ->where('post_id', $post_id)
                ->delete();
                $response['msg'] = 'You unlike this post!';
            } else {
                PostLikes::create([
                    'post_id' => $post_id,
                    'user_id' => Auth::user()->id,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                $response['msg'] = 'You have like this post!';
            }

            DB::commit();
            $response['status'] = 'success';
        } catch(\Exception $e) {
            DB::rollBack();
            $response['error'] = $e->getMessage();
        }

        return response()->json($response);
    }
}
