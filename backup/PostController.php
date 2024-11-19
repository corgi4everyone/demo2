<?php

namespace App\Http\Controllers;

use App\Events\PostCreated;
use App\Models\Course;
use Inertia\Inertia;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $posts = Post::with('user', 'course', 'comments.user')->latest()->get();
        return Inertia::render('Post/Index', [
            'posts' => $posts,
            'user' => auth()->user(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return Inertia::render('Post/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'title' => 'required',
            'course_code' => 'required|exists:courses,course_code',
            'content' => 'required',
        ]);

        $post = Post::create([
            'user_id' => auth()->user()->id,
            'course_id' => Course::where('course_code', $request->course_code)->first()->id,
            'title' => $request->title,
            'content' => $request->content,
            
        ]);

        $post->load('user', 'comments', 'course');

        event(new PostCreated($post));

        return response()->json(['message' => 'Post created successfully'], 201);
    }

    /**
     *  const newPost = {
            
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
        $post->load('user', 'comments', 'course');
        return Inertia::render('Post/Show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
