<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language_phrase extends Model
{
    use HasFactory;

    protected $fillable = ['language_id', 'phrase', 'translated', 'created_at', 'updated_at'];

    public function language() {
        return $this->belongsTo(Language::class);
    }
}
