<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CharacterTabAccess
{
    public function handle(Request $request, Closure $next, string $tab)
    {
        $character = $request->route('character'); // route-model binding

        if (!$character) {
            return $next($request);
        }

        $role = $character->role;

        // generic_npc: block equipment + spells
        if ($role === 'generic_npc' && in_array($tab, ['equipment', 'spells'], true)) {
            return redirect()
                ->route('characters.basic.edit', $character)
                ->with('status', 'That tab is disabled for Generic NPC.');
        }

        // player: block npc_traits
        if ($role === 'player' && $tab === 'npc_traits') {
            return redirect()
                ->route('characters.basic.edit', $character)
                ->with('status', 'That tab is disabled for Player Characters.');
        }

        return $next($request);
    }
}
