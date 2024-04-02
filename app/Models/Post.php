<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function postDates(): HasMany
    {
        return $this->hasMany(PostDate::class);
    }

    public function postImages(): HasMany
    {
        return $this->hasMany(PostImage::class);
    }
}
