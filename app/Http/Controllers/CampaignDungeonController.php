<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Dungeon;
use App\Models\Map;
use Illuminate\Http\Request;

class CampaignDungeonController extends Controller
{
    public function index(Campaign $campaign)
    {
        $this->authorizeCampaign($campaign);

        $attachedMaps = $campaign->maps()
            ->latest()
            ->get();

        $attachedDungeons = $campaign->dungeons()
            ->latest()
            ->get();

        $availableMaps = Map::query()
            ->where('user_id', auth()->id())
            ->whereNull('campaign_id')
            ->latest()
            ->get();

        $availableDungeons = Dungeon::query()
            ->where('user_id', auth()->id())
            ->whereNull('campaign_id')
            ->latest()
            ->get();

        return view('campaigns.dungeons.index', [
            'campaign' => $campaign,
            'attachedMaps' => $attachedMaps,
            'attachedDungeons' => $attachedDungeons,
            'availableMaps' => $availableMaps,
            'availableDungeons' => $availableDungeons,
        ]);
    }

    public function attachMap(Campaign $campaign, Map $map)
    {
        $this->authorizeCampaign($campaign);
        $this->authorizeMap($map);

        $map->update([
            'campaign_id' => $campaign->id,
        ]);

        return back()->with('success', 'Map attached to campaign.');
    }

    public function detachMap(Campaign $campaign, Map $map)
    {
        $this->authorizeCampaign($campaign);
        $this->authorizeMap($map);

        abort_if((int) $map->campaign_id !== (int) $campaign->id, 404);

        $map->update([
            'campaign_id' => null,
        ]);

        return back()->with('success', 'Map removed from campaign.');
    }

    public function attachDungeon(Campaign $campaign, Dungeon $dungeon)
    {
        $this->authorizeCampaign($campaign);
        $this->authorizeDungeon($dungeon);

        $dungeon->update([
            'campaign_id' => $campaign->id,
        ]);

        return back()->with('success', 'Dungeon attached to campaign.');
    }

    public function detachDungeon(Campaign $campaign, Dungeon $dungeon)
    {
        $this->authorizeCampaign($campaign);
        $this->authorizeDungeon($dungeon);

        abort_if((int) $dungeon->campaign_id !== (int) $campaign->id, 404);

        $dungeon->update([
            'campaign_id' => null,
        ]);

        return back()->with('success', 'Dungeon removed from campaign.');
    }

    private function authorizeCampaign(Campaign $campaign): void
    {
        abort_if((int) $campaign->user_id !== (int) auth()->id(), 403);
    }

    private function authorizeMap(Map $map): void
    {
        abort_if((int) $map->user_id !== (int) auth()->id(), 403);
    }

    private function authorizeDungeon(Dungeon $dungeon): void
    {
        abort_if((int) $dungeon->user_id !== (int) auth()->id(), 403);
    }
}
