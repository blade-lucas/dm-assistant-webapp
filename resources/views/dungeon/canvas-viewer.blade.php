<x-layouts.app title="Dungeon Canvas Viewer">

    <style>
        .dungeon-page {
            padding: 24px;
            color: #f9fafb;
            max-width: 1600px;
            margin: 0 auto;
        }

        .dungeon-header {
            margin-bottom: 20px;
        }

        .dungeon-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .dungeon-header p {
            color: #9ca3af;
            margin: 0;
        }

        .dungeon-layout {
            display: grid;
            grid-template-columns: minmax(900px, 1fr) 360px;
            gap: 24px;
            align-items: start;
        }

        .canvas-panel,
        .sidebar {
            background: #111827;
            border: 1px solid #374151;
            border-radius: 14px;
        }

        .canvas-panel {
            background: #111827;
            border: 1px solid #374151;
            border-radius: 14px;
            overflow: hidden;
        }

        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;

            padding: 14px 16px;
            background: #111827;
            border-bottom: 1px solid #374151;

            gap: 16px;
            flex-wrap: nowrap;
        }

        .toolbar-left,
        .toolbar-right {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: nowrap;
        }

        .toolbar button,
        .mode-button {
            background: linear-gradient(#1f2937, #111827);
            color: #f9fafb;

            border: 1px solid #4b5563;
            border-radius: 10px;

            padding: 0 18px;
            height: 44px;

            min-width: auto;
            white-space: nowrap;

            cursor: pointer;

            font-size: 14px;
            font-weight: 700;

            box-shadow:
                inset 0 1px 0 rgba(255,255,255,0.08),
                0 2px 6px rgba(0,0,0,0.25);

            transition: all .15s ease;
        }

        .mode-button {
            min-width: 86px;
        }

        .toolbar button:hover,
        .mode-button:hover {
            background: linear-gradient(#374151, #1f2937);
            border-color: #6b7280;
        }

        .mode-button.active {
            background: linear-gradient(#2563eb, #1d4ed8);
            border-color: #93c5fd;
        }

        .door-mode-button.active {
            background: linear-gradient(#f97316, #7c2d12);
            border-color: #fdba74;
            color: #fff7ed;
        }

        .legend-bar {
            position: sticky;
            top: 73px;
            z-index: 9;

            display: flex;
            justify-content: space-between;
            align-items: center;

            gap: 16px;
            padding: 12px 16px;

            background: #0f172a;
            border-bottom: 1px solid #374151;
        }

        .canvas-wrap {
            height: 720px;
            overflow: hidden;
            background: #020617;
        }

        .legend-items {
            display: flex;
            align-items: center;
            gap: 22px;
            flex-wrap: wrap;
        }

        .legend-item {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #f9fafb;
            font-weight: 600;
        }

        .legend-swatch {
            width: 18px;
            height: 18px;
            display: inline-block;
            border: 1px solid #6b7280;
        }

        .room-swatch {
            background: #e5e7eb;
        }

        .corridor-swatch {
            background: #9ca3af;
        }

        .start-swatch {
            background: #22c55e;
        }

        .end-swatch {
            background: #ef4444;
        }

        .legend-door {
            width: 28px;
            height: 5px;
            background: #f97316;
            display: inline-block;
            border-radius: 999px;
        }

        .tool-help {
            color: #d1d5db;
            font-size: 14px;
        }

        #dungeon-canvas {
            display: block;
            width: 100%;
            height: 100%;
            background: #020617;
            cursor: grab;
            image-rendering: pixelated;
        }

        #dungeon-canvas:active {
            cursor: grabbing;
        }

        .sidebar {
            padding: 20px;
            color: #f9fafb;
        }

        .sidebar h2 {
            font-size: 22px;
            font-weight: 700;
            margin-top: 0;
            margin-bottom: 16px;
        }

        .room-detail {
            margin-bottom: 14px;
        }

        .room-detail strong {
            display: block;
            font-size: 13px;
            color: #9ca3af;
            margin-bottom: 5px;
        }

        .room-detail span {
            color: #f9fafb;
        }

        .editor-input {
            width: 100%;
            padding: 8px;
            background: #1f2937;
            color: #f9fafb;
            border: 1px solid #374151;
            border-radius: 8px;
        }

        textarea.editor-input {
            resize: vertical;
        }

        .empty-state {
            color: #9ca3af;
            line-height: 1.5;
        }

        .section-divider {
            border-top: 1px solid #374151;
            margin: 18px 0;
        }

        #save-dungeon {
            background: #16a34a;
            border: none;
            width: 100%;
            margin-top: 10px;
        }

        #save-room {
            background: #2563eb;
            border: none;
            width: 100%;
            margin-top: 12px;
        }
    </style>

    <div class="dungeon-page">

        <div class="dungeon-header">
            <h1>
                {{ $savedDungeon?->name ?? 'Generated Dungeon' }}
            </h1>

            <p>
                Type: {{ $dungeon['metadata']['type'] ?? 'unknown' }}
                |
                Seed: {{ $dungeon['metadata']['seed'] ?? 'none' }}
            </p>
        </div>

        <div class="dungeon-layout">

            <section class="canvas-panel">

                <div class="toolbar">

                    <div class="toolbar-left">

                        <button onclick="DungeonHistory.undo()">
                            Undo
                        </button>

                        <button onclick="DungeonHistory.redo()">
                            Redo
                        </button>

                        <button onclick="resetView()">
                            Reset View
                        </button>

                    </div>

                    <div class="toolbar-right">

        <span class="mode-label">
            Mode:
        </span>

                        <button
                            id="select-tool"
                            class="mode-button active">

                            Select

                        </button>

                        <button
                            id="move-room"
                            class="mode-button">

                            Move

                        </button>

                        <button
                            id="resize-room"
                            class="mode-button">

                            Resize

                        </button>

                        <button
                            id="door-tool"
                            class="mode-button door-mode-button">

                            Door Tool

                        </button>

                    </div>

                </div>

                <div class="legend-bar">
                    <div class="legend-items">
                        <span class="legend-item">
                            <span class="legend-swatch room-swatch"></span>
                            Room
                        </span>

                        <span class="legend-item">
                            <span class="legend-swatch corridor-swatch"></span>
                                Corridor
                        </span>

                        <span class="legend-item">
                            <span class="legend-door"></span>
                            Door
                        </span>

                        <span class="legend-item">
                            <span class="legend-swatch start-swatch"></span>
                            Start
                        </span>

                        <span class="legend-item">
                            <span class="legend-swatch end-swatch"></span>
                            End
                        </span>
                    </div>

                    <div id="tool-help" class="tool-help">
                        Select a room to edit it.
                    </div>
                </div>

                <canvas id="dungeon-canvas"></canvas>

            </section>

            <aside class="sidebar">

                <h2>Dungeon Editor</h2>

                <div class="room-detail">
                    <strong>Dungeon Name</strong>
                    <input
                        id="dungeon-name"
                        class="editor-input"
                        type="text"
                        value="{{ $savedDungeon?->name ?? '' }}"
                        placeholder="Dungeon name"
                    >
                </div>

                <button id="save-dungeon" class="editor-button" type="button">
                    Save Dungeon
                </button>

                <div class="section-divider"></div>

                <h2>Selected Room</h2>

                <div id="empty-state" class="empty-state">
                    Click a room to view and edit its data.
                </div>

                <div id="room-info" style="display: none;">

                    <div class="room-detail">
                        <strong>ID</strong>
                        <span id="room-id"></span>
                    </div>

                    <div class="room-detail">
                        <strong>Name</strong>
                        <input id="edit-name" class="editor-input" type="text">
                    </div>

                    <div class="room-detail">
                        <strong>Type</strong>
                        <select id="edit-type" class="editor-input">
                            <option value="room">Room</option>
                            <option value="entrance">Entrance</option>
                            <option value="boss_room">Boss Room</option>
                            <option value="treasure_room">Treasure Room</option>
                            <option value="burial_chamber">Burial Chamber</option>
                            <option value="shrine">Shrine</option>
                            <option value="ossuary">Ossuary</option>
                            <option value="ritual_room">Ritual Room</option>
                            <option value="hallway_room">Hallway Room</option>
                        </select>
                    </div>

                    <div class="room-detail">
                        <strong>Description</strong>
                        <textarea id="edit-description" class="editor-input" rows="4"></textarea>
                    </div>

                    <div class="room-detail">
                        <strong>Tags</strong>
                        <input id="edit-tags" class="editor-input" type="text">
                    </div>

                    <div class="room-detail">
                        <strong>Connected Rooms</strong>
                        <span id="room-connections"></span>
                    </div>

                    <button
                        id="move-room"
                        class="editor-button"
                        type="button">

                        Move Room
                    </button>

                    <button
                        id="resize-room"
                        class="editor-button"
                        type="button">
                        Resize Room
                    </button>

                    <button
                        id="door-tool"
                        class="editor-button"
                        type="button">
                        Door Tool
                    </button>

                    <button id="save-room" class="editor-button" type="button">
                        Save Room
                    </button>

                </div>

            </aside>

        </div>

    </div>

    <script>
        window.dungeon = @json($dungeon);
        window.storeUrl = "{{ route('dungeon-new.store') }}";
        window.csrfToken = "{{ csrf_token() }}";
    </script>

    @vite('resources/js/dungeon/canvas-viewer.js')

</x-layouts.app>
