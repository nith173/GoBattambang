<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $table = 'reviews';

    protected $primaryKey = 'review_id';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'destination_id',
        'rating',
        'comment',
        'status',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'rating' => 'integer',
    ];

   public function user(): BelongsTo
   {
       return $this->belongsTo(User::class, 'user_id', 'id');
   }

  public function destination(): BelongsTo
  {
      return $this->belongsTo(Destination::class, 'destination_id', 'id');
  }
}
