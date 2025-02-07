<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BootcampModule extends Model
{
    use HasFactory;

    protected $fillable = [
        'bootcamp_id',
        'title',
        'publish_date',
        'expiry_date',
        'restriction',
        'sort',
    ];
}
