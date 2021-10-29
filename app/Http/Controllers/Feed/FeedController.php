<?php

namespace App\Http\Controllers\Feed;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repository\Feed\FeedRepository;

class FeedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function feed(Request $request, FeedRepository $feed): JsonResponse
    {
        try {
            $data = $feed->newsFeed($request->query());
            return response()->json([
                'posts' => $data,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
