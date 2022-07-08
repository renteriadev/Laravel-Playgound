<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Post extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'postName',
        'postDescription',
        'postCategory',
        'user_id'
    ];

    /*     public function images()
    {
        return $this->hasOne(Images::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    } */
}
