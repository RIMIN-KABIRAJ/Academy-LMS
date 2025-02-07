<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'story_id',
        'album_id',
        'product_id',
        'page_id',
        'group_id',
        'chat_id',
        'file_name',
        'file_type',
        'privacy',
    ];
}
