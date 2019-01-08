<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\PostPublish;
use App\Post;

class PostController extends Controller
{
	public function store(Request $request) {

		$data = $request->only(['title', 'description']);

		$post = Post::create($data);

		event(new PostPublish($post));

		return response($post, 201);
	}
}