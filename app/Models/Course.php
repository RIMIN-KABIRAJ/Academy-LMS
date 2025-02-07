<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;




    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function sections() {
        return $this->hasMany(Section::class);
    }

    public function lessons() {
        return $this->hasMany(Lesson::class);
    }

    public function enrollments() {
        return $this->hasMany(Enrollments::class);
    }

    public function wishlists() {
        $query = $this->hasMany(Wishlist::class);

        if(auth()->user()){
            $query->where('user_id', auth()->user()->id);
        }

        return $query;
    }

    public function creator() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function instructors($instructors_ids = array()) {
        if(!$instructors_ids){
            $instructors_ids = json_decode($this->instructors, true);
        }elseif(!is_array($instructors_ids)){
            $instructors_ids = json_decode($instructors_ids, true);
        }

        if(!is_array($instructors_ids)){
            $instructors_ids = array();
        }

        return User::whereIn('id', $instructors_ids)->get();
    }

    function total_second(){
        return $this->hasMany(Lesson::class)
        ->select('id')
        ->selectRaw('SUM(TIME_TO_SEC(duration)) as total_time')
        ->groupBy('id')
        ->first()->total_time;
    }

    function total_duration(){
        $total_seconds = $this->hasMany(Lesson::class)
        ->select('id')
        ->selectRaw('SUM(TIME_TO_SEC(duration)) as total_time')
        ->groupBy('id')
        ->first()->total_time;


        $hours = floor($total_seconds / 3600); // Calculate the number of hours
        $minutes = floor(($total_seconds / 60) % 60); // Calculate the number of minutes
        $total_seconds = $total_seconds % 60; // Calculate the remaining seconds

        $duration = sprintf("%02d:%02d:%02d", $hours, $minutes, $total_seconds);
        return $duration;
    }




}
