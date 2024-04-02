<?php

namespace App\Services;

use App\Models\EventImage;
use App\Models\Event;
use App\Models\EventDate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventService
{
    public function getAll(): Collection
    {
        return Event::with('eventDates', 'eventImages')->get();
    }

    public function show($id)
    {
        return Event::with('eventDates', 'eventImages')->find($id);
    }

    public function store(array $data): void
    {
        if (isset($data['cover_picture'])) {
            $coverPictureName = Str::random(32).'.'
                .$data['cover_picture']->getClientOriginalExtension();

            Storage::disk('public')->put(
                '/EventCoverPictures/'.$coverPictureName,
                file_get_contents($data['cover_picture'])
            );

            Event::create([
                'title'         => $data['title'],
                'cover_picture' => $coverPictureName,
                'description'   => $data['description'],
                'trailer'       => $data['trailer'],
                'category'      => $data['category'],
                'subcategory'   => $data['subcategory'],
            ]);
        } else {
            Event::create([
                'title'       => $data['title'],
                'description' => $data['description'],
                'trailer'     => $data['trailer'],
                'category'    => $data['category'],
                'subcategory' => $data['subcategory'],
            ]);
        }
//
//        $postId = Event::query()->latest()->first()->id;
//
//        EventDate::create([
//            'day'         => $data['day'],
//            'month'       => $data['month'],
//            'day_of_week' => $data['day_of_week'],
//            'duration'    => $data['duration'],
//            'cinema'      => $data['cinema'],
//            'hall'        => $data['hall'],
//            'price'       => $data['price'],
//            'age_limit'   => $data['age_limit'],
//            'time'        => $data['time'],
//            'post_id'     => $postId,
//        ]);
    }

    public function storeImages($id, $images): void
    {
        foreach ($images as $image) {
            $imageName = Str::random(32).'.'.$image->getClientOriginalExtension(
                );

            Storage::disk('public')->put(
                '/EventPictures/'.$imageName,
                file_get_contents($image)
            );

            EventImage::create([
                'image'      => $imageName,
                'event_id'    => $id,
            ]);
        }
    }

    public function storeDates($id, $dates): void
    {
        foreach ($dates as $date) {
            EventDate::create([
                'day'         => $date['day'],
                'month'       => $date['month'],
                'day_of_week' => $date['day_of_week'],
                'duration'    => $date['duration'],
                'cinema'      => $date['cinema'],
                'hall'        => $date['hall'],
                'price'       => $date['price'],
                'age_limit'   => $date['age_limit'],
                'time'        => $date['time'],
                'event_id'     => $id,
            ]);
        }
    }


    // Update logic (petqa dzvi kesna grac)

    public function update($id, array $data)
    {
        $movie = Event::findOrFail($id);

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
        $movie = Event::findOrFail($id);
        $coverPictureName = $movie['cover_picture'];

        Storage::disk('public')->delete(
            'MovieCoverPictures/'.$coverPictureName
        );

        return $movie->delete();
    }
}
