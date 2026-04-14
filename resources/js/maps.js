document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('generateBtn');
    const loading = document.getElementById('loading');
    const img = document.getElementById('mapImage');
    const placeholder = document.getElementById('placeholder');
    const mapForm = document.getElementById('mapForm');

    mapForm.addEventListener('submit', e => {
        e.preventDefault();
    });

    btn.addEventListener('click', async () => {
        try {
            placeholder.style.display = 'none';
            loading.classList.remove('hidden');
            img.style.display = 'none';
            img.src = '';

            const themeEl = document.getElementById('theme');
            const roomsEl = document.getElementById('room_count');
            const guidanceEl = document.getElementById('guidance');

            const theme = themeEl ? themeEl.value : null;
            const roomsRaw = roomsEl ? roomsEl.value : null;
            const guidance = guidanceEl ? guidanceEl.value : 2.5;

            console.log('Map request payload:', {
                theme,
                rooms: roomsRaw,
                guidance
            });

            const response = await fetch('/dungeons/generate-map', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    theme: theme,
                    rooms: roomsRaw,
                    guidance: guidance
                })
            });

            const data = await response.json();
            loading.classList.add('hidden');

            if (data.image) {
                placeholder.style.display = 'none';
                img.src = 'data:image/png;base64,' + data.image;
                img.style.display = 'block';
            } else {
                console.error('Map generation error:', data);
                alert('Error generating map.');
                placeholder.style.display = 'flex';
            }
        } catch (err) {
            loading.classList.add('hidden');
            placeholder.style.display = 'flex';
            console.error('Frontend map generation failed:', err);
            alert('Frontend error while generating map.');
        }
    });
});
