<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Services\AISummaryService;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

class NoteSummaryController extends Controller
{
    public function __construct(
        private AISummaryService $summaryService
    ) {}

    public function generate(int $id): JsonResponse
    {
        $note = Note::find($id);

        if (!$note) {

            return response()->json([
                'success' => false,
                'message' => 'Note not found'
            ], 404);
        }

        try {

            $summary = $this->summaryService
                ->generateSummary($note->content);

            $note->update([
                'summary' => $summary
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Summary generated successfully',
                'data' => [
                    'note_id' => $note->id,
                    'summary' => $summary
                ]
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Summary generation failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}