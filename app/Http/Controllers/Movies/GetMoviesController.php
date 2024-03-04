<?php

namespace App\Http\Controllers\Movies;

use App\Http\Controllers\Controller;
use App\Services\MovieService;
use Illuminate\Http\JsonResponse;

class GetMoviesController extends Controller
{
    protected $service;

    public function __construct(MovieService $service)
    {
        $this->service = $service;
    }

    public function __invoke(): JsonResponse
    {
        return response()->json([
            'movies' => $this->service->getAll(),
        ]);
    }

}
