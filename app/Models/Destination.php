<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Destination extends Model
{
    protected $table = 'destinations';

    protected $primaryKey = 'destination_id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'category_id',
        'created_by',
        'title',
        'slug',
        'description',
        'things_to_do',
        'things_to_prepare',
        'address',
        'latitude',
        'longitude',
        'map_link',
        'ticket_price',
        'contact_phone',
        'open_time',
        'close_time',
        'status',
    ];

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'ticket_price' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(
            Category::class,
            'category_id',
            'category_id'
        );
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by',
            'user_id'
        );
    }

    public function images(): HasMany
    {
        return $this->hasMany(
            DestinationImage::class,
            'destination_id',
            'destination_id'
        );
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(
            Review::class,
            'destination_id',
            'destination_id'
        );
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(
            Wishlist::class,
            'destination_id',
            'destination_id'
        );
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(
            Booking::class,
            'destination_id',
            'destination_id'
        );
    }

    public function tuktukBookings(): HasMany
    {
        return $this->hasMany(
            TuktukBooking::class,
            'destination_id',
            'destination_id'
        );
    }
}