<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;

    public function users(){
        // return $this->belongsToMany('App\Models\User')->withTimestamps();
        return $this->belongsToMany('App\Models\User', 'day_user')->withPivot('start_time', 'end_time')->withTimestamps();
    }

    public function determined_users(){
        return $this->belongsToMany('App\Models\User', 'latest_shifts')->withPivot('id', 'start_time', 'end_time')->withTimestamps();
    }
}
