<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Images;
use Illuminate\Support\Carbon;

class PostController extends Controller
{
    public function createPost(Request $request)
    {
        $postName = $request->get('postName');
        $postDescription = $request->get('postDescription');
        $postCategory = $request->get('postCategory');
        $userId = $request->get('id');

        $newPost = new Post([
            'postName' => $postName,
            'postDescription' => $postDescription,
            'postCategory' => $postCategory,
            'user_id' => $userId
        ]);

        $newPost->save();
        return response()->json($newPost);
    }

    public function GetAllPost()
    {
        $posts = Post::all();
        if (count($posts) <= 0) return response()->json([]);

        $arrayIds = collect($posts)->map(function ($value) {
            return $value->id;
        });

        $allImagesPost = Images::find($arrayIds);
        return response()->json([
            'posts' => $posts,
            'allImagesPost' => $allImagesPost
        ]);
    }

    public function getPostById($id)
    {
        $post = Post::where('id', '=', $id)->get();
        if (count($post) <= 0) return response()->json([]);
        $images = Images::where('post_id', '=',  $post[0]->id)
            ->select('id', 'nameImage', 'single_url_image', 'public_id')->get();

        return response()->json([
            'post' => $post,
            'images' => $images
        ]);
    }

    public function detelePostById($id)
    {
        $post = Post::find($id)->delete();
        if ($post <= 0) return response()->json([]);
        return response()->json($post);
    }

    public function updatePostById(Request $request, $id)
    {

        Post::where('id', '=', $id)->update(([
            'postName' => $request->get('postName'),
            'postDescription' => $request->get('postDescription'),
            'postCategory' => $request->get('postCategory'),
        ]));

        $post = Post::where('id', '=', $id)->get();
        return response()->json($post);
    }

    public function listPostsByUserId($user_id)
    {

        $userPosts = Post::where('user_id', '=', $user_id)->get();
        if (count($userPosts) <= 0) return response()->json([]);
        return response()->json($userPosts);
    }

    public function findingPostByDates(Request $request)
    {

        $userId = $request->get('userId');
        $start_date = Carbon::parse($request->get('startDate'))->toDateTimeString();
        $end_date = Carbon::parse($request->get('endDate'))->toDateTimeString();
        $posts = Post::where('user_id', '=', $userId)->whereBetween('created_at', [$start_date, $end_date])->get();

        if (count($posts) <= 0) return response()->json([]);
        return response()->json($posts);
    }
}
