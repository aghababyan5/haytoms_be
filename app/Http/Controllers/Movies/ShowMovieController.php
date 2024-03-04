<?php

namespace App\Http\Controllers\Movies;

use App\Http\Controllers\Controller;
use App\Services\MovieService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShowMovieController extends Controller
{
    protected $service;

    public function __construct(MovieService $service)
    {
        $this->service = $service;
    }

    public function __invoke($id): JsonResponse
    {
        return response()->json([
            'movie' => $this->service->show($id),
        ]);
    }
}
