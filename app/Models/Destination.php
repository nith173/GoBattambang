<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Destination extends Model
{
    use HasFactory;

    protected $table = 'destinations';
    protected $primaryKey = 'destination_id';

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

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(DestinationImage::class, 'destination_id', 'destination_id');
    }

    public function primaryImage()
    {
        return $this->images()->where('is_primary', 1)->first() ?? $this->images()->first();
    }
}