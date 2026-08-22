<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Destination;
use App\Models\User;

class Booking extends Model
{
    protected $table = 'bookings';

    protected $primaryKey = 'booking_id';

    public $timestamps = false;

    protected $guarded = [];

    public function destination()
    {
        return $this->belongsTo(
            Destination::class,
            'destination_id',
            'destination_id'
        );
    }

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'user_id'
        );
    }
}
