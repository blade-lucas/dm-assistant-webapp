window.DungeonGeometry = {
    clearRoomTiles(roomId) {
        const dungeon = window.DungeonState.dungeon;

        for (let y = 0; y < dungeon.height; y++) {
            for (let x = 0; x < dungeon.width; x++) {
                const tile = dungeon.tiles[y][x];

                if (String(tile.room_id) === String(roomId)) {
                    tile.type = 'wall';
                    tile.room_id = null;
                }
            }
        }
    },

    clearCorridorTiles() {
        const dungeon = window.DungeonState.dungeon;

        for (let y = 0; y < dungeon.height; y++) {
            for (let x = 0; x < dungeon.width; x++) {
                const tile = dungeon.tiles[y][x];

                if (tile.corridor_id) {
                    tile.type = 'wall';
                    tile.corridor_id = null;
                }
            }
        }

        dungeon.corridors = [];
    },

    drawRoom(room) {
        const dungeon = window.DungeonState.dungeon;

        for (let y = room.y; y < room.y + room.height; y++) {
            for (let x = room.x; x < room.x + room.width; x++) {
                dungeon.tiles[y][x] = {
                    ...dungeon.tiles[y][x],
                    type: 'floor',
                    room_id: room.id,
                    corridor_id: null,
                };
            }
        }
    },

    canPlaceRoom(room, newX, newY) {
        const dungeon = window.DungeonState.dungeon;

        for (let y = newY; y < newY + room.height; y++) {
            for (let x = newX; x < newX + room.width; x++) {
                if (
                    x < 0 ||
                    y < 0 ||
                    x >= dungeon.width ||
                    y >= dungeon.height
                ) {
                    return false;
                }

                const tile = dungeon.tiles[y][x];

                if (
                    tile.room_id &&
                    String(tile.room_id) !== String(room.id)
                ) {
                    return false;
                }
            }
        }

        return true;
    },

    moveRoom(room, newX, newY) {
        this.clearRoomTiles(room.id);

        room.x = newX;
        room.y = newY;

        this.drawRoom(room);
        this.regenerateCorridors();
    },

    regenerateCorridors() {
        const dungeon = window.DungeonState.dungeon;

        this.clearCorridorTiles();

        const created = new Set();

        dungeon.rooms.forEach(room => {
            room.connected_rooms.forEach(connectedRoomId => {
                const key = [room.id, connectedRoomId].sort().join('-');

                if (created.has(key)) {
                    return;
                }

                const targetRoom = dungeon.rooms.find(
                    candidate => String(candidate.id) === String(connectedRoomId)
                );

                if (!targetRoom) {
                    return;
                }

                this.createCorridor(room, targetRoom);
                created.add(key);
            });
        });
        this.regenerateDoors();
    },

    createCorridor(fromRoom, toRoom) {
        const dungeon = window.DungeonState.dungeon;

        const corridorId = dungeon.corridors.length + 1;

        const start = this.roomCenter(fromRoom);
        const end = this.roomCenter(toRoom);

        const tiles = [];

        if (Math.random() < 0.5) {
            this.carveHorizontal(start.x, end.x, start.y, corridorId, tiles);
            this.carveVertical(start.y, end.y, end.x, corridorId, tiles);
        } else {
            this.carveVertical(start.y, end.y, start.x, corridorId, tiles);
            this.carveHorizontal(start.x, end.x, end.y, corridorId, tiles);
        }

        dungeon.corridors.push({
            id: corridorId,
            from_room_id: fromRoom.id,
            to_room_id: toRoom.id,
            tiles,
            type: 'standard',
            metadata: {},
            notes: null,
        });
    },

    carveHorizontal(x1, x2, y, corridorId, tiles) {
        const dungeon = window.DungeonState.dungeon;

        for (let x = Math.min(x1, x2); x <= Math.max(x1, x2); x++) {
            const tile = dungeon.tiles[y][x];

            if (tile.type === 'wall') {
                tile.type = 'corridor';
                tile.corridor_id = corridorId;
            }

            tiles.push({ x, y });
        }
    },

    carveVertical(y1, y2, x, corridorId, tiles) {
        const dungeon = window.DungeonState.dungeon;

        for (let y = Math.min(y1, y2); y <= Math.max(y1, y2); y++) {
            const tile = dungeon.tiles[y][x];

            if (tile.type === 'wall') {
                tile.type = 'corridor';
                tile.corridor_id = corridorId;
            }

            tiles.push({ x, y });
        }
    },

    roomCenter(room) {
        return {
            x: Math.floor(room.x + room.width / 2),
            y: Math.floor(room.y + room.height / 2),
        };
    },

    canResizeRoom(room, newWidth, newHeight) {
        const dungeon = window.DungeonState.dungeon;

        if (newWidth < 3 || newHeight < 3) {
            return false;
        }

        for (let y = room.y; y < room.y + newHeight; y++) {
            for (let x = room.x; x < room.x + newWidth; x++) {
                if (
                    x < 0 ||
                    y < 0 ||
                    x >= dungeon.width ||
                    y >= dungeon.height
                ) {
                    return false;
                }

                const tile = dungeon.tiles[y][x];

                if (
                    tile.room_id &&
                    String(tile.room_id) !== String(room.id)
                ) {
                    return false;
                }
            }
        }

        return true;
    },

    resizeRoom(room, newWidth, newHeight) {
        this.clearRoomTiles(room.id);

        room.width = newWidth;
        room.height = newHeight;

        this.drawRoom(room);
        this.regenerateCorridors();
    },

    canResizeRoomAt(room, newX, newY, newWidth, newHeight) {
        const dungeon = window.DungeonState.dungeon;

        if (newWidth < 3 || newHeight < 3) {
            return false;
        }

        for (let y = newY; y < newY + newHeight; y++) {
            for (let x = newX; x < newX + newWidth; x++) {
                if (
                    x < 0 ||
                    y < 0 ||
                    x >= dungeon.width ||
                    y >= dungeon.height
                ) {
                    return false;
                }

                const tile = dungeon.tiles[y][x];

                if (
                    tile.room_id &&
                    String(tile.room_id) !== String(room.id)
                ) {
                    return false;
                }
            }
        }

        return true;
    },

    resizeRoomAt(room, newX, newY, newWidth, newHeight) {
        this.clearRoomTiles(room.id);

        room.x = newX;
        room.y = newY;
        room.width = newWidth;
        room.height = newHeight;

        this.drawRoom(room);
        this.regenerateCorridors();
    },

    ensureDoorsArray() {
        const dungeon = window.DungeonState.dungeon;

        if (!Array.isArray(dungeon.doors)) {
            dungeon.doors = [];
        }
    },

    clearDoorTiles() {
        const dungeon = window.DungeonState.dungeon;

        this.ensureDoorsArray();

        dungeon.doors.forEach(door => {
            const tile = dungeon.tiles[door.y]?.[door.x];

            if (tile && tile.type === 'door') {
                tile.type = 'corridor';
                tile.door_id = null;
            }
        });
    },

    regenerateDoors() {
        const dungeon = window.DungeonState.dungeon;

        this.ensureDoorsArray();
        this.clearDoorTiles();

        dungeon.doors = [];

        let nextDoorId = 1;

        dungeon.corridors.forEach(corridor => {
            const candidates = this.findDoorCandidatesForCorridor(corridor);

            candidates.forEach(candidate => {
                if (Math.random() > 0.65) {
                    return;
                }

                const door = {
                    id: nextDoorId++,
                    x: candidate.x,
                    y: candidate.y,
                    room_id: candidate.room_id,
                    corridor_id: corridor.id,
                    type: 'door',
                    state: 'closed',
                    locked: false,
                    secret: false,
                    metadata: {},
                };

                dungeon.doors.push(door);

                const tile = dungeon.tiles[door.y][door.x];
                tile.type = 'door';
                tile.door_id = door.id;
            });
        });
    },

    findDoorCandidatesForCorridor(corridor) {
        const dungeon = window.DungeonState.dungeon;
        const candidates = [];

        corridor.tiles.forEach(tilePos => {
            const tile = dungeon.tiles[tilePos.y]?.[tilePos.x];

            if (!tile || tile.type !== 'corridor') {
                return;
            }

            const neighbors = [
                { x: tilePos.x + 1, y: tilePos.y },
                { x: tilePos.x - 1, y: tilePos.y },
                { x: tilePos.x, y: tilePos.y + 1 },
                { x: tilePos.x, y: tilePos.y - 1 },
            ];

            const adjacentRoomTile = neighbors.find(pos => {
                const neighbor = dungeon.tiles[pos.y]?.[pos.x];

                return neighbor && neighbor.room_id;
            });

            if (!adjacentRoomTile) {
                return;
            }

            const roomTile = dungeon.tiles[adjacentRoomTile.y][adjacentRoomTile.x];

            candidates.push({
                x: tilePos.x,
                y: tilePos.y,
                room_id: roomTile.room_id,
                corridor_id: corridor.id,
            });
        });

        return candidates;
    },

    toggleDoorAtTile(tile) {
        const dungeon = window.DungeonState.dungeon;

        this.ensureDoorsArray();

        if (!tile) {
            return;
        }

        if (tile.type === 'door') {
            dungeon.doors = dungeon.doors.filter(
                door => String(door.id) !== String(tile.door_id)
            );

            tile.type = 'corridor';
            tile.door_id = null;

            return;
        }

        if (tile.type !== 'corridor') {
            return;
        }

        const doorId = dungeon.doors.length
            ? Math.max(...dungeon.doors.map(door => door.id)) + 1
            : 1;

        const door = {
            id: doorId,
            x: tile.x,
            y: tile.y,
            room_id: null,
            corridor_id: tile.corridor_id ?? null,
            type: 'door',
            state: 'closed',
            locked: false,
            secret: false,
            metadata: {},
        };

        dungeon.doors.push(door);

        tile.type = 'door';
        tile.door_id = door.id;
    },
};

