<?php

namespace App\Http\Controllers;

use App\Models\SavedEncounterTable;
use Illuminate\Http\Request;

class SavedEncounterTableController extends Controller
{
    public function index()
    {
        $query = SavedEncounterTable::query()->orderByDesc('created_at');

        if (!auth()->user()?->is_admin) {
            $query->where('user_id', auth()->id());
        }

        $tables = $query->get();

        return view('encounters.saved', compact('tables'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required','string','max:120'],
            'campaign_id' => ['nullable', 'integer', 'exists:campaigns,id'],
        ]);

        $generated = session('encounter_generated_table');

        if (!$generated || !isset($generated['rows'])) {
            return back()->with('status', 'Nothing to save — generate an encounter table first.');
        }

        $campaignId = $validated['campaign_id'] ?? null;

        if ($campaignId) {
            \App\Models\Campaign::where('user_id', auth()->id())
                ->findOrFail($campaignId);
        }

        SavedEncounterTable::create([
            'user_id' => auth()->id(),
            'campaign_id' => $campaignId,
            'name' => $validated['name'],
            'payload' => $generated,
        ]);

        if ($campaignId) {
            return redirect()
                ->route('campaigns.encounters.index', $campaignId)
                ->with('success', 'Encounter table saved and attached to campaign.');
        }

        return redirect()
            ->route('encounters.saved')
            ->with('status', 'Encounter table saved.');
    }

    public function load(SavedEncounterTable $table)
    {
        if (!auth()->user()->is_admin && $table->user_id !== auth()->id()) {
            abort(403);
        }

        session()->put('encounter_generated_table', $table->payload);

        return redirect()->route('encounters.index', ['show' => 1])
            ->with('status', "Loaded: {$table->name}");
    }

    public function destroy(SavedEncounterTable $table)
    {
        if (!auth()->user()->is_admin && $table->user_id !== auth()->id()) {
            abort(403);
        }

        $table->delete();

        return back()->with('status', 'Deleted saved encounter table.');
    }
}
