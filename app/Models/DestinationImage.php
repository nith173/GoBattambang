<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DestinationImage extends Model
{
    protected $table = 'destination_images';

    protected $primaryKey = 'image_id';

    public $timestamps = false;

    protected $fillable = [
        'destination_id',
        'image_url',
        'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function destination(): BelongsTo
    {
        return $this->belongsTo(
            Destination::class,
            'destination_id',
            'destination_id'
        );
    }
}