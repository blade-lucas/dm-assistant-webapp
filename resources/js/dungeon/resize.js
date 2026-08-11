window.DungeonResize = {
    getCornerTiles(room) {
        return {
            nw: { x: room.x, y: room.y },
            ne: { x: room.x + room.width - 1, y: room.y },
            sw: { x: room.x, y: room.y + room.height - 1 },
            se: { x: room.x + room.width - 1, y: room.y + room.height - 1 },
        };
    },

    getHandles(room) {
        const state = window.DungeonState;
        const tileSize = state.tileSize;
        const corners = this.getCornerTiles(room);

        return Object.fromEntries(
            Object.entries(corners).map(([name, corner]) => [
                name,
                {
                    name,
                    x: corner.x,
                    y: corner.y,
                    screenX: (corner.x + 0.5) * tileSize,
                    screenY: (corner.y + 0.5) * tileSize,
                },
            ])
        );
    },

    getHandleAtMouse(event) {
        const state = window.DungeonState;

        const room = state.dungeon.rooms.find(
            room => String(room.id) === String(state.resizeMode.roomId)
        );

        if (!room) return null;

        const tile = window.DungeonSelection.getTileFromMouse(event);

        if (!tile) return null;

        const corners = this.getCornerTiles(room);

        for (const [handleName, corner] of Object.entries(corners)) {
            if (tile.x === corner.x && tile.y === corner.y) {
                return handleName;
            }
        }

        return null;
    },

    startResize(handleName) {
        const state = window.DungeonState;

        const room = state.dungeon.rooms.find(
            room => String(room.id) === String(state.resizeMode.roomId)
        );

        if (!room) return;

        state.resizeMode.isResizing = true;
        state.resizeMode.handle = handleName;

        state.resizeMode.startRoomX = room.x;
        state.resizeMode.startRoomY = room.y;
        state.resizeMode.startWidth = room.width;
        state.resizeMode.startHeight = room.height;

        state.resizeMode.previewX = room.x;
        state.resizeMode.previewY = room.y;
        state.resizeMode.previewWidth = room.width;
        state.resizeMode.previewHeight = room.height;
        state.resizeMode.canResize = true;

        window.DungeonRenderer.draw();
    },

    updateResize(event) {
        const state = window.DungeonState;

        if (!state.resizeMode.isResizing) return false;

        const tile = window.DungeonSelection.getTileFromMouse(event);

        if (!tile) return true;

        const room = state.dungeon.rooms.find(
            room => String(room.id) === String(state.resizeMode.roomId)
        );

        if (!room) return true;

        const left = state.resizeMode.startRoomX;
        const top = state.resizeMode.startRoomY;
        const right = left + state.resizeMode.startWidth - 1;
        const bottom = top + state.resizeMode.startHeight - 1;

        let newLeft = left;
        let newTop = top;
        let newRight = right;
        let newBottom = bottom;

        if (state.resizeMode.handle.includes('w')) {
            newLeft = tile.x;
        }

        if (state.resizeMode.handle.includes('e')) {
            newRight = tile.x;
        }

        if (state.resizeMode.handle.includes('n')) {
            newTop = tile.y;
        }

        if (state.resizeMode.handle.includes('s')) {
            newBottom = tile.y;
        }

        const newX = Math.min(newLeft, newRight);
        const newY = Math.min(newTop, newBottom);
        const newWidth = Math.abs(newRight - newLeft) + 1;
        const newHeight = Math.abs(newBottom - newTop) + 1;

        state.resizeMode.previewX = newX;
        state.resizeMode.previewY = newY;
        state.resizeMode.previewWidth = newWidth;
        state.resizeMode.previewHeight = newHeight;

        state.resizeMode.canResize = window.DungeonGeometry.canResizeRoomAt(
            room,
            newX,
            newY,
            newWidth,
            newHeight
        );

        window.DungeonRenderer.draw();

        return true;
    },

    finishResize() {
        const state = window.DungeonState;

        if (!state.resizeMode.isResizing) return;

        const room = state.dungeon.rooms.find(
            room => String(room.id) === String(state.resizeMode.roomId)
        );

        if (
            room &&
            state.resizeMode.canResize &&
            state.resizeMode.previewWidth &&
            state.resizeMode.previewHeight
        ) {
            window.DungeonHistory.saveState();

            window.DungeonGeometry.resizeRoomAt(
                room,
                state.resizeMode.previewX,
                state.resizeMode.previewY,
                state.resizeMode.previewWidth,
                state.resizeMode.previewHeight
            );

            window.DungeonSelection.selectRoom(room.id);
        }

        this.cancel();
    },

    cancel() {
        const state = window.DungeonState;

        state.resizeMode.active = false;
        state.resizeMode.roomId = null;
        state.resizeMode.isResizing = false;
        state.resizeMode.handle = null;

        state.resizeMode.previewX = null;
        state.resizeMode.previewY = null;
        state.resizeMode.previewWidth = null;
        state.resizeMode.previewHeight = null;
        state.resizeMode.canResize = false;

        const resizeButton = document.getElementById('resize-room');

        if (resizeButton) {
            resizeButton.textContent = 'Resize Room';
        }

        window.DungeonRenderer.draw();
    },
};
