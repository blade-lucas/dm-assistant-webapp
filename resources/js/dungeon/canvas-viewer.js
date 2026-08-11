import './state';
import './renderer';
import './camera';
import './selection';
import './editor';
import './history';
import './geometry';
import './resize';

const state = window.DungeonState;
const canvas = state.canvas;

function resetMoveMode() {
    state.moveMode.active = false;
    state.moveMode.roomId = null;
    state.moveMode.previewX = null;
    state.moveMode.previewY = null;
    state.moveMode.canPlace = false;
}

function resetDoorMode() {
    state.doorMode.active = false;
}

function resetResizeMode() {
    if (window.DungeonResize) {
        window.DungeonResize.cancel();
        return;
    }

    state.resizeMode.active = false;
    state.resizeMode.roomId = null;
    state.resizeMode.isResizing = false;
    state.resizeMode.handle = null;
    state.resizeMode.previewX = null;
    state.resizeMode.previewY = null;
    state.resizeMode.previewWidth = null;
    state.resizeMode.previewHeight = null;
    state.resizeMode.canResize = false;
}

function resetToolButtons() {
    document.querySelectorAll('.mode-button').forEach(button => {
        button.classList.remove('active');
    });

    document.getElementById('select-tool')?.classList.add('active');
}

function switchToSelectMode() {
    resetMoveMode();
    resetDoorMode();

    state.resizeMode.active = false;
    state.resizeMode.roomId = null;
    state.resizeMode.isResizing = false;
    state.resizeMode.handle = null;
    state.resizeMode.previewX = null;
    state.resizeMode.previewY = null;
    state.resizeMode.previewWidth = null;
    state.resizeMode.previewHeight = null;
    state.resizeMode.canResize = false;

    resetToolButtons();

    const help = document.getElementById('tool-help');

    if (help) {
        help.textContent = 'Select a room to edit it.';
    }

    window.DungeonRenderer.draw();
}

function initializeDoors() {
    window.DungeonGeometry.ensureDoorsArray();

    if (window.DungeonState.dungeon.doors.length === 0) {
        window.DungeonGeometry.regenerateDoors();
    }
}

canvas.addEventListener('mousedown', event => {
    if (state.resizeMode.active) {
        const handle = window.DungeonResize.getHandleAtMouse(event);

        if (handle) {
            window.DungeonResize.startResize(handle);
        }

        return;
    }

    window.DungeonCamera.startPan(event);
});

canvas.addEventListener('mousemove', event => {
    if (state.resizeMode.isResizing) {
        window.DungeonResize.updateResize(event);
        return;
    }

    const didPan = window.DungeonCamera.updatePan(event);

    if (didPan) {
        return;
    }

    const tile = window.DungeonSelection.getTileFromMouse(event);

    if (state.moveMode.active) {
        const room = state.dungeon.rooms.find(
            room => String(room.id) === String(state.moveMode.roomId)
        );

        if (room && tile) {
            state.moveMode.previewX = tile.x;
            state.moveMode.previewY = tile.y;
            state.moveMode.canPlace = window.DungeonGeometry.canPlaceRoom(
                room,
                tile.x,
                tile.y
            );
        }

        window.DungeonRenderer.draw();
        return;
    }

    if (state.resizeMode.active || state.doorMode.active) {
        return;
    }

    window.DungeonSelection.updateHover(event);
});

canvas.addEventListener('wheel', event => {
    event.preventDefault();

    const rect = canvas.getBoundingClientRect();

    const mouseX = event.clientX - rect.left;
    const mouseY = event.clientY - rect.top;

    const worldXBefore = (mouseX - state.camera.x) / state.tileSize;
    const worldYBefore = (mouseY - state.camera.y) / state.tileSize;

    const zoomAmount = event.deltaY < 0 ? 2 : -2;

    state.tileSize = Math.max(4, Math.min(40, state.tileSize + zoomAmount));

    state.camera.x = mouseX - worldXBefore * state.tileSize;
    state.camera.y = mouseY - worldYBefore * state.tileSize;

    window.DungeonRenderer.draw();
}, { passive: false });

window.addEventListener('mouseup', () => {
    if (state.resizeMode.isResizing) {
        window.DungeonResize.finishResize();
        switchToSelectMode();
        return;
    }

    window.DungeonCamera.endPan();
});

canvas.addEventListener('click', event => {
    if (state.resizeMode.active) {
        return;
    }

    if (state.drag.hasDragged) {
        return;
    }

    const tile = window.DungeonSelection.getTileFromMouse(event);

    if (state.doorMode.active) {
        if (tile) {
            window.DungeonHistory.saveState();
            window.DungeonGeometry.toggleDoorAtTile(tile);
            window.DungeonRenderer.draw();
        }

        return;
    }

    if (state.moveMode.active) {
        const room = state.dungeon.rooms.find(
            room => String(room.id) === String(state.moveMode.roomId)
        );

        if (room && tile && state.moveMode.canPlace) {
            window.DungeonHistory.saveState();
            window.DungeonGeometry.moveRoom(room, tile.x, tile.y);
            window.DungeonSelection.selectRoom(room.id);
            switchToSelectMode();
        }

        return;
    }

    if (!tile || !tile.room_id) {
        window.DungeonSelection.clearSelection();
        return;
    }

    window.DungeonSelection.selectRoom(tile.room_id);
});

canvas.addEventListener('mouseleave', () => {
    window.DungeonCamera.endPan();
    window.DungeonSelection.clearHover();
});

window.addEventListener('keydown', event => {
    if (event.ctrlKey && event.key.toLowerCase() === 'z') {
        event.preventDefault();
        window.DungeonHistory.undo();
        return;
    }

    if (event.ctrlKey && event.key.toLowerCase() === 'y') {
        event.preventDefault();
        window.DungeonHistory.redo();
        return;
    }

    if (event.key === 'Escape') {
        switchToSelectMode();
    }
});

window.addEventListener('resize', () => {
    window.DungeonRenderer.draw();
});

window.DungeonEditor.bindEvents();

initializeDoors();
window.DungeonRenderer.draw();
