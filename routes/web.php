<?php

use App\Http\Controllers\CharacterController;
use App\Http\Controllers\DungeonGeneratorController;
use App\Http\Controllers\EncounterController;
use App\Http\Controllers\MapGenerationController;
use App\Http\Controllers\MonsterController;
use App\Http\Controllers\SavedEncounterTableController;
use App\Models\Character;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::view('/rules', 'rules.index');

Route::view('/databases', 'databases.index')->name('databases.index');
Route::view('/databases/monsters', 'databases.monsters')->name('databases.monsters');
Route::view('/databases/spells', 'databases.spells')->name('databases.spells');

Route::view('/characters', 'characters.index');
Route::view('/characters/create', 'characters.create');

Route::view('/encounters', 'encounters.index');
Route::view('/encounters/generate', 'encounters.generate');

Route::view('/maps', 'maps.index');
Route::view('/maps/create', 'maps.create');
Route::post('/maps/generate-map', [MapGenerationController::class, 'generate']);

Route::get('/characters/{character}/basic', [CharacterController::class, 'edit'])
    ->name('characters.basic.edit');

Route::post('/characters/{character}/basic', [CharacterController::class, 'updateBasic'])
    ->name('characters.basic.update');

// quick create for testing (optional)
Route::post('/characters', function () {
    $c = Character::create([
        'name' => 'New Character',
        'abilities' => ['str'=>10,'dex'=>10,'con'=>10,'int'=>10,'wis'=>10,'cha'=>10],
        'skills' => ['proficient'=>[],'bonuses'=>[]],
        'features' => [],
        'role' => 'player',
        'level' => 1,
    ]);
    return redirect()->route('characters.basic.edit', $c);
})->name('characters.create.quick');

Route::get('/characters/{character}/equipment', fn () => 'Equipment tab (TODO)')
    ->middleware('character.tab:equipment')
    ->name('characters.equipment.edit');

Route::post('/characters/{character}/equipment/purchase', [CharacterController::class, 'purchaseEquipment'])
    ->middleware('character.tab:equipment')
    ->name('characters.equipment.purchase');

Route::get('/characters/{character}/spells', fn () => 'Spells tab (TODO)')
    ->middleware('character.tab:spells')
    ->name('characters.spells.edit');

Route::post('/characters/{character}/spells/toggle', [CharacterController::class, 'toggleSpell'])
    ->middleware('character.tab:spells')
    ->name('characters.spells.toggle');

Route::get('/characters/{character}/npc-traits', fn () => 'NPC Traits tab (TODO)')
    ->middleware('character.tab:npc_traits')
    ->name('characters.npc_traits.edit');

Route::get('/characters/{character}/notes', fn () => 'DM Notes tab (TODO)')
    ->name('characters.notes.edit');

Route::get('/characters/{character}/equipment', [CharacterController::class, 'editEquipment'])
    ->middleware('character.tab:equipment')
    ->name('characters.equipment.edit');

Route::post('/characters/{character}/equipment', [CharacterController::class, 'updateEquipment'])
    ->middleware('character.tab:equipment')
    ->name('characters.equipment.update');

Route::get('/characters/{character}/spells', [CharacterController::class, 'editSpells'])
    ->middleware('character.tab:spells')
    ->name('characters.spells.edit');

Route::post('/characters/{character}/spells', [CharacterController::class, 'updateSpells'])
    ->middleware('character.tab:spells')
    ->name('characters.spells.update');

Route::get('/characters/{character}/npc-traits', [CharacterController::class, 'editNpcTraits'])
    ->middleware('character.tab:npc_traits')
    ->name('characters.npc_traits.edit');

Route::post('/characters/{character}/npc-traits', [CharacterController::class, 'updateNpcTraits'])
    ->middleware('character.tab:npc_traits')
    ->name('characters.npc_traits.update');

Route::get('/characters/{character}/notes', [CharacterController::class, 'editNotes'])
    ->name('characters.notes.edit');

Route::post('/characters/{character}/notes', [CharacterController::class, 'updateNotes'])
    ->name('characters.notes.update');

Route::post('/characters/{character}/notes/delete', [CharacterController::class, 'deleteNote'])
    ->name('characters.notes.delete');

Route::get('/characters', [CharacterController::class, 'index'])->name('characters.index');
Route::get('/characters/create', [CharacterController::class, 'create'])->name('characters.create');
Route::post('/characters', [CharacterController::class, 'store'])->name('characters.store');
Route::post('/characters/{character}/delete', [CharacterController::class, 'destroy'])->name('characters.destroy');

Route::get('/monsters', [MonsterController::class, 'index'])->name('monsters.index');

Route::get('/encounters', [EncounterController::class, 'index'])->name('encounters.index');
Route::post('/encounters/roll', [EncounterController::class, 'roll'])->name('encounters.roll');

Route::get('/encounters/row/{row}/monster/{slot}', [EncounterController::class, 'pickMonster'])
    ->name('encounters.pickMonster');

Route::post('/encounters/row/{row}/monster/{slot}', [EncounterController::class, 'setMonster'])
    ->name('encounters.setMonster');

Route::get('/encounters/saved', [SavedEncounterTableController::class, 'index'])->name('encounters.saved');
Route::post('/encounters/save', [SavedEncounterTableController::class, 'store'])->name('encounters.save');
Route::post('/encounters/saved/{table}/load', [SavedEncounterTableController::class, 'load'])->name('encounters.saved.load');
Route::delete('/encounters/saved/{table}', [SavedEncounterTableController::class, 'destroy'])->name('encounters.saved.delete');

Route::get('/maps', [MapGenerationController::class, 'index'])->name('maps.index');

//Auth access, move needed routes later
Route::middleware(['auth'])->group(function () {
    Route::get('/account', fn () => view('account.index'))->name('account.index');

    // Your user-owned resources later:
    // characters, encounters, maps, feedback
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', fn () => view('admin.index'))->name('admin.index');
});

Route::get('/dungeons/generate', [DungeonGeneratorController::class, 'index'])->name('dungeons.generate');
Route::post('/dungeons/generate', [DungeonGeneratorController::class, 'generate'])->name('dungeons.generate.run');
Route::post('/dungeons/generate-map', [MapGenerationController::class, 'generate'])->name('dungeons.generate.map');
