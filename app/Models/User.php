<?php

namespace App\Models;

use App\Http\Requests\User\Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Jobs\SendEmailJob;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'email_verified_at',
        'pivot'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(UserPost::class, 'created_by', 'id');
    }

    public function pages()
    {
        return $this->hasMany(Page::class, 'created_by', 'id');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_followers', 'followed_to', 'followed_by');
    }

    public function followings()
    {
        return $this->belongsToMany(User::class, 'user_followers', 'followed_by', 'followed_to');
    }

    public function pageFollowings()
    {
        return $this->belongsToMany(Page::class, 'page_followers', 'followed_by', 'followed_page');
    }

    public function registration($request)
    {
        $input = $request->only('first_name', 'last_name', 'email');
        $input['password'] = bcrypt($request->password);
        $user = User::create($input);
        $details['email'] = $request->email;
        $details['title'] = "Mail from Social Network";
        $details['body'] = "Welcome to Social Network";
        dispatch(new SendEmailJob($details));
        return $user;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
