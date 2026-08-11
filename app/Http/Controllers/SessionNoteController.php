<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\SessionNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionNoteController extends Controller
{
    public function index(Campaign $campaign)
    {
        $this->authorizeCampaign($campaign);

        $sessionNotes = $campaign->sessionNotes()
            ->latest('session_date')
            ->latest()
            ->get();

        return view('campaigns.session-notes.index', compact('campaign', 'sessionNotes'));
    }

    public function create(Campaign $campaign)
    {
        $this->authorizeCampaign($campaign);

        return view('campaigns.session-notes.create', compact('campaign'));
    }

    public function store(Request $request, Campaign $campaign)
    {
        $this->authorizeCampaign($campaign);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'session_number' => ['nullable', 'integer', 'min:1'],
            'session_date' => ['nullable', 'date'],
            'summary' => ['nullable', 'string'],
            'important_events' => ['nullable', 'string'],
            'unresolved_hooks' => ['nullable', 'string'],
        ]);

        $campaign->sessionNotes()->create($validated);

        return redirect()
            ->route('campaigns.session-notes.index', $campaign)
            ->with('success', 'Session note created successfully.');
    }

    public function show(Campaign $campaign, SessionNote $sessionNote)
    {
        $this->authorizeCampaign($campaign);
        $this->authorizeSessionNote($campaign, $sessionNote);

        return view('campaigns.session-notes.show', compact('campaign', 'sessionNote'));
    }

    public function edit(Campaign $campaign, SessionNote $sessionNote)
    {
        $this->authorizeCampaign($campaign);
        $this->authorizeSessionNote($campaign, $sessionNote);

        return view('campaigns.session-notes.edit', compact('campaign', 'sessionNote'));
    }

    public function update(Request $request, Campaign $campaign, SessionNote $sessionNote)
    {
        $this->authorizeCampaign($campaign);
        $this->authorizeSessionNote($campaign, $sessionNote);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'session_number' => ['nullable', 'integer', 'min:1'],
            'session_date' => ['nullable', 'date'],
            'summary' => ['nullable', 'string'],
            'important_events' => ['nullable', 'string'],
            'unresolved_hooks' => ['nullable', 'string'],
        ]);

        $sessionNote->update($validated);

        return redirect()
            ->route('campaigns.session-notes.show', [$campaign, $sessionNote])
            ->with('success', 'Session note updated successfully.');
    }

    public function destroy(Campaign $campaign, SessionNote $sessionNote)
    {
        $this->authorizeCampaign($campaign);
        $this->authorizeSessionNote($campaign, $sessionNote);

        $sessionNote->delete();

        return redirect()
            ->route('campaigns.session-notes.index', $campaign)
            ->with('success', 'Session note deleted successfully.');
    }

    private function authorizeCampaign(Campaign $campaign): void
    {
        abort_if($campaign->user_id !== Auth::id(), 403);
    }

    private function authorizeSessionNote(Campaign $campaign, SessionNote $sessionNote): void
    {
        abort_if($sessionNote->campaign_id !== $campaign->id, 404);
    }
}
