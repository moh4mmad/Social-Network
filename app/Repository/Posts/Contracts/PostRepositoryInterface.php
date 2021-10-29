<?php

namespace App\Repository\Posts\Contracts;


interface PostRepositoryInterface
{
    public function userPostStore($request);
    public function pagePostStore($id, $request);
}
