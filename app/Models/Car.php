<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Carbon\Carbon;

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
        'sold_at',
        'views',
    ];

    protected $casts = [
        'sold_at' => 'datetime',
    ];


    protected $appends = ['is_sold'];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
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
