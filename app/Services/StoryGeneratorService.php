<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class StoryGeneratorService
{
    private function client(): PendingRequest
    {
        return Http::baseUrl(rtrim(config('services.story_generator.base_url'), '/'))
            ->acceptJson()
            ->timeout(120);
    }

    public function generateFromImage(
        string $absolutePath,
        string $filename,
        string $mimeType,
        ?string $originalStory = null,
        ?string $tone = null,
        ?array $enhancements = null,
        ?string $feedbackText = null,
        ?string $reaction = null,
    ): array {
        $request = $this->client()->attach(
            'file',
            fopen($absolutePath, 'r'),
            $filename,
            ['Content-Type' => $mimeType]
        );

        $form = array_filter([
            'original_story' => $originalStory,
            'tone' => $tone,
            'enhancements' => $enhancements ? json_encode($enhancements) : null,
            'feedback_text' => $feedbackText,
            'reaction' => $reaction,
        ], fn ($v) => $v !== null);

        $response = $request->post('/api/stories/generate', $form);

        if ($response->failed()) {
            throw new RuntimeException('Story generation failed: ' . $response->body());
        }

        return $response->json();
    }
}
