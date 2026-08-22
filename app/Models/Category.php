<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'categories';

    protected $primaryKey = 'category_id';

    public $incrementing = true;

    protected $keyType = 'int';

    // Your table has created_at but NO updated_at.
    public $timestamps = true;

    const UPDATED_AT = null;

    protected $fillable = [
        'name',
        'description',
    ];

    public function destinations(): HasMany
    {
        return $this->hasMany(
            Destination::class,
            'category_id',
            'category_id'
        );
    }
}