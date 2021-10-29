<?php

namespace App\Repository\Posts;

use App\Models\UserPost;
use App\Models\PagePost;
use Illuminate\Support\Facades\Auth;
use App\Repository\Posts\Contracts\PostRepositoryInterface;

class PostRepository implements PostRepositoryInterface
{

    public function __construct(UserPost $user_post, PagePost $post_post)
    {
        $this->user_post = $user_post;
        $this->post_post = $post_post;
    }

    public function userPostStore($request): bool
    {
        $input = $request->only('post_content');
        $input['created_by'] = Auth::guard('api')->user()->id;
        $this->user_post->create($input);
        return true;
    }

    public function pagePostStore($id, $request): bool
    {
        $input = $request->only('post_content');
        $input['page_id'] = $id;
        $input['created_by'] = Auth::guard('api')->user()->id;
        $this->post_post->create($input);
        return true;
    }
}
