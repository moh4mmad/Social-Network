<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\Page;
use App\Repository\Posts\PostRepository;
use Illuminate\Http\JsonResponse;

class PagePostController extends Controller
{
    public function store($id, Page $request, PostRepository $post): JsonResponse
    {
        try {
            $post->pagePostStore($id, $request);
            return response()->json([
                'status' => 'success',
                'message' => 'New post created!'
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
