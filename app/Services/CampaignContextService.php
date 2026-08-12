<?php

namespace App\Services;

use App\Models\Campaign;

class CampaignContextService
{
    public function build(Campaign $campaign): array
    {
        $campaign->load([
            'characters',
            'sessionNotes' => fn ($query) => $query
                ->orderByDesc('session_number')
                ->orderByDesc('session_date')
                ->limit(3),
            'encounterTables' => fn ($query) => $query
                ->latest()
                ->limit(3),
            'dungeons' => fn ($query) => $query
                ->latest()
                ->limit(3),
        ]);

        return [
            'campaign' => $this->campaignDetails($campaign),
            'characters' => $this->characters($campaign),
            'recent_sessions' => $this->sessionNotes($campaign),
            'recent_encounters' => $this->encounters($campaign),
            'recent_dungeons' => $this->dungeons($campaign),
        ];
    }

    private function campaignDetails(Campaign $campaign): array
    {
        return [
            'name' => $campaign->name,
            'theme' => $campaign->setting_theme,
            'tone' => $campaign->tone,
            'status' => $campaign->status,
            'starting_level' => $campaign->starting_level,
            'max_level' => $campaign->max_level,
            'world_description' => $campaign->world_description,
            'campaign_summary' => $campaign->campaign_summary,
        ];
    }

    private function characters(Campaign $campaign): array
    {
        return $campaign->characters
            ->map(function ($character) {
                return [
                    'name' => $character->name,
                    'type' => $character->type ?? null,
                    'race' => $character->race ?? null,
                    'class' => $character->class ?? null,
                    'level' => $character->level ?? null,
                ];
            })
            ->values()
            ->all();
    }

    private function sessionNotes(Campaign $campaign): array
    {
        return $campaign->sessionNotes
            ->map(function ($note) {
                return [
                    'session_number' => $note->session_number,
                    'session_date' => $note->session_date?->format('Y-m-d'),
                    'title' => $note->title,
                    'summary' => $note->summary,
                    'important_events' => $note->important_events,
                    'npcs_locations' => $note->npcs_locations,
                    'player_decisions' => $note->player_decisions,
                    'unresolved_hooks' => $note->unresolved_hooks,
                    'dm_notes' => $note->dm_notes,
                ];
            })
            ->values()
            ->all();
    }

    private function encounters(Campaign $campaign): array
    {
        return $campaign->encounterTables
            ->map(function ($table) {
                return [
                    'name' => $table->name,
                    'mode' => data_get($table->payload, 'params.mode'),
                    'location' => data_get($table->payload, 'params.location_type'),
                ];
            })
            ->values()
            ->all();
    }

    private function dungeons(Campaign $campaign): array
    {
        return $campaign->dungeons
            ->map(function ($dungeon) {
                return [
                    'name' => $dungeon->name ?? null,
                    'theme' => $dungeon->theme ?? null,
                    'difficulty' => $dungeon->difficulty ?? null,
                    'room_count' => $dungeon->room_count ?? null,
                ];
            })
            ->values()
            ->all();
    }
}
