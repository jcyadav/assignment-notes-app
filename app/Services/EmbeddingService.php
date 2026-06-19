<?php

namespace App\Services;

use App\Models\Note;
use OpenAI;

class EmbeddingService
{
    public function generateEmbedding(string $text): array
    {
        try {

            $client = OpenAI::client(
                config('openai.api_key')
            );

            $response = $client->embeddings()->create([
                'model' => 'text-embedding-3-small',
                'input' => $text,
            ]);

            return $response->embeddings[0]->embedding;

        } catch (\Exception $e) {

            return [];
        }
    }

    public function cosineSimilarity(
        array $vectorA,
        array $vectorB
    ): float {

        if (
            empty($vectorA) ||
            empty($vectorB) ||
            count($vectorA) !== count($vectorB)
        ) {
            return 0;
        }

        $dotProduct = 0;
        $normA = 0;
        $normB = 0;

        foreach ($vectorA as $i => $value) {

            $dotProduct += $value * $vectorB[$i];

            $normA += $value * $value;

            $normB += $vectorB[$i] * $vectorB[$i];
        }

        if ($normA == 0 || $normB == 0) {
            return 0;
        }

        return $dotProduct /
            (sqrt($normA) * sqrt($normB));
    }

    public function searchRelevantNotes(
        string $query
    ): array {

        try {

            $queryEmbedding =
                $this->generateEmbedding($query);

            if (!empty($queryEmbedding)) {

                $notes = Note::all();

                $results = [];

                foreach ($notes as $note) {

                    if (empty($note->embedding)) {
                        continue;
                    }

                    $score = $this->cosineSimilarity(
                        $queryEmbedding,
                        $note->embedding
                    );

                    if ($score > 0) {

                        $results[] = [
                            'note' => $note,
                            'score' => round($score, 4)
                        ];
                    }
                }

                usort($results, function ($a, $b) {
                    return $b['score'] <=> $a['score'];
                });

                if (!empty($results)) {
                    return array_slice($results, 0, 10);
                }
            }

        } catch (\Exception $e) {
            // fallback below
        }

        // FALLBACK KEYWORD SEARCH

        return Note::where('title', 'like', "%{$query}%")
            ->orWhere('content', 'like', "%{$query}%")
            ->get()
            ->map(function ($note) {
                return [
                    'note' => $note,
                    'score' => 1
                ];
            })
            ->toArray();
    }
}