<div class="grid gap-4 md:grid-cols-2">
    <div>
        <label class="text-sm text-slate-300">Title</label>

        <input name="title"
               value="{{ old('title', $sessionNote->title ?? '') }}"
               class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
    </div>

    <div>
        <label class="text-sm text-slate-300">Session Number</label>

        <input type="number"
               min="1"
               name="session_number"
               value="{{ old('session_number', $sessionNote->session_number ?? '') }}"
               class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
    </div>
</div>

<div>
    <label class="text-sm text-slate-300">Session Date</label>

    <input type="date"
           name="session_date"
           value="{{ old('session_date', $sessionNote?->session_date?->format('Y-m-d') ?? '') }}"
           class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
</div>

<div>
    <label class="text-sm text-slate-300">Summary</label>

    <textarea name="summary"
              rows="6"
              class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">{{ old('summary', $sessionNote->summary ?? '') }}</textarea>
</div>

<div>
    <label class="text-sm text-slate-300">Important Events</label>

    <textarea name="important_events"
              rows="5"
              class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">{{ old('important_events', $sessionNote->important_events ?? '') }}</textarea>
</div>

<div>
    <label class="text-sm text-slate-300">NPCs & Locations</label>

    <textarea name="npcs_locations"
              rows="5"
              placeholder="Notable NPCs met, locations visited, factions encountered..."
              class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">{{ old('npcs_locations', $sessionNote->npcs_locations ?? '') }}</textarea>
</div>

<div>
    <label class="text-sm text-slate-300">Player Decisions</label>

    <textarea name="player_decisions"
              rows="5"
              placeholder="Important choices the party made and their potential consequences..."
              class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">{{ old('player_decisions', $sessionNote->player_decisions ?? '') }}</textarea>
</div>

<div>
    <label class="text-sm text-slate-300">Unresolved Hooks</label>

    <textarea name="unresolved_hooks"
              rows="5"
              class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">{{ old('unresolved_hooks', $sessionNote->unresolved_hooks ?? '') }}</textarea>
</div>

<div>
    <label class="text-sm text-slate-300">DM Notes / Next Session</label>

    <textarea name="dm_notes"
              rows="6"
              placeholder="Preparation notes, consequences to remember, and ideas for the next session..."
              class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">{{ old('dm_notes', $sessionNote->dm_notes ?? '') }}</textarea>
</div>
