window.DungeonState = {
    dungeon: window.dungeon,
    storeUrl: window.storeUrl,
    csrfToken: window.csrfToken,

    canvas: document.getElementById('dungeon-canvas'),
    ctx: document.getElementById('dungeon-canvas').getContext('2d'),

    tileSize: 12,

    selectedRoomId: null,
    hoveredRoomId: null,

    camera: {
        x: 0,
        y: 0,
    },

    drag: {
        isMouseDown: false,
        hasDragged: false,
        startX: 0,
        startY: 0,
        cameraX: 0,
        cameraY: 0,
    },

    moveMode: {
        active: false,
        roomId: null,
        previewX: null,
        previewY: null,
        canPlace: false,
    },

    resizeMode: {
        active: false,
        roomId: null,

        isResizing: false,
        handle: null,

        startX: null,
        startY: null,
        startWidth: null,
        startHeight: null,
        startRoomX: null,
        startRoomY: null,

        previewX: null,
        previewY: null,
        previewWidth: null,
        previewHeight: null,

        canResize: false,
    },

    history: {
        undoStack: [],
        redoStack: [],
        maxStates: 50,
    },

    doorMode: {
        active: false,
    },
};

