<?php

use App\Http\Controllers\CharacterController;
use App\Http\Controllers\DungeonGeneratorController;
use App\Http\Controllers\EncounterController;
use App\Http\Controllers\ItemLibraryController;
use App\Http\Controllers\MapGenerationController;
use App\Http\Controllers\MonsterController;
use App\Http\Controllers\SaveController;
use App\Http\Controllers\SavedEncounterTableController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/

Route::view('/', 'home')->name('home');

Route::view('/rules', 'rules.index')->name('rules.index');

Route::view('/databases', 'databases.index')->name('databases.index');
Route::view('/databases/monsters', 'databases.monsters')->name('databases.monsters');
Route::view('/databases/spells', 'databases.spells')->name('databases.spells');

/*
|--------------------------------------------------------------------------
| Public Libraries / Tools
|--------------------------------------------------------------------------
*/

Route::get('/monsters', [MonsterController::class, 'index'])->name('monsters.index');

Route::get('/items', [ItemLibraryController::class, 'index'])->name('items.index');
Route::get('/items/{id}', [ItemLibraryController::class, 'show'])->name('items.show');

Route::get('/encounters', [EncounterController::class, 'index'])->name('encounters.index');
Route::post('/encounters/roll', [EncounterController::class, 'roll'])->name('encounters.roll');
Route::get('/encounters/row/{row}/monster/{slot}', [EncounterController::class, 'pickMonster'])->name('encounters.pickMonster');
Route::post('/encounters/row/{row}/monster/{slot}', [EncounterController::class, 'setMonster'])->name('encounters.setMonster');
Route::post('/encounters/ai-generate', [EncounterController::class, 'aiGenerate'])->name('encounters.aiGenerate');

Route::get('/maps', [MapGenerationController::class, 'index'])->name('maps.index');
Route::post('/maps/generate-map', [MapGenerationController::class, 'generate'])->name('maps.generate');

Route::get('/dungeons/generate', [DungeonGeneratorController::class, 'index'])->name('dungeons.generate');
Route::post('/dungeons/generate', [DungeonGeneratorController::class, 'generate'])->name('dungeons.generate.run');
Route::post('/dungeons/generate-map', [MapGenerationController::class, 'generate'])->name('dungeons.generate.map');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::view('/dashboard', 'dashboard.user')->name('dashboard');
    Route::view('/account', 'account.index')->name('account.index');

    /*
    |--------------------------------------------------------------------------
    | Saves
    |--------------------------------------------------------------------------
    */

    Route::get('/saves/{type?}', [SaveController::class, 'index'])->name('saves.index');
    Route::get('/saves/{type}/{id}', [SaveController::class, 'show'])->name('saves.show');

    /*
    |--------------------------------------------------------------------------
    | Characters
    |--------------------------------------------------------------------------
    */

    Route::get('/characters', [CharacterController::class, 'index'])->name('characters.index');
    Route::get('/characters/create', [CharacterController::class, 'create'])->name('characters.create');
    Route::post('/characters', [CharacterController::class, 'store'])->name('characters.store');
    Route::post('/characters/{character}/delete', [CharacterController::class, 'destroy'])->name('characters.destroy');

    // Main character entry point
    Route::get('/characters/{character}', [CharacterController::class, 'editBasic'])->name('characters.edit');

    // Character tabs
    Route::get('/characters/{character}/basic', [CharacterController::class, 'editBasic'])->name('characters.basic.edit');
    Route::post('/characters/{character}/basic', [CharacterController::class, 'updateBasic'])->name('characters.basic.update');

    Route::get('/characters/{character}/equipment', [CharacterController::class, 'editEquipment'])
        ->middleware('character.tab:equipment')
        ->name('characters.equipment.edit');
    Route::post('/characters/{character}/equipment', [CharacterController::class, 'updateEquipment'])
        ->middleware('character.tab:equipment')
        ->name('characters.equipment.update');
    Route::post('/characters/{character}/equipment/purchase', [CharacterController::class, 'purchaseEquipment'])
        ->middleware('character.tab:equipment')
        ->name('characters.equipment.purchase');

    Route::get('/characters/{character}/spells', [CharacterController::class, 'editSpells'])
        ->middleware('character.tab:spells')
        ->name('characters.spells.edit');
    Route::post('/characters/{character}/spells', [CharacterController::class, 'updateSpells'])
        ->middleware('character.tab:spells')
        ->name('characters.spells.update');
    Route::post('/characters/{character}/spells/toggle', [CharacterController::class, 'toggleSpell'])
        ->middleware('character.tab:spells')
        ->name('characters.spells.toggle');

    Route::get('/characters/{character}/npc-traits', [CharacterController::class, 'editNpcTraits'])
        ->middleware('character.tab:npc_traits')
        ->name('characters.npc_traits.edit');
    Route::post('/characters/{character}/npc-traits', [CharacterController::class, 'updateNpcTraits'])
        ->middleware('character.tab:npc_traits')
        ->name('characters.npc_traits.update');

    Route::get('/characters/{character}/notes', [CharacterController::class, 'editNotes'])->name('characters.notes.edit');
    Route::post('/characters/{character}/notes', [CharacterController::class, 'updateNotes'])->name('characters.notes.update');
    Route::post('/characters/{character}/notes/delete', [CharacterController::class, 'deleteNote'])->name('characters.notes.delete');

    /*
    |--------------------------------------------------------------------------
    | Saved Encounters
    |--------------------------------------------------------------------------
    */

    Route::get('/encounters/saved', [SavedEncounterTableController::class, 'index'])->name('encounters.saved');
    Route::post('/encounters/save', [SavedEncounterTableController::class, 'store'])->name('encounters.save');
    Route::post('/encounters/saved/{table}/load', [SavedEncounterTableController::class, 'load'])->name('encounters.saved.load');
    Route::delete('/encounters/saved/{table}', [SavedEncounterTableController::class, 'destroy'])->name('encounters.saved.delete');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {
    Route::view('/admin', 'dashboard.admin')->name('admin.index');
});
