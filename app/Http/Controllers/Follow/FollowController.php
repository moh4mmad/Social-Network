<?php

namespace App\Http\Controllers\Follow;

use App\Http\Controllers\Controller;
use App\Http\Requests\Follow\User;
use App\Http\Requests\Follow\Page;
use App\Repository\Follows\FollowRepository;
use Illuminate\Http\JsonResponse;

class FollowController extends Controller
{
    public function followUser(User $request, FollowRepository $follow, $id): JsonResponse
    {
        try {
            if ($follow->user($id)) {
                return response()->json([
                    'status' => 'success',
                ], 200);
            }
            return response()->json([
                'status' => 'error',
            ], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function followPage(Page $request, FollowRepository $follow, $id): JsonResponse
    {
        try {
            if ($follow->page($id)) {
                return response()->json([
                    'status' => 'success',
                ], 200);
            }
            return response()->json([
                'status' => 'error',
            ], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
