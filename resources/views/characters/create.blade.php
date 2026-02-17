<x-layouts.app title="Create Character">
    <div class="mx-auto max-w-3xl rounded-2xl border border-slate-800 bg-slate-950 p-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight">Create Character</h1>
                <p class="mt-1 text-sm text-slate-400">Start a new character and jump into Basic Info/Stats.</p>
            </div>

            <a href="{{ route('characters.index') }}"
               class="rounded-xl border border-slate-700 px-4 py-2 text-sm hover:bg-slate-900">
                Back
            </a>
        </div>

        @if($errors->any())
            <div class="mt-4 rounded-2xl border border-slate-800 bg-slate-950 p-4 text-sm">
                <div class="font-semibold">Fix the following:</div>
                <ul class="mt-2 list-disc pl-5 text-slate-300">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('characters.store') }}" class="mt-6 grid gap-5">
            @csrf

            <div>
                <label class="text-sm text-slate-300">Name</label>
                <input name="name" value="{{ old('name') }}"
                       class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
            </div>

            <div>
                <label class="text-sm text-slate-300">Role</label>
                <div class="mt-2 grid gap-2 text-sm">
                    <label class="flex items-center gap-2 rounded-xl border border-slate-800 bg-slate-950 px-3 py-2">
                        <input type="radio" name="role" value="party_npc" @checked(old('role','party_npc')==='party_npc')>
                        Party NPC
                    </label>
                    <label class="flex items-center gap-2 rounded-xl border border-slate-800 bg-slate-950 px-3 py-2">
                        <input type="radio" name="role" value="generic_npc" @checked(old('role')==='generic_npc')>
                        Generic NPC
                    </label>
                    <label class="flex items-center gap-2 rounded-xl border border-slate-800 bg-slate-950 px-3 py-2">
                        <input type="radio" name="role" value="player" @checked(old('role')==='player')>
                        Player Character
                    </label>
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-sm text-slate-300">Race</label>
                    <select name="race" class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                        <option value="">—</option>
                        @foreach($raceOptions as $opt)
                            <option value="{{ $opt }}" @selected(old('race')===$opt)>{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-sm text-slate-300">Class</label>
                    <select name="class" class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                        <option value="">—</option>
                        @foreach($classOptions as $opt)
                            <option value="{{ $opt }}" @selected(old('class')===$opt)>{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="text-sm text-slate-300">Alignment</label>
                <select name="alignment" class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                    <option value="">—</option>
                    @foreach($alignmentOptions as $opt)
                        <option value="{{ $opt }}" @selected(old('alignment')===$opt)>{{ $opt }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit"
                        class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-900 hover:bg-white">
                    Create
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
