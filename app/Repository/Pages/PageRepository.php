<?php

namespace App\Repository\Pages;

use App\Models\Page;
use Illuminate\Support\Facades\Auth;
use App\Repository\Pages\Contracts\PageRepositoryInterface;

class PageRepository implements PageRepositoryInterface
{

    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    public function store($request): bool
    {
        $input = $request->only('page_name');
        $input['created_by'] = Auth::guard('api')->user()->id;
        $this->page->create($input);
        return true;
    }
}
