<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfflinePayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_type',
        'items',
        'tax',
        'total_amount',
        'coupon',
        'phone_no',
        'bank_no',
        'doc',
        'status',
    ];
}
