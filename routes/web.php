<?php

use App\Http\Controllers\UrlShortenerController;

Route::get('/', [UrlShortenerController::class, 'index']);
Route::post('/shorten', [UrlShortenerController::class, 'shorten']);
Route::get('/{shortCode}', [UrlShortenerController::class, 'redirect']);
