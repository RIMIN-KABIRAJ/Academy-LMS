<?php

namespace App\Models\payment_gateway;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paytm extends Model
{
    use HasFactory;

    protected $table = 'payment_histories';

    protected $fillable = ['item_type', 'item_id', 'user_id', 'amount', 'currency', 'identifier', 'transaction_keys'];

    public static function payment_status($identifier, $transaction_keys = [])
    {
        if (is_array($transaction_keys) && count($transaction_keys) > 0) {
            array_shift($transaction_keys);
            session(['keys' => $transaction_keys]);
            return true;
        }
        return false;
    }
}
