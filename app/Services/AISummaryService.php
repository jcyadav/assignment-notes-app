<?php

namespace App\Services;

use OpenAI;

class AISummaryService
{
    public function generateSummary(string $content): string
    {
        try {

            $client = OpenAI::client(
                config('openai.api_key')
            );

            $response = $client->chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are an expert note summarizer.'
                    ],
                    [
                        'role' => 'user',
                        'content' => "Summarize the following note in 3-5 concise sentences:\n\n".$content
                    ]
                ]
            ]);

            return trim(
                $response->choices[0]->message->content
            );

        } catch (\Exception $e) {

            // Fallback summary
            $content = strip_tags($content);

            if (strlen($content) <= 150) {
                return $content;
            }

            return substr($content, 0, 150) . '...';
        }
    }
}