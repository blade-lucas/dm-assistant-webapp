<x-layouts.app title="Saved Dungeons">

    <div class="p-6">

        <h1 class="text-2xl font-bold mb-6">
            Saved Dungeons
        </h1>

        <div class="space-y-4">

            @foreach($dungeons as $dungeon)

                <div class="bg-gray-800 p-4 rounded">

                    <h2 class="font-bold">
                        {{ $dungeon->name }}
                    </h2>

                    <p>
                        Type: {{ $dungeon->type }}
                    </p>

                    <p>
                        Seed: {{ $dungeon->seed }}
                    </p>

                    <a
                        href="{{ route('dungeon-new.show',$dungeon) }}"
                        class="text-blue-400"
                    >
                        Open Dungeon
                    </a>

                </div>

            @endforeach

        </div>

    </div>

</x-layouts.app>
