<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'license_plate',
        'brand',
        'model',
        'price',
        'mileage',
        'seats',
        'doors',
        'production_year',
        'weight',
        'color',
        'image',
        'is_sold',
        'views',
        'sold_at',
    ];

    protected $casts = [
        'production_year' => 'integer',
        'price' => 'integer',
        'mileage' => 'integer',
        'seats' => 'integer',
        'doors' => 'integer',
        'weight' => 'integer',
        'is_sold' => 'boolean',
        'sold_at' => 'datetime',
        'views' => 'integer',
    ];

    protected $appends = ['is_sold'];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getIsSoldAttribute(): bool
    {
        return $this->sold_at !== null;
    }

    public function setIsSoldAttribute(bool $value)
    {
        $this->attributes['sold_at'] = $value ? Carbon::now() : null;
    }
}
