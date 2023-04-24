<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LatestShift extends Model
{
    use HasFactory;

    public function breaks()
    {
        return $this->hasMany(ShiftBreak::class);
    }
}
