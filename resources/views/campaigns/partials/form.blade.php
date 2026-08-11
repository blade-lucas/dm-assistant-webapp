<div>
    <label class="text-sm text-slate-300">Campaign Name</label>
    <input name="name"
           value="{{ old('name', $campaign->name ?? '') }}"
           class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
</div>

<div class="grid gap-4 md:grid-cols-2">
    <div>
        <label class="text-sm text-slate-300">Setting / Theme</label>
        <input name="setting_theme"
               value="{{ old('setting_theme', $campaign->setting_theme ?? '') }}"
               class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
    </div>

    <div>
        <label class="text-sm text-slate-300">Tone</label>
        <input name="tone"
               value="{{ old('tone', $campaign->tone ?? '') }}"
               class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
    </div>
</div>

<div class="grid gap-4 md:grid-cols-2">
    <div>
        <label class="text-sm text-slate-300">Starting Level</label>
        <input name="starting_level"
               type="number"
               min="1"
               max="20"
               value="{{ old('starting_level', $campaign->starting_level ?? '') }}"
               class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
    </div>

    <div>
        <label class="text-sm text-slate-300">Max Level</label>
        <input name="max_level"
               type="number"
               min="1"
               max="20"
               value="{{ old('max_level', $campaign->max_level ?? '') }}"
               class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
    </div>
</div>

<div>
    <label class="text-sm text-slate-300">World Description</label>
    <textarea name="world_description"
              rows="5"
              class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">{{ old('world_description', $campaign->world_description ?? '') }}</textarea>
</div>

<div>
    <label class="text-sm text-slate-300">Campaign Summary</label>
    <textarea name="campaign_summary"
              rows="4"
              class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">{{ old('campaign_summary', $campaign->campaign_summary ?? '') }}</textarea>
</div>

@if($campaign)
    <div>
        <label class="text-sm text-slate-300">Status</label>
        <select name="status"
                class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
            <option value="active" @selected(old('status', $campaign->status) === 'active')>Active</option>
            <option value="completed" @selected(old('status', $campaign->status) === 'completed')>Completed</option>
            <option value="archived" @selected(old('status', $campaign->status) === 'archived')>Archived</option>
        </select>
    </div>
@endif
