<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NoteController;
use App\Http\Controllers\Api\NoteSummaryController;
use App\Http\Controllers\Api\NoteSearchController;

Route::middleware('throttle:api-notes')
    ->prefix('notes')
    ->group(function () {

        Route::get('/search', [NoteSearchController::class, 'search']);

        Route::get('/', [NoteController::class, 'index']);

        Route::post('/', [NoteController::class, 'store']);

        Route::get('/{id}', [NoteController::class, 'show']);

        Route::put('/{id}', [NoteController::class, 'update']);

        Route::delete('/{id}', [NoteController::class, 'destroy']);

        Route::post('/{id}/summary', [NoteSummaryController::class, 'generate']);
    });
