<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostsController extends Controller {
    public function index() {
        return 'Hello World';
        
        $years = Post::with('author')
            ->latest('published_at')
            ->get()
            ->groupBy(fn($post) => $post->published_at->year);

        return view('posts.index', ['years' => $years]);
    }
}
