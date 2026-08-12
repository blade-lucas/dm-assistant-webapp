<x-layouts.app title="Dungeon Canvas Viewer">

    <style>
        .dungeon-page {
            color: #f8fafc;
            max-width: 1600px;
            margin: 0 auto;
        }

        /* ================================================================
           PAGE HEADER
        ================================================================ */

        .dungeon-header {
            position: relative;
            overflow: hidden;

            margin-bottom: 24px;
            padding: 26px 28px;

            border: 1px solid rgba(16, 185, 129, 0.22);
            border-radius: 24px;

            background:
                radial-gradient(
                    circle at 90% 0%,
                    rgba(16, 185, 129, 0.08),
                    transparent 35%
                ),
                linear-gradient(
                    135deg,
                    #0f172a,
                    #020617
                );
        }

        .dungeon-header::before {
            content: "INTERACTIVE DUNGEON EDITOR";
            display: block;

            margin-bottom: 8px;

            color: #34d399;

            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.16em;
        }

        .dungeon-header h1 {
            margin: 0;

            color: #f8fafc;

            font-size: 32px;
            font-weight: 800;
            letter-spacing: -0.025em;
        }

        .dungeon-header p {
            margin: 8px 0 0;

            color: #94a3b8;

            font-size: 13px;
        }


        /* ================================================================
           MAIN LAYOUT
        ================================================================ */

        .dungeon-layout {
            display: grid;
            grid-template-columns: minmax(780px, 1fr) 340px;
            gap: 20px;
            align-items: start;
        }


        /* ================================================================
           PANELS
        ================================================================ */

        .canvas-panel,
        .sidebar {
            overflow: hidden;

            border: 1px solid #1e293b;
            border-radius: 20px;

            background: #020617;

            box-shadow:
                0 15px 40px rgba(0, 0, 0, 0.18);
        }


        /* ================================================================
           TOOLBAR
        ================================================================ */

        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;

            padding: 12px 14px;

            gap: 14px;

            border-bottom: 1px solid #1e293b;

            background:
                linear-gradient(
                    180deg,
                    rgba(15, 23, 42, 0.98),
                    rgba(2, 6, 23, 0.98)
                );

            flex-wrap: nowrap;
        }

        .toolbar-left,
        .toolbar-right {
            display: flex;
            align-items: center;

            gap: 7px;

            flex-wrap: nowrap;
        }

        .mode-label {
            margin-right: 3px;

            color: #64748b;

            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .toolbar button,
        .mode-button,
        .editor-button {
            height: 40px;

            padding: 0 14px;

            border: 1px solid #334155;
            border-radius: 10px;

            background:
                linear-gradient(
                    180deg,
                    #1e293b,
                    #0f172a
                );

            color: #cbd5e1;

            font-size: 12px;
            font-weight: 700;

            white-space: nowrap;

            cursor: pointer;

            box-shadow:
                inset 0 1px 0 rgba(255,255,255,0.04);

            transition:
                background 0.15s ease,
                border-color 0.15s ease,
                color 0.15s ease,
                transform 0.15s ease;
        }

        .toolbar button:hover,
        .mode-button:hover,
        .editor-button:hover {
            border-color: #475569;

            background:
                linear-gradient(
                    180deg,
                    #334155,
                    #1e293b
                );

            color: #f8fafc;
        }

        .toolbar button:active,
        .mode-button:active,
        .editor-button:active {
            transform: translateY(1px);
        }

        .mode-button {
            min-width: 78px;
        }

        .mode-button.active {
            border-color: rgba(16, 185, 129, 0.6);

            background:
                linear-gradient(
                    180deg,
                    #10b981,
                    #047857
                );

            color: #022c22;
        }

        .door-mode-button.active {
            border-color: #fb923c;

            background:
                linear-gradient(
                    180deg,
                    #f97316,
                    #c2410c
                );

            color: #fff7ed;
        }


        /* ================================================================
           LEGEND
        ================================================================ */

        .legend-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;

            gap: 16px;

            padding: 10px 16px;

            border-bottom: 1px solid #1e293b;

            background: #0f172a;
        }

        .legend-items {
            display: flex;
            align-items: center;

            gap: 18px;

            flex-wrap: wrap;
        }

        .legend-item {
            display: inline-flex;
            align-items: center;

            gap: 7px;

            color: #94a3b8;

            font-size: 11px;
            font-weight: 600;
        }

        .legend-swatch {
            display: inline-block;

            width: 14px;
            height: 14px;

            border: 1px solid #475569;
            border-radius: 4px;
        }

        .room-swatch {
            background: #e5e7eb;
        }

        .corridor-swatch {
            background: #9ca3af;
        }

        .start-swatch {
            border-color: #22c55e;

            background: #22c55e;
        }

        .end-swatch {
            border-color: #ef4444;

            background: #ef4444;
        }

        .legend-door {
            display: inline-block;

            width: 24px;
            height: 4px;

            border-radius: 999px;

            background: #f97316;
        }

        .tool-help {
            color: #64748b;

            font-size: 11px;
            font-style: italic;
        }


        /* ================================================================
           CANVAS
        ================================================================ */

        .canvas-wrap {
            height: 720px;

            overflow: hidden;

            background: #020617;
        }

        #dungeon-canvas {
            display: block;

            width: 100%;
            height: 720px;

            background:
                radial-gradient(
                    circle at center,
                    #07111f,
                    #020617 70%
                );

            cursor: grab;

            image-rendering: pixelated;
        }

        #dungeon-canvas:active {
            cursor: grabbing;
        }


        /* ================================================================
           SIDEBAR
        ================================================================ */

        .sidebar {
            position: sticky;
            top: 88px;

            padding: 20px;

            color: #f8fafc;

            border-color: rgba(16, 185, 129, 0.16);

            background:
                linear-gradient(
                    180deg,
                    rgba(15, 23, 42, 0.96),
                    rgba(2, 6, 23, 0.98)
                );
        }

        .sidebar h2 {
            margin: 0 0 16px;

            color: #f1f5f9;

            font-size: 18px;
            font-weight: 750;
        }

        .sidebar h2:first-child::before {
            content: "DUNGEON";
            display: block;

            margin-bottom: 4px;

            color: #34d399;

            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.15em;
        }

        .room-detail {
            margin-bottom: 14px;
        }

        .room-detail strong {
            display: block;

            margin-bottom: 6px;

            color: #64748b;

            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        .room-detail span {
            color: #e2e8f0;

            font-size: 13px;
        }

        .editor-input {
            width: 100%;

            padding: 10px 11px;

            border: 1px solid #1e293b;
            border-radius: 10px;

            outline: none;

            background: #020617;

            color: #f8fafc;

            font-size: 13px;

            transition:
                border-color 0.15s ease,
                box-shadow 0.15s ease;
        }

        .editor-input:focus {
            border-color: rgba(16, 185, 129, 0.55);

            box-shadow:
                0 0 0 2px rgba(16, 185, 129, 0.08);
        }

        textarea.editor-input {
            resize: vertical;

            line-height: 1.5;
        }

        .empty-state {
            padding: 18px;

            border: 1px dashed #334155;
            border-radius: 12px;

            background: rgba(15, 23, 42, 0.45);

            color: #64748b;

            font-size: 12px;
            line-height: 1.6;
            text-align: center;
        }

        .section-divider {
            margin: 20px 0;

            border-top: 1px solid #1e293b;
        }


        /* ================================================================
           SAVE BUTTONS
        ================================================================ */

        #save-dungeon {
            width: 100%;
            height: 42px;

            margin-top: 8px;

            border-color: rgba(16, 185, 129, 0.4);

            background:
                linear-gradient(
                    180deg,
                    #10b981,
                    #059669
                );

            color: #022c22;
        }

        #save-dungeon:hover {
            border-color: #34d399;

            background:
                linear-gradient(
                    180deg,
                    #34d399,
                    #10b981
                );
        }

        #save-room {
            width: 100%;

            margin-top: 12px;

            border-color: rgba(59, 130, 246, 0.45);

            background:
                linear-gradient(
                    180deg,
                    #3b82f6,
                    #2563eb
                );

            color: white;
        }


        /* ================================================================
           RESPONSIVE
        ================================================================ */

        @media (max-width: 1180px) {
            .dungeon-layout {
                grid-template-columns: minmax(0, 1fr);
            }

            .sidebar {
                position: static;
            }
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
        window.campaignId = @json($campaignId ?? null);
    </script>

    @vite('resources/js/dungeon/canvas-viewer.js')

</x-layouts.app>
