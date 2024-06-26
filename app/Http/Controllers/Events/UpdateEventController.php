<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use App\Http\Requests\Events\StoreEventRequest;
use App\Services\EventService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpdateEventController extends Controller
{
    protected $service;

    public function __construct(EventService $service)
    {
        $this->service = $service;
    }

    public function __invoke($id, StoreEventRequest $request): JsonResponse
    {
        $this->service->update($id, $request->validated());

        return response()->json([
            'message' => 'Data updated successfully',
        ]);
    }
}
