<?php

namespace App\Repository\Follows\Contracts;


interface FollowRepositoryInterface
{
    public function user($id);
    public function page($id);
}
