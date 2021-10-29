<?php

namespace Tests\Feature;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;

class FeedTest extends TestCase
{


    /**
     * Tring to get feed without Bearer Token.
     *
     * @return void
     */
    public function testGetFeedsWithoutToken()
    {
        $this->json(
            'GET',
            'api/person/feed',
            [],
            ['Accept' => 'application/json']
        )->assertStatus(401)
            ->assertJsonStructure([
                'message'
            ]);
    }


    /**
     * Tring to get feed with Bearer Token.
     *
     * @return void
     */
    public function testGetFeedsWithToken()
    {
        $user = User::where('email', 'moh4mmadsakib@gmail.com')->first();
        $token = JWTAuth::fromUser($user);
        $this->json(
            'GET',
            'api/person/feed',
            [],
            ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token]
        )->assertStatus(200)
            ->assertJsonStructure([
                'posts'
            ]);
    }


    /**
     * Tring to get feed with pagination.
     *
     * @return void
     */
    public function testGetFeedsWithPagination()
    {
        $user = User::where('email', 'moh4mmadsakib@gmail.com')->first();
        $token = JWTAuth::fromUser($user);
        $result = $this->json(
            'GET',
            'api/person/feed?page=0&page_size=5',
            [],
            ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token]
        )->assertStatus(200)
            ->assertJsonStructure([
                'posts'
            ])->decodeResponseJson();
        $this->assertEquals(5, count($result['posts']));
    }
}
