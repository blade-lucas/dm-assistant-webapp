window.DungeonEditor = {
    setActiveTool(tool) {
        const state = window.DungeonState;

        state.moveMode.active = false;
        state.resizeMode.active = false;
        state.doorMode.active = false;

        document.querySelectorAll('.mode-button').forEach(button => {
            button.classList.remove('active');
        });

        document.getElementById(`${tool}-tool`)?.classList.add('active');

        const help = document.getElementById('tool-help');

        if (!help) {
            return;
        }

        const messages = {
            select: 'Select a room to edit it.',
            move: 'Move Tool: click a valid destination tile to move the selected room.',
            resize: 'Resize Tool: drag a corner handle to resize the selected room.',
            door: 'Door Tool: click a corridor tile to add a door. Click a door to remove it.',
        };

        help.textContent = messages[tool] ?? messages.select;
    },

    populateRoomFields(room) {
        document.getElementById('empty-state').style.display = 'none';
        document.getElementById('room-info').style.display = 'block';

        document.getElementById('room-id').textContent = room.id;
        document.getElementById('edit-name').value = room.name ?? '';
        document.getElementById('edit-type').value = room.type ?? 'room';
        document.getElementById('edit-description').value = room.description ?? '';
        document.getElementById('edit-tags').value = room.tags?.join(', ') ?? '';

        document.getElementById('room-connections').textContent =
            room.connected_rooms?.length
                ? room.connected_rooms.join(', ')
                : 'None';
    },

    saveRoom() {
        const state = window.DungeonState;

        const room = state.dungeon.rooms.find(
            room => String(room.id) === String(state.selectedRoomId)
        );

        if (!room) {
            return;
        }

        room.name = document.getElementById('edit-name').value;
        room.type = document.getElementById('edit-type').value;
        room.description = document.getElementById('edit-description').value;

        room.tags = document
            .getElementById('edit-tags')
            .value
            .split(',')
            .map(tag => tag.trim())
            .filter(tag => tag.length > 0);

        alert('Room updated locally.');
    },

    async saveDungeon() {
        const state = window.DungeonState;

        state.dungeon.name =
            document.getElementById('dungeon-name').value || 'Generated Dungeon';

        const payload = {
            ...state.dungeon,
            campaign_id: window.campaignId ?? null,
        };

        try {
            const response = await fetch(state.storeUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': state.csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify(payload),
            });

            const data = await response.json();

            if (!response.ok || !data.success) {
                throw new Error(data.message || 'Dungeon could not be saved.');
            }

            if (data.redirect_url) {
                window.location.href = data.redirect_url;
                return;
            }

            alert(`Dungeon saved. ID: ${data.id}`);
        } catch (error) {
            console.error('Dungeon save failed:', error);
            alert(error.message || 'Dungeon could not be saved.');
        }
    },

    bindEvents() {
        document
            .getElementById('save-room')
            .addEventListener('click', () => this.saveRoom());

        document
            .getElementById('save-dungeon')
            .addEventListener('click', () => this.saveDungeon());

        document.getElementById('select-tool').addEventListener('click', () => {
            this.setActiveTool('select');
            window.DungeonRenderer.draw();
        });

        document.getElementById('move-room').addEventListener('click', () => {
            const state = window.DungeonState;

            if (!state.selectedRoomId) {
                return;
            }

            this.setActiveTool('move');

            state.moveMode.active = true;
            state.moveMode.roomId = state.selectedRoomId;

            document.getElementById('move-room').classList.add('active');

            window.DungeonRenderer.draw();
        });

        document.getElementById('resize-room').addEventListener('click', () => {
            const state = window.DungeonState;

            if (!state.selectedRoomId) {
                return;
            }

            this.setActiveTool('resize');

            state.resizeMode.active = true;
            state.resizeMode.roomId = state.selectedRoomId;

            document.getElementById('resize-room').classList.add('active');

            window.DungeonRenderer.draw();
        });

        document.getElementById('door-tool').addEventListener('click', () => {
            const state = window.DungeonState;

            this.setActiveTool('door');

            state.doorMode.active = true;

            document.getElementById('door-tool').classList.add('active');

            window.DungeonRenderer.draw();
        });
    },
};
