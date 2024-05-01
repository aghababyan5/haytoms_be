<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function eventDates(): HasMany
    {
        return $this->hasMany(EventDate::class);
    }

    public function eventImages(): HasMany
    {
        return $this->hasMany(EventImage::class);
    }

    public function eventSubcategories(): HasMany
    {
        return $this->hasMany(EventSubcategory::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
