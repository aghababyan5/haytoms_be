<?php

namespace App\Http\Controllers\Movies;

use App\Http\Controllers\Controller;
use App\Http\Requests\Movie\StoreMovieRequest;
use App\Models\Movie;
use App\Services\MovieService;
use Illuminate\Support\Arr;
use Illuminate\Http\JsonResponse;

class StoreMovieController extends Controller
{
    protected $service;

    public function __construct(MovieService $service)
    {
        $this->service = $service;
    }

    public function __invoke(StoreMovieRequest $request): JsonResponse
    {
        $validated_data = $request->validated();
        $productWithoutImages = Arr::except($validated_data, 'images');

        $this->service->store($productWithoutImages);
        $storedProductId = Movie::latest()->first()->id;

        if ($storedProductImages = $request['images']) {
            $this->service->storeImages($storedProductId, $storedProductImages);
        }

        return response()->json([
            'message' => 'Data stored successfully',
        ]);
    }
}
