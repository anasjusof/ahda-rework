<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class booking_history extends Model
{
    protected $fillable = [
        'user_id', 'car_id', 'start_date', 'end_date', 'approval', 'destination', 'purpose', 'remarks', 'attachment_id', 'total_passenger'
    ];
}
