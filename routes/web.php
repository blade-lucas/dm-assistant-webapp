<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::view('/rules', 'rules.index');
Route::view('/monsters', 'monsters.index');
Route::view('/characters', 'characters.index');
Route::view('/encounters', 'encounters.index');

Route::view('/characters/create', 'characters.create');
Route::view('/encounters/generate', 'encounters.generate');

Route::view('/maps', 'maps.index');

