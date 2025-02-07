<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BootcampLiveClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'title',
        'slug',
        'description',
        'start_time',
        'end_time',
        'sort',
        'status',
        'provider',
        'joining_data',
        'force_stop',
    ];
}
