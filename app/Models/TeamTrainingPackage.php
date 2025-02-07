<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamTrainingPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'course_privacy',
        'course_id',
        'allocation',
        'pricing_type',
        'price',
        'expiry_type',
        'start_date',
        'expiry_date',
        'features',
        'thumbnail',
        'status',
    ];

}
