<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\SavedEncounterTable;

class CampaignEncounterController extends Controller
{
    public function index(Campaign $campaign)
    {
        $this->authorizeCampaign($campaign);

        $attachedTables = $campaign->encounterTables()
            ->latest()
            ->get();

        $availableTables = SavedEncounterTable::query()
            ->where('user_id', auth()->id())
            ->whereNull('campaign_id')
            ->latest()
            ->get();

        return view('campaigns.encounters.index', [
            'campaign' => $campaign,
            'attachedTables' => $attachedTables,
            'availableTables' => $availableTables,
        ]);
    }

    public function attach(Campaign $campaign, SavedEncounterTable $table)
    {
        $this->authorizeCampaign($campaign);
        $this->authorizeTable($table);

        $table->update([
            'campaign_id' => $campaign->id,
        ]);

        return back()->with('success', 'Encounter table attached to campaign.');
    }

    public function detach(Campaign $campaign, SavedEncounterTable $table)
    {
        $this->authorizeCampaign($campaign);
        $this->authorizeTable($table);

        abort_if((int) $table->campaign_id !== (int) $campaign->id, 404);

        $table->update([
            'campaign_id' => null,
        ]);

        return back()->with('success', 'Encounter table removed from campaign.');
    }

    private function authorizeCampaign(Campaign $campaign): void
    {
        abort_if((int) $campaign->user_id !== (int) auth()->id(), 403);
    }

    private function authorizeTable(SavedEncounterTable $table): void
    {
        abort_if((int) $table->user_id !== (int) auth()->id(), 403);
    }
}
