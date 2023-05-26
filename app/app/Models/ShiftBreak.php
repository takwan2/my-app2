<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftBreak extends Model
{
    use HasFactory;

    protected $fillable = [
        'shift_id',
        'start_time',
        'end_time',
    ];

    protected $table = 'breaks';

    public function shift()
    {
        return $this->belongsTo(LatestShift::class);
    }
}
