<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\PostResource;
use App\Http\Requests\StorePostRequest;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PostResource::collection(Post::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $data['author_id'] = 1;

        $post = Post::create($data);

        return (new PostResource($post))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
       return response()->json(new PostResource($post));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $data = $request ->validate([
            'title' => 'required|string|min:2',
            'body' => 'required|string|min:2',
        ]);
        $post->update($data);
        return (new PostResource($post))->response()->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post->delete();
        return response()->json(null, 204);
    }
}
