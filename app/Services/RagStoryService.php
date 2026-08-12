<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class RagStoryService
{
    public function generate(
        string $theme,
        int $roomCount,
        ?string $tone = null,
        ?string $difficulty = null,
        ?string $campaignId = null,
        ?string $campaignNotes = null,
        ?string $userPrompt = null,
        int $partyLevel = 1,
        int $partySize = 4,
        array $rooms = [],
    ): array {
        $response = Http::baseUrl(
            rtrim(config('services.rag_story.base_url'), '/')
        )
            ->acceptJson()
            ->timeout(120)
            ->post('/generate-story', [
                'map' => [
                    'theme' => $theme,
                    'room_count' => $roomCount,
                    'rooms' => $rooms,
                    'campaign_id' => $campaignId,
                    'extra' => [],
                ],
                'user_prompt' => $userPrompt ?? '',
                'party_level' => $partyLevel,
                'party_size' => $partySize,
                'tone' => $tone ?: 'heroic fantasy',
                'difficulty' => $this->normalizeDifficulty($difficulty),
                'campaign_notes' => $campaignNotes,
            ]);

        if ($response->failed()) {
            throw new RuntimeException(
                'RAG story generation failed: ' . $response->body()
            );
        }

        $data = $response->json();

        if (!is_array($data) || !isset($data['story'])) {
            throw new RuntimeException(
                'RAG story generation returned an invalid response.'
            );
        }

        return $data;
    }

    public function storyToText(array $response): string
    {
        $story = $response['story'] ?? [];

        if (!is_array($story)) {
            return 'No story generated.';
        }

        $parts = [];

        if (!empty($story['title'])) {
            $parts[] = $story['title'];
        }

        if (!empty($story['summary'])) {
            $parts[] = $story['summary'];
        }

        if (!empty($story['adventure_hook'])) {
            $parts[] = "Adventure Hook\n" . $story['adventure_hook'];
        }

        if (!empty($story['rooms']) && is_array($story['rooms'])) {
            $roomSections = [];

            foreach ($story['rooms'] as $room) {
                if (!is_array($room)) {
                    continue;
                }

                $heading = $room['room_name']
                    ?? ('Room ' . ($room['room_id'] ?? '?'));

                $lines = [$heading];

                if (!empty($room['description'])) {
                    $lines[] = $room['description'];
                }

                if (!empty($room['encounter'])) {
                    $lines[] = 'Encounter: ' . $room['encounter'];
                }

                if (!empty($room['treasure'])) {
                    $lines[] = 'Treasure: ' . $room['treasure'];
                }

                if (!empty($room['clue_or_secret'])) {
                    $lines[] = 'Clue or Secret: ' . $room['clue_or_secret'];
                }

                $roomSections[] = implode("\n", $lines);
            }

            if ($roomSections) {
                $parts[] = "Rooms\n\n" . implode("\n\n", $roomSections);
            }
        }

        if (!empty($story['final_encounter'])) {
            $parts[] = "Final Encounter\n" . $story['final_encounter'];
        }

        if (!empty($story['dm_notes']) && is_array($story['dm_notes'])) {
            $parts[] = "DM Notes\n- " . implode(
                    "\n- ",
                    $story['dm_notes']
                );
        }

        if (!empty($story['assumptions']) && is_array($story['assumptions'])) {
            $parts[] = "Assumptions\n- " . implode(
                    "\n- ",
                    $story['assumptions']
                );
        }

        return trim(implode("\n\n", $parts));
    }

    private function normalizeDifficulty(?string $difficulty): string
    {
        $difficulty = strtolower(trim((string) $difficulty));

        return in_array(
            $difficulty,
            ['easy', 'medium', 'hard', 'deadly'],
            true
        )
            ? $difficulty
            : 'medium';
    }
}
