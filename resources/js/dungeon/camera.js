window.DungeonCamera = {
    zoomIn() {
        window.DungeonState.tileSize += 2;
        window.DungeonRenderer.draw();
    },

    zoomOut() {
        window.DungeonState.tileSize = Math.max(
            4,
            window.DungeonState.tileSize - 2
        );

        window.DungeonRenderer.draw();
    },

    reset() {
        window.DungeonState.tileSize = 12;
        window.DungeonState.camera.x = 0;
        window.DungeonState.camera.y = 0;

        window.DungeonRenderer.draw();
    },

    startPan(event) {
        const state = window.DungeonState;

        state.drag.isMouseDown = true;
        state.drag.hasDragged = false;

        state.drag.startX = event.clientX;
        state.drag.startY = event.clientY;

        state.drag.cameraX = state.camera.x;
        state.drag.cameraY = state.camera.y;
    },

    updatePan(event) {
        const state = window.DungeonState;

        if (!state.drag.isMouseDown) {
            return false;
        }

        const dx = event.clientX - state.drag.startX;
        const dy = event.clientY - state.drag.startY;

        if (Math.abs(dx) > 3 || Math.abs(dy) > 3) {
            state.drag.hasDragged = true;
        }

        if (!state.drag.hasDragged) {
            return false;
        }

        state.camera.x = state.drag.cameraX + dx;
        state.camera.y = state.drag.cameraY + dy;

        window.DungeonRenderer.draw();

        return true;
    },

    endPan() {
        window.DungeonState.drag.isMouseDown = false;
    },
};

window.zoomIn = () => window.DungeonCamera.zoomIn();
window.zoomOut = () => window.DungeonCamera.zoomOut();
window.resetView = () => window.DungeonCamera.reset();
