<?php

namespace App\Services;

use App\Models\Movie;
use App\Models\MovieDate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MovieService
{
    public function getAll(): Collection
    {
        return Movie::with('movieDates')->get();
    }

    public function show($id)
    {
        return Movie::find($id);
    }

    public function store(array $data): void
    {
        $iconName = Str::random(32).'.'
            .$data['cover_picture']->getClientOriginalExtension();

        Storage::disk('public')->put(
            '/MovieCoverPictures/'.$iconName,
            file_get_contents($data['cover_picture'])
        );

        Movie::create([
            'cover_picture' => $iconName,
            'description'   => $data['description'],
            'trailer'       => $data['trailer'],
        ]);

        $movieId = Movie::query()->latest()->first()->id;

        MovieDate::create([
            'day'         => $data['day'],
            'month'       => $data['month'],
            'day_of_week' => $data['day_of_week'],
            'time'        => $data['time'],
            'cinema'      => $data['cinema'],
            'hall'        => $data['hall'],
            'price'       => $data['price'],
            'age_limit'   => $data['age_limit'],
            'movie_id'    => $movieId,
        ]);
    }
}
