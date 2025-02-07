<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageThread extends Model
{
    use HasFactory;
    protected $table    = 'message_threads';
    protected $fillable = [
        'code',
        'contact_one',
        'contact_two',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        $user = $this->belongsTo(User::class, 'contact_one', 'id');

        if ($user->value('id') != auth()->user()->id) {
            return $user;
        } else {
            return $this->belongsTo(User::class, 'contact_two', 'id');
        }
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'thread_id', 'id');
    }

    public function message_to_sender()
    {
        return $this->belongsTo(User::class, 'sender', 'id');
    }

    public function message_to_receiver()
    {
        return $this->belongsTo(User::class, 'receiver', 'id');
    }
}
