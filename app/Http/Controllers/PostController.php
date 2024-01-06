<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PostController extends Controller
{
    public function index()
    {

        $response = Http::get('http://jsonplaceholder.typicode.com/posts');
        $posts = $response->json();

        return view('posts.index', ['posts' => $posts]);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $response = Http::get('https://jsonplaceholder.typicode.com/posts/' . $id);
        $post = $response->json();

        return view('posts.edit', ['post' => $post]);
    }

    public function update(Request $request, $id)
    {
        // Simulates update logic for a real application (not supported by this API)
        $response = Http::put('https://jsonplaceholder.typicode.com/posts/' . $id, [
            'title' => $request->input('title'),
            'body' => $request->input('body'),
        ]);

        // Simulated response for successful or failed update
        if ($response->successful()) {
            return redirect()->route('posts.index')->with('success', 'Post updated successfully!');
        } else {
            return redirect()->route('posts.index')->with('error', 'Failed to update post. Please try again.');
        }
    }

    public function destroy($id)
    {
        // Simulates deletion logic for a real application (not supported by this API)
        $response = Http::delete('https://jsonplaceholder.typicode.com/posts/' . $id);

        // Simulated response for successful or failed deletion
        if ($response->successful()) {
            return redirect()->route('posts.index')->with('success', 'Post deleted successfully!');
        }

        return redirect()->route('posts.index')->with('error', 'Failed to delete post. Please try again.');
    }
}
