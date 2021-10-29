<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers\Auth',
    'prefix' => 'auth'
], function () {
    Route::post('register', 'AuthController@registration');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
});

Route::group([
    'middleware' => 'auth:api',
    'namespace' => 'App\Http\Controllers',
], function () {

    Route::group(['prefix' => 'page'], function () {
        Route::post('create', 'Page\PageController@store');
        Route::post('{pageId}/attach-post', 'Post\PagePostController@store');
    });

    Route::group(['prefix' => 'follow'], function () {
        Route::match(['post', 'put'], 'person/{personId}', 'Follow\FollowController@followUser');
        Route::match(['post', 'put'], 'page/{pageId}', 'Follow\FollowController@followPage');
    });

    Route::group(['prefix' => 'person'], function () {
        Route::post('attach-post', 'Post\UserPostController@store');
        Route::get('feed', 'Feed\FeedController@feed');
    });
});
