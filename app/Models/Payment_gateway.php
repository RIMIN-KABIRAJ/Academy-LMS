<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment_gateway extends Model
{
    use HasFactory;

    protected $fillable = [
        'identifier', 'currency', 'title', 'description', 'keys', 'model_name', 'test_model', 'status', 'is_addon'
    ];
}
