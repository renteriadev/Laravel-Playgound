<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Orders extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'orders';
    protected $fillable = [
        'nameWhoPosted',
        'user_id',
        'emailToSend',
        'postInfo',
        'whoOrdered'
    ];
}
