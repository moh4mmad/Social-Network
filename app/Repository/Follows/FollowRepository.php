<?php

namespace App\Repository\Follows;

use App\Models\UserFollower;
use App\Models\PageFollower;
use Illuminate\Support\Facades\Auth;
use App\Repository\Follows\Contracts\FollowRepositoryInterface;

class FollowRepository implements FollowRepositoryInterface
{

    public function __construct(UserFollower $user_follow, PageFollower $page_follow)
    {
        $this->user_follow = $user_follow;
        $this->page_follow = $page_follow;
    }

    public function user($id): bool
    {
        if ($this->user_follow->where('followed_by', Auth::guard('api')->user()->id)
            ->where('followed_to', $id)->doesntExist()
        ) {
            $input = [
                'followed_by' => Auth::guard('api')->user()->id,
                'followed_to' => $id
            ];
            $this->user_follow->create($input);
            return true;
        }
        return false;
    }

    public function page($id): bool
    {
        if ($this->page_follow->where('followed_by', Auth::guard('api')->user()->id)
            ->where('followed_page', $id)->doesntExist()
        ) {
            $input = [
                'followed_by' => Auth::guard('api')->user()->id,
                'followed_page' => $id
            ];
            $this->page_follow->create($input);
            return true;
        }
        return false;
    }
}
