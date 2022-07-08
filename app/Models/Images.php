<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use CloudinaryLabs\CloudinaryLaravel\MediaAlly;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Images extends Model
{
    use HasApiTokens, HasFactory, MediaAlly, Notifiable;

    protected $table = 'images';
    protected $fillable = [
        'nameImage',
        'single_url_image',
        'several_url_images',
        'public_id',
        'post_id',
        'created_date_image',
    ];
}
