<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;

class DeletePostController extends Controller
{
    protected $service;

    public function __construct(PostService $service)
    {
        $this->service = $service;
    }

    public function __invoke($id): JsonResponse
    {
        $this->service->destroy($id);

        return response()->json([
            'message' => 'Post deleted successfully',
        ]);
    }
}
