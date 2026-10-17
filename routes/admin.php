<?php

use App\Http\Controllers\Admin\LansiaController;
use Illuminate\Support\Facades\Route;

//route admin panti
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        //nampilin foto lansia secara private
        Route::get('/lansia/{lansia}/foto', [LansiaController::class, 'foto'])
            ->name('lansia.foto');

        //CRUD data lansia
        Route::resource('lansia', LansiaController::class);

    });