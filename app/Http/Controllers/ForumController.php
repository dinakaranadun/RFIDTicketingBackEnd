<?php

namespace App\Http\Controllers;


use App\Models\Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $forums = Forum::with('passenger', 'answers')->get();
        
        return response()->json($forums);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'category' => 'required|string',
            'content' => 'required|string',
            'passenger_id' => 'required|integer',
        ]);

        // Create a new forum post
        $forum = new Forum();
        $forum->title = $request->input('title');
        $forum->category = $request->input('category');
        $forum->content = $request->input('content');
        $forum->passenger_id = $request->input('passenger_id');
        $forum->save();

        return response()->json(['message' => 'Question Submitted Successfully'], 201);



        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id,Request $request)
    {

        Log::info('info' . $id);
        Log::info('info' . $request);
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post = Forum::findOrFail($id);
        $post->title = $request->title;
        $post->category = $request->category;
        $post->content = $request->content;
        $post->save();


        return response()->json(['message' => 'Post updated successfully', 'post' => $post], 200);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post=Forum::find($id);
        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        $post->delete();
        return response()->json(['message' => 'Post deleted successfully'], 200);
    }
}
