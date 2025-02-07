<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BootcampResource extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'title',
        'upload_type',
        'file',
    ];
}
