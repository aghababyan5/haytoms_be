<?php

namespace App\Services;

use App\Models\EventImage;
use App\Models\Event;
use App\Models\EventDate;
use App\Models\EventSubcategory;
use Illuminate\Contracts\Auth\Authenticatable;
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
            'user_id'        => auth()->user()->id,
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
        $event = Event::find($id);

        $event->update([
            'title_en'       => $data['title_en'],
            'title_ru'       => $data['title_ru'],
            'title_am'       => $data['title_am'],
            'description_en' => $data['description_en'],
            'description_ru' => $data['description_ru'],
            'description_am' => $data['description_am'],
            'trailer_url'    => $data['trailer_url'],
            'category'       => $data['category'],
        ]);

        // Cover picture update
        if (isset($data['cover_picture']) && $data['cover_picture'] != '') {
            if ($event['cover_picture'] != '') {
                $oldCoverPictureName = $event['cover_picture'];

                Storage::disk('public')->delete(
                    '/EventCoverPictures/'.$oldCoverPictureName
                );
            }
            $newCoverPicture = $data['cover_picture'];
            $newCoverPictureName = Str::random(32).'.'
                .$newCoverPicture->getClientOriginalExtension();

            Storage::disk('public')->put(
                '/EventCoverPictures/'.$newCoverPictureName,
                file_get_contents($newCoverPicture)
            );

            $event->update([
                'cover_picture' => $newCoverPictureName,
            ]);
        }

        // Trailer file update
        if (isset($data['trailer_file']) && $data['trailer_file'] != '') {
            if ($event['trailer_file'] != '') {
                $oldTrailerFileName = $event['trailer_file'];

                Storage::disk('public')->delete(
                    '/EventVideos/'.$oldTrailerFileName
                );
            }
            $newTrailerFile = $data['trailer_file'];
            $newTrailerFileName = Str::random(32).'.'
                .$newTrailerFile->getClientOriginalExtension();

            Storage::disk('public')->put(
                '/EventVideos/'.$newTrailerFileName,
                file_get_contents($newTrailerFile)
            );

            $event->update([
                'trailer_file' => $newTrailerFileName,
            ]);
        }

        // Event dates update
        $eventDates = $data['event_dates'];
        $eventDateIdsToDelete = [];

        foreach ($eventDates as $eventDate) {
            if (isset($eventDate['id'])) {
                // If event date ID is provided, update existing event date
                $currentEventDate = EventDate::find($eventDate['id']);

                if ($currentEventDate) {
                    $currentEventDate->update([
                        'day'         => $eventDate['day'],
                        'month'       => $eventDate['month'],
                        'day_of_week' => $eventDate['day_of_week'],
                        'duration'    => $eventDate['duration'],
                        'cinema'      => $eventDate['cinema'],
                        'hall'        => $eventDate['hall'],
                        'price'       => $eventDate['price'],
                        'age_limit'   => $eventDate['age_limit'],
                        'time'        => $eventDate['time'],
                    ]);
                }
            } else {
                $newEventDate = EventDate::create([
                    'day'         => $eventDate['day'],
                    'month'       => $eventDate['month'],
                    'day_of_week' => $eventDate['day_of_week'],
                    'duration'    => $eventDate['duration'],
                    'cinema'      => $eventDate['cinema'],
                    'hall'        => $eventDate['hall'],
                    'price'       => $eventDate['price'],
                    'age_limit'   => $eventDate['age_limit'],
                    'time'        => $eventDate['time'],
                ]);

                $eventDateIdsToDelete[] = $newEventDate->id;
            }
            // Find event dates that need to be deleted
//            $existingEventDates = EventDate::where('event_id', )
        }

        // Event subcategories update
        $eventSubcategories = $data['event_subcategories'];

        foreach ($eventSubcategories as $eventSubcategory) {
            $currentEventSubcategory = EventSubcategory::find(
                $eventSubcategory['id']
            );

            $currentEventSubcategory->update([
                'subcategory' => $eventSubcategory['subcategory'],
            ]);
        }

        // Event images update
        $eventImages = $data['event_images'];

        if (!empty($eventImages)) {
            foreach ($eventImages as $eventImage) {
                // Store new image
                $newEventImage = $eventImage['image'];
                $newEventImageName = Str::random(32).'.'
                    .$newEventImage->getClientOriginalExtension();

                Storage::disk('public')->put(
                    '/EventPictures/'.$newEventImageName,
                    file_get_contents($newEventImage)
                );

                if ($currentEventImage = EventImage::find(
                    $eventImage['id']
                )
                ) {
                    // Delete old image
                    Storage::disk('public')->delete(
                        '/EventPictures/'.$currentEventImage['image']
                    );

                    $currentEventImage->update([
                        'image' => $newEventImageName,
                    ]);
                }

                EventImage::create([
                    'image'    => $newEventImageName,
                    'event_id' => $event['id'],
                ]);
            }
        }
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
