<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    // Garante que só usuários logados acessem esses métodos
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * GET /api/posts?user_id=1
     */
    public function index(Request $request)
    {
        $userId = $request->query('user_id');
        return Post::where('user_id', $userId)
                   ->orderBy('created_at', 'desc')
                   ->get();
    }

    /**
     * POST /api/posts
     */
    public function store(Request $request)
    {
        $user = $request->user();
        if (! $user->is_admin) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $data = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $data['user_id'] = $user->id;

        $post = Post::create($data);

        return response()->json($post, 201);
    }
}
