<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Http\Resources\NoteResource;
use App\Repositories\Contracts\NoteRepositoryInterface;
use Illuminate\Http\JsonResponse;
use App\Services\EmbeddingService;
use OpenApi\Annotations as OA;

class NoteController extends Controller
{
   public function __construct(
    private NoteRepositoryInterface $noteRepository,
    private EmbeddingService $embeddingService
) {}

    public function index(): JsonResponse
    {
        $perPage = request()->get('limit', 10);

        $notes = $this->noteRepository->getAll($perPage);

        return response()->json([
            'success' => true,
            'data' => NoteResource::collection($notes),
            'pagination' => [
                'current_page' => $notes->currentPage(),
                'last_page' => $notes->lastPage(),
                'per_page' => $notes->perPage(),
                'total' => $notes->total()
            ]
        ]);
    }

    public function store(StoreNoteRequest $request): JsonResponse
    {
       $data = $request->validated();

        $data['embedding'] =
            $this->embeddingService
                ->generateEmbedding(
                    $data['title'].' '.$data['content']
                );

        $note = $this->noteRepository
                    ->create($data);

        return response()->json([
            'success' => true,
            'message' => 'Note created successfully',
            'data' => new NoteResource($note)
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $note = $this->noteRepository->findById($id);

        if (!$note) {
            return response()->json([
                'success' => false,
                'message' => 'Note not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new NoteResource($note)
        ]);
    }

    public function update(
        UpdateNoteRequest $request,
        int $id
    ): JsonResponse {

        $note = $this->noteRepository->findById($id);

        if (!$note) {
            return response()->json([
                'success' => false,
                'message' => 'Note not found'
            ], 404);
        }

       $data = $request->validated();

            $title =
                $data['title']
                ?? $note->title;

            $content =
                $data['content']
                ?? $note->content;

            $data['embedding'] =
                $this->embeddingService
                    ->generateEmbedding(
                        $title.' '.$content
                    );

            $this->noteRepository
                ->update($note, $data);

        return response()->json([
            'success' => true,
            'message' => 'Note updated successfully',
            'data' => new NoteResource(
                $note->fresh()
            )
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $note = $this->noteRepository->findById($id);

        if (!$note) {
            return response()->json([
                'success' => false,
                'message' => 'Note not found'
            ], 404);
        }

        $this->noteRepository->delete($note);

        return response()->json([
            'success' => true,
            'message' => 'Note deleted successfully'
        ]);
    }
}