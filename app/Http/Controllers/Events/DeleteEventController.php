<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use App\Services\EventService;
use Illuminate\Http\JsonResponse;

class DeleteEventController extends Controller
{
    protected $service;

    public function __construct(EventService $service)
    {
        $this->service = $service;
    }

    public function __invoke($id): JsonResponse
    {
        $this->service->destroy($id);

        return response()->json([
            'message' => 'Event deleted successfully',
        ]);
    }
}
