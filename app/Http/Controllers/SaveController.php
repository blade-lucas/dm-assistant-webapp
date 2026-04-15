<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Map;
use App\Models\SavedEncounterTable;
use Illuminate\Http\Request;

class SaveController extends Controller
{
    public function index(Request $request, ?string $type = null)
    {
        $type = $type ?: 'characters';
        $user = $request->user();
        $isAdmin = (bool) ($user->is_admin ?? false);

        $items = match ($type) {
            'encounters' => SavedEncounterTable::query()
                ->when(!$isAdmin, fn ($q) => $q->where('user_id', $user->id))
                ->latest()
                ->get(),

            'maps' => Map::query()
                ->when(!$isAdmin, fn ($q) => $q->where('user_id', $user->id))
                ->latest()
                ->get(),

            default => Character::query()
                ->when(!$isAdmin, fn ($q) => $q->where('user_id', $user->id))
                ->latest()
                ->get(),
        };

        return view('saves.index', [
            'type' => $type,
            'items' => $items,
        ]);
    }

    public function show(Request $request, string $type, int $id)
    {
        $user = $request->user();
        $isAdmin = (bool) ($user->is_admin ?? false);

        $item = match ($type) {
            'encounters' => SavedEncounterTable::findOrFail($id),
            'maps' => Map::findOrFail($id),
            default => Character::findOrFail($id),
        };

        if (
            !$isAdmin &&
            isset($item->user_id) &&
            (int) $item->user_id !== (int) $user->id
        ) {
            abort(403);
        }

        return view('saves.show', [
            'type' => $type,
            'item' => $item,
        ]);
    }
}
