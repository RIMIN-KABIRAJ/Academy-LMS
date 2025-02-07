<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;



    public function childs() {
        return $this->hasMany(Category::class,'parent_id');
    }
    public function parent() {
        return $this->belongsTo(Category::class,'parent_id');
    }
    public function courses() {
        return $this->hasMany(Course::class);
    }

}
