{{-- ============================================================
     SESSION DETAILS
============================================================ --}}
<section class="rounded-2xl border border-slate-800 bg-slate-950 p-6">

    <div class="mb-5">
        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-amber-400">
            Session Details
        </p>

        <h2 class="mt-1 text-lg font-semibold text-slate-100">
            Identify this session
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            Give the session a title, number, and date for your campaign journal.
        </p>
    </div>


    <div class="grid gap-4 md:grid-cols-2">

        <div>
            <label class="text-xs font-medium uppercase tracking-wide text-slate-400">
                Title
            </label>

            <input name="title"
                   value="{{ old('title', $sessionNote->title ?? '') }}"
                   placeholder="e.g. Secrets Beneath Ravencrest"
                   class="mt-2 w-full rounded-xl border border-slate-800
                          bg-slate-950 px-4 py-3 text-sm text-slate-100
                          outline-none transition
                          placeholder:text-slate-600
                          focus:border-amber-500/40 focus:ring-1
                          focus:ring-amber-500/20">
        </div>


        <div>
            <label class="text-xs font-medium uppercase tracking-wide text-slate-400">
                Session Number
            </label>

            <input type="number"
                   min="1"
                   name="session_number"
                   value="{{ old('session_number', $sessionNote->session_number ?? '') }}"
                   placeholder="1"
                   class="mt-2 w-full rounded-xl border border-slate-800
                          bg-slate-950 px-4 py-3 text-sm text-slate-100
                          outline-none transition
                          placeholder:text-slate-600
                          focus:border-amber-500/40 focus:ring-1
                          focus:ring-amber-500/20">
        </div>

    </div>


    <div class="mt-4 max-w-sm">

        <label class="text-xs font-medium uppercase tracking-wide text-slate-400">
            Session Date
        </label>

        <input type="date"
               name="session_date"
               value="{{ old('session_date', $sessionNote?->session_date?->format('Y-m-d') ?? '') }}"
               class="mt-2 w-full rounded-xl border border-slate-800
                      bg-slate-950 px-4 py-3 text-sm text-slate-100
                      outline-none transition
                      focus:border-amber-500/40 focus:ring-1
                      focus:ring-amber-500/20">
    </div>

</section>


{{-- ============================================================
     SESSION RECAP
============================================================ --}}
<section class="rounded-2xl border border-slate-800 bg-slate-950 p-6">

    <div class="mb-5">
        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-amber-400">
            Session Recap
        </p>

        <h2 class="mt-1 text-lg font-semibold text-slate-100">
            What happened?
        </h2>
    </div>


    <div>
        <label class="text-xs font-medium uppercase tracking-wide text-slate-400">
            Summary
        </label>

        <p class="mt-1 text-xs text-slate-600">
            A concise overview of the session from beginning to end.
        </p>

        <textarea name="summary"
                  rows="6"
                  placeholder="Summarize the major events of the session..."
                  class="mt-3 w-full rounded-xl border border-slate-800
                         bg-slate-950 px-4 py-3 text-sm leading-6
                         text-slate-100 outline-none transition
                         placeholder:text-slate-600
                         focus:border-amber-500/40 focus:ring-1
                         focus:ring-amber-500/20">{{ old('summary', $sessionNote->summary ?? '') }}</textarea>
    </div>


    <div class="mt-5">
        <label class="text-xs font-medium uppercase tracking-wide text-slate-400">
            Important Events
        </label>

        <p class="mt-1 text-xs text-slate-600">
            Major discoveries, battles, reveals, consequences, or milestones.
        </p>

        <textarea name="important_events"
                  rows="5"
                  placeholder="Record the moments that may matter later..."
                  class="mt-3 w-full rounded-xl border border-slate-800
                         bg-slate-950 px-4 py-3 text-sm leading-6
                         text-slate-100 outline-none transition
                         placeholder:text-slate-600
                         focus:border-amber-500/40 focus:ring-1
                         focus:ring-amber-500/20">{{ old('important_events', $sessionNote->important_events ?? '') }}</textarea>
    </div>

</section>


{{-- ============================================================
     WORLD & PARTY
============================================================ --}}
<section class="rounded-2xl border border-slate-800 bg-slate-950 p-6">

    <div class="mb-5">
        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-blue-400">
            World & Party
        </p>

        <h2 class="mt-1 text-lg font-semibold text-slate-100">
            Who and what mattered?
        </h2>
    </div>


    <div class="grid gap-5 md:grid-cols-2">

        <div>
            <label class="text-xs font-medium uppercase tracking-wide text-slate-400">
                NPCs & Locations
            </label>

            <textarea name="npcs_locations"
                      rows="6"
                      placeholder="Notable NPCs met, locations visited, factions encountered..."
                      class="mt-2 w-full rounded-xl border border-slate-800
                             bg-slate-950 px-4 py-3 text-sm leading-6
                             text-slate-100 outline-none transition
                             placeholder:text-slate-600
                             focus:border-blue-500/40 focus:ring-1
                             focus:ring-blue-500/20">{{ old('npcs_locations', $sessionNote->npcs_locations ?? '') }}</textarea>
        </div>


        <div>
            <label class="text-xs font-medium uppercase tracking-wide text-slate-400">
                Player Decisions
            </label>

            <textarea name="player_decisions"
                      rows="6"
                      placeholder="Important choices the party made and their potential consequences..."
                      class="mt-2 w-full rounded-xl border border-slate-800
                             bg-slate-950 px-4 py-3 text-sm leading-6
                             text-slate-100 outline-none transition
                             placeholder:text-slate-600
                             focus:border-blue-500/40 focus:ring-1
                             focus:ring-blue-500/20">{{ old('player_decisions', $sessionNote->player_decisions ?? '') }}</textarea>
        </div>

    </div>

</section>


{{-- ============================================================
     FUTURE THREADS
============================================================ --}}
<section class="rounded-2xl border border-slate-800 bg-slate-950 p-6">

    <div class="mb-5">
        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-violet-400">
            Future Threads
        </p>

        <h2 class="mt-1 text-lg font-semibold text-slate-100">
            What remains unresolved?
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            These details are especially useful for maintaining campaign continuity.
        </p>
    </div>


    <div class="grid gap-5 md:grid-cols-2">

        <div>
            <label class="text-xs font-medium uppercase tracking-wide text-slate-400">
                Unresolved Hooks
            </label>

            <textarea name="unresolved_hooks"
                      rows="6"
                      placeholder="Mysteries, unfinished quests, unanswered questions, or threats still in motion..."
                      class="mt-2 w-full rounded-xl border border-slate-800
                             bg-slate-950 px-4 py-3 text-sm leading-6
                             text-slate-100 outline-none transition
                             placeholder:text-slate-600
                             focus:border-violet-500/40 focus:ring-1
                             focus:ring-violet-500/20">{{ old('unresolved_hooks', $sessionNote->unresolved_hooks ?? '') }}</textarea>
        </div>


        <div>
            <label class="text-xs font-medium uppercase tracking-wide text-slate-400">
                DM Notes / Next Session
            </label>

            <textarea name="dm_notes"
                      rows="6"
                      placeholder="Preparation notes, consequences to remember, and ideas for the next session..."
                      class="mt-2 w-full rounded-xl border border-slate-800
                             bg-slate-950 px-4 py-3 text-sm leading-6
                             text-slate-100 outline-none transition
                             placeholder:text-slate-600
                             focus:border-violet-500/40 focus:ring-1
                             focus:ring-violet-500/20">{{ old('dm_notes', $sessionNote->dm_notes ?? '') }}</textarea>
        </div>

    </div>

</section>
