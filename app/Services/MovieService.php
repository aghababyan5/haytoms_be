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
        return Movie::with('movieDates')->find($id);
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
            'title'         => $data['title'],
            'cover_picture' => $iconName,
            'description'   => $data['description'],
            'trailer'       => $data['trailer'],
        ]);

        $movieId = Movie::query()->latest()->first()->id;

        MovieDate::create([
            'day'         => $data['day'],
            'month'       => $data['month'],
            'day_of_week' => $data['day_of_week'],
            'duration'    => $data['duration'],
            'cinema'      => $data['cinema'],
            'hall'        => $data['hall'],
            'price'       => $data['price'],
            'age_limit'   => $data['age_limit'],
            'time'        => $data['time'],
            'movie_id'    => $movieId,
        ]);
    }

    // Update logic (petqa dzvi kesna grac)

    public function update($id, array $data)
    {
        $movie = Movie::findOrFail($id);

        if (isset($data['cover_picture']) && $data['cover_picture'] != '') {
            return $this->updateWithIcon($movie, $data);
        }

        return $this->updateWithoutIcon($movie, $data);
    }

    public function updateWithIcon($movie, $data)
    {
        $oldCoverPictureName = $movie['cover_picture'];
        $newCoverPicture = $data['cover_picture'];
        $newCoverPictureName = Str::random(32).'.'
            .$newCoverPicture->getClientOriginalExtension();

        Storage::disk('public')->delete(
            'MovieCoverPictures/'.$oldCoverPictureName
        );
        Storage::disk('public')->put(
            '/partners/'.$newCoverPictureName,
            file_get_contents($newCoverPicture)
        );

        return $movie->update([
            'title'         => $data['title'],
            'cover_picture' => $newCoverPictureName,
            'description'   => $data['description'],
            'day'           => $data['day'],
            'day_of_week'   => $data['day_of_week'],
            'duration'      => $data['duration'],
            'cinema'        => $data['cinema'],
            'hall'          => $data['hall'],
            'price'         => $data['price'],
            'age_limit'     => $data['age_limit'],
            'time'          => $data['time'],
        ]);
    }

    public function updateWithoutIcon($movie, $data)
    {
        return $movie->update([
            'title'       => $data['title'],
            'description' => $data['description'],
            'day'         => $data['day'],
            'day_of_week' => $data['day_of_week'],
            'duration'    => $data['duration'],
            'cinema'      => $data['cinema'],
            'hall'        => $data['hall'],
            'price'       => $data['price'],
            'age_limit'   => $data['age_limit'],
            'time'        => $data['time'],
        ]);
    }

    public function destroy($id)
    {
        $movie = Movie::findOrFail($id);
        $coverPictureName = $movie['cover_picture'];

        Storage::disk('public')->delete(
            'MovieCoverPictures/'.$coverPictureName
        );

        return $movie->delete();
    }
}
