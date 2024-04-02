<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use App\Services\EventService;
use Illuminate\Http\JsonResponse;

class GetEventsController extends Controller
{
    protected $service;

    public function __construct(EventService $service)
    {
        $this->service = $service;
    }

    public function __invoke(): JsonResponse
    {
        return response()->json([
            'events' => $this->service->getAll(),
        ]);
    }

}
