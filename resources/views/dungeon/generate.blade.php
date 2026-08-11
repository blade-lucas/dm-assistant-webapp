<x-layouts.app title="Generate Dungeon">

    <style>
        .generate-page {
            padding: 24px;
            color: #f9fafb;
            max-width: 900px;
        }

        .generate-card {
            background: #111827;
            border: 1px solid #374151;
            border-radius: 14px;
            padding: 24px;
        }

        .generate-header {
            margin-bottom: 24px;
        }

        .generate-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .generate-header p {
            color: #9ca3af;
            margin: 0;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-group label {
            font-size: 14px;
            font-weight: 600;
            color: #d1d5db;
        }

        .form-group small {
            color: #9ca3af;
            font-size: 12px;
        }

        .editor-input {
            width: 100%;
            padding: 10px;
            background: #1f2937;
            color: #f9fafb;
            border: 1px solid #374151;
            border-radius: 8px;
        }

        .form-actions {
            margin-top: 24px;
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .primary-button {
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 16px;
            cursor: pointer;
            font-weight: 600;
        }

        .primary-button:hover {
            background: #1d4ed8;
        }

        .secondary-link {
            color: #93c5fd;
            text-decoration: none;
        }

        .secondary-link:hover {
            text-decoration: underline;
        }

        .error-box {
            background: #7f1d1d;
            border: 1px solid #ef4444;
            color: #fecaca;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 18px;
        }
    </style>

    <div class="generate-page">

        <div class="generate-header">
            <h1>Generate Dungeon</h1>
            <p>Create a structured editable dungeon using procedural generation.</p>
        </div>

        <div class="generate-card">

            @if ($errors->any())
                <div class="error-box">
                    <strong>There were problems with your input:</strong>

                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="GET" action="{{ route('dungeon-new.viewer') }}">

                <div class="form-grid">

                    <div class="form-group full">
                        <label for="preset">
                            Dungeon Preset
                        </label>

                        <select
                            id="preset"
                            class="editor-input">

                            <option value="custom">Custom</option>
                            <option value="small_crypt">Small Crypt</option>
                            <option value="large_castle">Large Castle</option>
                            <option value="prison_complex">Prison Complex</option>
                            <option value="temple">Temple</option>
                            <option value="sewers">Sewers</option>
                            <option value="mines">Mines</option>
                            <option value="stronghold">Stronghold</option>

                        </select>

                        <small>
                            Automatically fills recommended generation settings
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="width">Map Width</label>
                        <input
                            id="width"
                            name="width"
                            class="editor-input"
                            type="number"
                            min="30"
                            max="200"
                            value="{{ old('width', 80) }}"
                        >
                        <small>Recommended: 80–120</small>
                    </div>

                    <div class="form-group">
                        <label for="height">Map Height</label>
                        <input
                            id="height"
                            name="height"
                            class="editor-input"
                            type="number"
                            min="30"
                            max="200"
                            value="{{ old('height', 50) }}"
                        >
                        <small>Recommended: 50–100</small>
                    </div>

                    <div class="form-group">
                        <label for="room_count">Room Count</label>
                        <input
                            id="room_count"
                            name="room_count"
                            class="editor-input"
                            type="number"
                            min="3"
                            max="50"
                            value="{{ old('room_count', 12) }}"
                        >
                        <small>More rooms = denser dungeon</small>
                    </div>

                    <div class="form-group">
                        <label for="seed">Seed</label>
                        <input
                            id="seed"
                            name="seed"
                            class="editor-input"
                            type="number"
                            min="1"
                            value="{{ old('seed') }}"
                            placeholder="Leave blank for random"
                        >
                        <small>Same seed + settings creates same layout</small>
                    </div>

                    <div class="form-group">
                        <label for="min_room_size">Minimum Room Size</label>
                        <input
                            id="min_room_size"
                            name="min_room_size"
                            class="editor-input"
                            type="number"
                            min="3"
                            max="30"
                            value="{{ old('min_room_size', 5) }}"
                        >
                    </div>

                    <div class="form-group">
                        <label for="max_room_size">Maximum Room Size</label>
                        <input
                            id="max_room_size"
                            name="max_room_size"
                            class="editor-input"
                            type="number"
                            min="4"
                            max="40"
                            value="{{ old('max_room_size', 12) }}"
                        >
                    </div>

                    <div class="form-group">
                        <label for="type">Dungeon Type</label>
                        <select id="type" name="type" class="editor-input">
                            <option value="crypt">Crypt</option>
                            <option value="castle">Castle</option>
                            <option value="sewer">Sewer</option>
                            <option value="temple">Temple</option>
                            <option value="ruins">Ruins</option>
                            <option value="prison">Prison</option>
                            <option value="mine">Mine</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="theme">Theme</label>
                        <input
                            id="theme"
                            name="theme"
                            class="editor-input"
                            type="text"
                            value="{{ old('theme', 'ancient undead crypt') }}"
                        >
                    </div>

                </div>

                <div class="form-actions">
                    <button class="primary-button" type="submit">
                        Generate Dungeon
                    </button>

                    <a class="secondary-link" href="{{ route('dungeon-new.list') }}">
                        View saved dungeons
                    </a>
                </div>

            </form>

        </div>

    </div>

    <script>

        const presets = {

            small_crypt:{

                width:60,
                height:40,

                room_count:10,

                min_room_size:5,
                max_room_size:10,

                type:'crypt',

                theme:'Ancient Undead Crypt'

            },

            large_castle:{

                width:140,
                height:90,

                room_count:25,

                min_room_size:8,
                max_room_size:20,

                type:'castle',

                theme:'Noble Fortress'

            },

            prison_complex:{

                width:100,
                height:70,

                room_count:18,

                min_room_size:4,
                max_room_size:12,

                type:'prison',

                theme:'Underground Prison'

            },

            temple:{

                width:90,
                height:60,

                room_count:15,

                min_room_size:6,
                max_room_size:14,

                type:'temple',

                theme:'Ancient Temple'

            },

            sewers:{

                width:110,
                height:80,

                room_count:20,

                min_room_size:5,
                max_room_size:12,

                type:'sewer',

                theme:'Abandoned Sewers'

            },

            mines:{

                width:130,
                height:85,

                room_count:22,

                min_room_size:5,
                max_room_size:15,

                type:'mine',

                theme:'Dwarven Mines'

            },

            stronghold:{

                width:160,
                height:100,

                room_count:30,

                min_room_size:8,
                max_room_size:18,

                type:'stronghold',

                theme:'Ancient Stronghold'

            }

        };

        document
            .getElementById(
                'preset'
            )
            .addEventListener(
                'change',
                event=>{

                    const preset=
                        presets[
                            event.target.value
                            ];

                    if(
                        !preset
                    ){
                        return;
                    }

                    Object.entries(
                        preset
                    )
                        .forEach(
                            ([key,value])=>{

                                const input=
                                    document.getElementById(
                                        key
                                    );

                                if(
                                    input
                                ){
                                    input.value=value;
                                }

                            }
                        );

                }
            );

    </script>
</x-layouts.app>
