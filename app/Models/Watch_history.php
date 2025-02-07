<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Watch_history extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'student_id',
        'completed_lesson',
        'watching_lesson_id',
        'completed_date',
    ];
}
