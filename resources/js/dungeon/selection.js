window.DungeonSelection = {
    getTileFromMouse(event) {
        const state = window.DungeonState;
        const rect = state.canvas.getBoundingClientRect();

        const worldX = event.clientX - rect.left - state.camera.x;
        const worldY = event.clientY - rect.top - state.camera.y;

        const x = Math.floor(worldX / state.tileSize);
        const y = Math.floor(worldY / state.tileSize);

        if (
            x < 0 ||
            y < 0 ||
            x >= state.dungeon.width ||
            y >= state.dungeon.height
        ) {
            return null;
        }

        return state.dungeon.tiles[y][x];
    },

    selectRoom(roomId) {
        const state = window.DungeonState;

        state.selectedRoomId = roomId;

        const room = state.dungeon.rooms.find(
            room => String(room.id) === String(roomId)
        );

        if (!room) {
            return;
        }

        window.DungeonEditor.populateRoomFields(room);
        window.DungeonRenderer.draw();
    },

    clearSelection() {
        const state = window.DungeonState;

        state.selectedRoomId = null;
        state.hoveredRoomId = null;

        document.getElementById('room-info').style.display = 'none';
        document.getElementById('empty-state').style.display = 'block';

        window.DungeonRenderer.draw();
    },

    updateHover(event) {
        const state = window.DungeonState;
        const tile = this.getTileFromMouse(event);
        const newHoveredRoomId = tile?.room_id ?? null;

        if (String(newHoveredRoomId) !== String(state.hoveredRoomId)) {
            state.hoveredRoomId = newHoveredRoomId;
            window.DungeonRenderer.draw();
        }
    },

    clearHover() {
        window.DungeonState.hoveredRoomId = null;
        window.DungeonRenderer.draw();
    },
};
