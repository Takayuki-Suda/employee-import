<?php

use App\Http\Controllers\ImportController;

Route::view('/', 'import');
Route::post('/import', [ImportController::class, 'import']);


