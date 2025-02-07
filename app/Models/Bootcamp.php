<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bootcamp extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'category_id',
        'description',
        'short_description',
        'is_paid',
        'price',
        'discount_flag',
        'discounted_price',
        'publish_date',
        'thumbnail',
        'faqs',
        'requirements',
        'outcomes',
        'meta_keywords',
        'meta_description',
        'status',
        'pending',
    ];

    public function instructor() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
