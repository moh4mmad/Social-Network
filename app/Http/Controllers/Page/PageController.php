<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Http\Requests\Page\CreatePage;
use App\Repository\Pages\PageRepository;
use Illuminate\Http\JsonResponse;

class PageController extends Controller
{
    public function store(CreatePage $request, PageRepository $page): JsonResponse
    {
        try {
            $page->store($request);
            return response()->json([
                'status' => 'success',
                'message' => 'New page created!'
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
