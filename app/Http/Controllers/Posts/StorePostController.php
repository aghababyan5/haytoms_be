<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Movie\StoreMovieRequest;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Support\Arr;
use Illuminate\Http\JsonResponse;

class StorePostController extends Controller
{
    protected $service;

    public function __construct(PostService $service)
    {
        $this->service = $service;
    }

    public function __invoke(StoreMovieRequest $request): JsonResponse
    {
        $validated_data = $request->validated();
        $postWithoutImagesAndDates = Arr::except($validated_data, 'images, dates');

        $this->service->store($postWithoutImagesAndDates);
        $storedPostId = Post::latest()->first()->id;

        if ($storedPostImages = $request['images']) {
            $this->service->storeImages($storedPostId, $storedPostImages);
        }

        if ($storedPostDates = $request['dates']) {
            $this->service->storeDates($storedPostId, $storedPostDates);
        }

        return response()->json([
            'message' => 'Posts stored successfully',
        ]);
    }
}
