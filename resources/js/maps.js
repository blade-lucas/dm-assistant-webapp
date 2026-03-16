document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('generateBtn');
    const loading = document.getElementById('loading');
    const img = document.getElementById('mapImage');

    btn.addEventListener('click', async () => {
        loading.classList.remove('hidden');
        img.src="";
        img.style.display = 'none';

        const response = await fetch('/maps/generate-map', {
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
            img.src = "data:image/png;base64," + data.image;
            img.style.display = 'block';
        } else {
            alert("Error generating map.");
        }
    });
});