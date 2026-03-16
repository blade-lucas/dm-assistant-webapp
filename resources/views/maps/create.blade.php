<x-layouts.app :title="'DM Assistant: Map Creation'">
    <div class="grid gap-8">

        <div class="flex flex-col items-start gap-4">

            <button 
                id="generateBtn"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
            >
                Generate Map
            </button>

            <div id="loading" class="text-gray-600 hidden">
                Generating map, please wait...
            </div>

            <img 
                id="mapImage" 
                class="mt-4 border rounded shadow max-w-full"
                style="display:none;"
            />
        </div>

    </div>
</x-layouts.app>