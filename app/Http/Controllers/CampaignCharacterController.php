<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Character;
use Illuminate\Support\Facades\Auth;

class CampaignCharacterController extends Controller
{
    public function index(Campaign $campaign)
    {
        $this->authorizeCampaign($campaign);

        $attachedCharacters = $campaign->characters()
            ->latest()
            ->get();

        $availableCharacters = Character::where('user_id', Auth::id())
            ->whereNull('campaign_id')
            ->latest()
            ->get();

        return view('campaigns.characters.index', compact(
            'campaign',
            'attachedCharacters',
            'availableCharacters'
        ));
    }

    public function attach(Campaign $campaign, Character $character)
    {
        $this->authorizeCampaign($campaign);
        $this->authorizeCharacter($character);

        $character->update([
            'campaign_id' => $campaign->id,
        ]);

        return redirect()
            ->route('campaigns.characters.index', $campaign)
            ->with('success', 'Character attached to campaign.');
    }

    public function detach(Campaign $campaign, Character $character)
    {
        $this->authorizeCampaign($campaign);
        $this->authorizeCharacter($character);

        abort_if($character->campaign_id !== $campaign->id, 404);

        $character->update([
            'campaign_id' => null,
        ]);

        return redirect()
            ->route('campaigns.characters.index', $campaign)
            ->with('success', 'Character removed from campaign.');
    }

    private function authorizeCampaign(Campaign $campaign): void
    {
        abort_if($campaign->user_id !== Auth::id(), 403);
    }

    private function authorizeCharacter(Character $character): void
    {
        abort_if($character->user_id !== Auth::id(), 403);
    }
}
