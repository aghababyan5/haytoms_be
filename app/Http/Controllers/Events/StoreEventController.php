<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use App\Http\Requests\Events\StoreEventRequest;
use App\Models\Event;
use App\Services\EventService;
use Illuminate\Support\Arr;
use Illuminate\Http\JsonResponse;

class StoreEventController extends Controller
{
    protected $service;

    public function __construct(EventService $service)
    {
        $this->service = $service;
    }

    public function __invoke(StoreEventRequest $request): JsonResponse
    {
        $validated_data = $request->validated();
        $eventWithoutImagesAndDatesAndSubcategories = Arr::except(
            $validated_data,
            'images, dates, subcategories'
        );

        $this->service->store($eventWithoutImagesAndDatesAndSubcategories);
        $storedEventId = Event::latest()->first()->id;

        if ($storedEventImages = $request['images']) {
            $this->service->storeImages($storedEventId, $storedEventImages);
        }

        if ($storedEventDates = $request['event_dates']) {
            $this->service->storeDates($storedEventId, $storedEventDates);
        }

        $this->service->storeSubcategories(
            $storedEventId,
            $request['subcategories']
        );

        return response()->json([
            'message' => 'Events stored successfully',
        ]);
    }
}
