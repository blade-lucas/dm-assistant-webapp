window.DungeonRenderer = {
    colors: {
        wall: '#020617',
        floor: '#e5e7eb',
        corridor: '#9ca3af',
        door: '#f97316',
        entrance: '#22c55e',
        exit: '#ef4444',
    },

    draw() {
        const state = window.DungeonState;
        const { canvas, ctx, dungeon, tileSize, camera } = state;

        const rect = canvas.getBoundingClientRect();

        canvas.width = rect.width;
        canvas.height = rect.height;

        ctx.clearRect(0, 0, canvas.width, canvas.height);

        ctx.save();
        ctx.translate(camera.x, camera.y);

        this.drawTiles();
        this.drawGrid();
        this.drawDoors();
        this.drawMovePreview();
        this.drawResizePreview();

        ctx.restore();
    },

    drawTiles() {
        const state = window.DungeonState;
        const { ctx, dungeon, tileSize } = state;

        for (let y = 0; y < dungeon.height; y++) {
            for (let x = 0; x < dungeon.width; x++) {
                const tile = dungeon.tiles[y][x];

                const drawType = tile.type === 'door'
                    ? 'corridor'
                    : tile.type;

                ctx.fillStyle = this.colors[drawType] ?? '#ec4899';

                ctx.fillRect(
                    x * tileSize,
                    y * tileSize,
                    tileSize,
                    tileSize
                );

                if (
                    tile.room_id &&
                    String(tile.room_id) === String(state.hoveredRoomId)
                ) {
                    ctx.fillStyle = 'rgba(250, 204, 21, 0.25)';
                    ctx.fillRect(
                        x * tileSize,
                        y * tileSize,
                        tileSize,
                        tileSize
                    );
                }

                if (
                    tile.room_id &&
                    String(tile.room_id) === String(state.selectedRoomId)
                ) {
                    ctx.strokeStyle = '#facc15';
                    ctx.lineWidth = 2;
                    ctx.strokeRect(
                        x * tileSize + 1,
                        y * tileSize + 1,
                        tileSize - 2,
                        tileSize - 2
                    );
                }
            }
        }
    },

    drawGrid() {
        const state = window.DungeonState;
        const { ctx, dungeon, tileSize } = state;

        ctx.strokeStyle = 'rgba(148, 163, 184, 0.25)';
        ctx.lineWidth = 1;

        for (let x = 0; x <= dungeon.width; x++) {
            ctx.beginPath();
            ctx.moveTo(x * tileSize, 0);
            ctx.lineTo(x * tileSize, dungeon.height * tileSize);
            ctx.stroke();
        }

        for (let y = 0; y <= dungeon.height; y++) {
            ctx.beginPath();
            ctx.moveTo(0, y * tileSize);
            ctx.lineTo(dungeon.width * tileSize, y * tileSize);
            ctx.stroke();
        }
    },

    drawDoors() {
        const state = window.DungeonState;
        const { ctx, dungeon, tileSize } = state;

        if (!Array.isArray(dungeon.doors)) {
            return;
        }

        dungeon.doors.forEach(door => {
            const tile = dungeon.tiles[door.y]?.[door.x];

            if (!tile) {
                return;
            }

            const neighbors = [
                dungeon.tiles[door.y - 1]?.[door.x],
                dungeon.tiles[door.y + 1]?.[door.x],
                dungeon.tiles[door.y]?.[door.x - 1],
                dungeon.tiles[door.y]?.[door.x + 1],
            ];

            const hasVerticalCorridor =
                neighbors[0]?.type === 'corridor' ||
                neighbors[0]?.type === 'door' ||
                neighbors[1]?.type === 'corridor' ||
                neighbors[1]?.type === 'door';

            const centerX = door.x * tileSize + tileSize / 2;
            const centerY = door.y * tileSize + tileSize / 2;

            ctx.strokeStyle = '#f97316';
            ctx.lineWidth = Math.max(4, tileSize * 0.35);
            ctx.lineCap = 'round';

            ctx.beginPath();

            if (hasVerticalCorridor) {
                ctx.moveTo(door.x * tileSize + 2, centerY);
                ctx.lineTo((door.x + 1) * tileSize - 2, centerY);
            } else {
                ctx.moveTo(centerX, door.y * tileSize + 2);
                ctx.lineTo(centerX, (door.y + 1) * tileSize - 2);
            }

            ctx.stroke();
            ctx.lineCap = 'butt';
        });
    },

    drawMovePreview() {
        const state = window.DungeonState;

        if (!state.moveMode.active) {
            return;
        }

        const room = state.dungeon.rooms.find(
            room => String(room.id) === String(state.moveMode.roomId)
        );

        if (!room || state.moveMode.previewX === null || state.moveMode.previewY === null) {
            return;
        }

        const { ctx, tileSize } = state;

        ctx.fillStyle = state.moveMode.canPlace
            ? 'rgba(250, 204, 21, 0.45)'
            : 'rgba(239, 68, 68, 0.45)';

        ctx.strokeStyle = state.moveMode.canPlace
            ? '#facc15'
            : '#ef4444';

        ctx.lineWidth = 3;

        ctx.fillRect(
            state.moveMode.previewX * tileSize,
            state.moveMode.previewY * tileSize,
            room.width * tileSize,
            room.height * tileSize
        );

        ctx.strokeRect(
            state.moveMode.previewX * tileSize,
            state.moveMode.previewY * tileSize,
            room.width * tileSize,
            room.height * tileSize
        );
    },

    drawResizePreview() {
        const state = window.DungeonState;

        if (!state.resizeMode.active) {
            return;
        }

        const room = state.dungeon.rooms.find(
            room => String(room.id) === String(state.resizeMode.roomId)
        );

        if (!room) {
            return;
        }

        const { ctx, tileSize } = state;

        const x = state.resizeMode.previewX ?? room.x;
        const y = state.resizeMode.previewY ?? room.y;
        const width = state.resizeMode.previewWidth ?? room.width;
        const height = state.resizeMode.previewHeight ?? room.height;

        ctx.fillStyle = state.resizeMode.isResizing
            ? (state.resizeMode.canResize
                ? 'rgba(34, 197, 94, 0.30)'
                : 'rgba(239, 68, 68, 0.30)')
            : 'rgba(250, 204, 21, 0.15)';

        ctx.strokeStyle = state.resizeMode.canResize || !state.resizeMode.isResizing
            ? '#facc15'
            : '#ef4444';

        ctx.lineWidth = 3;

        ctx.fillRect(
            x * tileSize,
            y * tileSize,
            width * tileSize,
            height * tileSize
        );

        ctx.strokeRect(
            x * tileSize,
            y * tileSize,
            width * tileSize,
            height * tileSize
        );

        this.drawResizeHandles(room);
    },

    drawResizeHandles(room) {
        const state = window.DungeonState;
        const { ctx, tileSize } = state;

        const handleSize = Math.max(8, tileSize);

        const handles = window.DungeonResize.getHandles(room);

        Object.values(handles).forEach(handle => {
            ctx.fillStyle = '#38bdf8';
            ctx.strokeStyle = '#0f172a';
            ctx.lineWidth = 2;

            ctx.fillRect(
                handle.screenX - handleSize / 2,
                handle.screenY - handleSize / 2,
                handleSize,
                handleSize
            );

            ctx.strokeRect(
                handle.screenX - handleSize / 2,
                handle.screenY - handleSize / 2,
                handleSize,
                handleSize
            );
        });
    },
};
