<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Auth::user()
            ->campaigns()
            ->where('status', '!=', 'archived')
            ->latest()
            ->get();

        return view('campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        return view('campaigns.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'setting_theme' => ['nullable', 'string', 'max:255'],
            'tone' => ['nullable', 'string', 'max:255'],
            'world_description' => ['nullable', 'string'],
            'starting_level' => ['nullable', 'integer', 'min:1', 'max:20'],
            'max_level' => ['nullable', 'integer', 'min:1', 'max:20'],
            'campaign_summary' => ['nullable', 'string'],
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'active';

        $campaign = Campaign::create($validated);

        return redirect()
            ->route('campaigns.show', $campaign)
            ->with('success', 'Campaign created successfully.');
    }

    public function show(Campaign $campaign)
    {
        $this->authorizeCampaign($campaign);

        return view('campaigns.show', compact('campaign'));
    }

    public function edit(Campaign $campaign)
    {
        $this->authorizeCampaign($campaign);

        return view('campaigns.edit', compact('campaign'));
    }

    public function update(Request $request, Campaign $campaign)
    {
        $this->authorizeCampaign($campaign);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'setting_theme' => ['nullable', 'string', 'max:255'],
            'tone' => ['nullable', 'string', 'max:255'],
            'world_description' => ['nullable', 'string'],
            'starting_level' => ['nullable', 'integer', 'min:1', 'max:20'],
            'max_level' => ['nullable', 'integer', 'min:1', 'max:20'],
            'campaign_summary' => ['nullable', 'string'],
            'status' => ['required', 'in:active,completed,archived'],
        ]);

        $campaign->update($validated);

        return redirect()
            ->route('campaigns.show', $campaign)
            ->with('success', 'Campaign updated successfully.');
    }

    public function destroy(Campaign $campaign)
    {
        $this->authorizeCampaign($campaign);

        $campaign->update([
            'status' => 'archived',
        ]);

        return redirect()
            ->route('campaigns.index')
            ->with('success', 'Campaign archived successfully.');
    }

    private function authorizeCampaign(Campaign $campaign): void
    {
        abort_if($campaign->user_id !== Auth::id(), 403);
    }
}
