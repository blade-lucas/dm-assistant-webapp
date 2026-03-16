document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('generateBtn');
    const loading = document.getElementById('loading');
    const img = document.getElementById('mapImage');

    document.getElementById('mapForm').addEventListener('submit', e => {
    e.preventDefault();
    });

    btn.addEventListener('click', async () => {
        // Hide placeholder immediately
        placeholder.style.display = 'none';
        loading.classList.remove('hidden');
        img.style.display = 'none';
        img.src="";

        const response = await fetch('/dungeons/generate-map', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({})
        });

        const data = await response.json();
        loading.classList.add('hidden');

        if (data.image) {
            placeholder.style.display = 'none';   // hide the "No dungeon generated yet"
            img.src = "data:image/png;base64," + data.image;
            img.style.display = 'block';
        }
        else {
            alert("Error generating map.");
        }
    });
});