<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    protected $req;

    public function __construct()
    {
        $this->req = [
            'title' => 'required',
            'body' => 'required',
        ];
    }

    public function index()
    {
        $posts = Post::get();
        return response()->json([
            'success' => true,
            'message' => 'All Posts',
            'data'    => $posts
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), $this->req);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'All field not null!',
                'data'   => $validator->errors()
            ], 401);
        } else {
            $post = Post::create([
                'title' => request('title'),
                'slug' => Str::slug(request('title') . Str::random(20)),
                'body' => request('body'),
            ]);
            if ($post) {
                return response()->json([
                    'success' => true,
                    'message' => 'Post Berhasil Disimpan!',
                    'data' => $post
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Post Gagal Disimpan!',
                ], 400);
            }
        }
    }

    public function show($id)
    {
        // try {
        $post = Post::find($id);
        if ($post) {
            return response()->json([
                'success'   => true,
                'message'   => 'Detail Post!',
                'data'      => $post
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post Not Found!',
            ], 404);
        }
        // } catch (\Exception $e) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Error!'
        //     ]);
        // }
    }

    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), $this->req);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'All field not null!',
                'data'   => $validator->errors()
            ], 401);
        } else {
            $post = Post::whereId($id)->update([
                'title' => request('title'),
                'slug' => Str::slug(request('title') . Str::random(20)),
                'body' => request('body'),
            ]);
            if ($post) {
                return response()->json([
                    'success' => true,
                    'message' => 'Post Berhasil diupdate',
                    'data' => $post
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Post Gagal diupdate!',
                ], 404);
            }
        }
    }

    public function destroy($id)
    {
        $post = Post::whereId($id)->delete();
        if ($post) {
            return response()->json([
                'success' => true,
                'message' => 'Post Berhasil Dihapus!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post Gagal dihapus!',
            ], 404);
        }
    }
}
