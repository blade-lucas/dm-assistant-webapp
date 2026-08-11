<x-layouts.app title="Dungeon Viewer">

    <style>
        .dungeon-page {
            padding: 24px;
        }

        .dungeon-layout {
            display: flex;
            gap: 24px;
            align-items: flex-start;
        }

        #map {
            display:grid;
            grid-template-columns: repeat({{ $dungeon['width'] }}, 10px);

            width: fit-content;
            max-width: none;

            overflow: visible;
        }

        .tile{
            width:10px;
            height:10px;
        }

        .wall {
            background: #111827;
        }

        .floor {
            background: #e5e7eb;
        }

        .corridor {
            background: #9ca3af;
        }

        .door {
            background: #92400e;
        }

        .entrance {
            background: #22c55e;
        }

        .exit {
            background: #ef4444;
        }

        .selected-room {
            outline: 2px solid #facc15;
            z-index: 2;
        }

        .sidebar{
            background:#111827;
            color:white;
            border:1px solid #374151;
        }

        .sidebar h2 {
            margin-top: 0;
            font-size: 20px;
            font-weight: bold;
        }

        .room-detail {
            margin-bottom: 12px;
        }

        .room-detail strong {
            display: block;
            font-size: 13px;
            color: #6b7280;
        }

        .room-detail span{
            color:white;
        }
    </style>

    <div class="dungeon-page">
        <h1>Dungeon Viewer</h1>

        <div class="dungeon-layout">
            <div id="map">
                @foreach($dungeon['tiles'] as $row)
                    @foreach($row as $tile)
                        <div
                            class="tile {{ $tile['type'] }}"
                            data-room="{{ $tile['room_id'] }}"
                            data-corridor="{{ $tile['corridor_id'] }}"
                            @if($tile['room_id'])
                                {{ $tile['room_id'] }}
                            @endif
                        ></div>
                    @endforeach
                @endforeach
            </div>

            <aside class="sidebar">
                <h2>Selected Room</h2>

                <div id="empty-state">
                    Click a room tile to view its data.
                </div>

                <div id="room-info" style="display: none;">
                    <div class="room-detail">
                        <strong>ID</strong>
                        <span id="room-id"></span>
                    </div>

                    <div class="room-detail">
                        <strong>Name</strong>
                        <span id="room-name"></span>
                    </div>

                    <div class="room-detail">
                        <strong>Type</strong>
                        <span id="room-type"></span>
                    </div>

                    <div class="room-detail">
                        <strong>Size</strong>
                        <span id="room-size"></span>
                    </div>

                    <div class="room-detail">
                        <strong>Tags</strong>
                        <span id="room-tags"></span>
                    </div>

                    <div class="room-detail">
                        <strong>Connected Rooms</strong>
                        <span id="room-connections"></span>
                    </div>

                    <div class="room-detail">
                        <strong>Metadata</strong>
                        <pre id="room-metadata"></pre>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <script>
        const dungeon = @json($dungeon);
        const rooms = dungeon.rooms;

        function clearSelection() {
            document.querySelectorAll('.selected-room').forEach(tile => {
                tile.classList.remove('selected-room');
            });
        }

        function selectRoom(roomId) {
            clearSelection();

            document.querySelectorAll(`[data-room="${roomId}"]`).forEach(tile => {
                tile.classList.add('selected-room');
            });

            const room = rooms.find(room => String(room.id) === String(roomId));

            if (!room) {
                return;
            }

            document.getElementById('empty-state').style.display = 'none';
            document.getElementById('room-info').style.display = 'block';

            document.getElementById('room-id').textContent = room.id;
            document.getElementById('room-name').textContent = room.name ?? 'Unnamed Room';
            document.getElementById('room-type').textContent = room.type;
            document.getElementById('room-size').textContent = `${room.width} x ${room.height}`;
            document.getElementById('room-tags').textContent = room.tags?.length ? room.tags.join(', ') : 'None';
            document.getElementById('room-connections').textContent = room.connected_rooms?.length ? room.connected_rooms.join(', ') : 'None';
            document.getElementById('room-metadata').textContent = JSON.stringify(room.metadata, null, 2);
        }

        document.querySelectorAll('.tile').forEach(tile => {
            tile.addEventListener('click', () => {
                const roomId = tile.dataset.room;

                if (!roomId) {
                    clearSelection();
                    return;
                }

                selectRoom(roomId);
            });
        });

        document.querySelectorAll('.tile').forEach(tile=>{

            tile.addEventListener('mouseenter',()=>{

                const roomId=tile.dataset.room;

                if(!roomId) return;

                document.querySelectorAll(
                    `[data-room="${roomId}"]`
                ).forEach(t=>{

                    if(!t.classList.contains('selected-room')){
                        t.style.opacity="0.7";
                    }

                });

            });

            tile.addEventListener('mouseleave',()=>{

                document.querySelectorAll('.tile').forEach(t=>{

                    t.style.opacity="1";

                });

            });

        });
    </script>

</x-layouts.app>
