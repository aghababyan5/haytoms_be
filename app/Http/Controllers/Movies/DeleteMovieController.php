<?php

namespace App\Http\Controllers\Movies;

use App\Http\Controllers\Controller;
use App\Services\MovieService;
use Illuminate\Http\JsonResponse;

class DeleteMovieController extends Controller
{
    protected $service;

    public function __construct(MovieService $service)
    {
        $this->service = $service;
    }

    public function __invoke($id): JsonResponse
    {
        $this->service->destroy($id);

        return response()->json([
            'message' => 'Movie deleted successfully',
        ]);
    }
}
