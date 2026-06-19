<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\EmbeddingService;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

class NoteSearchController extends Controller
{
    public function __construct(
        private EmbeddingService $embeddingService
    ) {}

    public function search(): JsonResponse
    {
        $query = request('query');

        if (!$query) {

            return response()->json([
                'success' => false,
                'message' => 'Search query required'
            ], 422);
        }

        $results =
            $this->embeddingService
                 ->searchRelevantNotes($query);

        return response()->json([
            'success' => true,
            'query' => $query,
            'results' => $results
        ]);
    }
}