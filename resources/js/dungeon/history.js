window.DungeonHistory = {
    saveState() {
        const state = window.DungeonState;

        const snapshot = JSON.stringify(state.dungeon);

        state.history.undoStack.push(snapshot);

        if (state.history.undoStack.length > state.history.maxStates) {
            state.history.undoStack.shift();
        }

        state.history.redoStack = [];
    },

    undo() {
        const state = window.DungeonState;

        if (state.history.undoStack.length === 0) {
            return;
        }

        const currentSnapshot = JSON.stringify(state.dungeon);
        state.history.redoStack.push(currentSnapshot);

        const previousSnapshot = state.history.undoStack.pop();
        state.dungeon = JSON.parse(previousSnapshot);

        window.dungeon = state.dungeon;

        state.selectedRoomId = null;
        state.hoveredRoomId = null;

        window.DungeonSelection.clearSelection();
        window.DungeonRenderer.draw();
    },

    redo() {
        const state = window.DungeonState;

        if (state.history.redoStack.length === 0) {
            return;
        }

        const currentSnapshot = JSON.stringify(state.dungeon);
        state.history.undoStack.push(currentSnapshot);

        const nextSnapshot = state.history.redoStack.pop();
        state.dungeon = JSON.parse(nextSnapshot);

        window.dungeon = state.dungeon;

        state.selectedRoomId = null;
        state.hoveredRoomId = null;

        window.DungeonSelection.clearSelection();
        window.DungeonRenderer.draw();
    },
};
