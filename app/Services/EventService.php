<?php

namespace App\Services;

use App\Models\EventImage;
use App\Models\Event;
use App\Models\EventDate;
use App\Models\EventSubcategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventService
{
    public function getAll(): Collection
    {
        return Event::with('eventDates', 'eventImages', 'eventSubcategories')
            ->get();
    }

    public function show($id)
    {
        return Event::with('eventDates', 'eventImages', 'eventSubcategories')
            ->find($id);
    }

    public function store(array $data): void
    {
         Event::create([
            'title_en'       => $data['title_en'],
            'title_ru'       => $data['title_ru'],
            'title_am'       => $data['title_am'],
            'description_en' => $data['description_en'],
            'description_ru' => $data['description_ru'],
            'description_am' => $data['description_am'],
            'trailer_url'    => $data['trailer_url'],
            'category'       => $data['category'],
        ]);

        $event = Event::latest()->first();

        if (isset($data['cover_picture'])) {
            $coverPictureName = Str::random(32).'.'
                .$data['cover_picture']->getClientOriginalExtension();

            Storage::disk('public')->put(
                '/EventCoverPictures/'.$coverPictureName,
                file_get_contents($data['cover_picture'])
            );

            $event->update([
                'cover_picture' => $coverPictureName,
            ]);
        }

        if (isset($data['trailer_file'])) {
            $videoName = Str::random(32).'.'
                .$data['trailer_file']->getClientOriginalExtension();

            Storage::disk('public')->put(
                '/EventVideos/'.$videoName,
                file_get_contents($data['trailer_file'])
            );

            $event->update([
                'trailer_file' => $videoName,
            ]);
        }
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
                'image'    => $imageName,
                'event_id' => $id,
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
                'event_id'    => $id,
            ]);
        }
    }

    public function storeSubcategories($id, $subcategories): void
    {
        foreach ($subcategories as $subcategory) {
            EventSubcategory::create([
                'subcategory' => $subcategory,
                'event_id'    => $id,
            ]);
        }
    }

    // Update logic (petqa dzvi kesna grac)

    public function update($id, array $data)
    {
        $event = Event::with('eventDates', 'eventImages', 'eventSubcategories')
            ->find($id);
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
        $event = Event::with('eventDates', 'eventImages', 'eventSubcategories')
            ->find($id);
        $eventsImages = $event['eventImages'];

        if (isset($event['cover_picture'])) {
            Storage::disk('public')->delete(
                'EventCoverPictures/'.$event['cover_picture']
            );
        }

        if (isset($eventsImages)) {
            foreach ($eventsImages as $eventsImage) {
                Storage::disk('public')->delete(
                    'EventPictures/'.$eventsImage['image']
                );
            }
        }

        return $event->delete();
    }
}
