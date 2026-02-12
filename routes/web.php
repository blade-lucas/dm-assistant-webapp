<?php

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

