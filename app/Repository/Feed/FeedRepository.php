<?php

namespace App\Repository\Feed;

use App\Models\PagePost;
use App\Models\User;
use App\Models\UserPost;
use Illuminate\Support\Facades\Auth;
use App\Repository\Feed\Contracts\FeedRepositoryInterface;
use Illuminate\Support\Facades\DB;

class FeedRepository implements FeedRepositoryInterface
{

    public function __construct()
    {
    }

    public function newsFeed($request)
    {
        $page = $request['page'] ?? 0;
        $size = $request['page_size'] ?? 10;

        $user = User::where('id', Auth::guard('api')->user()->id)->first();

        $followings = $user->followings()->pluck('followed_to');
        $followings[] = $user->id;

        $following_pages = $user->pageFollowings()->pluck('followed_page');

        $user_posts = UserPost::whereIn('created_by', $followings)
            ->select([
                "id as post_id",
                "post_content",
                DB::raw("CONCAT('user') as type"),
                "created_by as posted_by",
                "created_at"
            ]);

        return PagePost::whereIn('page_id', $following_pages)
            ->select([
                "id as post_id",
                "post_content",
                DB::raw("CONCAT('page') as type"),
                DB::raw("page_id as posted_by"),
                "created_at"
            ])
            ->union($user_posts)->skip($page)->take($size)->orderBy('created_at', 'DESC')->get();
    }
}
