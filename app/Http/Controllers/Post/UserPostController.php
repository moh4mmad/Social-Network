<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\User;
use App\Repository\Posts\PostRepository;
use Illuminate\Http\JsonResponse;

class UserPostController extends Controller
{
    public function store(User $request, PostRepository $post): JsonResponse
    {
        try {
            $post->userPostStore($request);
            return response()->json([
                'status' => 'success',
                'message' => 'New post created!'
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
