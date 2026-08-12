{{-- ============================================================
     CAMPAIGN IDENTITY
============================================================ --}}
<section class="rounded-2xl border border-slate-800 bg-slate-950 p-6">

    <div class="mb-5">
        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-amber-400">
            Campaign Identity
        </p>

        <h2 class="mt-1 text-lg font-semibold text-slate-100">
            Define the adventure
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            Give the campaign a clear name, theme, and tone.
        </p>
    </div>

    <div>
        <label class="text-xs font-medium uppercase tracking-wide text-slate-400">
            Campaign Name
        </label>

        <input name="name"
               value="{{ old('name', $campaign->name ?? '') }}"
               placeholder="e.g. Shadows of Ravencrest"
               class="mt-2 w-full rounded-xl border border-slate-800
                      bg-slate-950 px-4 py-3 text-sm text-slate-100
                      outline-none transition
                      placeholder:text-slate-600
                      focus:border-amber-500/40
                      focus:ring-1 focus:ring-amber-500/20">
    </div>

    <div class="mt-5 grid gap-4 md:grid-cols-2">

        <div>
            <label class="text-xs font-medium uppercase tracking-wide text-slate-400">
                Setting / Theme
            </label>

            <input name="setting_theme"
                   value="{{ old('setting_theme', $campaign->setting_theme ?? '') }}"
                   placeholder="e.g. Gothic fantasy, political intrigue, dungeon crawl"
                   class="mt-2 w-full rounded-xl border border-slate-800
                          bg-slate-950 px-4 py-3 text-sm text-slate-100
                          outline-none transition
                          placeholder:text-slate-600
                          focus:border-amber-500/40
                          focus:ring-1 focus:ring-amber-500/20">
        </div>

        <div>
            <label class="text-xs font-medium uppercase tracking-wide text-slate-400">
                Tone
            </label>

            <input name="tone"
                   value="{{ old('tone', $campaign->tone ?? '') }}"
                   placeholder="e.g. Dark, heroic, mysterious, comedic"
                   class="mt-2 w-full rounded-xl border border-slate-800
                          bg-slate-950 px-4 py-3 text-sm text-slate-100
                          outline-none transition
                          placeholder:text-slate-600
                          focus:border-amber-500/40
                          focus:ring-1 focus:ring-amber-500/20">
        </div>

    </div>

</section>


{{-- ============================================================
     LEVEL RANGE
============================================================ --}}
<section class="rounded-2xl border border-slate-800 bg-slate-950 p-6">

    <div class="mb-5">
        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-blue-400">
            Progression
        </p>

        <h2 class="mt-1 text-lg font-semibold text-slate-100">
            Set the level range
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            Define the expected starting point and upper level for the campaign.
        </p>
    </div>

    <div class="grid gap-4 md:grid-cols-2">

        <div>
            <label class="text-xs font-medium uppercase tracking-wide text-slate-400">
                Starting Level
            </label>

            <input name="starting_level"
                   type="number"
                   min="1"
                   max="20"
                   value="{{ old('starting_level', $campaign->starting_level ?? '') }}"
                   placeholder="1"
                   class="mt-2 w-full rounded-xl border border-slate-800
                          bg-slate-950 px-4 py-3 text-sm text-slate-100
                          outline-none transition
                          placeholder:text-slate-600
                          focus:border-blue-500/40
                          focus:ring-1 focus:ring-blue-500/20">
        </div>

        <div>
            <label class="text-xs font-medium uppercase tracking-wide text-slate-400">
                Max Level
            </label>

            <input name="max_level"
                   type="number"
                   min="1"
                   max="20"
                   value="{{ old('max_level', $campaign->max_level ?? '') }}"
                   placeholder="10"
                   class="mt-2 w-full rounded-xl border border-slate-800
                          bg-slate-950 px-4 py-3 text-sm text-slate-100
                          outline-none transition
                          placeholder:text-slate-600
                          focus:border-blue-500/40
                          focus:ring-1 focus:ring-blue-500/20">
        </div>

    </div>

</section>


{{-- ============================================================
     CAMPAIGN CONTEXT
============================================================ --}}
<section class="rounded-2xl border border-slate-800 bg-slate-950 p-6">

    <div class="mb-5">
        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-violet-400">
            Campaign Context
        </p>

        <h2 class="mt-1 text-lg font-semibold text-slate-100">
            Describe the world and story
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            These details help define the campaign and support campaign-aware AI generation.
        </p>
    </div>

    <div>
        <label class="text-xs font-medium uppercase tracking-wide text-slate-400">
            World Description
        </label>

        <p class="mt-1 text-xs text-slate-600">
            Describe the setting, important regions, factions, atmosphere, or major world details.
        </p>

        <textarea name="world_description"
                  rows="6"
                  placeholder="Describe the world your campaign takes place in..."
                  class="mt-3 w-full rounded-xl border border-slate-800
                         bg-slate-950 px-4 py-3 text-sm leading-6
                         text-slate-100 outline-none transition
                         placeholder:text-slate-600
                         focus:border-violet-500/40
                         focus:ring-1 focus:ring-violet-500/20">{{ old('world_description', $campaign->world_description ?? '') }}</textarea>
    </div>

    <div class="mt-5">
        <label class="text-xs font-medium uppercase tracking-wide text-slate-400">
            Campaign Summary
        </label>

        <p class="mt-1 text-xs text-slate-600">
            Summarize the campaign premise, current situation, and major story direction.
        </p>

        <textarea name="campaign_summary"
                  rows="5"
                  placeholder="Summarize the campaign's main story and current direction..."
                  class="mt-3 w-full rounded-xl border border-slate-800
                         bg-slate-950 px-4 py-3 text-sm leading-6
                         text-slate-100 outline-none transition
                         placeholder:text-slate-600
                         focus:border-violet-500/40
                         focus:ring-1 focus:ring-violet-500/20">{{ old('campaign_summary', $campaign->campaign_summary ?? '') }}</textarea>
    </div>

</section>


{{-- ============================================================
     CAMPAIGN STATUS
============================================================ --}}
@if($campaign)
    <section class="rounded-2xl border border-slate-800 bg-slate-950 p-6">

        <div class="mb-5">
            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-emerald-400">
                Campaign Status
            </p>

            <h2 class="mt-1 text-lg font-semibold text-slate-100">
                Current state
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Update whether this campaign is active, completed, or archived.
            </p>
        </div>

        <div class="max-w-sm">
            <label class="text-xs font-medium uppercase tracking-wide text-slate-400">
                Status
            </label>

            <select name="status"
                    class="mt-2 w-full rounded-xl border border-slate-800
                           bg-slate-950 px-4 py-3 text-sm text-slate-100
                           outline-none transition
                           focus:border-emerald-500/40
                           focus:ring-1 focus:ring-emerald-500/20">

                <option value="active"
                    @selected(old('status', $campaign->status) === 'active')>
                    Active
                </option>

                <option value="completed"
                    @selected(old('status', $campaign->status) === 'completed')>
                    Completed
                </option>

                <option value="archived"
                    @selected(old('status', $campaign->status) === 'archived')>
                    Archived
                </option>

            </select>
        </div>

    </section>
@endif
