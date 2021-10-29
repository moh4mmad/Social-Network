<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_name', 'created_by'
    ];

    protected $hidden = [
        'pivot'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'created_by');
    }

    public function posts()
    {
        return $this->hasMany(PagePost::class, 'page_id', 'id');
    }

    public static function myPage($id): bool
    {
        return self::where('id', $id)->where('created_by', Auth::guard('api')->user()->id)->exists();
    }
}
